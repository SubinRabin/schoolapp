var base_url = '';
var username;

$(document).ready(function()
{
    username = $('#username').val();
    $('.conversation-list').scrollTo('100%', '100%', {
        easing: 'swing'
    });
    allChat();
    pullData();
    $(document).keyup(function(e) {
        if (e.keyCode == 13)
            sendMessage();
        else
            isTyping();
    });
    $(".chat-send-btn").click(function() {
        sendMessage();
    });
    
});

function pullData()
{
    retrieveChatMessages();
    // retrieveTypingStatus();
    setTimeout(pullData,3000);

}
function allChat() {
    var receiverId = $("#receiverId").val();
    var type = $("#type").val();
    $.ajax({
      dataType: "json",
      // type: 'POST',
      url:  base_url+'allChatMessages?receiverId='+receiverId+'&type='+type,
      success: function (data) {
        if (data.length > 0) {
            $('#chat-window').html(data);
            $('.conversation-list').scrollTo('100%', '100%', {
                easing: 'swing'
            });
        }
      }
    });
}
function retrieveChatMessages()
{   
    var receiverId = $("#receiverId").val();
    var type = $("#type").val();
    
    $.ajax({
          dataType: "json",
          // type: 'POST',
          url:  base_url+'retrieveChatMessages?receiverId='+receiverId+'&type='+type,
          success: function (data) {
            if (data.length > 0) {
                var audio = new Audio(base_url+'../resources/assets/chat.mp3');
                audio.play();
                $('#chat-window').append(data);
                $('.conversation-list').scrollTo('100%', '100%', {
                    easing: 'swing'
                });
            }
          }
        });
}


function sendMessage()
{
    var text = $('#text').val();
    $('#text').val('');
    $('#text').focus();
    $('.conversation-list').scrollTo('100%', '100%', {
        easing: 'swing'
    });

    var receiverId = $('#receiverId').val();
    var type = $('#type').val();
    if (text.length > 0)
    {
        $.ajax({
              dataType: "json",
              // type: 'POST',
              url:  base_url+'sendMessage?text='+text+'&receiverId='+receiverId+'&type='+type,
              success: function (data) {
                if (data.length > 0) {
                    $('#chat-window').append(data);
                    // $('#text').focus();
                    $('.conversation-list').scrollTo('100%', '100%', {
                        easing: 'swing'
                    });
                }
              }
        });
    }
    
}

function isTyping() {
  
}