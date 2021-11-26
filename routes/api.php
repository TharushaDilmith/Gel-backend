<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AwardingBodyController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\ResourceTypeController;
use Illuminate\Support\Facades\Route;

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

//admin login
Route::post('admin/login', [AuthController::class, 'adminLogin']);

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
    Route::middleware(['scope:admin'])->put('/course/{id}', [CourseController::class, 'editCourse']);
    //delete a course
    Route::middleware(['scope:admin'])->delete('/course/{id}', [CourseController::class, 'deleteCourse']);

    //resource
    //add a resource
    Route::middleware(['scope:admin'])->post('/resource', [ResourceController::class, 'addResource']);
    //update a resource
    Route::middleware(['scope:admin'])->put('/resource/{id}', [ResourceController::class, 'editResource']);
    //delete a resource
    Route::middleware(['scope:admin'])->delete('/resource/{id}', [ResourceController::class, 'deleteResource']);
    

    //admin and user routes
    //get a course
    Route::middleware(['scope:admin,user'])->get('/course/{id}', [CourseController::class, 'getCourse']);

    //get a resource
    Route::middleware(['scope:admin,user'])->get('/resources/{id}', [ResourceController::class, 'getResource']);

    //logout
    Route::middleware(['scope:admin,user'])->post('logout', [AuthController::class, 'logout']);


});

//normal api

//get all courses
Route::get('/courses', [CourseController::class, 'getCourses']);

//get all awarding bodies
Route::get('/awarding_bodies', [AwardingBodyController::class, 'getAllAwardingBodies']);

//get an awarding body
Route::get('/awarding_body/{id}', [AwardingBodyController::class, 'getAwardingBody']);

//get all resource types
Route::get('/resource_types', [ResourceTypeController::class, 'getAllResourceTypes']);

//get an resource type
Route::get('/resource_type/{id}', [ResourceTypeController::class, 'getResourceTypeById']);

//get all resources
Route::get('/resources', [ResourceController::class, 'getResources']);
