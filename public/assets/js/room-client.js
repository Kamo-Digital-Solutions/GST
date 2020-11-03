var OV;
var session;

var sessionName;	// Name of the video session the user will connect to
var token;			// Token retrieved from OpenVidu Server

var nickName = "";

$(function() {
	joinSession();
});

/* OPENVIDU METHODS */

function joinSession() {
	getToken((token) => {

		// --- 1) Get an OpenVidu object ---

		OV = new OpenVidu();

		// --- 2) Init a session ---

		session = OV.initSession();

		// --- 3) Specify the actions when events take place in the session ---

		// On every new Stream received...
		session.on('streamCreated', (event) => {

			// Subscribe to the Stream to receive it
			// HTML video will be appended to element with 'video-container' id
			var subscriber = session.subscribe(event.stream, 'video-container');

			// When the HTML video has been appended to DOM...
			subscriber.on('videoElementCreated', (event) => {

				// Add a new HTML element for the user's name and nickname over its video
				appendUserData(event.element, subscriber.stream.connection);
			});
		});

		// On every Stream destroyed...
		session.on('streamDestroyed', (event) => {
			// Delete the HTML element with the user's name and nickname
			removeUserData(event.stream.connection);
		});

		// --- 4) Connect to the session passing the retrieved token and some more data from
		//        the client (in this case a JSON with the nickname chosen by the user) ---
		

		// Get the username
		$.ajax({
			type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
			url         : '/user/get_username/', // the url where we want to POST
			data        : "", // our data object
			dataType    : 'json', // what type of data do we expect back from the server
			encode          : true
		})
		// using the done promise callback
		.done(function(data) {
			nickName = data.username;
			console.log(nickName);
			console.log("ID: "+data.id);
			console.log("Logged IN: "+ data.logged_in);
		});

		session.connect(token, { clientData: nickName })
			.then(() => {

				// --- 5) Set page layout for active call ---

				var score = 0;
				//$('#session-title').text(sessionName);

					// --- 6) Get your own camera stream ---

					var publisher = OV.initPublisher('video-container', {
						audioSource: undefined, // The source of audio. If undefined default microphone
						videoSource: undefined, // The source of video. If undefined default webcam
						publishAudio: true,  	// Whether you want to start publishing with your audio unmuted or not
						publishVideo: true,  	// Whether you want to start publishing with your video enabled or not
						resolution: '640x480',  // The resolution of your video
						frameRate: 30,			// The frame rate of your video
						insertMode: 'APPEND',	// How the video is inserted in the target element 'video-container'
						mirror: false       	// Whether to mirror your local video or not
					});

					// --- 7) Specify the actions when events take place in our publisher ---

					// Check the role if is a host or not
					var role = "";
					$.ajax({
						type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
						url         : '/adminroom/ishost/', // the url where we want to POST
						data        : "", // our data object
						dataType    : 'json', // what type of data do we expect back from the server
						encode          : true
					})
					// using the done promise callback
					.done(function(data) {
						// log data to the console so we can see
						if(data.result == "true")
						{
							console.log("true");
							role = "host";
						} else {
							role = "participant";
						}
	
					});
					// When our HTML video has been added to DOM...
					publisher.on('videoElementCreated', (event) => {
						// Init the main video with ours and append our data
						var userData = {
							nickName: nickName,
							score: score,
							role: role
						};
						//initMainVideo(event.element, userData);
						appendUserData(event.element, userData);
						$(event.element).prop('muted', true); // Mute local video
					});


					// --- 8) Publish your stream ---

					session.publish(publisher);
			})
			.catch(error => {
				console.warn('There was an error connecting to the session:', error.code, error.message);
			});

			session.on('signal', (event) => {
				console.log("New Msg Received!");
				if(event.type == "signal:update-score") {
					userToChange = JSON.parse(event.data).user;
					newScore = JSON.parse(event.data).score;

					console.log(userToChange);
					console.log(newScore);
					update_score(userToChange, newScore);
				}
				//console.log(event.data); // Message
				//console.log(event.from); // Connection object of the sender
				//console.log(event.type); // The type of message
			});
	});

	return false;
}


function leaveSession() {

	// --- 9) Leave the session by calling 'disconnect' method over the Session object ---

	session.disconnect();
	session = null;

	// Removing all HTML elements with the user's nicknames
	cleanSessionView();

	$('#join').show();
	$('#session').hide();
}

function getToken(callback) {
	var url = $(location).attr('href');
	var parts = url.split("/");
	if(parts[parts.length-1] == "") {
		var last_part = parts[parts.length-2];

	} else {
		var last_part = parts[parts.length-1];
	}

	sessionName = last_part;

	httpPostRequest(
		'/api-sessions/get-token/'+sessionName,
		{},
		'Request of TOKEN gone WRONG:',
		(response) => {
			token = response.token; // Get token from response
			console.warn('Request of TOKEN gone WELL (TOKEN:' + token + ')');
			callback(token); // Continue the join operation
		}
	);
}

function removeUser() {

	// Function is note working
	httpPostRequest(
		'api-sessions/remove-user',
		{sessionName: sessionName, token: token},
		'User couldn\'t be removed from session', 
		(response) => {
			console.warn("You have been removed from session " + sessionName);
		}
	);
}

function httpPostRequest(url, body, errorMsg, callback) {
	var http = new XMLHttpRequest();
	http.open('GET', url, true);
	http.setRequestHeader('Content-type', 'application/json');
	http.addEventListener('readystatechange', processRequest, false);
	http.send(JSON.stringify(body));

	function processRequest() {
		if (http.readyState == 4) {
			if (http.status == 200) {
				try {
					callback(JSON.parse(http.responseText));
				} catch (e) {
					callback();
				}
			} else {
				console.warn(errorMsg);
				console.warn(http.responseText);
			}
		}
	}
}

function appendUserData(videoElement, connection) {
	var clientData;
	var serverData;
	var nodeId;
	if (connection.nickName) { // Appending local video data
		clientData = connection.nickName;
		serverData = connection.score;

		nodeId = 'main-videodata';
	} else {
		clientData = JSON.parse(connection.data.split('%/%')[0]).clientData;
		serverData = JSON.parse(connection.data.split('%/%')[1]).serverData;
		nodeId = connection.connectionId;
	}
	var dataNode = document.createElement('div');
	dataNode.className = "data-node";
	dataNode.id = "data-" + nodeId;
	dataNode.innerHTML = "<p class='nickName'>" + clientData + "</p><p class='userName'>" + serverData + "</p>";
	videoElement.parentNode.insertBefore(dataNode, videoElement.nextSibling);
	//addClickListener(videoElement, clientData, serverData);

	if (connection.role == "host") {
		initMainVideo(videoElement, connection);
	}
}

function initMainVideo(videoElement, userData) {
	$('#main-video video').get(0).srcObject = videoElement.srcObject;
	$('#main-video p.nickName').html(userData.nickName);
	$('#main-video p.userName').html(userData.userName);
	$('#main-video video').prop('muted', true);
}

function update_score(user_id, score) {
	// TODO
}

/*
function addClickListener(videoElement, clientData, serverData) {
	videoElement.addEventListener('click', function () {
		var mainVideo = $('#main-video video').get(0);
		if (mainVideo.srcObject !== videoElement.srcObject) {
			$('#main-video').fadeOut("fast", () => {
				$('#main-video p.nickName').html(clientData);
				$('#main-video p.userName').html(serverData);
				mainVideo.srcObject = videoElement.srcObject;
				$('#main-video').fadeIn("fast");
			});
		}
	});
}
*/
