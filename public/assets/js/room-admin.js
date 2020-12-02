var OV;
var session;

var OV_game_dashboard;
var session_game_dashboard;
var publisher;
var publisher2;

var sessionName;	// Name of the video session the user will connect to
var token;			// Token retrieved from OpenVidu Server

var nickName = "";
var game_session = "";
var userid = "";

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


$(function() {
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
		userid = data.id;
		console.log(nickName);
		console.log("ID: "+data.id);
		console.log("Logged IN: "+ data.logged_in);
		joinSession();
	});
	setInterval(function(){ update_scores(); }, 3000);

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
			console.log("New Stream");
			// Subscribe to the Stream to receive it
			// HTML video will be appended to element with 'video-container' id
			var subscriber = session.subscribe(event.stream, 'video-container');

			// When the HTML video has been appended to DOM...
			subscriber.on('videoElementCreated', (event) => {

				// Add a new HTML element for the user's name and nickname over its video
				 
				if (JSON.parse(subscriber.stream.connection.data.split('%/%')[0]).role == "host") {
					initMainVideo(event.element, subscriber.stream.connection);
				} else {
					appendUserData(event.element, subscriber.stream.connection);
				}

			});
		});

		// On every Stream destroyed...
		session.on('streamDestroyed', (event) => {
			// Delete the HTML element with the user's name and nickname
			removeUserData(event.stream.connection);
		});

		// --- 4) Connect to the session passing the retrieved token and some more data from
		//        the client (in this case a JSON with the nickname chosen by the user) ---
	

		
		session.connect(token, { clientData: nickName, u_id: userid, role: "host" })
		.then(() => {

			// --- 5) Set page layout for active call ---

			var score = 0;
			//$('#session-title').text(sessionName);

				// --- 6) Get your own camera stream ---

				publisher = OV.initPublisher('video-container', {
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
						role: "host"
					};
					initMainVideo(event.element, userData);
					//appendUserData(event.element, userData);
					//$(event.element).prop('muted', true); // Mute local video
					update_game_users();
				});

				// --- 8) Publish your stream ---

				session.publish(publisher);

		})
		.catch(error => {
			console.warn('There was an error connecting to the session:', error.code, error.message);
		});

		
		// Session signals managements 
		////"signal:buzzer"
		session.on('signal', (event) => {
			if(event.type == "signal:buzzer") {
				$("#events_log").append("\n"+event.data + " hit buzzer");
			}
		});
	});

	return false;
}

// Update the game for the users
function update_game_users() {
	var gameData = document.getElementById("main_game").innerHTML;
	//console.log(gameData);

	session.signal({
		data: gameData,  // Any string (optional)
		to: [],                     // Array of Connection objects (optional. Broadcast to everyone if empty)
		type: 'game-status'             // The type of message (optional)
	  })
	  .then(() => {
		  console.log('Message successfully sent');
	  })
	  .catch(error => {
		  console.error(error);
	  });


	  s_id = get_session_id();

	  data = {
		  "game_session": s_id,
		  "game_data" : gameData
	  }
	  // Get the username
	  $.ajax({
		  type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
		  url: '/api-sessions/set_current_game_data/', // the url where we want to POST
		  data: data, // our data object
		  dataType: 'json', // what type of data do we expect back from the server
		  encode: true
	  })// using the done promise callback
	.done(function (data) {
		// Nothing to do
	}); 
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
			console.log(token);
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
		var u_id;
		var nodeId;
		console.log(connection);

		if (connection.nickName) { // Appending local video data
			clientData = connection.nickName;
			serverData = connection.score;
			u_id = connection.u_id;
	
			nodeId = 'main-videodata';
		} else {
			clientData = JSON.parse(connection.data.split('%/%')[0]).clientData;
			serverData = JSON.parse(connection.data.split('%/%')[1]).serverData;
			u_id = JSON.parse(connection.data.split('%/%')[0]).u_id;
			nodeId = connection.connectionId;
		}

		var dataNode = document.createElement('div');
		dataNode.className = "data-node";
		dataNode.id = "data-" + nodeId;
		nodeCode = "";
		nodeCode += "<p class='nickName'>" + clientData + "</p><p class='userName' id='user_score_"+ u_id +"'>" + serverData + "</p><br>";
		nodeCode += "<button class='btn bg_dark_blue game_btn' onclick='mute_user("+u_id+")'>Mute</button>";
		nodeCode += "<button class='btn bg_dark_blue game_btn' onclick='unmute_user("+u_id+")'>Unmute</button>";
		nodeCode += "<button class='btn bg_dark_blue game_btn' onclick='talk_access("+u_id+")'>Role</button>";
		dataNode.innerHTML = nodeCode;
		videoElement.parentNode.insertBefore(dataNode, videoElement.nextSibling);
		//addClickListener(videoElement, clientData, serverData);
	
		if(!isNaN(u_id))
			$("#players").append("<option user_id='"+u_id+"'>"+clientData+"</option>");	
}


