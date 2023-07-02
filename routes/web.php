<?php

use App\Http\Controllers\Controller;
use App\Http\Livewire\Posts;
use App\Http\Livewire\Users;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/', Posts::class)->name('dashboard');
    Route::get('users', Users::class)
        ->name('users')
        ->middleware('user.admin');
    Route::get('/download', [Controller::class, 'getDownload'])->name('download.get');
    Route::post('/download', [Controller::class, 'saveDownload'])->name('download.save');
});
