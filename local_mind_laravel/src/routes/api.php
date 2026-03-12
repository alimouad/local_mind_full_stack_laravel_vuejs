<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FavouriteController;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Public auth routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout']);

// Public question routes
Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user()->only('id', 'name', 'email', 'role');
    });

    Route::get('/questions', [QuestionController::class, 'index']);
    Route::get('/questions/{question}', [QuestionController::class, 'show']);
    Route::post('/questions', [QuestionController::class, 'store']);
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy']);
    Route::post('/questions/{question}/answers', [AnswerController::class, 'storeAnswer']);
    Route::delete('/answers/{answer}', [AnswerController::class, 'destroy']);
    Route::post('/questions/{question}/favourite', [FavouriteController::class, 'toggle']);
    Route::get('/favourites', [FavouriteController::class, 'index']);

});

Route::middleware(['auth:api', 'admin'])->group(function () {
    Route::get('/admin/home', [AdminController::class, 'dashboardApi']);
    Route::get('/admin/questions', [QuestionController::class, 'questionsApi']);
    Route::get('/admin/answers', [AnswerController::class, 'answersApi']);
    Route::delete('/admin/questions/{question}', [QuestionController::class, 'deleteQuestionApi']);
    Route::delete('/admin/answers/{answer}', [AnswerController::class, 'deleteAnswerApi']);
    Route::delete('/admin/users/{user}', [UserController::class, 'deleteUserApi']);
    Route::get('/admin/users', [UserController::class, 'usersApi']);
});
