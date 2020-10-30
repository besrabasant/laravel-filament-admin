<?php

use Illuminate\Support\Facades\Route;
use Filament\Features;
use Filament\Http\Controllers\{
    AssetController,
};

Route::group([
    'prefix' => config('filament.prefix.route'),
    'middleware' => config('filament.middleware', ['web']),
    'as' => 'filament.',
], function () {
    // Assets
    Route::name('assets.')->group(function () {
        Route::get('filament.css', [AssetController::class, 'css'])->name('css');
        Route::get('filament.css.map', [AssetController::class, 'cssMap']);
        Route::get('filament.js', [AssetController::class, 'js'])->name('js');   
        Route::get('filament.js.map', [AssetController::class, 'jsMap']);  
    });

    // Auth
    Route::prefix('auth')->group(function () {
        Route::get('login', config('filament.livewire.login'))->name('login');
        Route::get('forgot-password', config('filament.livewire.forgot-password'))->name('password.forgot');
        Route::get('reset-password/{token}', config('filament.livewire.reset-password'))->name('password.reset');
    });

    // Registration
    if (Features::registersUsers()) {
        Route::get('/register', config('filament.livewire.register'))->name('register');
    }

    // Authenticated routes
    Route::group(['middleware' => ['auth']], function () {
        // Dashboard
        Route::get('/', config('filament.livewire.dashboard'))
            // ->middleware('verified')
            ->name('dashboard');

        // Profile
        // Route::get('profile', config('filament.livewire.profile'))
        //  ->middleware('verified')
        //  ->name('profile');
    });
});

// Conditional route login alias
if (!Route::has('login')) {
    Route::get('/login', function () {
        return redirect()->route("filament.login");
    })->name('login');
}