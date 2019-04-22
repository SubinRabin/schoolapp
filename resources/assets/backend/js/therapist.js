$(document).ready(function() {
	$("#therapistSubmitBtn").click(function() {
		var Username = $("#Username").val();
		var Name = $("#Name").val();
		var Email = $("#Email").val();
		var number = $("#number").val();
		var Qualification = $("#Qualification").val();
		var TherapyType = $("#TherapyType").val();
		var changeapass = $("#changeapass").val();
      	var Password = $("#Password").val();
		var CPassword = $("#CPassword").val();
		var checkstatusUname = $("#checkstatusUname").val();
      	if(changeapass==undefined || $("#changeapass").is(':checked')) {

	      	if (Name=="") {
	      		addToast("Name field is required!","orange");
	      		$("#Name").focus();
	      	} else if (Email=="") {
	      		addToast("Email field is required!","orange");
	      		$("#Email").focus();
	      	} else if (number=="") {
	      		addToast("Mobile number field is required!","orange");
	      		$("#number").focus();
	      	// } else if (Qualification=="") {
	      	// 	addToast("Qualification field is required!","orange");
	      	// 	$("#Qualification").focus();
	      	}  else if (TherapyType=="") {
	      		addToast("Therapy type field is required!","orange");
	      		$("#TherapyType").focus();
      		} else if(Password=="") {
	      		addToast("Password field is required!","orange");
	      		$("#Password").focus();
	      	} else if(CPassword=="") {
	      		addToast("Confirm password field is required!","orange");
	      		$("#CPassword").focus();
	      	} else if(Password!=CPassword) {
	      		addToast("Must be same password and Confirm Password","orange");
	      		$("#CPassword").focus();
	      	} else {
	      		if (checkstatusUname!=0) {
	                addToast("Login Name is already exist","red");
	                $("#Username").focus();
              	} else {
		      		$("#therapistSubmitBtn").attr('disabled',true);
		      		therapySubmitBtnFun();
	      		}
	      	}
      	} else {
      		if (Name=="") {
	      		addToast("Name field is required!","orange");
	      		$("#Name").focus();
	      	} else if (Email=="") {
	      		addToast("Email field is required!","orange");
	      		$("#Email").focus();
	      	} else if (number=="") {
	      		addToast("Mobile number field is required!","orange");
	      		$("#number").focus();
	      	} else if (Qualification=="") {
	      		addToast("Qualification field is required!","orange");
	      		$("#Qualification").focus();
	      	}  else if (TherapyType=="") {
	      		addToast("Therapy type field is required!","orange");
	      		$("#TherapyType").focus();
	      	} else {
	      		if (checkstatusUname!=0) {
	                addToast("Login Name is already exist","red");
	                $("#Username").focus();
              	} else {
		      		$("#therapistSubmitBtn").attr('disabled',true);
		      		therapySubmitBtnFun();
	      		}
	      	}
      	}
	});

	$("#changeapass").change(function() {
		if ($("#changeapass").is(':checked')==true) {
			$("#Password").removeAttr('disabled');
			$("#CPassword").removeAttr('disabled');
		} else {
			$("#Password").attr('disabled','disabled');
			$("#CPassword").attr('disabled','disabled');
		}
	});

	$("#Username").on('keyup' , function() {
    	$.ajax({
          dataType: "json",
          // type: 'POST',
          url: 'TherapistExistingStudentUsernameCheck',
          data: $('#therapistSubmitForm').serialize(),
          success: function (response) {
            $("#checkstatusUname").val(response);
            if (response!=0) {
              $("#Username").css('border','1px solid red');
            } else {
              $("#Username").css('border','1px solid #eee');
            }
          }
        });
  	});

});


function therapistSubmitModalfun(id) {
    $("#myModal").load('../backend/therapistSubmitModal?id='+id);
	$("#myModal").modal({
       backdrop: 'static',
        keyboard: false
    });
}
function therapySubmitBtnFun() {
	var id= $("#id").val();
	if (id=="") {
		addToast("Inserted succefully","green");
	} else {
		addToast("Updated succefully","green");
	}
	$('#therapistSubmitForm').attr('action','therapySubmitBtnFun');
	$('#therapistSubmitForm').submit();
	// $.ajax({
 //          dataType: "json",
 //          // type: 'POST',
 //          url: 'therapySubmitBtnFun',
 //          data: $('#therapistSubmitForm').serialize(),
 //          success: function (response) {
 //          	if (response.status=="true") {
 //          		$(".close").trigger('click');
 //      			addToast(response.msg,"green");
 //      			window.location.reload();
 //          	}
 //          },
 //           error: function (xhr,status,error) {
 //             alert("Error: " + error);
 //          }
 //        });
}
function therapistDeleteModalfun(id,flag) {
	if (flag==1) {
		var msg = 'Do you want active this therapist?'
	} else {
		var msg = 'Do you want Inactive this therapist?'
	}
	if(confirm(msg)) {
		$.ajax({
          dataType: "json",
          // type: 'POST',
          url: 'therapistDeleteBtnFun?id='+id+'&flag='+flag,
          success: function (response) {
          	if (response.status=="true") {
      			addToast(response.msg,"green");
      			window.location.reload();
          	}
          },
           error: function (xhr,status,error) {
             alert("Error: " + error);
          }
        });
	} 
}