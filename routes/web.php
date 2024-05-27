<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScrpController;
use App\Http\Controllers\TestdbController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

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


Route::get('/dragtest', function () {
    return Inertia::render('Dragtest');
});

Route::get('/mausetest', function () {
    return Inertia::render('Mausetest');
});

// Route::get('/scrptest', [ScrpController::class, 'scrapetest']);
Route::get('/scrptest', [ScrpController::class, 'scrapesumo']);

Route::get('/testres', function () {

    $meta = Storage::get('public');
    $body = Storage::get('public/body.html');
    $test = Storage::get('public/test.html');

    $htmlinfo = '<!DOCTYPE html><html lang="ja">'.$meta.'<body>'.$body.$test.'</body></html>';

    return $htmlinfo;
});

Route::post('/testres/{testdb}', [TestdbController::class,"update"]);

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// ダッシュボード画面
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// 認証したユーザー用
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
