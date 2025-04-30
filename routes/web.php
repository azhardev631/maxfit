<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\MedicalAssessmentQuestionController;
use App\Http\Controllers\OrganisationController;
use App\Http\Controllers\OrganisationTypesController;





Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/', function () {return redirect(route('dashboard'));});
    Route::get('/dashboard', function () {return view('dashboard');})->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');




    Route::resource('users', UsersController::class);
    Route::resource('organisation-types', OrganisationTypesController::class);
    Route::resource('organisations', OrganisationController::class);
    Route::resource('medical-assessment-questions', MedicalAssessmentQuestionController::class);

});



Route::get('clear-cache', function() {
    Artisan::call('optimize:clear');
    return "Cache is cleared";
});


Route::get('/force-fix-link', function () {
    $publicStorage = public_path('storage');

    // If it's a directory or file (not a real symlink), remove it
    if (file_exists($publicStorage) && !is_link($publicStorage)) {
        \File::deleteDirectory($publicStorage);
    }

    // If it's a broken symlink, unlink it
    if (is_link($publicStorage)) {
        unlink($publicStorage);
    }

    // Now create the correct symlink
    Artisan::call('storage:link');

    return '✅ Symlink force-fixed';
});

require __DIR__ . '/auth.php';
