$(document).ready(function() {
	$("#studentSubmitBtn").click(function() {
        var Username = $("#Username").val();
        var studentId = $("#studentId").val();
      	var Name = $("#Name").val();
      	var parentName = $("#parentName").val();
      	var number = $("#number").val();
        var Email = $("#Email").val();
      	var ClassRoom = $("#ClassRoom").val();
      	var section = $("#section").val();
      	var Program = $("#Program").val();
      	var changeapass = $("#changeapass").val();
      	var Password = $("#Password").val();
		    var CPassword = $("#CPassword").val();
        var checkstatus = $("#checkstatus").val();
        var checkstatusUname = $("#checkstatusUname").val();
        var mailFormat = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
      	if(changeapass==undefined || $("#changeapass").is(':checked')) {
      		
          if(Username=="") {
            addToast("Login name field is required!","orange");
            $("#Username").focus();
          } else if (studentId=="") {
            addToast("Student id field is required!","orange");
            $("#studentId").focus();
          } else if (Name=="") {
	      		addToast("Student name field is required!","orange");
	      		$("#Name").focus();
	      	} else if(parentName=="") {
	      		addToast("Parent name field is required!","orange");
	      		$("#parentName").focus();
          } else if(Email=="") {
            addToast("Email field is required!","orange");
            $("#Email").focus();
          } else if (mailFormat.test(Email) == false) {
            addToast("Invalid mail format!","orange");
            $("#Email").focus(); 
	      	} else if(number=="") {
	      		addToast("Mobile number field is required!","orange");
	      		$("#number").focus();
      		} else if(ClassRoom=="") {
	      		addToast("Class room field is required!","orange");
	      		$("#ClassRoom").focus();
      		// } else if(section=="") {
	      	// 	addToast("Section field is required!","orange");
	      	// 	$("#section").focus();
      		} else if(Program=="") {
	      		addToast("Program field is required!","orange");
	      		$("#Program").focus();
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
            if (checkstatus==0 && checkstatusUname==0) {
              $("#studentSubmitBtn").attr('disabled',true);
              studentSubmitBtnFun();
            } else {
              if (checkstatus==0) {
                addToast("Student id is already exist","red");
                $("#studentId").focus();
              } else if (checkstatusUname==0) {
                addToast("Login Name is already exist","red");
                $("#Username").focus();
              }
            }
	      		
	      	}
      	} else {
      		if(Username=="") {
            addToast("Login name field is required!","orange");
            $("#Username").focus();
          } else if (studentId=="") {
            addToast("Student id field is required!","orange");
            $("#studentId").focus();
          } else if (Name=="") {
	      		addToast("Name field is required!","orange");
	      		$("#Name").focus();
	      	} else if(parentName=="") {
	      		addToast("Parent name field is required!","orange");
	      		$("#parentName").focus();
          } else if(Email=="") {
            addToast("Email field is required!","orange");
            $("#Email").focus();
          } else if (mailFormat.test(Email) == false) {
            addToast("Invalid mail format!","orange");
            $("#Email").focus(); 
	      	} else if(number=="") {
	      		addToast("Mobile number field is required!","orange");
	      		$("#number").focus();
      		} else if(ClassRoom=="") {
	      		addToast("Class room field is required!","orange");
	      		$("#ClassRoom").focus();
      		// } else if(section=="") {
	      	// 	addToast("Section field is required!","orange");
	      	// 	$("#section").focus();
      		} else if(Program=="") {
	      		addToast("Program field is required!","orange");
	      		$("#Program").focus();
	      	}  else {
	      		if (checkstatus==0 && checkstatusUname==0) {
              $("#studentSubmitBtn").attr('disabled',true);
              studentSubmitBtnFun();
            } else {
              if (checkstatus!=0) {
                addToast("Student id is already exist","red");
                $("#studentId").focus();
              } else if (checkstatusUname!=0) {
                addToast("Login Name is already exist","red");
                $("#Username").focus();
              }
            }
	      	}
      	}
	});

  $("#studentId").on('keyup' , function() {
    $.ajax({
          dataType: "json",
          // type: 'POST',
          url: 'StudentExistingStudentIdCheck',
          data: $('#studentSubmitForm').serialize(),
          success: function (response) {
            $("#checkstatus").val(response);
            if (response!=0) {
              $("#studentId").css('border','1px solid red');
            } else {
              $("#studentId").css('border','1px solid #eee');
            }
          }
        });
  });

  $("#Username").on('keyup' , function() {
    $.ajax({
          dataType: "json",
          // type: 'POST',
          url: 'StudentExistingStudentUsernameCheck',
          data: $('#studentSubmitForm').serialize(),
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
function studentSubmitModalfun(id) {
    $("#myModal").load('../backend/studentSubmitModal?id='+id);
	$("#myModal").modal({
       backdrop: 'static',
        keyboard: false
    });
}
function studentSubmitBtnFun() {
  var id= $("#id").val();
  if (id=="") {
    addToast("Inserted succefully","green");
  } else {
    addToast("Updated succefully","green");
  }
  $('#studentSubmitForm').attr('action','studentSubmitBtnFun');
  $('#studentSubmitForm').submit();
  
	// console.log($('#studentSubmitForm').serialize());
	// $.ajax({
 //          dataType: "json",
 //          // type: 'POST',
 //          url: 'studentSubmitBtnFun',
 //          data: $('#studentSubmitForm').serialize(),
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
// function studentTable() {
//     $('#studentTable').DataTable({
//                 processing: true,
//                 serverSide: true,
//                 responsive: true,
//                 ajax: 'studentlist',
                
//                 columns: [
//                 {data: 'rownum', name: 'rownum', "searchable": false},
//                 {data: 'studentId', name: 'studentId'},
//                 {data: 'Name', name: 'Name'},
//                 {data: 'ParentName', name: 'ParentName'},
//                 {data: 'Mobile', name: 'Mobile'},
//                 {data: 'classRoom', name: 'tbl_classroom.classRoom'},
//                 {data: 'Program', name: 'Program'},
//                 // {data: 'Therapy', name: 'Therapy'},
//                 {data: 'Therapist', name: 'Therapist'},
//                 {data: 'SectionHeadData', name: 'SectionHeadData'},
//                 {data: 'Status', name: 'Status'},
//                 {data: 'action', name: 'action',targets: 'no-sort', orderable: false}
//             ]
//     });
// }
function studentDeleteModalfun(id,flag) {
	if (flag==1) {
		var msg = 'Do you want active this student?'
	} else {
		var msg = 'Do you want Inactive this student?'
	}
	if(confirm(msg)) {
		$.ajax({
          dataType: "json",
          // type: 'POST',
          url: 'studentDeleteBtnFun?id='+id+'&flag='+flag,
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