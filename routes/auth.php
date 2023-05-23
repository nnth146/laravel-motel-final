<?php

use App\Http\Controllers\AvatarController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RateController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Models\Avatar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'create'])->name('login');

    Route::post('login', [LoginController::class, 'store']);

    Route::get('register', [RegisterController::class, 'create'])->name('register');

    Route::post('register', [RegisterController::class, 'store']);
});


Route::middleware('auth')->group(function () {
    Route::get('users.edit', [UserController::class, 'edit'])->name('users.edit');

    Route::patch('users.update', [UserController::class, 'update'])->name('users.update');

    Route::post('logout', function (Request $request) {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('home');
    })->name('logout');

    Route::get('users/rooms/search', [UserController::class, 'search']); // return response for script

    Route::patch('avatars/{avatar?}', [AvatarController::class, 'update'])->name('avatars.update');

    Route::delete('avatars/{avatar?}', [AvatarController::class, 'destroy'])->name('avatars.destroy');

    Route::post('rooms/{room}/rates', [RateController::class, 'store'])->name('rates.store');

    Route::patch('rates/{rate}', [RateController::class, 'update'])->name('rates.update');

    Route::delete('rates/{rate}', [RateController::class, 'destroy'])->name('rates.destroy');
});
