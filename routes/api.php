<?php

use App\Http\Controllers\Api\App\AuthController;
use App\Http\Controllers\Api\App\JobApplicationController;
use App\Http\Controllers\Api\App\JobController;
use App\Http\Controllers\Api\App\SavedJobController;
use App\Http\Controllers\Api\App\UserController;
use Illuminate\Http\Request;
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
// 
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [AuthController::class, 'createUser']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/createUserProfile', [UserController::class, 'createUserProfile']);
    Route::get('/getUserProfile', [UserController::class, 'getUserProfile']);
    Route::post('/uploadUserImage', [UserController::class, 'editProfile']);
    Route::post('/addSkills', [UserController::class, 'addSkill']);
    Route::post('/updateJobPreferance', [UserController::class, 'updateJobPreferance']);
    Route::post('/Set_job_location_preferances', [UserController::class, 'Set_job_location_preferances']);
    Route::post('/setEducation', [UserController::class, 'setEducation']);
    Route::post('/set-user-assets', [UserController::class, 'setUserAssets']);
    Route::post('/set-user-experience', [UserController::class, 'setUserExperience']);
    Route::post('/set-user-app-lng', [UserController::class, 'setUserAppLanguage']);
    Route::post('/uploadUserDocuments', [UserController::class, 'uploadUserDocuments']);
    Route::post('/application/create', [JobApplicationController::class, 'store']);
    // GET USER APPLICATIONS 

    Route::get('/application', [JobApplicationController::class, 'index']);
});
Route::post('/save-job', [SavedJobController::class, 'store']);
Route::get('/saved-jobs', [SavedJobController::class, 'index']);
Route::delete('/saved-jobs/{users_saved_job}', [SavedJobController::class, 'destroy']);

Route::post('/send_Login_Otp', [authController::class, 'sendLoginOtp']);
Route::post('/verifyOtp', [authController::class, 'verifyOtp']);
Route::get('/job-dashboard', [JobController::class, 'index']);
Route::get('/get_job_by_category', [JobController::class, 'get_job_by_category']);
