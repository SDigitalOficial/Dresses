<?php

Route::group(['middleware' => ['auth','usuariodresses']], function (){

Route::get('dresses/empresa', function () {
    return view('indexdresses');
});

});

Route::get('dresses/usuarios', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@index');
Route::get('dresses/crear-usuario', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@crearusuario');
Route::get('dresses/editar/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@editar');
Route::get('dresses/eliminar/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@eliminar');
Route::post('dresses/crear-usuario', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@crear');
Route::post('dresses/actualizar/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@actualizar');

Route::get('dresses/clientes', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@clientes');
Route::get('dresses/editar/cliente/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@editarclientes');
Route::get('dresses/editar/orden/{id}', 'DigitalsiteSaaS\Dresses\Http\OrdenController@editarorden');
Route::post('dresses/dresses/eidtar-clienteweb/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@editarclienteweb');

Route::get('dresses/editar/producto/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@editarproductosweb');
Route::post('dresses/editar/producto/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@editarproductoswebs');

Route::get('dresses/edit/store/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@editstore');
Route::post('dresses/edit/store/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@editstores');

Route::get('dresses/crear-cliente', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@crearcliente');
Route::post('dresses/crear-cliente', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@createcliente');

Route::get('dresses/factura/lista-facturas/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@facturaempresa');

Route::get('dresses/factura/crear-producto', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@createproducto');
Route::post('productos/creates', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@creaproducts');

Route::get('dresses/factura/crear-facturacion/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@crearfactura');
Route::post('dresses/factura/crear-factura', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@createfactura');

Route::post('dresses/crear-impuesto', 'DigitalsiteSaaS\Dresses\Http\OrdenController@createimpuesto');

Route::get('Facturacione/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@facturacione');
Route::get('Facturacione/{id}/ajax-subcat', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@facturacioneajax');
Route::post('dresses/factura/creacion-producto', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@creatproducto');
Route::get('dresses/factura/generar-factura/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@pdf');
Route::post('dresses/factura/editar-empresa/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@editarempresa');
Route::post('dresses/factura/actualizar-empresa/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@update');
Route::post('dresses/factura/crear-empresa', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@createempresa');
Route::get('dresses/factura/crearempresa', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@crearempresaweb');
Route::get('dresses/factura/negocios', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@negocios');

Route::post('/productos/pdf', [DigitalsiteSaaS\Dresses\Http\OrdenController::class, 'bulkFicha'])
    ->name('productos.pdf');


Route::get('dresses/specialorders', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@special');

Route::get('dresses/impuestos', 'DigitalsiteSaaS\Dresses\Http\OrdenController@impuestos');

Route::get('dresses/specialorders/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuariaController@specialedit');

Route::get('dresses/ver-ordenes/{id}', 'DigitalsiteSaaS\Dresses\Http\OrdenController@verordenes');

Route::get('dresses/ver-ordenes', 'DigitalsiteSaaS\Dresses\Http\OrdenController@verordenestotal');

Route::get('dresses/ver-taxes', 'DigitalsiteSaaS\Dresses\Http\OrdenController@vertaxes');
Route::get('dresses/crear-taxes', 'DigitalsiteSaaS\Dresses\Http\OrdenController@creartaxes');

Route::get('orden/delete/{id}', 'DigitalsiteSaaS\Dresses\Http\OrdenController@ordendelete');
Route::get('gestion/factura/eliminar-almacen/{id}', 'DigitalsiteSaaS\Dresses\Http\OrdenController@productdelete');

Route::get('gestion/factura/eliminar-taxes/{id}', 'DigitalsiteSaaS\Dresses\Http\OrdenController@impuestodelete');


Route::get('gestion/factura/eliminar-tienda/{id}', 'DigitalsiteSaaS\Dresses\Http\OrdenController@negociodelete');




Route::get('/dresses/search', [DigitalsiteSaaS\Dresses\Http\UsuariaController::class, 'search'])->name('dresses.search');

Route::get('/dresses/client', [DigitalsiteSaaS\Dresses\Http\UsuariaController::class, 'client'])->name('dresses.client');


Route::post('/dresses/venta', [DigitalsiteSaaS\Dresses\Http\UsuariaController::class, 'store'])->name('dresses.ventaa');


Route::post('/guardar-venta', [DigitalsiteSaaS\Dresses\Http\OrdenController::class, 'store'])->name('dresses.venta');
Route::get('/buscar-clientes', [DigitalsiteSaaS\Dresses\Http\OrdenController::class, 'searchClientes'])->name('dresses.clients');
Route::get('/buscar-productos', [DigitalsiteSaaS\Dresses\Http\OrdenController::class, 'searchProductos'])->name('dresses.searchs');
Route::post('/clientes', [DigitalsiteSaaS\Dresses\Http\ClienteController::class, 'store'])->name('clientes.store');

Route::get('/orders/{id}/edit', [DigitalsiteSaaS\Dresses\Http\OrdenController::class, 'edit'])->name('orders.edit');
Route::put('/orders/{id}', [DigitalsiteSaaS\Dresses\Http\OrdenController::class, 'update'])->name('orders.update');
Route::get('/orders/{id}', [DigitalsiteSaaS\Dresses\Http\OrdenController::class, 'show'])->name('orders.show');


Route::get('/orders/{id}/pdf', [DigitalsiteSaaS\Dresses\Http\OrdenController::class, 'generatePDF'])->name('orders.pdf');


// Para visualizar en navegador
Route::get('/orders/{id}/view', [DigitalsiteSaaS\Dresses\Http\OrdenController::class, 'generatePDF'])->name('orders.view');

// Para descargar
Route::get('/orders/{id}/download', function($id) {
    return app()->call('DigitalsiteSaaS\Dresses\Http\OrdenController@generatePDF', ['id' => $id, 'download' => true]);
})->name('orders.download');

Route::get('/dresses/impuestos', function() {
    return \DigitalsiteSaaS\Dresses\Tenant\Impuesto::all();
})->name('dresses.impuestos');

