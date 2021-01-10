var game_data = "";
var question_id = -1;
var actual_score = 0;
var g_d = {};

$(function() {
	get_game_data();
});

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


function show_answer(id) {
	answer = Object.values(game_data)[question_id][id][0];
	pts = Object.values(game_data)[question_id][id][1];
	if($("#answer_"+id+" .back").length == 0) {
		$("#answer_"+id).html('<div class="back"><span>' + answer + '</span> <b class="answer_pts">' + pts + '</b></div>');
		actual_score += pts;
		update_score();	
	}

	// Send data to the client and save it to the ser
	g_d[id] = [answer, pts];
	dashboard_array = JSON.stringify(g_d);

	update_game_users(); // from room-admin.js
}

function award_team(team_id) {

	data_state[current_teams[team_id]] += actual_score;
	console.log("TEST: ", data_state);
	update_game_users(); // from room-admin.js
	$("#team" + (team_id+1) + "_score").html(data_state[current_teams[team_id]]);
}

function update_score() {
	$("#actual_score").html(actual_score);
}

function next_question() {
	// init
	question_id++;
	actual_score = 0;
	g_d = {};
	update_score();
	$("#question_family").html(Object.keys(game_data)[question_id]);
	current_state = Object.keys(game_data)[question_id];
	$("#answers_dashboard_1").html("");
	$("#answers_dashboard_2").html("");
	ans_l = Object.values(game_data)[question_id].length;

	// Divide into two groups
	half = ans_l/2;
	half = half | 0; // to make it integer (It was double).

	// If it's odd add 1 to the half.
	if(ans_l % 2 != 0) {
		half++;
	}

	// Empty the solution list first
	$("#solutions ol").html("");

	// Add answers divs
	for(var j = 0; j<half; j++) {
		$("#answers_dashboard_1").append('<div class="cardHolder" onclick="show_answer(' + j + ')"><div class="answer_card" id="answer_' + j + '"><div class="front"><span>' + (j+1) + '</span></div></div></div>');
	
		// add to dashboard_array, to send it later to the user
		g_d[j] = [];
		
		// Add solution for the host
		$("#solutions ol").append("<li>" + Object.values(game_data)[question_id][j][0] + "</li>");
	}

	for(var j = half; j<Object.values(game_data)[question_id].length; j++) {
		$("#answers_dashboard_2").append('<div class="cardHolder" onclick="show_answer(' + j + ')"><div class="answer_card" id="answer_' + j + '"><div class="front"><span>' + (j+1) + '</span></div></div></div>');

		g_d[j] = [];
		// Add solution for the host
		$("#solutions ol").append("<li>" + Object.values(game_data)[question_id][j][0] + "</li>");
	}

	// add empty box if needed (if it's odd)
	if(ans_l % 2 != 0) {
		$("#answers_dashboard_2").append('<div class="cardHolder"><div class="answer_card"></div></div>');
	}

	dashboard_array = JSON.stringify(g_d);
	//update_game_users(); // from room-admin.js
}

function get_game_data() {


	// Getting current game data
	dataSend = {
		"game_session": get_session_id(),
	}

	$.ajax({
		type: 'GET', // define the type of HTTP verb we want to use (POST for our form)
		url: '/api-sessions/get_current_game_data/', // the url where we want to POST
		data: dataSend, // our data object
		dataType: 'json', // what type of data do we expect back from the server
		encode: true
	})// using the done promise callback
	.done(function (data) {
		// Get Current state or init one
		
		if(data.code) {
			current_teams = JSON.parse(data.code).current_teams;
			
			data_state = JSON.parse(data.code).data_state;
		} else {
			// Hardcoded
			current_teams = [1, 2];
			// End of Hardcoded
			data_state = {};
			data_state[current_teams[0]] = 0;
			data_state[current_teams[1]] = 0;
		}

		$("#team" + current_teams[0] + "_score").html(data_state[current_teams[0]]);
		$("#team" + current_teams[1] + "_score").html(data_state[current_teams[1]]);
	});

	////// Getting Game data: Question ... 

	var formData = {
		'game_session_id': get_session_id()
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
		question_id = -1;
		next_question();
	});
}