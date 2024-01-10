<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\Auth\UserAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', [UserAuthController::class, 'register']);
Route::post('/login', [UserAuthController::class, 'login']);

Route::middleware('auth:api')->prefix('students')->group(function(){
    Route::get('/', [StudentsController::class, 'index']);
    Route::get('/name/{name}', [StudentsController::class, 'search_name']);
    Route::get('/email/{email}', [StudentsController::class, 'search_email']);
    Route::post('/import_students', [StudentsController::class, 'importStudents']);
});
