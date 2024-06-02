<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TagController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/editor', [ArticleController::class, 'create']);
Route::get('/editor/{slug}', [ArticleController::class, 'edit'])->name('article.edit');
Route::get('/article/{slug}', [ArticleController::class, 'show'])->name('article.show');
Route::get('/profile/{username}', [ProfileController::class, 'show']);
Route::get('/settings', [SettingsController::class, 'index']);
Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::put('/article/{slug}', [ArticleController::class, 'update'])->name('article.update');
Route::delete('/article/{slug}', [ArticleController::class, 'destroy'])->name('article.destroy');
Route::post('/article/{slug}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/article/{slug}/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');
