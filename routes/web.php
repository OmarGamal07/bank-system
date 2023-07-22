<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\TypeController;
use Illuminate\Support\Facades\Auth;
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
// */
// <<<<<<< HEAD

// Route::get('/add',[TransferController::class, 'create'])->name('transfer.create');
// Route::post('/storeTransfer',[TransferController::class, 'store'])->name('transfer.store');
// Route::get('/admin',[TransferController::class, 'index'])->name('transfer.index');
// Route::post('/filter',[TransferController::class, 'filter'])->name('transfer.filter');
// Route::get('/all-data', [TransferController::class, 'fetchAllData'])->name('all.data');
// Route::post('/updateStatus', [TransferController::class, 'update'])->name('update.status');
// Route::get('transfers-export',[TransferController::class, 'export'])->name('transfers.export');
// Route::post('transfers-import',[TransferController::class,'import'])->name('transfers.import');

// });
Auth::routes();
Route::group(['middleware' => 'auth'], function () {
    Route::get('/add',[TransferController::class, 'create'])->name('transfer.create');
    Route::get('/admin',[TransferController::class, 'index'])->name('transfer.index');
    Route::post('/storeTransfer',[TransferController::class, 'store'])->name('transfer.store');
    Route::post('/filter',[TransferController::class, 'filter'])->name('transfer.filter');
    Route::get('/all-data', [TransferController::class, 'fetchAllData'])->name('all.data');
    Route::post('/updateStatus', [TransferController::class, 'update'])->name('update.status');
    Route::post('/save-bank',[BankController::class,'store'])->name('bank.store');
    Route::post('/save-type',[TypeController::class,'store'])->name('type.store');
    Route::get('transfers-export',[TransferController::class, 'export'])->name('transfers.export');
    Route::post('transfers-import',[TransferController::class,'import'])->name('transfers.import');
    Route::get('/my-transfers',function (){
                return view('client.transfers');
            })->name('client.transfers');
});

// >>>>>>> d728c1b8d585c6f157df5cf5e3dc98bd8609877d