function initMainVideo(videoElement, userData) {
	//$('#main-video video').get(0).srcObject = videoElement.srcObject;
	//console.log(videoElement);
	//$('#main-video video').prop('muted', true);
	$('#main-video').get(0).append(videoElement);
}

function send_score() {
	session.signal({
		data: '',  // Any string (optional)
		to: [],                     // Array of Connection objects (optional. Broadcast to everyone if empty)
		type: 'update-score'             // The type of message (optional)
	  })
	  .then(() => {
		  console.log('Message successfully sent');
	  })
	  .catch(error => {
		  console.error(error);
	  });
}

function update_scores() {
	// get session from url
	var url = $(location).attr('href');
	var parts = url.split("/");
	if(parts[parts.length-1] == "") {
		game_session = parts[parts.length-2];

	} else {
		game_session = parts[parts.length-1];
	}

	data = {
		"game_session": game_session,
	}

	// Get the username
	$.ajax({
		type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
		url         : '/api-sessions/get_users_score/', // the url where we want to POST
		data        : data, // our data object
		dataType    : 'json', // what type of data do we expect back from the server
		encode          : true
	})// using the done promise callback
	.done(function(data) {
		for(var i =0; i<data.scores.length;i++) {
			$("#user_score_"+data.scores[i].user_id).html(data.scores[i].score);
			console.log("#user_score_"+data.scores[i].user_id + data.scores[i].score);
		}
	});
}

function set_score(op) {

	// get session from url
	var url = $(location).attr('href');
	var parts = url.split("/");
	if(parts[parts.length-1] == "") {
		game_session = parts[parts.length-2];

	} else {
		game_session = parts[parts.length-1];
	}

	if(!$("#score").val()) {
		score = $("#scores").children("option:selected").val();
	} else {
		score = $("#score").val();
	}

	console.log("VALUE IS " + score);

	if(op=="sub") {
		score = score*-1;
	}

	user_id = $("#players").children("option:selected").attr("user_id");
	console.log("USERID: "+user_id);
	data = {
		"game_session": game_session,
		"score": score,
		"user_id": user_id
	}
	console.log(data);
	// Get the username
	$.ajax({
		type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
		url         : '/api-sessions/set_user_score/', // the url where we want to POST
		data        : data, // our data object
		dataType    : 'json', // what type of data do we expect back from the server
		encode          : true
	})
	// using the done promise callback
	.done(function(data) {

		// To tell participants that there is a change in scores
		send_score();

		// To update local scores
		update_scores();
	});

}

function lock_buzzers() {
	session.signal({
		data: '',  // Any string (optional)
		to: [],                     // Array of Connection objects (optional. Broadcast to everyone if empty)
		type: 'lock-buzzer'             // The type of message (optional)
	  })
	  .then(() => {
		  console.log('Message successfully sent');
	  })
	  .catch(error => {
		  console.error(error);
	  });
}

function unlock_buzzers() {
	session.signal({
		data: '',  // Any string (optional)
		to: [],                     // Array of Connection objects (optional. Broadcast to everyone if empty)
		type: 'unlock-buzzer'             // The type of message (optional)
	  })
	  .then(() => {
		  console.log('Message successfully sent');
	  })
	  .catch(error => {
		  console.error(error);
	  });
}

function mute_user(id) {
	session.signal({
		data: id,  // Any string (optional)
		to: [],                     // Array of Connection objects (optional. Broadcast to everyone if empty)
		type: 'mute'             // The type of message (optional)
	  })
	  .then(() => {
		  console.log('Message successfully sent for' + id);
	  })
	  .catch(error => {
		  console.error(error);
	  });
}

function unmute_user(tp) {
	session.signal({
		data: id,  // Any string (optional)
		to: [],                     // Array of Connection objects (optional. Broadcast to everyone if empty)
		type: 'unmute'             // The type of message (optional)
	  })
	  .then(() => {
		  console.log('Message successfully sent for ' + id);
	  })
	  .catch(error => {
		  console.error(error);
	  });
}

function talk_access(id) {
	console.log("Buzzer for: " + id);
	session.signal({
		data: id,  // Any string (optional)
		to: [],                     // Array of Connection objects (optional. Broadcast to everyone if empty)
		type: 'role'             // The type of message (optional)
	  })
	  .then(() => {
		  console.log('Message successfully sent');
	  })
	  .catch(error => {
		  console.error(error);
	  });

}
