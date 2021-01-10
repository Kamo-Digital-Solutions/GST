function update_game(data) {

	current_teams = JSON.parse(data).current_teams;

	// Get team id
	if ((team_id == current_teams[0] || team_id == current_teams[1]) && !published) {
		republishing_session();
	} else if ((team_id != current_teams[0] && team_id != current_teams[1]) && published) {
		stop_publishing();
	}
	
	$("#game-dashboard").empty();
	$("#game-dashboard").append('<div class="jeopardy"><div class="jeopardy_boxes"></div><div class="jeopardy_question"></div><div class="jeopardy_answer"></div></div>');

	if(JSON.parse(data).current_state == "table") {
		
		$(".jeopardy_button").remove();
		$( ".jeopardy_answer" ).hide();
		$( ".jeopardy_boxes" ).show();

		$( ".jeopardy_boxes" ).append("<div class='row' id='jeopardy_header'></div>");

		// If it's Final Jeopardy, that's mean that we have just one cell in every row
		if(JSON.parse(data).game_dashboard[0] == "Final Jeopardy") {
			$( ".jeopardy_boxes #jeopardy_header" ).append('<div class="col jeopardy_box text-center">' + JSON.parse(data).game_dashboard[0] + '</div>');
			i = 1;
			j = 0;
			$( ".jeopardy_boxes" ).append("<div class='row' id='jeopardy_box"+i+"'></div>");
			$( ".jeopardy_boxes #jeopardy_box"+i).append('<button class="col jeopardy_box text-center">' + JSON.parse(data).game_dashboard[1] + '</button>');
		} else {
			// add headers
			for(var i = 0; i<5; i++) {
				$( ".jeopardy_boxes #jeopardy_header" ).append('<div class="col jeopardy_box text-center">' + JSON.parse(data).game_dashboard[i] + '</div>');
			}

			// add cells 
			for(var i =1; i<6; i++) {
				$( ".jeopardy_boxes" ).append("<div class='row' id='jeopardy_box"+i+"'></div>");

				for(var j=0; j<5; j++) {
					$( ".jeopardy_boxes #jeopardy_box"+i).append('<button class="col jeopardy_box text-center">' + JSON.parse(data).game_dashboard[(i*5)+j] + '</button>');
				}
			}

		}


		// add data
	} else if (JSON.parse(data).current_state == "question") {

		$( ".jeopardy_boxes" ).hide();
		$( ".jeopardy_question" ).show();
		$( ".jeopardy_question" ).addClass("question_class");
		$( ".jeopardy_question" ).append("<button class='jeopardy_button'>"+ JSON.parse(data).data_state +"</button>");
	
	} else if (JSON.parse(data).current_state == "answer") {
		$(".jeopardy_button").remove();
		$( ".jeopardy_question" ).hide();
		$( ".jeopardy_answer" ).show();
		$( ".jeopardy_answer" ).addClass("question_class");
		$( ".jeopardy_answer" ).append("<button class='jeopardy_button' onclick='back_to_game()'>" + JSON.parse(data).data_state + "</button>");	
	}
}