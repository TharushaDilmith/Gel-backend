<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AwardingBodyController;
use App\Http\Controllers\BrandController;
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
Route::post('admin/register', [AuthController::class, 'register']);

//logout
Route::post('logout', [AuthController::class, 'logout']);

//authenticate api
Route::middleware('auth:api')->group(function () {

    //admin

    //brands
    //get all brands
    Route::middleware(['scope:admin'])->get('/brands', [BrandController::class, 'index']);
    //add a brand
    Route::middleware(['scope:admin'])->post('/brands', [BrandController::class, 'create']);
    //update a brand
    Route::middleware(['scope:admin'])->put('/brands/{id}', [BrandController::class, 'update']);
    //delete a brand
    Route::middleware(['scope:admin'])->delete('/brands/{id}', [BrandController::class, 'delete']);
    //get all deleted brands
    Route::middleware(['scope:admin'])->get('/brands/deleted', [BrandController::class, 'getAllDeletedBrands']);

    //awardingbody
    //add an awarding body
    Route::middleware(['scope:admin'])->post('/awarding_body', [AwardingBodyController::class, 'addAwardingBody']);
    //update an awarding body
    Route::middleware(['scope:admin'])->put('/awarding_body/{id}', [AwardingBodyController::class, 'updateAwardingBody']);
    //delete an awarding body
    Route::middleware(['scope:admin'])->delete('/awarding_body/{id}', [AwardingBodyController::class, 'deleteAwardingBody']);
    //get a deleted awarding body
    Route::middleware(['scope:admin'])->get('/awarding_body/deleted/{id}', [AwardingBodyController::class, 'getDeletedAwardingBody']);
    //get all deleted awarding bodies
    Route::middleware(['scope:admin'])->get('/awarding_body/deleted', [AwardingBodyController::class, 'getAllDeletedAwardingBodies']);
    //restore a deleted awarding body
    Route::middleware(['scope:admin'])->post('/awarding_body/restore/{id}', [AwardingBodyController::class, 'restoreAwardingBody']);
    //restore all deleted awarding bodies
    Route::middleware(['scope:admin'])->post('/awarding_body/restore/', [AwardingBodyController::class, 'restoreAllDeletedAwardingBodies']);
    //delete permanently an awarding body
    Route::middleware(['scope:admin'])->post('/awarding_body/delete/{id}', [AwardingBodyController::class, 'deleteAwardingBodyPermanently']);
    //delete permanently all deleted awarding bodies
    Route::middleware(['scope:admin'])->post('/awarding_body/delete', [AwardingBodyController::class, 'deleteAllDeletedAwardingBodiesPermanently']);

    //resource type
    //add a resource type
    Route::middleware(['scope:admin'])->post('/resource_type', [ResourceTypeController::class, 'addResourceType']);
    //update a resource type
    Route::middleware(['scope:admin'])->put('/resource_type/{id}', [ResourceTypeController::class, 'updateResourceType']);
    //delete a resource type
    Route::middleware(['scope:admin'])->delete('/resource_type/{id}', [ResourceTypeController::class, 'deleteResourceType']);
    //get a deleted resource type
    Route::middleware(['scope:admin'])->get('/resource_type/deleted/{id}', [ResourceTypeController::class, 'getDeletedResourceType']);
    //get all deleted resource types
    Route::middleware(['scope:admin'])->get('/resource_type/deleted', [ResourceTypeController::class, 'getAllDeletedResourceTypes']);
    //restore a deleted resource type
    Route::middleware(['scope:admin'])->post('/resource_type/restore/{id}', [ResourceTypeController::class, 'restoreResourceType']);
    //restore all deleted resource types
    Route::middleware(['scope:admin'])->post('/resource_type/restore', [ResourceTypeController::class, 'restoreAllResourceTypes']);
    //delete permanently a resource type
    Route::middleware(['scope:admin'])->post('/resource_type/delete/{id}', [ResourceTypeController::class, 'deleteResourceTypePermanently']);
    //delete permanently all deleted resource types
    Route::middleware(['scope:admin'])->post('/resource_type/delete', [ResourceTypeController::class, 'deleteAllResourceTypesPermanently']);

    //course
    //add a course
    Route::middleware(['scope:admin'])->post('/course', [CourseController::class, 'addCourse']);
    //update a course
    Route::middleware(['scope:admin'])->put('/course/{id}', [CourseController::class, 'editCourse']);
    //delete a course
    Route::middleware(['scope:admin'])->delete('/course/{id}', [CourseController::class, 'deleteCourse']);
    //get a deleted course
    Route::middleware(['scope:admin'])->get('/course/deleted/{id}', [CourseController::class, 'getDeletedCourse']);
    //get all deleted courses
    Route::middleware(['scope:admin'])->get('/course/deleted', [CourseController::class, 'getAllDeletedCourses']);
    //restore a deleted course
    Route::middleware(['scope:admin'])->post('/course/restore/{id}', [CourseController::class, 'restoreCourse']);
    //restore all deleted courses
    Route::middleware(['scope:admin'])->post('/course/restore', [CourseController::class, 'restoreAllCourses']);
    //delete permanently a course
    Route::middleware(['scope:admin'])->post('/course/delete/{id}', [CourseController::class, 'deletePermanentlyCourse']);
    //delete permanently all deleted courses
    Route::middleware(['scope:admin'])->post('/course/delete', [CourseController::class, 'deletePermanentlyAllCourses']);

    //resource
    //add a resource
    Route::middleware(['scope:admin'])->post('/resource', [ResourceController::class, 'addResource']);
    //update a resource
    Route::middleware(['scope:admin'])->put('/resource/{id}', [ResourceController::class, 'editResource']);
    //delete a resource
    Route::middleware(['scope:admin'])->delete('/resource/{id}', [ResourceController::class, 'deleteResource']);
    //get a deleted resource
    Route::middleware(['scope:admin'])->get('/resource/deleted/{id}', [ResourceController::class, 'getDeletedResource']);
    //get all deleted resources
    Route::middleware(['scope:admin'])->get('/resource/deleted', [ResourceController::class, 'getAllDeletedResources']);
    //restore a deleted resource
    Route::middleware(['scope:admin'])->post('/resource/restore/{id}', [ResourceController::class, 'restoreResource']);
    //restore all deleted resources
    Route::middleware(['scope:admin'])->post('/resource/restore', [ResourceController::class, 'restoreAllResources']);
    //delete permanently a resource
    Route::middleware(['scope:admin'])->post('/resource/delete/{id}', [ResourceController::class, 'deletePermanentlyResource']);
    //delete permanently all deleted resources
    Route::middleware(['scope:admin'])->post('/resource/delete', [ResourceController::class, 'deletePermanentlyAllResources']);

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
