<?php

use App\Http\Controllers\TransferController;
use Illuminate\Support\Facades\Route;

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

Route::get('/add',[TransferController::class, 'create'])->name('transfer.create');
Route::post('/storeTransfer',[TransferController::class, 'store'])->name('transfer.store');
Route::get('/admin',[TransferController::class, 'index'])->name('transfer.index');
Route::post('/filter',[TransferController::class, 'filter'])->name('transfer.filter');
Route::get('/all-data', [TransferController::class, 'fetchAllData'])->name('all.data');

Route::get('/my-transfers',function (){
    return view('client.transfers');
})->name('client.transfers');
