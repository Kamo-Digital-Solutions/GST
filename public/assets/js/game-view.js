function update_game(data) {
	$("#game-dashboard").empty();
	$("#game-dashboard").append('<div class="jeopardy"><div class="jeopardy_boxes"></div><div class="jeopardy_question"></div><div class="jeopardy_answer"></div></div>');

	if(JSON.parse(data).current_state == "table") {
		
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
				$( ".jeopardy_boxes #jeopardy_box"+i).append('<button class="col jeopardy_box text-center">' + JSON.parse(data).game_dashboard[(i*5)+j] + '</button>');
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