<?php


Route::get('dresses/empresa', function () {
    return view('indexdresses');
});


Route::get('dresses/usuarios', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@index');
Route::get('dresses/crear-usuario', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@crearusuario');
Route::get('dresses/editar/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@editar');
Route::get('dresses/eliminar/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@eliminar');
Route::post('dresses/crear-usuario', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@crear');
Route::post('dresses/actualizar/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@actualizar');

Route::get('dresses/clientes', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@clientes');
Route::get('dresses/crear-cliente', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@crearcliente');
Route::post('dresses/crear-cliente', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@createcliente');

Route::get('dresses/factura/lista-facturas/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@facturaempresa');

Route::get('dresses/factura/crear-producto', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@createproducto');
Route::post('productos/create', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@creaproduct');

Route::get('dresses/factura/crear-facturacion/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@crearfactura');
Route::post('dresses/factura/crear-factura', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@createfactura');

Route::get('Facturacione/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@facturacione');
Route::get('Facturacione/{id}/ajax-subcat', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@facturacioneajax');
Route::post('dresses/factura/creacion-producto', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@creatproducto');
Route::get('dresses/factura/generar-factura/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@pdf');
Route::get('dresses/factura/editar-empresa/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@editarempresa');
Route::post('dresses/factura/actualizar-empresa/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@update');
Route::post('dresses/factura/crear-empresa', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@createempresa');
Route::get('dresses/factura/crearempresa', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@crearempresaweb');
Route::get('dresses/factura/negocios', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@negocios');

Route::get('dresses/specialorders', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@special');
Route::get('/dresses/search', [DigitalsiteSaaS\Dresses\Http\UsuariaController::class, 'search'])->name('dresses.search');

Route::get('/dresses/client', [DigitalsiteSaaS\Dresses\Http\UsuariaController::class, 'client'])->name('dresses.client');


Route::post('/dresses/venta', [DigitalsiteSaaS\Dresses\Http\UsuariaController::class, 'store'])->name('dresses.ventaa');


Route::post('/guardar-venta', [App\Http\Controllers\OrdenController::class, 'store'])->name('dresses.venta');
Route::get('/buscar-clientes', [App\Http\Controllers\OrdenController::class, 'searchClientes'])->name('dresses.clients');
Route::get('/buscar-productos', [App\Http\Controllers\OrdenController::class, 'searchProductos'])->name('dresses.searchs');
Route::post('/clientes', [App\Http\Controllers\ClienteController::class, 'store'])->name('clientes.store');