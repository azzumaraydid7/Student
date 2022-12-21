<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudentController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/students', [StudentController::class, 'getAllStudents']);
Route::post('/add-student', [StudentController::class, 'addStudent']);
Route::get('/edit-student/{id}', [StudentController::class, 'editStudent']);
Route::post('/update-student/{id}', [StudentController::class, 'updateStudent']);
Route::post('/delete-student/{id}', [StudentController::class, 'deleteStudent']);
