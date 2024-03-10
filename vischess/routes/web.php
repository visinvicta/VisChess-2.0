<?php

use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StudyController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CommentController;

Route::middleware('web')->group(function () {

    Route::get('/', function () {
        return view('index');
    });

    Route::get('/about', function () {
        return view('about');
    });

    Route::get('/analysis', function () {
        return view('analysis');
    });

    //Register

    Route::get('/register', [RegisterController::class, 'create'])->middleware('guest');
    Route::post('/register', [RegisterController::class, 'store'])->middleware('guest');

    Route::get('/login', [SessionsController::class, 'create'])->name('login')->middleware('guest');
    Route::post('/login', [SessionsController::class, 'store'])->middleware('guest');
    Route::post('/logout', [SessionsController::class, 'destroy'])->middleware('auth');

    //Games

    Route::get('/games', [GameController::class, 'index']);
    Route::get('/game/{game}', [GameController::class, 'show']);
    Route::post('/games', [GameController::class, 'store']);
    Route::delete('/games/{game}', [GameController::class, 'destroy']);

    //Favorites

    Route::middleware('auth')->group(function () {
        Route::get('/favorites', [FavoriteController::class, 'index']);
        Route::get('/favorite/{favorite}', [FavoriteController::class, 'show']);
        Route::post('/favorites', [FavoriteController::class, 'store']);
        Route::delete('/favorites/{favorite}', [FavoriteController::class, 'destroy']);
    });

    //Studies

    Route::get('/studies', [StudyController::class, 'index']);
    Route::get('/studies/create', [StudyController::class, 'create']);
    Route::get('/study/{study}', [StudyController::class, 'show']);
    Route::post('/studies', [StudyController::class, 'store']);

    //Chapters

    Route::post('/chapters', [ChapterController::class, 'store'])->name('chapters.store');
    Route::get('/get-chapter-pgn/{chapter}', [StudyController::class, 'getChapterPgn']);
    Route::get('/get-chapter-comments/{chapter}', [StudyController::class, 'getChapterComments']);
    

    //Comments
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');








});
