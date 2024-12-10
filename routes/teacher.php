<?php

use App\Http\Controllers\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('teacher')->group(function () {
    Route::post('add-new-teacher', [TeacherController::class, 'addedTeacher']);
    Route::patch('update-teacher/{id}', [TeacherController::class, 'updateTeacher']);
    Route::get('get-single-teacher/{id}', [TeacherController::class, 'getSingleTeacher']);
});
