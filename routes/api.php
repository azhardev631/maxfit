<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PersonalInfoController;
use App\Http\Controllers\API\MedicalAssessmentAnswerController;
use App\Http\Controllers\API\MedicalAssessmentQuestionController;

// ==========================================================================public routes=================================================================
Route::prefix('v1')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgot-password']);
    Route::post('reset-password', [AuthController::class, 'reset-password']);
    Route::get('organisation-types', [PersonalInfoController::class, 'getOrganisationTypes']);
    Route::get('organisations/{id}', [PersonalInfoController::class, 'getOrganisations']);
    Route::get('countries', [PersonalInfoController::class, 'get_countries']);
    Route::get('provinces/{id}', [PersonalInfoController::class, 'get_provinces']);
    Route::get('cities/{id}', [PersonalInfoController::class, 'get_cities']);
});




// ==========================================================================protected routes==============================================================

Route::prefix('v1')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/profile', [PersonalInfoController::class, 'profile']);
    Route::post('/physical-assessment', [PersonalInfoController::class, 'physical_assessment']);
    Route::post('/medical-assessment-answers', MedicalAssessmentAnswerController::class);
    Route::get('/medical-assessment-questions', MedicalAssessmentQuestionController::class);
})->middleware('auth:sanctum');
