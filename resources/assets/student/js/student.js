$(document).ready(function() {
	$("#studentSubmitBtn").click(function() {
      	var Name = $("#Name").val();
      	var parentName = $("#parentName").val();
      	var Email = $("#Email").val();
      	var number = $("#number").val();
      	var changeapass = $("#changeapass").val();
      	var Password = $("#Password").val();
		var CPassword = $("#CPassword").val();
      	if(changeapass==undefined || $("#changeapass").is(':checked')) {
      		if (Name=="") {
	      		addToast("Name field is required!","orange");
	      		$("#Name").focus();
	      	} else if(parentName=="") {
	      		addToast("Parent name field is required!","orange");
	      		$("#parentName").focus();
	      	} else if(Email=="") {
	      		addToast("Email field is required!","orange");
	      		$("#Email").focus();
	      	} else if(number=="") {
	      		addToast("Mobile number field is required!","orange");
	      		$("#number").focus();
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
	      		addToast("updated successfully","green");
	      		$("#studentSubmitForm").submit();
	      	}
      	} else {
      		if (Name=="") {
	      		addToast("Name field is required!","orange");
	      		$("#Name").focus();
	      	} else if(parentName=="") {
	      		addToast("Parent name field is required!","orange");
	      		$("#parentName").focus();
      		} else if(Email=="") {
	      		addToast("Email field is required!","orange");
	      		$("#Email").focus();
	      	} else if(number=="") {
	      		addToast("Mobile number field is required!","orange");
	      		$("#number").focus();
	      	}  else {
	      		addToast("updated successfully","green");
	      		$("#studentSubmitForm").submit();
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
});
