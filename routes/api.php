<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AwardingBodyController;
use App\Http\Controllers\ResourceTypeController;
use App\Http\Controllers\CourseController;


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

//login
Route::post('login', [AuthController::class, 'login']);

//register
Route::post('register', [AuthController::class, 'register']);

//logout
Route::post('logout', [AuthController::class, 'logout']);

//authenticate api
Route::middleware('auth:api')->group(function () {
    
    //admin

    //awardingbody
    //add an awarding body
    Route::middleware(['scope:admin'])->post('/awarding_body', [AwardingBodyController::class, 'addAwardingBody']);
    //update an awarding body
    Route::middleware(['scope:admin'])->put('/awarding_body/{id}', [AwardingBodyController::class, 'updateAwardingBody']);
    //delete an awarding body
    Route::middleware(['scope:admin'])->delete('/awarding_body/{id}', [AwardingBodyController::class, 'deleteAwardingBody']);

    //resource type
    //add a resource type
    Route::middleware(['scope:admin'])->post('/resource_type', [ResourceTypeController::class, 'addResourceType']);
    //update a resource type
    Route::middleware(['scope:admin'])->put('/resource_type/{id}', [ResourceTypeController::class, 'updateResourceType']);
    //delete a resource type
    Route::middleware(['scope:admin'])->delete('/resource_type/{id}', [ResourceTypeController::class, 'deleteResourceType']);

    //course
    //add a course
    Route::middleware(['scope:admin'])->post('/course', [CourseController::class, 'addCourse']);
    //update a course
    Route::middleware(['scope:admin'])->put('/course/{id}', [CourseController::class, 'updateCourse']);
    //delete a course
    Route::middleware(['scope:admin'])->delete('/course/{id}', [CourseController::class, 'deleteCourse']);


    //admin and user routes
    //get a course
    Route::middleware(['scope:admin,user'])->get('/course/{id}', [CourseController::class, 'getCourse']);

    //logout
    Route::middleware(['scope:admin,user'])->post('logout', [AuthController::class, 'logout']);


    
});

//normal api

//get all courses
Route::get('/courses', [CourseController::class, 'getCourses']);

//get all awarding bodies
Route::get('/awarding_bodies', [AwardingBodyController::class, 'getAllAwardingBodies']);

//get all resource types
Route::get('/resource_types', [ResourceTypeController::class, 'getAllResourceTypes']);