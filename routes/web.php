<?php

use App\Http\Controllers\EquipoMedicoController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\loginController;
use App\Http\Controllers\logoutController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\ProveedoreController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\VentaController;
use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('auth.login');
})->name('index');

Route::get('/panel',[homeController::class,'index'])->name('panel');

Route::get('/login', [loginController::class,'index'])->name('login');
Route::post('/login', [loginController::class,'login']);
Route::get('/logout',[logoutController::class,'logout'])->name('logout');

Route::get('/medicamento', function () {
    return view('medicamento.index'); 
});
Route::view('/medicamento', 'medicamento.index')->name('medicamento');


Route::view('/equipoMedico', 'equipoMedico.index')->name('equipoMedico');



Route::resource('medicamentos', MedicamentoController::class);
Route::resource('equipoMedico', EquipoMedicoController::class);
Route::resource('proveedores', ProveedoreController::class);
Route::resource('sucursales', SucursalController::class);
Route::resource('ventas', VentaController::class);


Route::get('/404', function () {
    return view('page.404'); 
});
Route::view('/404', 'page.404')->name('404');