<?php


Route::get('dresses/empresa', function () {
    return view('indexdresses');
});


Route::get('dresses/usuarios', 'DigitalsiteSaaS\Dresses\Http\UsuarioController@index');
Route::get('dresses/crear-usuario', 'DigitalsiteSaaS\Dresses\Http\UsuarioController@crearusuario');
Route::get('dresses/editar/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuarioController@editar');
Route::get('dresses/eliminar/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuarioController@eliminar');
Route::post('dresses/crear-usuario', 'DigitalsiteSaaS\Dresses\Http\UsuarioController@crear');
Route::post('dresses/actualizar/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuarioController@actualizar');

Route::get('dresses/clientes', 'DigitalsiteSaaS\Dresses\Http\UsuarioController@clientes');
Route::get('dresses/crear-cliente', 'DigitalsiteSaaS\Dresses\Http\UsuarioController@crearcliente');
Route::post('dresses/crear-cliente', 'DigitalsiteSaaS\Dresses\Http\UsuarioController@createcliente');

Route::get('dresses/factura/lista-facturas/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuarioController@facturaempresa');

Route::get('dresses/factura/crear-producto', 'DigitalsiteSaaS\Dresses\Http\UsuarioController@createproducto');
Route::post('productos/create', 'DigitalsiteSaaS\Dresses\Http\UsuarioController@creaproduct');

Route::get('dresses/factura/crear-facturacion/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuarioController@crearfactura');
Route::post('dresses/factura/crear-factura', 'DigitalsiteSaaS\Dresses\Http\UsuarioController@createfactura');

Route::get('Facturacione/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuarioController@facturacione');
Route::get('Facturacione/{id}/ajax-subcat', 'DigitalsiteSaaS\Dresses\Http\UsuarioController@facturacioneajax');
Route::post('dresses/factura/creacion-producto', 'DigitalsiteSaaS\Dresses\Http\UsuarioController@creatproducto');
Route::get('dresses/factura/generar-factura/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuarioController@pdf');
Route::get('dresses/factura/editar-empresa/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuarioController@editarempresa');
Route::post('dresses/factura/actualizar-empresa/{id}', 'DigitalsiteSaaS\Dresses\Http\UsuarioController@update');
Route::post('dresses/factura/crear-empresa', 'DigitalsiteSaaS\Dresses\Http\UsuarioController@createempresa');
Route::get('dresses/factura/crearempresa', 'DigitalsiteSaaS\Dresses\Http\UsuarioController@crearempresaweb');
Route::get('dresses/factura/negocios', 'DigitalsiteSaaS\Dresses\Http\UsuarioController@negocios');