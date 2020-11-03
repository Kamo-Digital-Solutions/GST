
// On Buzzer click, start counting
$( "#buzzer" ).click(function() {
	var timer = 5;
	$( "#buzzer" ).prop('disabled', true);
	var x = setInterval(function() {
		$( "#timer" ).html(timer);
		timer--;
		if(timer <0) {
			clearInterval(x);
			$( "#buzzer" ).prop('disabled', false);
		}
	}, 1000);
});
