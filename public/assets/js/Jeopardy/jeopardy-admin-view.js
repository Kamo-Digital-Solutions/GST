var s_id = get_session_id();

$(function() {
	var game_data = "";

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
		// Check if there is data in the DB (Saved Data)
		if(data.code) {
			update_admin_game(data.code);
		} else {
			// New game
			get_Game_Data();
		} 
		get_teams();
	});
});


function reset_game_data() {
	dashboard_array = [];
	current_state = "table";
	data_state = "";
	current_teams = [];
	$(".jeopardy_boxes").empty();
	$(".jeopardy_question").empty();
	$(".jeopardy_answer").empty();
	get_Game_Data();
	update_game_users(); // from room-admin.js
}

function show_question($cat, $que, $sd) {
	$( "#q"+ $cat.toString() + $que.toString()).html("-");

	current_state = "question";
	console.log("CAT ", $cat, "QUE ", $que);
	console.log("DD:", game_data);

	data_state  = game_data[$cat].questions[$que-$sd].question;
	

	dashboard_array[(($que-$sd +1)*5) + ($cat-$sd)] = '-'; 

	$( ".jeopardy_boxes" ).hide();
	$( ".jeopardy_question" ).show();
	$( ".jeopardy_question" ).addClass("question_class");
	$( ".jeopardy_question" ).append("<button class='jeopardy_button' onclick='show_answer(" + $cat + "," + $que + "," + $sd + ")'>"+game_data[$cat].questions[$que-$sd].question+"</button>");
	update_game_users(); // from room-admin.js
}

function show_answer($cat, $que, $sd) {

	current_state = "answer";
	data_state  = game_data[$cat].questions[$que-$sd].answer;

	$(".jeopardy_button").remove();
	$( ".jeopardy_question" ).hide();
	$( ".jeopardy_answer" ).show();
	$( ".jeopardy_answer" ).addClass("question_class");
	$( ".jeopardy_answer" ).append("<button class='jeopardy_button' onclick='back_to_game()'>"+game_data[$cat].questions[$que-$sd].answer+"</button>");
	update_game_users(); // from room-admin.js
}

function back_to_game() {
	
	current_state = "table";
	$(".jeopardy_button").remove();
	$( ".jeopardy_answer" ).hide();
	$( ".jeopardy_boxes" ).show();
	update_game_users(); // from room-admin.js
}

// To clear the dashboard before use it

function clear_dashboard() {
	$("#main_game").empty();
	$("#main_game").append('<div class="jeopardy"><div class="jeopardy_boxes"></div><div class="jeopardy_question"></div><div class="jeopardy_answer"></div></div>');

		
	$(".jeopardy_button").remove();
	$( ".jeopardy_answer" ).hide();
	$( ".jeopardy_boxes" ).show();
}

// To play double Jeopardy

function double_jeopardy() {
	clear_dashboard();
	get_Game_Data(6,11);
	update_game_users(); // from room-admin.js
}


// To play Final Jeopardy
function final_jeopardy() {
	clear_dashboard();
	get_Game_Data(0,1);
	update_game_users(); // from room-admin.js
}

function get_Game_Data(start_data = 1, end_data = 6) {

	var formData = {
		'game_session_id': s_id
	};
	
	$.ajax({
		type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
		url         : '/adminroom/get_game_session_data/', // the url where we want to POST
		data        : formData, // our data object
		dataType    : 'json', // what type of data do we expect back from the server
		encode          : true
	})
	// using the done promise callback
	.done(function(data) {
		
		start_data_j = start_data;

		game_data = JSON.parse(data.result[0].data);

		// to add header
		$( ".jeopardy_boxes" ).append("<div class='row' id='jeopardy_header'></div>");
		
		dashboard_array = [];

		for(var i = start_data; i<end_data; i++) {
			$( ".jeopardy_boxes #jeopardy_header" ).append('<div class="col jeopardy_box text-center">'+game_data[i].category+'</div>');
			dashboard_array.push(game_data[i].category)
		}

		for(var i =start_data; i<end_data; i++) {
			$( ".jeopardy_boxes" ).append("<div class='row' id='jeopardy_box"+i+"'></div>");

			for(var j=0; j<end_data-start_data; j++) {
				$( ".jeopardy_boxes #jeopardy_box"+i).append('<button class="col jeopardy_box text-center" onclick="show_question('+(j+start_data).toString()+ ','+ i.toString() + ',' + start_data +')" id="q'+(j+start_data).toString()+i.toString()+'">'+game_data[i].questions[i-start_data].points+'</button>');
				dashboard_array.push(game_data[i].questions[i-start_data].points);
			}

		}
		update_game_users(); // from room-admin.js
	});
}

function update_admin_game(data) {

	/////// Get Game Data: Questions, Answers ...
	var formData = {
		'game_session_id': s_id
	};

	$.ajax({
		type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
		url         : '/adminroom/get_game_session_data/', // the url where we want to POST
		data        : formData, // our data object
		dataType    : 'json', // what type of data do we expect back from the server
		encode          : true
	})
	// using the done promise callback
	.done(function(data) {
		game_data = JSON.parse(data.result[0].data);
	});

	////// Update Global variables

	dashboard_array = JSON.parse(data).game_dashboard;
	current_state = JSON.parse(data).current_state;
	data_state = JSON.parse(data).data_state;
	start_data_j = JSON.parse(data).start_data_j;

	///// End of Updating Global variables

	////// End of getting data


	////// We will use here the data from data variable, to set the current data

	$("#main_game").empty();
	$("#main_game").append('<div class="jeopardy"><div class="jeopardy_boxes"></div><div class="jeopardy_question"></div><div class="jeopardy_answer"></div></div>');

		
	$(".jeopardy_button").remove();
	$( ".jeopardy_answer" ).hide();
	$( ".jeopardy_boxes" ).show();

	$( ".jeopardy_boxes" ).append("<div class='row' id='jeopardy_header'></div>");

	console.log("GD ", JSON.parse(data).game_dashboard);
	// add headers
	for(var i = 0; i<5; i++) {
		$( ".jeopardy_boxes #jeopardy_header" ).append('<div class="col jeopardy_box text-center">' + JSON.parse(data).game_dashboard[i] + '</div>');
	}

	// add 
	for(var i =start_data_j; i<start_data_j+5; i++) {
		$( ".jeopardy_boxes" ).append("<div class='row' id='jeopardy_box"+i+"'></div>");

		for(var j=0; j<5; j++) {
			$( ".jeopardy_boxes #jeopardy_box"+i).append('<button class="col jeopardy_box text-center" onclick="show_question('+(j+start_data_j).toString()+ ','+ i.toString() + ','+ start_data_j + ')" id="q'+(j+start_data_j).toString()+i.toString()+'">' + JSON.parse(data).game_dashboard[((i-start_data_j+1)*5)+j] + '</button>');
		}
	}
}