<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\CreatorController;
use App\Http\Controllers\PostController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', [PostController::class, 'index'])->name('posts.index');

Route::get('posts/trashed', [PostController::class, "trashed"])->name('posts.trashed');

Route::post('posts/{post}/comment', [CommentController::class, 'storeComment'])->name('posts.comment');

Route::get('posts/{post}/restore', [PostController::class, 'restore'])->name('posts.restore');

Route::delete('posts/{post}/forceDelete', [PostController::class, "forceDelete"])->name('posts.forceDelete');

Route::resource('posts', PostController::class);

Route::resource('users', CreatorController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/auth/redirect', function () {
    // return "github";
    return Socialite::driver('github')->redirect();
})->name("github.login");

Route::get('/auth/callback', function () {
    // return "redirected";
    $githubUser = Socialite::driver('github')->user();
    // dd($githubUser);

    $user = User::updateOrCreate([
        'github_id' => $githubUser->id,
    ], [
        'name' => $githubUser->name,
        'email' => $githubUser->email,
        'password' => $githubUser->token,
        'github_token' => $githubUser->token,
        'github_refresh_token' => $githubUser->refreshToken,
    ]);

    Auth::login($user);

    return redirect()->route('posts.index');
})->name("github.callback");
