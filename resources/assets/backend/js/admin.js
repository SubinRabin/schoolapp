
$(document).ready(function() {
	$("#adminSubmitBtn").click(function() {
      	var Name = $("#Name").val();
      	var Username = $("#Username").val();
      	var Email = $("#Email").val();
      	var number = $("#number").val();
      	var Role = $("#Role").val();
      	var changeapass = $("#changeapass").val();
      	var Password = $("#Password").val();
		var CPassword = $("#CPassword").val();
		var checkstatus = $("#checkstatus").val();
        var mailFormat = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
      	if(changeapass==undefined || $("#changeapass").is(':checked')) {
      		
      	 	if(Username=="") {
      	 		addToast("Username field is required!","orange");
	      		$("#Username").focus();
      	 	} else if (Name=="") {
	      		addToast("Name field is required!","orange");
	      		$("#Name").focus();
	      	} else if(Email=="") {
	      		addToast("Email field is required!","orange");
	      		$("#Email").focus();
      		} else if (mailFormat.test(Email) == false) {
	            addToast("Invalid mail format!","orange");
	            $("#Email").focus(); 
	      	} else if(number=="") {
	      		addToast("Mobile number field is required!","orange");
	      		$("#number").focus();
	      	} else if(Role=="") {
	      		addToast("Role field is required!","orange");
	      		$("#Role").focus();
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
	      		if (checkstatus==0) {
	      			$("#adminSubmitBtn").attr('disabled',true);
	      			adminSubmitBtnFun();
	      		} else {
	      			addToast("Username already exist","red");
	      			$("#Username").focus();
	      		}
	      		
	      	}
      	} else {
      		if(Username=="") {
      	 		addToast("Username field is required!","orange");
	      		$("#Username").focus();
      	 	} else if (Name=="") {
	      		addToast("Name field is required!","orange");
	      		$("#Name").focus();
	      	} else if(Email=="") {
	      		addToast("Email field is required!","orange");
	      		$("#Email").focus();
      		} else if (mailFormat.test(Email) == false) {
	            addToast("Invalid mail format!","orange");
	            $("#Email").focus(); 
	      	} else if(number=="") {
	      		addToast("Mobile number field is required!","orange");
	      		$("#number").focus();
	      	} else if(Role=="") {
	      		addToast("Role field is required!","orange");
	      		$("#Role").focus();
	      	}  else {
	      		if (checkstatus==0) {
	      			$("#adminSubmitBtn").attr('disabled',true);
	      			adminSubmitBtnFun();
	      		} else {
	      			addToast("Username already exist","red");
	      			$("#Username").focus();
	      		}
	      	}
      	}
	});

	$("#Username").on('input' ,function() {
		$.ajax({
          dataType: "json",
          // type: 'POST',
          url: 'adminExistingUserNameCheck',
          data: $('#adminSubmitForm').serialize(),
          success: function (response) {
          	$("#checkstatus").val(response);
          	if (response!=0) {
          		$("#Username").css('border','1px solid red');
          	} else {
          		$("#Username").css('border','1px solid #eee');
          	}
          }
        });
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

	$("#AdminProfileSubmitBtn").click(function() {
			var Name  = $("#Name").val();
			var Email = $("#Email").val();
			var number = $("#number").val();
			var changeapass = $("#changeapass").val();
	      	var Password = $("#Password").val();
			var CPassword = $("#CPassword").val();
        	var mailFormat = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
	      	if(changeapass==undefined || $("#changeapass").is(':checked')) {
      			if (Name=="") {
		      		addToast("Name field is required!","orange");
		      		$("#Name").focus();
		      	} else if(Email=="") {
		      		addToast("Email field is required!","orange");
		      		$("#Email").focus();
	      		} else if (mailFormat.test(Email) == false) {
		            addToast("Invalid mail format!","orange");
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
	      			$("#AdminProfileSubmitForm").submit();
	      		}
      		} else {
      			if (Name=="") {
		      		addToast("Name field is required!","orange");
		      		$("#Name").focus();
		      	} else if(Email=="") {
		      		addToast("Email field is required!","orange");
		      		$("#Email").focus();
	      		} else if (mailFormat.test(Email) == false) {
		            addToast("Invalid mail format!","orange");
		            $("#Email").focus(); 
		      	} else if(number=="") {
		      		addToast("Mobile number field is required!","orange");
		      		$("#number").focus();
	      		} else {
	      			$("#AdminProfileSubmitForm").submit();
	      		}
      		}
	});
});

function adminSubmitModalfun(id) {
    $("#myModal").load('../backend/adminSubmitModal?id='+id);
	$("#myModal").modal({
       backdrop: 'static',
        keyboard: false
    });
}
function adminSubmitBtnFun() {
	var id= $("#id").val();
	if (id=="") {
		addToast("Inserted succefully","green");
	} else {
		addToast("Updated succefully","green");
	}
	$('#adminSubmitForm').attr('action','adminSubmitBtnFun');
	$('#adminSubmitForm').submit();
	// console.log($('#adminSubmitForm').serialize());
	// 	$.ajax({
 //          dataType: "json",
 //          // type: 'POST',
 //          url: 'adminSubmitBtnFun',
 //          data: $('#adminSubmitForm').serialize(),
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
function adminDeleteModalfun(id,flag) {
	if (flag==1) {
		var msg = 'Do you want active this admin?'
	} else {
		var msg = 'Do you want Inactive this admin?'
	}
	if(confirm(msg)) {
		$.ajax({
          dataType: "json",
          // type: 'POST',
          url: 'adminDeleteBtnFun?id='+id+'&flag='+flag,
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
function GalleryTable() {
	$('#GalleryTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: 'gallerylist',
                columns: [
                {data: 'rownum', name: 'rownum', "searchable": false},
                {data: 'title', name: 'title'},
                {data: 'students', name: 'students'},
                {data: 'createdDate', name: 'createdDate'},
                {data: 'view', name: 'view'},
                {data: 'action', name: 'action'}
            ]
    });
}
function galleryDeleteModalfun(id) {
	if(confirm('Do you want delete this!')) {
		$.ajax({
          dataType: "json",
          // type: 'POST',
          url: 'galleryDelete?id='+id,
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
function FileManagerTable() {
	$('#FileManagerTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: 'fileManagerlist',
                columns: [
                 {data: 'rownum', name: 'rownum'},
                {data: 'title', name: 'title'},
                {data: 'students', name: 'students'},
                {data: 'createdDate', name: 'createdDate'},
                {data: 'view', name: 'view'},
                {data: 'action', name: 'action'}
            ]
    });
}
function fileManagerDeleteModalfun(id) {
	if(confirm('Do you want delete this!')) {
		$.ajax({
          dataType: "json",
          // type: 'POST',
          url: 'fileManagerDelete?id='+id,
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