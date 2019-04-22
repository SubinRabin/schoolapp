$(document).ready(function() {
	$("#adminRoleSubmitBtn").click(function() {
      	var roleName = $("#roleName").val();
      	if (roleName=="") {
      		addToast("Role name field is required!","orange");
      		$("#roleName").focus();
      	} else {
      		$("#adminRoleSubmitBtn").attr('disabled',true);
      		adminRoleSubmitBtnFun();
      	}
	});

  $("#programSubmitBtn").click(function() {
        var sectionName = $("#sectionName").val();
        if (sectionName=="") {
          addToast("Section name field is required!","orange");
          $("#sectionName").focus();
        } else {
          $("#programSubmitBtn").attr('disabled',true);
          programSubmitBtnFun();
        }
  });

  $("#sectionSubmitBtn").click(function() {
        var programName = $("#programName").val();
        if (programName=="") {
          addToast("Program name field is required!","orange");
          $("#programName").focus();
        } else {
          $("#sectionSubmitBtn").attr('disabled',true);
          sectionSubmitBtnFun();
        }
  });

  $("#classRoomSubmitBtn").click(function() {
        var classRoom = $("#classRoom").val();
        if (classRoom=="") {
          addToast("Class room name field is required!","orange");
          $("#classRoom").focus();
        } else {
          $("#classRoomSubmitBtn").attr('disabled',true);
          classRoomSubmitBtnFun();
        }
  });

  $("#therpyTypeSubmitBtn").click(function() {
        var therapyType = $("#therapyType").val();
        if (therapyType=="") {
          addToast("Therapy type name field is required!","orange");
          $("#therapyType").focus();
        } else {
          $("#therpyTypeSubmitBtn").attr('disabled',true);
          therpyTypeSubmitBtnFun();
        }
  });
});
function adminRoleSubmitModalfun(id) {
  $("#myModal").load('../backend/adminRoleSubmitModal?id='+id);
	$("#myModal").modal({
       backdrop: 'static',
        keyboard: false
    });
}
function programModalfun(id) {
  $("#programModal").load('../backend/programSubmitModalfun?id='+id);
  $("#programModal").modal({
       backdrop: 'static',
        keyboard: false
    });
}
function  adminRoleSubmitBtnFun() {
	$.ajax({
          dataType: "json",
          // type: 'POST',
          url: 'adminRoleSubmitBtnFun',
          data: $('#adminRoleSubmitForm').serialize(),
          success: function (response) {
          	if (response.status=="true") {
          		$(".close").trigger('click');
      			addToast(response.msg,"green");
      			window.location.reload();
          	}
          },
           error: function (xhr,status,error) {
             alert("Error: " + error);
          }
        });
}
function  programSubmitBtnFun() {
  $.ajax({
          dataType: "json",
          // type: 'POST',
          url: 'programSubmitBtnFun',
          data: $('#programSubmitForm').serialize(),
          success: function (response) {
            if (response.status=="true") {
              $(".close").trigger('click');
            addToast(response.msg,"green");
            window.location.reload();
            }
          },
           error: function (xhr,status,error) {
             alert("Error: " + error);
          }
        });
}
function  AdminRoleTable() {
    $('#AdminRoleTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: 'master/adminRoleList',
                columns: [
                {data: 'rownum', name: 'rownum', "searchable": false},
                {data: 'RoleName', name: 'RoleName'},
                {data: 'CreatedDate', name: 'CreatedDate'},
                {data: 'UpdatedDate', name: 'UpdatedDate'},
                {data: 'action', name: 'action',targets: 'no-sort', orderable: false}
            ]
    });
}
function adminRoleDeleteModalfun(id) {
	if(confirm("Do you want delete this?")) {
		$.ajax({
          dataType: "json",
          // type: 'POST',
          url: 'adminRoleDeleteBtnFun?id='+id,
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
function programDeleteModalfun(id) {
  if(confirm("Do you want delete this?")) {
    $.ajax({
          dataType: "json",
          // type: 'POST',
          url: 'programDeleteBtnFun?id='+id,
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
function sectionModalfun(id) {
  $("#sectionModal").load('../backend/sectionSubmitModalfun?id='+id);
  $("#sectionModal").modal({
       backdrop: 'static',
        keyboard: false
    });
}
function  sectionTable() {
    $('#sectionModalTable').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: 'master/sectionList',
                columns: [
                {data: 'rownum', name: 'rownum', "searchable": false},
                {data: 'section', name: 'section'},
                {data: 'CreatedDate', name: 'CreatedDate'},
                {data: 'UpdatedDate', name: 'UpdatedDate'},
                {data: 'action', name: 'action',targets: 'no-sort', orderable: false}
            ]
    });
}
function  sectionSubmitBtnFun() {
  $.ajax({
          dataType: "json",
          // type: 'POST',
          url: 'sectionSubmitBtnFun',
          data: $('#sectionSubmitForm').serialize(),
          success: function (response) {
            if (response.status=="true") {
              $(".close").trigger('click');
            addToast(response.msg,"green");
            window.location.reload();
            }
          },
           error: function (xhr,status,error) {
             alert("Error: " + error);
          }
        });
}
function sectionDeleteModalfun(id) {
  if(confirm("Do you want delete this?")) {
    $.ajax({
          dataType: "json",
          // type: 'POST',
          url: 'sectionDeleteBtnFun?id='+id,
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
function classRoomModalfun(id) {
  $("#classRoomModal").load('../backend/classRoomSubmitModalfun?id='+id);
  $("#classRoomModal").modal({
       backdrop: 'static',
        keyboard: false
    });
}
function  classRoomSubmitBtnFun() {
  $.ajax({
          dataType: "json",
          // type: 'POST',
          url: 'classRoomSubmitBtnFun',
          data: $('#classRoomSubmitForm').serialize(),
          success: function (response) {
            if (response.status=="true") {
              $(".close").trigger('click');
            addToast(response.msg,"green");
            window.location.reload();
            }
          },
           error: function (xhr,status,error) {
             alert("Error: " + error);
          }
        });
}
function classRoomDeleteModalfun(id) {
  if(confirm("Do you want delete this?")) {
    $.ajax({
          dataType: "json",
          // type: 'POST',
          url: 'classRoomDeleteModalfun?id='+id,
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
function therapyTypeModalfun(id) {
  $("#therapytypeModal").load('../backend/therapyTypeSubmitModalfun?id='+id);
  $("#therapytypeModal").modal({
       backdrop: 'static',
        keyboard: false
    });
}

function  therpyTypeSubmitBtnFun() {
  $.ajax({
          dataType: "json",
          // type: 'POST',
          url: 'therpyTypeSubmitBtnFun',
          data: $('#therpyTypeSubmitForm').serialize(),
          success: function (response) {
            if (response.status=="true") {
              $(".close").trigger('click');
            addToast(response.msg,"green");
            window.location.reload();
            }
          },
           error: function (xhr,status,error) {
             alert("Error: " + error);
          }
        });
}
function therapyTypeDeleteModalfun(id) {
  if(confirm("Do you want delete this?")) {
    $.ajax({
          dataType: "json",
          // type: 'POST',
          url: 'therapyTypeDeleteModalfun?id='+id,
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