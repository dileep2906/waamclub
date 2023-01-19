<?php

use App\Http\Controllers\Api\Web\AppModuleController;
use App\Http\Controllers\Api\Web\AuthController;
use App\Http\Controllers\Api\Web\CompanyController;
use App\Http\Controllers\Api\Web\DocumentTypeController;
use App\Http\Controllers\Api\Web\JobCategoryController;
use App\Http\Controllers\Api\Web\JobController;
use App\Http\Controllers\Api\Web\kamaaoBenefitsController;
use App\Http\Controllers\Api\Web\WebinarController;
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

/*
|--------------------------------------------------------------------------
| CONTENTAINS ROUTES 
|--------------------------------------------------------------------------
|   LOGIN
|   
|   MIDDLEWARE->sanctum
|               LOGOUT
|               
|               APP_MODULES
|               JOBS CATEGORY
|               JOBS 
|               SKILLS 
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::post('register', [AuthController::class, 'createUser']);
// PROTECTED ROUTES

Route::middleware(['auth:sanctum'])->group(function () {

    /**** COMPANY  *****/
    Route::get('/company', [CompanyController::class, 'index'])->middleware(['auth:sanctum', 'ability:company-list']);
    Route::get('/company/{company}', [CompanyController::class, 'show']);
    Route::post('/company', [CompanyController::class, 'store']);
    Route::post('/company/{company}', [CompanyController::class, 'update']);
    Route::delete('/company/{company}', [CompanyController::class, 'destroy']);
});

Route::get('/test', function (Request $request) {
    return "WebApi";
});


/**** AppModules  *****/
// Route::get('/app_module', [AppModuleController::class, 'index']);
Route::get('/app_modules/{applicationModules}', [AppModuleController::class, 'show']);
Route::post('/app_modules', [AppModuleController::class, 'store']);
Route::post('/app_modules/{applicationModules}', fn () => abort(403, 'Action not allowed'));
Route::delete('/app_modules/{applicationModules}', [AppModuleController::class, 'destroy']);


/**** JOBS  *****/
Route::get('/jobs', [JobController::class, 'index']);
Route::get('/jobs/{job}', [JobController::class, 'show']);
Route::get('/jobs/category/{query}', [JobController::class, 'show']);
Route::post('/jobs', [JobController::class, 'store']);
Route::post('/jobs/{job}', [JobController::class, 'update']);

// /**** JOBS CATEGORY  *****/
Route::get('/job/category', [JobCategoryController::class, 'index']);
Route::get('/job/category/{jobCategory}', [JobCategoryController::class, 'show']);
Route::post('/job/category', [JobCategoryController::class, 'store']);
Route::post('/job/category/{jobCategory}', [JobCategoryController::class, 'update']);
Route::delete('/job/category/{jobCategory}', [JobCategoryController::class, 'destroy']);

Route::get('/webinars', [WebinarController::class, 'index']);
Route::get('/webinars/{webinar}', [WebinarController::class, 'show']);
Route::post('/webinars', [WebinarController::class, 'store']);
Route::post('/webinars/{webinar}', [WebinarController::class, 'update']);
Route::delete('/webinars/{webinar}', [WebinarController::class, 'destroy']);

// Route::get('/job/benefits', [kamaaoBenefitsController::class, 'index']);
Route::get('job/benefits/{id}', [kamaaoBenefitsController::class, 'show']);
Route::post('job/benefits', [kamaaoBenefitsController::class, 'store']);
Route::post('job/benefits/{benefits}', [kamaaoBenefitsController::class, 'update']);
Route::delete('job/benefits/{benefits}', [kamaaoBenefitsController::class, 'destroy']);

/**** SKILLS  *****/
// Route::get('/skill', [SkillsController::class, 'index']);
// Route::get('/skill/{skills}', [SkillsController::class, 'show']);
// Route::post('/skill', [SkillsController::class, 'store']);
// Route::post('/skill/{skills}', [SkillsController::class, 'update']);
// Route::delete('/skill/{skills}', [SkillsController::class, 'destroy']);


/******PROJECT ****/
// Route::get('/projects', [ProjectController::class, 'index']);
// Route::get('/project/{project}', [ProjectController::class, 'show']);
// Route::post('/project', [ProjectController::class, 'store']);
// Route::post('/project/{project}', [ProjectController::class, 'update']);
// Route::delete('/project/{project}', [ProjectController::class, 'destroy']);

/**** DOCUMENT TYPE ****/
Route::get('/document-type', [DocumentTypeController::class, 'index']);
Route::get('/document-type/{documentType}', [DocumentTypeController::class, 'show']);
Route::post('/document-type', [DocumentTypeController::class, 'store']);
Route::post('/document-type/{documentType}', [DocumentTypeController::class, 'update']);
Route::delete('/document-type/{documentType}', [DocumentTypeController::class, 'destroy']);



/*** USER SUPPORT */

// Route::get('/support', [UserSupportController::class, 'index']);
// Route::get('/support/{userSupport}', [UserSupportController::class, 'show']);
// Route::post('/support', [UserSupportController::class, 'store']);
// Route::post('/support/{userSupport}', [UserSupportController::class, 'update']);
// Route::delete('/support/{userSupport}', [UserSupportController::class, 'destroy']);
// Route::post('/support/ricket/{userSupport}', [UserSupportController::class, 'closeSupportTicket']);
