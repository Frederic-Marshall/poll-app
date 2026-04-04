<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Messanger\ChatController;
use App\Http\Controllers\Poll\PollController;
use \App\Http\Controllers\User\UserController;
use \App\Http\Controllers\Messanger\MessageController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'registerPage'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('users')->name('users.')->controller(UserController::class)->group(function () {
        Route::get('{user:nickname}', 'show')->name('show');

        Route::get('{user:nickname}/edit', 'edit')->name('edit');
        Route::put('{user:nickname}', 'update')->name('update');
    });

    Route::prefix('polls')->name('polls.')->controller(PollController::class)->group(function () {
        // Queue Export
        Route::get('export', 'export')->name('export');

        Route::get('', 'index')->name('index');
        Route::get('{poll:join_code}', 'show')->name('show');
        Route::post('{poll:join_code}/vote', 'vote')->name('vote');
    });

    Route::prefix('chats')->name('chats.')->controller(ChatController::class)->group(function () {
        Route::get('', 'index')->name('index');

        Route::post('private', 'privateChat')->name('private');
        Route::get('{chat:id}', 'showChat')->name('show');

//        Route::post('send', [MessageController::class, 'send'])->name('send');
    });


});
Route::middleware(['auth', 'web'])->group(function () {
    Route::post('send', [MessageController::class, 'send'])->name('send');
});
