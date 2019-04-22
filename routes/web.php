<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Backend routes start


// Route::any('backend/changeLanguage', 'Backend\LoginController@changeLanguage');


Route::group(['prefix'=>'backend','middleware' => 'localization'], function()
{   

    Route::get('', 'Backend\LoginController@index');
    Route::any('AdminLogin', 'Backend\LoginController@AdminLogin');
    Route::get('profile', 'Backend\DashboardController@profile');
    Route::post('AdminProfileSubmit', 'Backend\DashboardController@AdminProfileSubmit');
    Route::any('forgetPassword', 'Backend\LoginController@forgetPassword');
    Route::any('resetPassword', 'Backend\LoginController@resetPassword');

    Route::get('dashboard', 'Backend\DashboardController@index');
    Route::get('admin', 'Backend\AdminController@index');
    Route::get('adminList', 'Backend\AdminController@adminList');
    Route::get('teacher', 'Backend\TeachersController@index');
    Route::get('teacherList', 'Backend\TeachersController@teacherList');
    Route::get('therapist', 'Backend\TherapistController@index');
    Route::get('therapistList', 'Backend\TherapistController@therapistList');
    Route::get('student', 'Backend\StudentsController@index');
    Route::get('studentlist', 'Backend\StudentsController@studentlist');

    Route::any('adminRole', 'Backend\MasterController@adminRole');
    Route::any('ProgramMaster', 'Backend\MasterController@ProgramMaster');
    Route::get('SectionMaster', 'Backend\MasterController@SectionMaster');
    Route::get('ClassroomMaster', 'Backend\MasterController@ClassroomMaster');
    Route::get('TherapytypeMaster', 'Backend\MasterController@TherapytypeMaster');
    Route::any('inbox', 'Backend\DashboardController@inbox');
    Route::any('inboxView', 'Backend\DashboardController@inboxView');
    Route::any('compose', 'Backend\DashboardController@compose');
    Route::any('composeSend', 'Backend\DashboardController@composeSend');
    Route::any('FileShare', 'Backend\DashboardController@FileShare');
    Route::any('AssessmentShare', 'Backend\DashboardController@AssessmentShare');
    Route::any('Gallery', 'Backend\DashboardController@Gallery');
    Route::get('gallerylist', 'Backend\DashboardController@gallerylist');
    Route::any('galleryDelete', 'Backend\DashboardController@galleryDelete');
    Route::any('fileManager', 'Backend\DashboardController@fileManager');
    Route::any('fileManagerlist', 'Backend\DashboardController@fileManagerlist');
    Route::any('fileManagerDelete', 'Backend\DashboardController@fileManagerDelete');
    Route::get('adminChat', 'Backend\DashboardController@adminChat');

    Route::any('allChatMessages', 'Backend\ChatController@allChatMessages');
    Route::any('retrieveChatMessages', 'Backend\ChatController@retrieveChatMessages');
    Route::any('retrieveTypingStatus', 'Backend\ChatController@retrieveTypingStatus');
    Route::any('sendMessage', 'Backend\ChatController@sendMessage');
    Route::any('isTyping', 'Backend\ChatController@isTyping');
    Route::any('notTyping', 'Backend\ChatController@notTyping');
    Route::any('notify_count', 'Backend\DashboardController@notify_count');
    Route::any('mailChatcount', 'Backend\DashboardController@mailChatcount');
    Route::any('AdminchatList', 'Backend\DashboardController@AdminchatList');
    Route::any('ChatLog', 'Backend\DashboardController@ChatLog');
    Route::any('chatLogview', 'Backend\DashboardController@chatLogview');
    Route::any('deleteAllChat', 'Backend\DashboardController@deleteAllChat');
    Route::any('chatLogDelete', 'Backend\DashboardController@chatLogDelete');
    
    // backend submit call start
    Route::get('adminRoleSubmitBtnFun', 'Backend\MasterController@adminRoleSubmitBtnFun');

    Route::get('programSubmitBtnFun', 'Backend\MasterController@programSubmitBtnFun');

    Route::get('sectionSubmitBtnFun', 'Backend\MasterController@sectionSubmitBtnFun');

    Route::get('classRoomSubmitBtnFun
    ', 'Backend\MasterController@classRoomSubmitBtnFun');

    Route::get('therpyTypeSubmitBtnFun
    ', 'Backend\MasterController@therpyTypeSubmitBtnFun');

    Route::any('adminSubmitBtnFun
    ', 'Backend\AdminController@adminSubmitBtnFun');
    Route::any('adminExistingUserNameCheck
    ', 'Backend\AdminController@adminExistingUserNameCheck');

    Route::any('therapySubmitBtnFun
    ', 'Backend\TherapistController@therapySubmitBtnFun');

    Route::any('TherapistExistingStudentUsernameCheck
    ', 'Backend\TherapistController@TherapistExistingStudentUsernameCheck');

    Route::any('teacherSubmitBtnFun
    ', 'Backend\TeachersController@teacherSubmitBtnFun');

    Route::any('TeacherExistingStudentUsernameCheck
    ', 'Backend\TeachersController@TeacherExistingStudentUsernameCheck');

    Route::any('studentSubmitBtnFun
    ', 'Backend\StudentsController@studentSubmitBtnFun');

    Route::any('StudentExistingStudentIdCheck
    ', 'Backend\StudentsController@StudentExistingStudentIdCheck');

    Route::any('StudentExistingStudentUsernameCheck
    ', 'Backend\StudentsController@StudentExistingStudentUsernameCheck');
    
    Route::any('galleryFileUpload
    ', 'Backend\DashboardController@galleryFileUpload');
    Route::any('assessmentFileUpload
    ', 'Backend\DashboardController@assessmentFileUpload');

    // backend submit call end

    // backend delete call start
    Route::get('adminDeleteBtnFun', 'Backend\AdminController@adminDeleteBtnFun');
    Route::get('adminRoleDeleteBtnFun', 'Backend\MasterController@adminRoleDeleteBtnFun');
    Route::get('programDeleteBtnFun', 'Backend\MasterController@programDeleteBtnFun');
    Route::get('sectionDeleteBtnFun', 'Backend\MasterController@sectionDeleteBtnFun');
    Route::get('classRoomDeleteModalfun', 'Backend\MasterController@classRoomDeleteModalfun');
    Route::get('therapyTypeDeleteModalfun', 'Backend\MasterController@therapyTypeDeleteModalfun');
    Route::get('therapistDeleteBtnFun', 'Backend\TherapistController@therapistDeleteBtnFun');
    Route::get('teacherDeleteBtnFun', 'Backend\TeachersController@teacherDeleteBtnFun');
    Route::get('studentDeleteBtnFun', 'Backend\StudentsController@studentDeleteBtnFun');

// backend delete call end
    // backned Modal call start
    Route::get('adminRoleSubmitModal', 'Backend\MasterController@adminRoleSubmitModal');
    Route::get('programSubmitModalfun', 'Backend\MasterController@programSubmitModalfun');
    Route::get('sectionSubmitModalfun', 'Backend\MasterController@sectionSubmitModalfun');
    Route::get('classRoomSubmitModalfun', 'Backend\MasterController@classRoomSubmitModalfun');
    Route::get('therapyTypeSubmitModalfun', 'Backend\MasterController@therapyTypeSubmitModalfun');


    Route::get('adminSubmitModal', 'Backend\AdminController@adminSubmitModal');
    Route::get('teacherSubmitModal', 'Backend\TeachersController@teacherSubmitModal');
    Route::get('therapistSubmitModal
    ', 'Backend\TherapistController@therapistSubmitModal');
    Route::get('studentSubmitModal
    ', 'Backend\StudentsController@studentSubmitModal');
    Route::get('announcement', 'Backend\DashboardController@announcement');
    Route::post('announcementSend', 'Backend\DashboardController@announcementSend');

    // backned Modal call end

});






Route::group(['prefix'=>'backend/master','middleware' => 'localization'], function()
{
    Route::any('adminRoleSubmitBtnFun', 'Backend\MasterController@adminRoleSubmitBtnFun');
    Route::get('adminRoleList', 'Backend\MasterController@adminRoleList');
    Route::get('programList', 'Backend\MasterController@programList');
    Route::get('sectionList', 'Backend\MasterController@sectionList');
    Route::get('classRoomList', 'Backend\MasterController@classRoomList');
    Route::get('therapyTypeList', 'Backend\MasterController@therapyTypeList');
});





Route::group(['prefix'=>'backend', 'middleware' => 'localization'], function()
{
    Route::get('changelanguage', 'Backend\AjaxController@index');
});

Route::get('backend/logout', 'Auth\AuthController@Adminlogout');

// Backend routes end


// Student Panel route start
Route::group(['prefix'=>'/','middleware' => 'localization'], function()
{
    Route::get('', 'Student\LoginController@index');
    Route::post('Login', 'Student\LoginController@Login');
    Route::get('gallery', 'Student\DashboardController@index');
    Route::get('studentProfile', 'Student\DashboardController@studentProfile');
    Route::get('assessmentDetails', 'Student\DashboardController@assessmentDetails');
    Route::post('studentProfileSubmit', 'Student\DashboardController@studentProfileSubmit');
    Route::any('studentInbox', 'Student\DashboardController@studentInbox');
    Route::get('studentChat', 'Student\DashboardController@studentChat');

    Route::any('student/allChatMessages', 'Student\ChatController@allChatMessages');
    Route::any('student/retrieveChatMessages', 'Student\ChatController@retrieveChatMessages');
    Route::any('student/retrieveTypingStatus', 'Student\ChatController@retrieveTypingStatus');
    Route::any('student/sendMessage', 'Student\ChatController@sendMessage');
    Route::any('student/isTyping', 'Student\ChatController@isTyping');
    Route::any('student/notTyping', 'Student\ChatController@notTyping');
    Route::any('inboxView', 'Student\DashboardController@inboxView');
    Route::any('compose', 'Student\DashboardController@compose');
    Route::any('composeSend', 'Student\DashboardController@composeSend');
    Route::get('logout', 'Auth\AuthController@Studentlogout');
    Route::any('notify_count', 'Student\DashboardController@notify_count');
    Route::any('mailChatcount', 'Student\DashboardController@mailChatcount');
    Route::any('StudentchatList', 'Student\DashboardController@StudentchatList');
    Route::any('Student/forgetPassword', 'Student\DashboardController@forgetPassword');
    Route::any('Student/resetPassword', 'Student\DashboardController@resetPassword');
    Route::any('Student/otpverification', 'Student\DashboardController@otpverification');
    Route::any('Student/changepass', 'Student\DashboardController@changepass');

});
// Student Panel route end
// Teacher Panel route start
Route::group(['prefix'=>'/','middleware' => 'localization'], function()
{
    Route::get('teacher', 'Teacher\LoginController@index');
    Route::post('TeacherLogin', 'Teacher\LoginController@TeacherLogin');
    Route::get('teacherDashboard', 'Teacher\DashboardController@index');
    Route::get('teacherLogout', 'Auth\AuthController@teacherLogout');
    Route::get('StudentList', 'Teacher\DashboardController@StudentList');
    Route::get('TshowStudentlist', 'Teacher\DashboardController@TshowStudentlist');
    Route::get('teacherProfile', 'Teacher\DashboardController@teacherProfile');
    Route::post('TeacherProfileSubmit', 'Teacher\DashboardController@TeacherProfileSubmit');
    Route::get('teacherInbox', 'Teacher\DashboardController@teacherInbox');
    Route::any('teacherChat', 'Teacher\DashboardController@teacherChat');


    Route::any('teacher/allChatMessages', 'Teacher\ChatController@allChatMessages');
    Route::any('teacher/retrieveChatMessages', 'Teacher\ChatController@retrieveChatMessages');
    Route::any('teacher/retrieveTypingStatus', 'Teacher\ChatController@retrieveTypingStatus');
    Route::any('teacher/sendMessage', 'Teacher\ChatController@sendMessage');
    Route::any('teacher/isTyping', 'Teacher\ChatController@isTyping');
    Route::any('teacher/notTyping', 'Teacher\ChatController@notTyping');
    
    Route::any('Teachernotify_count', 'Teacher\DashboardController@Teachernotify_count');
    Route::any('TeachermailChatcount', 'Teacher\DashboardController@TeachermailChatcount');
    Route::any('TeacherchatList', 'Teacher\DashboardController@TeacherchatList');
    Route::any('teacher/forgetPassword', 'Teacher\DashboardController@forgetPassword');
    Route::any('teacher/resetPassword', 'Teacher\DashboardController@resetPassword');
});
// Teacher Panel route end
Route::get('backend/dummy', 'Backend\StudentsController@dummy');

