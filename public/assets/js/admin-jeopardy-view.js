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
		} else { // New game
			get_Game_Data();
		} 
		
	});
});

function show_question($cat, $que) {
	$( "#q"+ $cat.toString() + $que.toString()).html("-");

	current_state = "question";
	data_state  = game_data[$cat].questions[$que-1].question;
	dashboard_array [($que*5) + ($cat-1)] = '-'; 

	$( ".jeopardy_boxes" ).hide();
	$( ".jeopardy_question" ).show();
	$( ".jeopardy_question" ).addClass("question_class");
	$( ".jeopardy_question" ).append("<button class='jeopardy_button' onclick='show_answer("+$cat+","+$que+")'>"+game_data[$cat].questions[$que-1].question+"</button>");
	update_game_users(); // from room-admin.js
}

function show_answer($cat, $que) {

	current_state = "answer";
	data_state  = game_data[$cat].questions[$que-1].answer;

	$(".jeopardy_button").remove();
	$( ".jeopardy_question" ).hide();
	$( ".jeopardy_answer" ).show();
	$( ".jeopardy_answer" ).addClass("question_class");
	$( ".jeopardy_answer" ).append("<button class='jeopardy_button' onclick='back_to_game()'>"+game_data[$cat].questions[$que-1].answer+"</button>");
	update_game_users(); // from room-admin.js
}

function back_to_game() {
	
	current_state = "table";
	$(".jeopardy_button").remove();
	$( ".jeopardy_answer" ).hide();
	$( ".jeopardy_boxes" ).show();
	update_game_users(); // from room-admin.js
}


function get_Game_Data() {

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

		// to add header
		$( ".jeopardy_boxes" ).append("<div class='row' id='jeopardy_header'></div>");
		

		for(var i = 1; i<6; i++) {
			$( ".jeopardy_boxes #jeopardy_header" ).append('<div class="col jeopardy_box text-center">'+game_data[i].category+'</div>');
			dashboard_array.push(game_data[i].category)
		}

		for(var i =1; i<6; i++) {
			$( ".jeopardy_boxes" ).append("<div class='row' id='jeopardy_box"+i+"'></div>");

			for(var j=0; j<5; j++) {
				$( ".jeopardy_boxes #jeopardy_box"+i).append('<button class="col jeopardy_box text-center" onclick="show_question('+(j+1).toString()+ ','+ i.toString() +')" id="q'+(j+1).toString()+i.toString()+'">'+game_data[i].questions[i-1].points+'</button>');
				dashboard_array.push(game_data[i].questions[i-1].points);
			}

		}
	});
}

function update_admin_game(data) {

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

	$("#main_game").empty();
	$("#main_game").append('<div class="jeopardy"><div class="jeopardy_boxes"></div><div class="jeopardy_question"></div><div class="jeopardy_answer"></div></div>');

		
	$(".jeopardy_button").remove();
	$( ".jeopardy_answer" ).hide();
	$( ".jeopardy_boxes" ).show();

	$( ".jeopardy_boxes" ).append("<div class='row' id='jeopardy_header'></div>");

	// add headers
	for(var i = 0; i<5; i++) {
		$( ".jeopardy_boxes #jeopardy_header" ).append('<div class="col jeopardy_box text-center">' + JSON.parse(data).game_dashboard[i] + '</div>');
	}

	// add 
	for(var i =1; i<6; i++) {
		$( ".jeopardy_boxes" ).append("<div class='row' id='jeopardy_box"+i+"'></div>");

		for(var j=0; j<5; j++) {
			$( ".jeopardy_boxes #jeopardy_box"+i).append('<button class="col jeopardy_box text-center" onclick="show_question('+(j+1).toString()+ ','+ i.toString() +')" id="q'+(j+1).toString()+i.toString()+'">' + JSON.parse(data).game_dashboard[(i*5)+j] + '</button>');
		}
	}
}