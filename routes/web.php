<?php

use App\Http\Controllers\BidBotController;
use App\Http\Controllers\BidHistoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\SettingController;
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

Route::get('/', function ()
{
    return redirect()->route('dashboard');
});

Route::group(['middleware' => 'auth'], function ()
{
    Route::get('/dashboard', [ItemController::class, 'index'])->name('dashboard');
    Route::get('/item/{item}', [ItemController::class, 'show'])->name('item.show');
    Route::post('/submit/bid/{item}', [BidHistoryController::class, 'submitBid'])->name('submitBid');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::put('/settings/save', [SettingController::class, 'store'])->name('saveSettings');
    Route::post('auto-bid/{item}', [BidBotController::class, 'store'])->name('autobid');
});

require __DIR__.'/auth.php';

Auth::routes();
