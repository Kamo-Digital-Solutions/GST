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
	

		session.connect(token, { clientData: nickName, u_id: userid, role: "host" })
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
				// When our HTML video has been added to DOM...
				publisher.on('videoElementCreated', (event) => {
					// Init the main video with ours and append our data
					var userData = {
						nickName: nickName,
						score: score,
						u_id: userid,
						role: "host"
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
			console.log(event.data); // Message
			console.log(event.from); // Connection object of the sender
			console.log(event.type); // The type of message
		});
	});

	return false;
}


function createGameStream() {

	getToken((token) => {
		var OV = new OpenVidu();
		var FRAME_RATE = 10;
		session = OV.initSession();

		session.connect(token, {})
		.then(()=> {

			var canvas = document.getElementById("canvas");
			var ctx = canvas.getContext("2d");
			var data = "<svg xmlns='http://www.w3.org/2000/svg' width='200' height='200'>" +
						 "<foreignObject width='100%' height='100%'>" +
						   "<div xmlns='http://www.w3.org/1999/xhtml' style='font-size:20px'>" +
							  "<table border='15'><tr><td>row 1, cell 1</td><td>row 1, cell 2</td></tr><tr><td>row 2, cell 1</td><td>row 2, cell 2</td></tr></table>" +
						   "</div>" +
						 "</foreignObject>" +
					   "</svg>";
			var DOMURL = self.URL || self.webkitURL || self;
			var img = new Image();
			var svg = new Blob([data], {type: "image/svg+xml;charset=utf-8"});
			var url = DOMURL.createObjectURL(svg);
			img.onload = function() {
				ctx.drawImage(img, 0, 0);
				DOMURL.revokeObjectURL(url);
			};
			img.src = url;
			

			OV.getUserMedia({
				audioSource: false,
				videoSource: undefined,
				resolution: '1280x720',
				frameRate: FRAME_RATE
			 })
			 .then(mediaStream => {
			 
				//var videoTrack = mediaStream.getVideoTracks()[0];
				//var video = document.createElement('video');
				//video.srcObject = canvas.captureStream();
			 
				//var canvas = document.createElement('canvas');
				//var ctx = canvas.getContext('2d');
				//ctx.filter = 'grayscale(100%)';
			 
				/*
				video.addEventListener('play', () => {
				  var loop = () => {
					//if (!video.paused && !video.ended) {
						//ctx.clearRect(0, 0, canvas.width, canvas.height);
					  	ctx.drawImage(canvas, 0, 0, 300, 170);
					  setTimeout(loop, 1000/ FRAME_RATE); // Drawing at 10 fps
					//}
				  };
				  loop();
				});
				video.play();
				*/

				/*
				setInterval(function(){
					ctx.beginPath();
					ctx.clearRect(0, 0, canvas.width, canvas.height);
					ctx.drawImage(canvas, 0, 0, 300, 170);
				}, 3000);
				*/
				var grayVideoTrack = canvas.captureStream(FRAME_RATE).getVideoTracks()[0];
				
				var publisher = this.OV.initPublisher(
				'testcanva',
				{
					audioSource: false,
					videoSource: grayVideoTrack
				});

				  session.publish(publisher);

			 });


		}) ;

	});
	return false;
}
