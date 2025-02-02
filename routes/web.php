<?php

use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\InformationController;
use App\Http\Controllers\Web\MangaDetailController;
use App\Http\Controllers\Web\SearchController;
use App\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Route;

//HOME CONTROLLER
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('/hot', 'hotIndex')->name('hot');
});

//SEARCH CONTROLLER
Route::get('/search/manga', [SearchController::class, 'index'])->name('mangas.search');
Route::get('/search/suggest', [SearchController::class, 'suggestSearch'])->name('search.suggest');

//MANGA DETAIL CONTROLLER
Route::controller(MangaDetailController::class)->group(function () {
    Route::get('manga/{slug}', 'index')->name('manga.detail');
    Route::get('random', 'random')->name('manga.random');
    Route::get('read/{slug}-chapter-{chapter_number}', 'read')
        ->name('manga.read')
        ->where([
            'slug' => '[a-zA-Z0-9_-]+', 
            'chapter_number' => '[0-9]+(?:\.[0-9]+)?' 
        ]);
});


//INFORMATION CONTROLLER
Route::controller(InformationController::class)->group(function () {
    Route::get('/dmca', 'dmca')->name('dmca');
    Route::get('/about-us', 'aboutUs')->name('about-us');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/privacy', 'privacy')->name('privacy');
});


Route::get('/bookmark', [UserController::class, 'bookmarkIndex'])->name('bookmark');
Route::get('/history', [UserController::class, 'historyIndex'])->name('history');
Route::get('get-history', [UserController::class, 'getHistory'])->name('get-history');
Route::get('get-bookmark', [UserController::class, 'getBookmark'])->name('get-bookmark');

