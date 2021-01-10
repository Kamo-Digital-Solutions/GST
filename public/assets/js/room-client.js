var OV;
var session;

var sessionName;	// Name of the video session the user will connect to
var token;			// Token retrieved from OpenVidu Server
var publisher;
var audioEnabled;
var buzzerDisabled = false;

var nickName = "";
var userid = "";
var role = "";
var game_session = "";
var timer;
var team_id;
var published;
var videoContainer;
var current_teams;
var g_data;


function get_session_id() {
	var url = $(location).attr('href');
	var parts = url.split("/");
	if (parts[parts.length - 1] == "") {
		var last_part = parts[parts.length - 2];

	} else {
		var last_part = parts[parts.length - 1];
	}

	return last_part;
}

$(function () {
	formdata = {
		"session_id" : get_session_id()
	}
	// Get the username
	$.ajax({
		type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
		url: '/user/get_username/', // the url where we want to POST
		data: formdata, // our data object
		dataType: 'json', // what type of data do we expect back from the server
		encode: true
	})
		// using the done promise callback
		.done(function (data) {
			nickName = data.username;
			userid = data.id;
			team_id = data.team_id;
			// get session from url
			var url = $(location).attr('href');
			var parts = url.split("/");
			if (parts[parts.length - 1] == "") {
				game_session = parts[parts.length - 2];

			} else {
				game_session = parts[parts.length - 1];
			}
			get_game_data();
		});
	setInterval(function () { update_scores(); }, 3000);

});

function get_game_data() {
	s_id = get_session_id();

	data = {
		"game_session": s_id,
	}
	// Get the username
	$.ajax({
		type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
		url: '/api-sessions/get_current_game_data/', // the url where we want to POST
		data: data, // our data object
		dataType: 'json', // what type of data do we expect back from the server
		encode: true
	})// using the done promise callback
		.done(function (data) {
			if(data.code) {
				current_teams = JSON.parse(data.code).current_teams;
				g_data = data.code;
			}
			joinSession();
		});
}

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
			if(JSON.parse(event.stream.connection.data.split('%/%')[0]).team_id == current_teams[0]) {
				var subscriber = session.subscribe(event.stream, 'video-container');
			} else {
				var subscriber = session.subscribe(event.stream, 'video-container2');
			}

			// When the HTML video has been appended to DOM...
			subscriber.on('videoElementCreated', (event) => {

				if (JSON.parse(subscriber.stream.connection.data.split('%/%')[0]).role == "host") {
					initMainVideo(event.element, subscriber.stream.connection);
				} else {
					appendUserData(event.element, subscriber.stream.connection);
				}
				// Add a new HTML element for the user's name and nickname over its video
			});
		});

		// On every Stream destroyed...
		session.on('streamDestroyed', (event) => {
			// Delete the HTML element with the user's name and nickname
			removeUserData(event.stream.connection);
		});

		// --- 4) Connect to the session passing the retrieved token and some more data from
		//        the client (in this case a JSON with the nickname chosen by the user) ---

		session.connect(token, { clientData: nickName, u_id: userid, team_id: team_id })
			.then(() => {

				// --- 5) Set page layout for active call ---

				var score = 0;
				//$('#session-title').text(sessionName);

				// --- 6) Get your own camera stream ---

				videoContainer = "video-container";
				if(team_id == current_teams[1])
					videoContainer = "video-container2";

				if(team_id == current_teams[0] || team_id == current_teams[1]) {
	
					publisher = OV.initPublisher(videoContainer, {
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
					// When our HTML video has been added to DOM...
					publisher.on('videoElementCreated', (event) => {
						// Init the main video with ours and append our data
						var userData = {
							nickName: nickName,
							score: score,
							u_id: userid,
							role: "participant",
							team_id: team_id
						};
						//initMainVideo(event.element, userData);
						appendUserData(event.element, userData);
						//$(event.element).prop('muted', true); // Mute local video
					});

					// --- 8) Publish your stream ---
					published = true;
					session.publish(publisher);	
				} else {

					// Lock Buzzer
					lock_buzzer();
				}
				update_game(g_data);

			})
			.catch(error => {
				console.warn('There was an error connecting to the session:', error.code, error.message);
			});

		// Check signal and assign function for each of them
		session.on('signal', (event) => {
			if (event.type == "signal:update-score") {
				update_scores();
			} else if (event.type == "signal:lock-buzzer") {
				lock_buzzer();
			} else if  (event.type == "signal:unlock-buzzer") {
				unlock_buzzer();
			} else if (event.type == "signal:mute") {
				if (event.data == userid || event.data == "") {
					mute_me();
				}
			} else if (event.type == "signal:unmute") {
				if (event.data == userid || event.data == "") {
					unmute_me();
				}
			} else if (event.type == "signal:role") {
				if (event.data == userid || event.data == nickName) {
					startBuzzer();
				}
			} else if (event.type == "signal:game-status") {
				update_game(event.data);
			} else if (event.type == "signal:countdown") {
				start_countdown();
			}
			//console.log(event.data); // Message
			//console.log(event.from); // Connection object of the sender
			console.log(event.type); // The type of message
		});
	});

	return false;
}

function stop_publishing() {
	location.reload();
}

function republishing_session() {
	location.reload(); 
}

function start_countdown() {
	timer = 5;
	var x = setInterval(function () {
		$(".answer_timer").html(timer.toFixed(2));
		timer-= 0.01;
		if (timer < 0) {
			clearInterval(x);
			$(".answer_timer").html("5.00");
		}
	}, 10);
}


