var teams = [];
var teams_ids = [];

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
    get_teams();

	data = {
		"game_session": get_session_id(),
	}

	// Get data
	$.ajax({
		type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
		url         : '/api-sessions/get_teams_data/', // the url where we want to POST
		data        : data, // our data object
		dataType    : 'json', // what type of data do we expect back from the server
		encode          : true
	})// using the done promise callback
	.done(function(data) {
		for(var i =0; i<data.data.length;i++) {
            ops = "<select name='user_team' id='user_team_"+ data.data[i].user_id +"' onchange='change_team(" + data.data[i].user_id + ")'>";
            
            for(var j =0; j<teams.length; j++) {
                if(teams[j] == data.data[i].team_name) {
                    ops += "<option value='"+ teams_ids[j] +"' selected>" + teams[j] + "</option>";
                } else {
                    ops += "<option value='"+ teams_ids[j] +"'>" + teams[j] + "</option>";
                }
            }
            
            ops += "</select>";
            $("#users_table").append("<tr><td>" + data.data[i].firstname + " " + data.data[i].lastname + "</td><td>" + ops + "</td></tr>");
            //$("#user_score_"+data.scores[i].user_id).html(data.scores[i].score);
			//console.log("#user_score_"+data.scores[i].user_id + data.scores[i].score);
		}
	});

});

function change_team(nbr) {
	console.log("USER ID: "+ nbr + " " + document.getElementById("user_team_"+nbr).value);

	data = {
		"game_session": get_session_id(),
		"user_id": nbr,
		"team_id": document.getElementById("user_team_"+nbr).value
	}

	// Get the username
	$.ajax({
		type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
		url         : '/api-sessions/update_user_team/', // the url where we want to POST
		data        : data, // our data object
		dataType    : 'json', // what type of data do we expect back from the server
		encode          : true
	})// using the done promise callback
	.done(function(data) {
		//Nothing to do
	});

}

// To add teams to teams and teams_ids arrays
function get_teams() {

	data = {
		"game_session": get_session_id(),
	}

	// Get the username
	$.ajax({
		type        : 'GET', // define the type of HTTP verb we want to use (POST for our form)
		url         : '/api-sessions/get_teams_name/', // the url where we want to POST
		data        : data, // our data object
		dataType    : 'json', // what type of data do we expect back from the server
		encode          : true
	})// using the done promise callback
	.done(function(data) {
		for(var i =0; i<data.data.length;i++) {
			teams.push(data.data[i].team_name);
			teams_ids.push(data.data[i].team_id);
        }
	});
}