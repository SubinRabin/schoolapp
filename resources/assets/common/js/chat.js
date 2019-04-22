function retrieveTypingStatus()
{
    var username = $('#username').val();
    var receiverId = $('#receiverId').val();
    var type = $('#type').val();
    var role = $('#role').val();
    $.ajax({
          dataType: "json",
          // type: 'POST',
          url:  base_url+'student/retrieveTypingStatus?username='+username+'&receiverId='+receiverId+'&type='+type+'&role='+role,
          success: function (data) {
          	if (data['name'].length > 0) {
          		if (data['id']==username) {
          			// alert(data['id']);
          			// alert(username);
	            	$('#typingStatus').html(data['name']+' is typing');
          		} else {
	            	$('#typingStatus').html('');
          		}
	       }  else {
   	            $('#typingStatus').html('');
          }
    	}
    });
}

// function isTyping()
// {
//     retrieveTypingStatus();
// }

// function notTyping()
// {
//     $('#typingStatus').html('');
// }
