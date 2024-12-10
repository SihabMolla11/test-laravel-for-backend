<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('student', [StudentController::class, 'index']);
Route::get('add-student', [StudentController::class, 'addStudent']);
Route::patch('update-student/{id}', [StudentController::class, 'editStudent']);
Route::delete('remove-student/{id}', [StudentController::class, 'deleteStudent']);



require __DIR__ . '/teacher.php';
