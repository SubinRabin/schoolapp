// $(document).ready(function() {
// 	$("#AdminLoginFormBtn").click(function() {
// 		$.ajax({
//           dataType: "json",
//           // type: 'POST',
//           url: 'AdminLogin',
//           data: $('#AdminLoginForm').serialize(),
//           success: function (response) {
//           	if (response.status=="false") {
//       			addToast(response.msg,"red");
//           	} else {
//           		window.location = 'dashboard'
//           	}
//           },
//            error: function (xhr,status,error) {
//              alert("Error: " + error);
//           }
//         });
// 	});
// })