<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\FacturaController;

Route::get('/', function () {
    return view('welcome');
});

//en este caso sólo queremos las facturas así que nos vamos a utilizar como una ruta de recurso.
Route::get('/facturas/{id?}', [FacturaController::class, 'show'])->name('facturas.show');