function start_videos() {
	$("video").trigger('play');
}

function send_spin() {
	session.signal({
		data: userid,  // Any string (optional)
		to: [],                     // Array of Connection objects (optional. Broadcast to everyone if empty)
		type: 'spin'             // The type of message (optional)
	})
	.then(() => {
		console.log('Message successfully sent');
	})
	.catch(error => {
		console.error(error);
	});

}

function update_state() {
	data = {
		"game_session": game_session,
		"user_id": userid
	}

	// Get the username
	$.ajax({
		type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
		url         : '/api-sessions/get_user_state/', // the url where we want to POST
		data        : data, // our data object
		dataType    : 'json', // what type of data do we expect back from the server
		encode          : true
	})// using the done promise callback
	.done(function(data) {
		if(data.mute == 1 && audioEnabled)
			mute_me();
		else if (data.mute == 0 && !audioEnabled)
			unmute_me();

		if(data.buzzer == 1 && buzzerDisabled)
			unlock_buzzer();
		
		else if (data.buzzer == 0 && !buzzerDisabled)
			lock_buzzer();

	});

}

function getToken(callback) {
	var url = $(location).attr('href');
	var parts = url.split("/");
	if (parts[parts.length - 1] == "") {
		var last_part = parts[parts.length - 2];

	} else {
		var last_part = parts[parts.length - 1];
	}

	sessionName = last_part;

	httpPostRequest(
		'/api-sessions/get-token/' + sessionName,
		{},
		'Request of TOKEN gone WRONG:',
		(response) => {
			token = response.token; // Get token from response
			console.warn('Request of TOKEN gone WELL (TOKEN:' + token + ')');
			callback(token); // Continue the join operation
		}
	);
}

function removeUserData(connection) {

	var userNameRemoved = $("#data-" + connection.connectionId);
	if ($(userNameRemoved).find('p.userName').html() === $('#main-video p.userName').html()) {
		cleanMainVideo(); // The participant focused in the main video has left
	}
	$("#data-" + connection.connectionId).remove();
}

function cleanMainVideo() {
	$('#main-video').empty();
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

function appendGameDashboard(gameElement, connection) {
	document.getElementById("game-dashboard").appendChild(gameElement);
	console.log("The game has been append");
}

function appendUserData(videoElement, connection) {
	var clientData;
	var serverData;
	var nodeId;
	var u_id;
	console.log(connection);
	if (connection.nickName) { // Appending local video data
		clientData = connection.nickName;
		u_id = connection.u_id;
		serverData = connection.score;
		nodeId = 'main-videodata';
	} else {
		clientData = JSON.parse(connection.data.split('%/%')[0]).clientData;
		u_id = JSON.parse(connection.data.split('%/%')[0]).u_id;
		serverData = JSON.parse(connection.data.split('%/%')[1]).serverData;
		nodeId = connection.connectionId;
	}

	var dataNode = document.createElement('div');
	dataNode.className = "data-node";
	dataNode.id = "data-" + nodeId;
	dataNode.innerHTML = "<p class='nickName'>" + clientData + "</p><p class='userName' id='user_score_" + u_id + "'>" + serverData + "</p>";
	videoElement.parentNode.insertBefore(dataNode, videoElement.nextSibling);

}

function initMainVideo(videoElement, userData) {
	$('#main-video').get(0).append(videoElement);
	$('#main-video').width(400);
	update_scores();
}

function cleanMainVideo() {
	$('#main-video video').get(0).srcObject = null;
	$('#main-video p').each(function () {
		$(this).html('');
	});
}

function update_scores() {
	data = {
		"game_session": game_session,
	}
	// Get the username
	$.ajax({
		type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
		url: '/api-sessions/get_users_score/', // the url where we want to POST
		data: data, // our data object
		dataType: 'json', // what type of data do we expect back from the server
		encode: true
	})// using the done promise callback
		.done(function (data) {
			for (var i = 0; i < data.scores.length; i++) {
				$("#user_score_" + data.scores[i].user_id).html(data.scores[i].score);
			}
		});
}

/// Buzzer

// On Buzzer click, start counting
$("#buzzer").click(function () {
	$("#buzzer").prop('disabled', true);

	//startBuzzer();

	session.signal({
		data: nickName,  // Any string (optional)
		to: [],                     // Array of Connection objects (optional. Broadcast to everyone if empty)
		type: 'buzzer'             // The type of message (optional)
	})
		.then(() => {
			console.log('Message successfully sent');
		})
		.catch(error => {
			console.error(error);
		});
});

function startBuzzer() {
	$("#successMsg").append("<div class='alert alert-success' id='successMsgData' role='alert'>You have the floor.</div>");
	unmute_me();
	timer = 5;
	var x = setInterval(function () {
		$("#timer").html(timer);
		timer--;
		if (timer < 0) {
			clearInterval(x);
			$("#buzzer").prop('disabled', false);
			$("#successMsgData").remove();
			$("#timer").html(5.0);
			mute_me();
		}
	}, 1000);
}

function mute_me() {
	audioEnabled = false;
	publisher.publishAudio(audioEnabled);
	console.log("Muted");
}

function unmute_me() {
	audioEnabled = true;
	publisher.publishAudio(audioEnabled);
	console.log("UnMuted");
}

function unlock_buzzer() {
	buzzerDisabled = false;
	$("#buzzer").prop('disabled', buzzerDisabled);
	console.log("UnlockBuzzer");
}

function lock_buzzer() {
	buzzerDisabled = true;
	$("#buzzer").prop('disabled', buzzerDisabled);
	console.log("LockBuzzer");
}
