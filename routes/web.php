<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotaController;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/nota/{transaksi}/pdf', [NotaController::class, 'generatePDF'])->name('nota.pdf');
