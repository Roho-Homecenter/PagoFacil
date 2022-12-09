<?php

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



//------------------------------------------PAGOFACILCHECKOUT----------------------------------------

// esta ruta es la vista inicial, que muestra un formulario basico para datos del cliente
Route::get('PagoFacilCheckout', 'PagoFacilCheckoutClient@inicio');

//esta ruta recibe los parametros del formulario inicial del cliente y pasa a encriptar los datos antes de enviarlos para ser procesados en PagoFacil Bolivia
Route::post('PagoFacilCheckoutEncript', 'PagoFacilCheckoutClient@Encript');
