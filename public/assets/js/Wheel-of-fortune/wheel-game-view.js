function div(parent, className) {
    var r = document.createElement('div');
    r.className = className;
    parent.appendChild(r);
    return r;
}



function update_game(data) {

    current_teams = JSON.parse(data).current_teams;
	// Get team id
	if ((team_id == current_teams[0] || team_id == current_teams[1]) && !published) {
		republishing_session();
	} else if ((team_id != current_teams[0] && team_id != current_teams[1]) && published) {
		stop_publishing();
	}

    var display = document.getElementById('display'),
      characters;

    puzzle = JSON.parse(data).current_state;

    characters = [];
    while (display.hasChildNodes()) { //remove old puzzle
        display.removeChild(display.firstChild);
    }
    var word = div(display, 'word');
    for (var i = 0; i < puzzle.length; ++i) {
        if (puzzle[i] == ' ') {
            characters.push(div(display, 'space'));
            word = div(display, 'word');
        } else {
            characters.push(div(word, 'letter'));
            
        }
        console.log(i, puzzle[i], word.children, characters.length);
    }
    div(display, 'clear');

    for(var i = 0; i<puzzle.length; i++) {
        if(puzzle[i] != '*') {
            characters[i].innerHTML = puzzle[i];
        }
    }

    // Update the wheel
    degrees = JSON.parse(data).data_state;
    var wheel = document.getElementById('wheel');

    prefix = (function () {
        if (document.body.style.MozTransform !== undefined) {
            return "MozTransform";
        } else if (document.body.style.WebkitTransform !== undefined) {
            return "WebkitTransform";
        } else if (document.body.style.OTransform !== undefined) {
            return "OTransform";
        } else {
            return "";
        }
    }()),
    
    degreeToRadian = function (deg) {
        return deg / (Math.PI * 180);
    };

    var val = "rotate(-" + degrees + "deg)";
    if (wheel.style[prefix] !== undefined) wheel.style[prefix] = val;
    var rad = degreeToRadian(degrees % 360),
        filter = "progid:DXImageTransform.Microsoft.Matrix(sizingMethod='auto expand', M11=" + rad + ", M12=-" + rad + ", M21=" + rad + ", M22=" + rad + ")";
    if (wheel.style.filter !== undefined) wheel.style.filter = filter;
    wheel.setAttribute("data-rotation", degrees);

}