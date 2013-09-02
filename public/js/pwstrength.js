$(function(){
	// load password strength library
	$.getScript('/js/zxcvbn.js', function() {
		// dynamically add password-strength p tag
		if($('#password-strength').length == 0) {
			$('#password').after($('<p id="password-strength" class="hint"/>'));
		}
		
		// bind event to password text box
		$('#password').keyup(function() {
		  var textValue = $(this).val();
		  if(textValue.length < 4) {
			  $('#password-strength').html('');
			  return;
		  }
		  var result = zxcvbn(textValue);
		  var strengths = ['<span style="color:red">very weak - upper case characters and symbols can strengthen your password</span>', '<span style="color:#ff6666">weak</span>', '<span style="color:#aaaa00">average</span>', '<span style="color:#448844">strong</span>', '<span style="color:#00aa00">very strong</span>'];
		  $('#password-strength').html("Password strength: " + strengths[result.score]);
		
		});
	});
});
