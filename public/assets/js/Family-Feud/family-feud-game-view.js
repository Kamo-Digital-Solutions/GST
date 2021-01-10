var actual_score = 0;

Object.size = function(obj) {
    var size = 0, key;
    for (key in obj) {
        if (obj.hasOwnProperty(key)) size++;
    }
    return size;
};

function update_score() {
	$("#actual_score").html(actual_score);
}


function update_game(data) {
    actual_score = 0;
    update_score();
    current_teams = JSON.parse(data).current_teams;
    $("#question_family").html(JSON.parse(data).current_state);
    $("#team1_score").html(JSON.parse(data).data_state[current_teams[0]]);
    $("#team2_score").html(JSON.parse(data).data_state[current_teams[1]]);

    // Check if he need to connect/disconnect

    // Get team id
    if ((team_id == current_teams[0] || team_id == current_teams[1]) && !published) {
        republishing_session();
    } else if ((team_id != current_teams[0] && team_id != current_teams[1]) && published) {
        stop_publishing();
    }

    $("#answers_dashboard_1").html("");
    $("#answers_dashboard_2").html("");
    
    ans_l = Object.size(JSON.parse(JSON.parse(data).game_dashboard));
    
    // Divide into two groups
	half = ans_l/2;
	half = half | 0; // to make it integer (It was double).

    // If it's odd add 1 to the half.
	if(ans_l % 2 != 0) {
		half++;
	}

    // Add answers divs
	for(var j = 0; j<half; j++) {
        
        $("#answers_dashboard_1").append('<div class="cardHolder"><div class="answer_card" id="answer_' + j + '"><div class="front"><span>' + (j+1) + '</span></div></div></div>');

        if(JSON.parse(JSON.parse(data).game_dashboard)[j] != "") {
            id = j;
            answer = JSON.parse(JSON.parse(data).game_dashboard)[j][0];
            pts = JSON.parse(JSON.parse(data).game_dashboard)[j][1];
            $("#answer_"+id).html('<div class="back"><span>' + answer + '</span> <b class="answer_pts">' + pts + '</b></div>');
            actual_score += pts;
    		update_score();	
        }
	}

	for(var j = half; j<ans_l; j++) {

        $("#answers_dashboard_2").append('<div class="cardHolder"><div class="answer_card" id="answer_' + j + '"><div class="front"><span>' + (j+1) + '</span></div></div></div>');

        if(JSON.parse(JSON.parse(data).game_dashboard)[j] != "") {
            id = j;
            answer = JSON.parse(JSON.parse(data).game_dashboard)[j][0];
            pts = JSON.parse(JSON.parse(data).game_dashboard)[j][1];
            $("#answer_"+id).html('<div class="back"><span>' + answer + '</span> <b class="answer_pts">' + pts + '</b></div>');
            actual_score += pts;
    		update_score();	
        }
	}

	// add empty box if needed (if it's odd)
	if(ans_l % 2 != 0) {
		$("#answers_dashboard_2").append('<div class="cardHolder"><div class="answer_card"></div></div>');
	}

}