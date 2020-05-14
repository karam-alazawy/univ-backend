<?php
//header("Access-Control-Allow-Origin: *");

use Illuminate\Http\Request;
// /use Illuminate\Routing\Route;

//use Illuminate\Routing\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::get('login', 'Api\login@login');
Route::get('checkToken', 'Api\login@checkToken');
Route::post('addStudent', 'Api\studentApi@addStudent');
Route::get('getStudents', 'Api\studentApi@getStudents');
Route::get('getStudentsNames', 'Api\studentApi@getStudentsNames');
Route::post('studentsAbsences', 'Api\studentApi@studentsAbsences');
Route::delete('deleteStudent', 'Api\studentApi@deleteStudent');
Route::get('getClasses', 'Api\classes@getClasses');
Route::post('addClass', 'Api\classes@addClass');
Route::get('getSections', 'Api\classes@getSections');
Route::get('getStages', 'Api\classes@getStages');
Route::get('getDivisions', 'Api\classes@getDivisions');
Route::post('addStudentNotification', 'Api\notification@addStudentNotification');
Route::get('getStageNotifications', 'Api\notification@getStageNotifications');
Route::get('getTeacherNotifications', 'Api\notification@getTeacherNotifications');
Route::post('addTeacherNotification', 'Api\notification@addTeacherNotification');
Route::post('addStageNotification', 'Api\notification@addStageNotification');
Route::get('getTeacherSp', 'Api\classes@getTeacherSp');
Route::post('addTeacher', 'Api\teachers@addTeacher');
Route::get('getTeachers', 'Api\teachers@getTeachers');
Route::get('getTeacherNames', 'Api\teachers@getTeacherNames');
Route::delete('deleteTeacher', 'Api\teachers@deleteTeacher');
Route::post('addAdvertisement', 'Api\advertisement@addAdvertisement');
Route::get('getAdvertisements', 'Api\advertisement@getAdvertisements');
Route::post('addDaySchedule', 'Api\schedule@addDaySchedule');
Route::get('getDaySchedule', 'Api\schedule@getDaySchedule');
Route::get('getSchedule', 'Api\schedule@getSchedule');
Route::delete('deleteLesson', 'Api\schedule@deleteLesson');
Route::post('addHomeWork', 'Api\homeWork@addHomeWork');


//Route::delete('getName','Api\getName@deleteName');
