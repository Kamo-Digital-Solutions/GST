$(function() {
	var game_data = "";
	get_Game_Data();
});

function show_question($cat, $que) {
	$( "#q"+ $cat.toString() + $que.toString()).html("-");
	console.log($cat + " " + $que);
	console.log(game_data[$cat].questions[$que-1].question);
	console.log(game_data[$cat].questions[$que-1].answer);
	$( ".jeopardy_boxes" ).hide();
	$( ".jeopardy_question" ).show();
	$( ".jeopardy_question" ).addClass("question_class");
	$( ".jeopardy_question" ).append("<button class='jeopardy_button' onclick='show_answer("+$cat+","+$que+")'>"+game_data[$cat].questions[$que-1].question+"</button>");
}

function show_answer($cat, $que) {
	$(".jeopardy_button").remove();
	$( ".jeopardy_question" ).hide();
	$( ".jeopardy_answer" ).show();
	$( ".jeopardy_answer" ).addClass("question_class");
	$( ".jeopardy_answer" ).append("<button class='jeopardy_button' onclick='back_to_game()'>"+game_data[$cat].questions[$que-1].answer+"</button>");
}

function back_to_game() {
	$(".jeopardy_button").remove();
	$( ".jeopardy_answer" ).hide();
	$( ".jeopardy_boxes" ).show();
}


function get_Game_Data() {

	var formData = {
		'game_session_id': 1
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
		// log data to the console so we can see
		game_data = JSON.parse(data.result[0].data);

		// to add header
		$( ".jeopardy_boxes" ).append("<div class='row' id='jeopardy_header'></div>");


		for(var i = 1; i<6; i++) {
			console.log(game_data[i].category);
			$( ".jeopardy_boxes #jeopardy_header" ).append('<div class="col jeopardy_box text-center">'+game_data[i].category+'</div>');
			console.log(game_data[i].questions);
		}

		for(var i =1; i<6; i++) {
			$( ".jeopardy_boxes" ).append("<div class='row' id='jeopardy_box"+i+"'></div>");

			for(var j=0; j<5; j++) {
				$( ".jeopardy_boxes #jeopardy_box"+i).append('<button class="col jeopardy_box text-center" onclick="show_question('+(j+1).toString()+ ','+ i.toString() +')" id="q'+(j+1).toString()+i.toString()+'">'+game_data[i].questions[i-1].points+'</button>');
			}

		}
	});
}
