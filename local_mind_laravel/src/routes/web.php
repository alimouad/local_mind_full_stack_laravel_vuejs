<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FavouriteController;
use App\Models\User;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;


// auth-----routes

Route::get('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'processRegister'])->name('register.process')->middleware('guest');
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process')->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// user routes---------
Route::get('/home', [UserController::class, 'index'])->name('home')->middleware('auth');
Route::get('/question', [UserController::class, 'questionForm'])->name('questions.create')->middleware('auth');
Route::post('/question/process', [UserController::class, 'questionProcess'])->name('question.process')->middleware('auth');
Route::get('/question/view/{id}', [UserController::class, 'viewQuestion'])->name('question.view')->middleware('auth');
Route::delete('/question/delete/{question}', [UserController::class, 'deleteQuestion'])->name('question.delete')->middleware('auth');
Route::post('/question/{question}/answer/add', [UserController::class, 'addAnswer'])->name('answer.process')->middleware('auth');
Route::post('/question/{question}/favorite/', [FavouriteController::class, 'setFavourite'])->name('questions.favorite')->middleware('auth');
Route::get('/favorites', [FavouriteController::class, 'index'])->name('favorites.index')->middleware('auth');


// admin route----------------
Route::middleware(['auth', 'role:ADMIN'])->group(function () {
    Route::get('/admin/home', [AdminController::class, 'dashboard'])->name('admin.home');
    Route::get('/admin/questions', [AdminController::class, 'getQuestions'])->name('admin.questions');
    Route::delete('/admin/question/delete/{id}', [AdminController::class, 'deleteQuestions'])->name('admin.delete.question');
    Route::get('/admin/answers', [AdminController::class, 'getAnswers'])->name('admin.answers');
    Route::delete('/admin/answer/delete/{id}', [AdminController::class, 'deleteAnswers'])->name('admin.delete.answer');
    Route::get('/admin/users', [AdminController::class, 'getUsers'])->name('admin.users');
    Route::delete('/admin/user/delete/{id}', [AdminController::class, 'deleteUsers'])->name('admin.delete.user');
});
