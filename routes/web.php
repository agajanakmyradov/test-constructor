<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\AnswerController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('test')->group(function() {
    Route::view('/create', 'test.create')->middleware('auth')->name('test.create');

    Route::post('/store', [TestController::class, 'store'])->name('test.store');

    Route::get('/edit/{test}', [TestController::class,  'edit'])->name('test.edit');

    Route::post('/update/{test}', [TestController::class, 'update'])->name('test.update');

    Route::get('/show/{test}', [TestController::class, 'show'])->name('test.show');

    Route::get('/details/{test}', [TestController::class, 'showDetails'])->name('test.show.details');

    Route::get('/destroy/{test}', [TestController::class, 'destroy'])->name('test.destroy');

    Route::get('/users', [TestController::class, 'showUserTest'])->middleware('auth')->name('user.test.show');
});

Route::prefix('question')->group(function() {
    Route::get('/create/{test}', [QuestionController::class, 'create'])->name('question.create');

    Route::post('/store/{test}', [QuestionController::class, 'store'])->name('question.store');

    Route::get('/destroy/{question}', [QuestionController::class, 'destroy'])->name('question.destroy');

    Route::get('/edit/{question}', [QuestionController::class, 'edit'])->name('question.edit');

    Route::post('/update/{question}', [QuestionController::class, 'update'])->name('question.update');
});

Route::prefix('result')->group(function() {
    Route::post('/check/{test}', [ResultController::class, 'check'])->name('result.check');

    Route::get('/{test}', [ResultController::class, 'show'])->name('result.show');
});

Route::prefix('answer')->group(function(){
    Route::get('/create/{question}', [AnswerController::class, 'create'])->name('answer.create');

    Route::post('/store', [AnswerController::class, 'store'])->name('answer.store');

    Route::get('/destroy/{answer}', [AnswerController::class, 'destroy'])->name('answer.destroy');
});




