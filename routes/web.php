<?php

use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\Pages\Parts;
use App\Livewire\Frontend\Pages\Welcome;
use App\Livewire\Dashboard\Pages\Parts\PartsShow;
use App\Livewire\Dashboard\Pages\Parts\PartsIndex;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', Welcome::class)->name('home');

Route::get('/login', Login::class)->name('login')->middleware(['guest']);

Route::middleware(['auth'])->prefix('dashboard')->group(function () {

    // Parts
    Route::get('/parts', PartsIndex::class)->name('parts.index');
    Route::get('/parts/{partId}', PartsShow::class)->name('parts.show');
});
