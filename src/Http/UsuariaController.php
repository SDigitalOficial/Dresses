<?php

namespace DigitalsiteSaaS\Dresses\Http;
use DigitalsiteSaaS\Usuario\Usuario;
use Illuminate\Support\Facades\Auth;
use DB;
use File;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Input;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Repositories\HostnameRepository;
use Hyn\Tenancy\Repositories\WebsiteRepository;
use DigitalsiteSaaS\Facturacion\Empresa;
use DigitalsiteSaaS\Facturacion\Notas;

use Illuminate\Http\Request;
use PDF;


class UsuariaController extends Controller{

protected $tenantName = null;

public function __construct(){
 $this->middleware('auth');
  $hostname = app(\Hyn\Tenancy\Environment::class)->hostname();
  if ($hostname){
  $fqdn = $hostname->fqdn;
  $this->tenantName = explode(".", $fqdn)[0];
 }
}

public function index() {
 if(!$this->tenantName){
 $users = Usuario::all();
 }else{
 $users = \DigitalsiteSaaS\Usuario\Tenant\Usuario::all();
 }
 $website = app(\Hyn\Tenancy\Environment::class)->website();
 return view('dresses::usuarios.usuarios')->with('users',$users)->with('website',$website);
}


public function crearusuario() {
 if(!$this->tenantName){
 $empresas = Empresa::all();
 }else{
 $empresas = \DigitalsiteSaaS\Facturacion\Tenant\Empresa::all();
 }
 return View('dresses::usuarios.crear-usuario')->with('empresas',$empresas);
}


public function crear(){
 if(!$this->tenantName){
 $price = Usuario::max('id');
 }else{
 $price = \DigitalsiteSaaS\Usuario\Tenant\Usuario::max('id');
 }
 $suma = $price + 1;
 $path = public_path() . '/fichaimg/clientes/'.$suma;
 File::makeDirectory($path, 0777, true, true);
 $password = Input::get('password');
 $remember = Input::get('_token');
 if(!$this->tenantName){
 $user = new Usuario;
 }else{
 $user = new \DigitalsiteSaaS\Usuario\Tenant\Usuario;	
 }
 $user->name = Input::get('name');
 $user->last_name = Input::get('last_name');
 $user->email = Input::get('email');
 $user->address = Input::get('address');
 $user->phone = Input::get('phone');;
 $user->rol_id = Input::get('level');
 $user->remember_token = Input::get('_token');
 $user->region = Input::get('store');
 $user->password = Hash::make($password);
 $user->remember_token = Hash::make($remember);
 $user->save();
 return Redirect('dresses/usuarios')->with('status', 'ok_create');
}  

public function eliminar($id) {
 if(!$this->tenantName){
 $user = Usuario::find($id);
 }else{
 $user = \DigitalsiteSaaS\Usuario\Tenant\Usuario::find($id);
 }
 $user->delete();
 return Redirect('dresses/usuarios')->with('status', 'ok_delete');
}


public function editar($id){
 if(!$this->tenantName){
 $usuario = Usuario::find($id);
 $empresas = Empresa::all();
 }else{
 $usuario = \DigitalsiteSaaS\Usuario\Tenant\Usuario::find($id);
 $empresas = \DigitalsiteSaaS\Facturacion\Tenant\Empresa::all();
 }
 return view('dresses::usuarios.editar')->with('usuario', $usuario)->with('empresas', $empresas);
}

public function actualizar($id){
 $input = Input::all();
 if(!$this->tenantName){
 $user = Usuario::find($id);
 }else{
 $user = \DigitalsiteSaaS\Usuario\Tenant\Usuario::find($id);  
 }
 $user->name = Input::get('name');
 $user->last_name = Input::get('last_name');
 $user->email = Input::get('email');
 $user->address = Input::get('address');
 $user->phone = Input::get('phone');
 $user->region = Input::get('store');
 $user->rol_id = Input::get('level');
 $user->save();
 return Redirect('dresses/usuarios')->with('status', 'ok_update');
}


public function clientes(){
if(!$this->tenantName){
$facturacion = Cliente::all();
}
else{
$facturacion = \DigitalsiteSaaS\Facturacion\Tenant\Cliente::all();
}
return view('dresses::clientes.clientes')->with('facturacion', $facturacion);    
}

public function crearcliente(){
 return view('dresses::clientes.crear-clientes');
}

 public function createcliente() {
 if(!$this->tenantName){
 $facturacion = new Cliente;
 }
 else{
 $facturacion = new \DigitalsiteSaaS\Facturacion\Tenant\Cliente;  
 }
 $facturacion->terceros = Input::get('terceros');
 $facturacion->t_persona = Input::get('t_persona');
 $facturacion->p_apellido = Input::get('p_apellido');
 $facturacion->s_apellido = Input::get('s_apellido');
 $facturacion->p_nombre = Input:: get ('p_nombre');
 $facturacion->s_nombre = Input:: get ('s_nombre');
 $facturacion->t_documento = Input:: get ('t_documento');
 $facturacion->documento = Input:: get ('documento');
 $facturacion->direccion = Input:: get ('direccion');
 $facturacion->telefono = Input:: get ('telefono');
 $facturacion->ciudad = Input:: get ('ciudad');
 $facturacion->email = Input:: get ('email');
 $facturacion->estado = Input:: get ('estado');
 $facturacion->proceso = Input:: get ('situacion');
 $facturacion->ingreso = Input:: get ('start');
 $facturacion->regimen = Input:: get ('regimen');
 $facturacion->retefuente = Input:: get ('retefuente');
 $facturacion->save();

  return Redirect('/dresses/clientes')->with('status', 'ok_create');
}


public function facturaempresa($id){
if(!$this->tenantName){
 $facturacion = Cliente::find($id)->Facturas;
 $contenido = Cliente::find($id);
 $usuarios = Usuario::all();
 $empresa = Empresa::all();
 }else{
 $facturacion = \DigitalsiteSaaS\Facturacion\Tenant\Cliente::find($id)->Facturas;
 $contenido = \DigitalsiteSaaS\Facturacion\Tenant\Cliente::find($id);
 $usuarios = \DigitalsiteSaaS\Usuario\Tenant\Usuario::all();
 $empresa = \DigitalsiteSaaS\Facturacion\Tenant\Empresa::all();

}
 return view('dresses::facturacion.crear_factura')->with('facturacion', $facturacion)->with('contenido', $contenido)->with('usuarios', $usuarios)->with('empresa', $empresa);
}

public function createproducto(){
if(!$this->tenantName){
$facturacion = Max::join('categories','categories.id','=','subcategories.category_id')->get();
$empresas = Empresa::all();
}else{
$facturacion = \DigitalsiteSaaS\Facturacion\Tenant\Max::join('categories','categories.id','=','subcategories.category_id')->get();
$empresas = \DigitalsiteSaaS\Facturacion\Tenant\Empresa::all();
}
return view('dresses::facturacion.crear_almacen')->with('facturacion', $facturacion)->with('empresas', $empresas);
}


public function editarempresa($id){
 if(!$this->tenantName){
 $facturacion = Empresa::find($id);
 }else{
 $facturacion = \DigitalsiteSaaS\Facturacion\Tenant\Empresa::find($id);
 }
 return view('dresses::empresas.editar_empresa')->with('facturacion', $facturacion);
}




public function update($id) {
 $input = Input::all();
 if(!$this->tenantName){
 $facturacion = Empresa::find($id);
 }else{
 $facturacion = \DigitalsiteSaaS\Facturacion\Tenant\Empresa::find($id); 
 }
 $facturacion->r_social =  Input::get('r_social');
 $facturacion->nit = Input::get('nit');
 $facturacion->direccion = Input::get('direccion');
 $facturacion->telefono = Input::get('telefono');
 $facturacion->ciudad = Input:: get ('ciudad');
 $facturacion->email = Input:: get ('email');
 $facturacion->aed = Input:: get ('aed');
 $facturacion->t_ica = Input:: get ('t_ica');
 $facturacion->t_cree = Input:: get ('t_cree');
 $facturacion->regimen = Input:: get ('regimen');
 $facturacion->r_factura = Input:: get ('r_factura');
 $facturacion->n_mercantil = Input:: get ('n_mercantil');
 $facturacion->website = Input:: get ('website');
 $facturacion->c_comercio = Input:: get ('c_comercio');
 $facturacion->f_ingreso = Input:: get ('start');
 $facturacion->prefijo = Input:: get ('prefijo');
 $facturacion->image = Input::get('FilePath');
 $facturacion->color = Input::get('color');
 $facturacion->coloruno = Input::get('coloruno');
 $facturacion->colordos = Input::get('colordos');
 $facturacion->save();
 return Redirect('dresses/factura/negocios')->with('status', 'ok_create');
}

public function crearempresaweb(){

 return view('dresses::empresas.crearempresa');
}


public function negocios(){

if(!$this->tenantName){
 $facturacion = Empresa::all();
}else{
 $facturacion = \DigitalsiteSaaS\Facturacion\Tenant\Empresa::all();
}
 return view('dresses::empresas.negocios')->with('facturacion', $facturacion);
}


public function createempresa() {

 if(!$this->tenantName){
 $facturacion = new Empresa;
 }else{
 $facturacion = new \DigitalsiteSaaS\Facturacion\Tenant\Empresa;  
 }
 $facturacion->r_social =  Input::get('r_social');
 $facturacion->nit = Input::get('nit');
 $facturacion->direccion = Input::get('direccion');
 $facturacion->telefono = Input::get('telefono');
 $facturacion->ciudad = Input:: get ('ciudad');
 $facturacion->email = Input:: get ('email');
 $facturacion->aed = Input:: get ('aed');
 $facturacion->t_ica = Input:: get ('t_ica');
 $facturacion->t_cree = Input:: get ('t_cree');
 $facturacion->regimen = Input:: get ('regimen');
 $facturacion->r_factura = Input:: get ('r_factura');
 $facturacion->n_mercantil = Input:: get ('n_mercantil');
 $facturacion->website = Input:: get ('website');
 $facturacion->c_comercio = Input:: get ('c_comercio');
 $facturacion->f_ingreso = Input:: get ('start');
 $facturacion->prefijo = Input:: get ('prefijo');
 $facturacion->image = Input::get('FilePath');
 $facturacion->color = Input::get('color');
 $facturacion->coloruno = Input::get('coloruno');
 $facturacion->colordos = Input::get('colordos');
 $facturacion->save();
 return Redirect('gestion/factura')->with('status', 'ok_create');
}

public function createfactura() {
 if(!$this->tenantName){
 $facturacion = new Factura;
 }else{
 $facturacion = new \DigitalsiteSaaS\Facturacion\Tenant\Factura;  
 }
 $facturacion->cliente_id = Input:: get ('identificador');
 $facturacion->observaciones = Input:: get ('observaciones');
 $facturacion->dirigido = Input:: get ('dirigido');
 $facturacion->f_emision = Input:: get ('start');
 $facturacion->f_vencimiento = Input:: get ('end');
 $facturacion->estadof = Input:: get ('estado');
 $facturacion->user_id = Auth::user()->id;
 $facturacion->region_id = Auth::user()->region;
 $facturacion->save();

return Redirect('dresses/factura/lista-facturas/'.$facturacion->cliente_id)->with('status', 'ok_create');

    }


public function facturacione($id){
if(!$this->tenantName){
 $facturacion = Factura::find($id)->Productos;
 $contenido = Factura::find($id);
 $categories = Category::all();
 $product = Almacen::Orderby('id', 'desc')->take(10)->pluck('producto','id');
 $retefuente = Factura::join('clientes','clientes.id','=','facturas.cliente_id')->where('facturas.id', '=', $id)->get();
 }else{
 $facturacion = \DigitalsiteSaaS\Facturacion\Tenant\Factura::find($id)->Productos;
 $contenido = \DigitalsiteSaaS\Facturacion\Tenant\Factura::find($id);
 $categories = \DigitalsiteSaaS\Facturacion\Tenant\Category::all();
 $product = \DigitalsiteSaaS\Facturacion\Tenant\Almacen::Orderby('id', 'desc')->take(10)->pluck('producto','id');
 $retefuente = \DigitalsiteSaaS\Facturacion\Tenant\Factura::join('clientes','clientes.id','=','facturas.cliente_id')->where('facturas.id', '=', $id)->get();
}
 return view('dresses::productos.crear_producto')->with('retefuente', $retefuente)->with('facturacion', $facturacion)->with('contenido', $contenido)->with('product', $product)->with('categories', $categories);
}

  public function creatproducto() {
    if(!$this->tenantName){
    $contenido = Empresa::find(1);
    $facturacion = new Producto;
    }else{
    $contenido = \DigitalsiteSaaS\Facturacion\Tenant\Empresa::find(1);
    $facturacion = new \DigitalsiteSaaS\Facturacion\Tenant\Producto;
    }
  $facturacion->cliente = Input:: get ('cliente');
  $facturacion->retefuente = Input:: get ('retefuente');
  $facturacion->reteiva = DB::table('clientes')->where('id', $facturacion->cliente)->value('regimen');
  $facturacion->factura_id = Input:: get ('identificador');
  $facturacion->producto = Input:: get ('producto');
  $facturacion->product = Input:: get ('product');
  $facturacion->cantidad = Input:: get ('cantidad');
  $facturacion->v_unitario = Input:: get ('v_unitario');
  $facturacion->iva = Input:: get ('iva');
  $facturacion->descuento = Input:: get ('descuento');
  $facturacion->descripcion = Input:: get ('descripcion');
  $facturacion->descue = $facturacion->v_unitario*$facturacion->cantidad*$facturacion->descuento/100;
  $facturacion->v_total = $facturacion->v_unitario*$facturacion->cantidad-$facturacion->descue;
  $facturacion->rteica = $facturacion->v_total*$contenido->t_ica/1000;
  $facturacion->rtefte = $facturacion->v_total*$facturacion->retefuente/100;
  $facturacion->masiva = $facturacion->v_total*$facturacion->iva/100+$facturacion->v_total;
  $facturacion->costoiva = $facturacion->v_total*$facturacion->iva/100;
  if($facturacion->reteiva == 1)
  $facturacion->rteiva = 0;
  else
  $facturacion->rteiva = $facturacion->costoiva*15/100;
    $facturacion->save();
    return Redirect('Facturacione/'.$facturacion->factura_id)->with('status', 'ok_create');
    }



    public function pdf($id){
 if(!$this->tenantName){
 $empresa = Empresa::where('id', 1)->get();
 $users = Factura::count();
 $empresario = Empresa::min('desde');
 $total = $users+$empresario;
 $totalazo = Producto::where('factura_id', '=', $id)->groupBy('factura_id')->sum('v_total');
 $totalseis = Producto::where('factura_id', '=', $id)->where('iva', '=', '16')->sum('costoiva');
 $totaldiez = Producto::where('factura_id', '=', $id)->where('iva', '=', '10')->sum('costoiva');
 $totalnueve = Producto::where('factura_id', '=', $id)->where('iva', '=', '19')->sum('costoiva');
 $descuento = Producto::where('factura_id', '=', $id)->sum('descue');
 $totaliva = $totalazo*16/100;
 $color = Empresa::find(1);
 $grantotal = $totalazo+$totaliva;
 $totalito = Producto::where('factura_id', '=', $id)->sum('masiva');
 $rteica = Producto::where('factura_id', '=', $id)->sum('rteica');
 $rtefte = Producto::where('factura_id', '=', $id)->sum('rtefte');
 $rteiva = Producto::where('factura_id', '=', $id)->sum('rteiva');
 $post = Factura::where('id', $id)->pluck('cliente_id');
 $name = Factura::where('id', '=', $id)->get();
 $prefijo = Empresawhere('id', 1)->get();
 $producto = Producto::where('factura_id', '=', $id)->get();
 $cliente = Cliente::where('id', '=', $post)->get();
 }else{
 $empresa = \DigitalsiteSaaS\Facturacion\Tenant\Empresa::where('id', 1)->get();
 $users = \DigitalsiteSaaS\Facturacion\Tenant\Factura::count();
 $empresario = \DigitalsiteSaaS\Facturacion\Tenant\Empresa::min('desde');

 $total = $users;
 $totalazo = \DigitalsiteSaaS\Facturacion\Tenant\Producto::where('factura_id', '=', $id)->groupBy('factura_id')->sum('v_total');
 $totalseis = \DigitalsiteSaaS\Facturacion\Tenant\Producto::where('factura_id', '=', $id)->where('iva', '=', '16')->sum('costoiva');
 $totaldiez = \DigitalsiteSaaS\Facturacion\Tenant\Producto::where('factura_id', '=', $id)->where('iva', '=', '10')->sum('costoiva');
 $totalnueve = \DigitalsiteSaaS\Facturacion\Tenant\Producto::where('factura_id', '=', $id)->where('iva', '=', '19')->sum('costoiva');
 $descuento = \DigitalsiteSaaS\Facturacion\Tenant\Producto::where('factura_id', '=', $id)->sum('descue');
 $totaliva = $totalazo*16/100;
 $color = \DigitalsiteSaaS\Facturacion\Tenant\Empresa::find(1);
 $grantotal = $totalazo+$totaliva;
 $totalito = \DigitalsiteSaaS\Facturacion\Tenant\Producto::where('factura_id', '=', $id)->sum('masiva');
 $rteica = \DigitalsiteSaaS\Facturacion\Tenant\Producto::where('factura_id', '=', $id)->sum('rteica');
 $rtefte = \DigitalsiteSaaS\Facturacion\Tenant\Producto::where('factura_id', '=', $id)->sum('rtefte');
 $rteiva = \DigitalsiteSaaS\Facturacion\Tenant\Producto::where('factura_id', '=', $id)->sum('rteiva');
 $post = \DigitalsiteSaaS\Facturacion\Tenant\Factura::where('id', $id)->pluck('cliente_id');
 $name = \DigitalsiteSaaS\Facturacion\Tenant\Factura::where('id', '=', $id)->get();
 $prefijo = \DigitalsiteSaaS\Facturacion\Tenant\Empresa::where('id', 1)->get();
 $producto = \DigitalsiteSaaS\Facturacion\Tenant\Producto::where('factura_id', '=', $id)->get();
 $cliente = \DigitalsiteSaaS\Facturacion\Tenant\Cliente::where('id', '=', $post)->get();

 }
    
 $pdf = PDF::loadView('facturacion::pdf', compact('empresa','color','cliente','prefijo','producto','name','totalazo','totaliva','grantotal','totalseis','totaldiez','usuarios','total', 'totalnueve', 'iva', 'totalito','descuento','rtefte','rteica','rteiva'));
 return $pdf->stream(); 
    }


public function facturacioneajax($id) {
 if(!$this->tenantName){
 $cat_id = Input::get('cat_id');
 $subcategories = Subcategory::where('category_id', '=', $cat_id)->get();
 }else{
 $cat_id = Input::get('cat_id');
 $subcategories = \DigitalsiteSaaS\Facturacion\Tenant\Subcategory::where('category_id', '=', $cat_id)->get();
 }
 return Response::json($subcategories);
}



public function creaproduct(){
if(!$this->tenantName){
 $category = Category::create([
 'producto' => Input::get('producto'),
 'identificador' => Input::get('identificador')]);
 $subcategory = new Subcategory([
 'iva' => Input::get('iva'),
 'identificador' => Input::get('identificador'),
 'precio' => Input::get('precio'),
 'producto' => Input::get('producto'),
 'color' => Input::get('color'),
 'size' => Input::get('size'),
 'cantidad' => Input::get('cantidad'),
 'store' => Input::get('store'),
  ]);
 }else{
 $category = \DigitalsiteSaaS\Facturacion\Tenant\Category::create([
 'producto' => Input::get('producto'),
 'identificador' => Input::get('identificador')]);
 $subcategory = new \DigitalsiteSaaS\Facturacion\Tenant\Subcategory([
 'iva' => Input::get('iva'),
 'identificador' => Input::get('identificador'),
 'precio' => Input::get('precio'),
 'producto' => Input::get('producto'),
 'color' => Input::get('color'),
 'size' => Input::get('size'),
 'cantidad' => Input::get('cantidad'),
 'store' => Input::get('store'),

  ]);

 }
 $category->subcategories()->save($subcategory);
 return Redirect('dresses/factura/crear-producto')->with('status', 'ok_create');
}



public function crearfactura($id){
 if(!$this->tenantName){
 $contenido = Cliente::find($id);
 }else{
 $contenido = \DigitalsiteSaaS\Facturacion\Tenant\Cliente::find($id);
 }
 return view('dresses::ordenes.crear_facturacion')->with('contenido', $contenido);
}


public function eliminarinfobancaria($id) {

 if(!$this->tenantName){
 $user = Informacion::find($id);
 }else{
 $user = \DigitalsiteSaaS\Dafer\Tenant\Informacion::find($id);
 $regreso = \DigitalsiteSaaS\Dafer\Tenant\Informacion::where('id', '=', $id)->get();

 }
 $user->delete();
 foreach ($regreso as $regreso) {
   $identi = $regreso->empresa_id;
 }

 return Redirect('dafer/informacion-bancaria/'.$identi)->with('status', 'ok_delete');
}






public function empresas(){
if(!$this->tenantName){
$facturacion = Empresa::orderBy('n_negocio', 'asc')->get();
}
else{
$facturacion = \DigitalsiteSaaS\Dafer\Tenant\Empresa::orderBy('n_negocio', 'asc')->get();
}
return view('dafer::empresas.empresas')->with('facturacion', $facturacion);
     
}


public function resumen($id){
if(!$this->tenantName){
$empresa = Empresa::all();
}
else{
$empresa = \DigitalsiteSaaS\Dafer\Tenant\Empresa::where('id','=',$id)->get();
$productos = \DigitalsiteSaaS\Dafer\Tenant\Infoproducto::join('dafer_productos','dafer_productos.id', '=', 'dafer_infoproductos.producto_id')->where('dafer_infoproductos.empresa_id','=',$id)->get();
$bancos = \DigitalsiteSaaS\Dafer\Tenant\Informacion::join('dafer_bancos','dafer_bancos.id', '=', 'dafer_infobancaria.banco_id')->where('dafer_infobancaria.empresa_id','=',$id)->get();
}

return view('dafer::empresas.resumen')->with('empresa', $empresa)->with('productos', $productos)->with('bancos', $bancos);
     
}


public function crearempresa() {
 return View('dafer::empresas.crear-empresa');
}

public function editarproducto($id){
if(!$this->tenantName){
 $producto = Producto::find($id);
 }else{
 $producto = \DigitalsiteSaaS\Dafer\Tenant\Producto::find($id); 
 }
 return view('dafer::productos.editar-producto')->with('producto', $producto);
}

public function editarproductoc($id){
if(!$this->tenantName){
 $producto = Producto::all();
 }else{
 $producto = \DigitalsiteSaaS\Dafer\Tenant\Producto::all(); 
 $datos = \DigitalsiteSaaS\Dafer\Tenant\Producto::join('dafer_infoproductos','dafer_productos.id', '=', 'dafer_infoproductos.producto_id')
         ->where('dafer_infoproductos.id', '=', $id)->get();
 }

 return view('dafer::productos.editar-productoc')->with('producto', $producto)->with('datos', $datos);
}

public function create() {
 if(!$this->tenantName){
 $facturacion = new Empresa;
 }
 else{
 $facturacion = new \DigitalsiteSaaS\Dafer\Tenant\Empresa;  
 }
 $facturacion->tipo = Input::get('tipo');
 $facturacion->n_negocio = Input::get('n_negocio');
 $facturacion->e_legal = Input::get('e_legal');
 $facturacion->t_identificacion = Input::get('t_identificacion');
 $facturacion->n_identificacion = Input::get('n_identificacion');
 $facturacion->representante = Input:: get ('representante');
 $facturacion->tel_1 = Input:: get ('tel_1');
 $facturacion->tel_2 = Input:: get ('tel_2');
 $facturacion->tel_3 = Input:: get ('tel_3');
 $facturacion->email = Input:: get ('email');
 $facturacion->email_dos = Input:: get ('email_dos');
 $facturacion->direccion_1 = Input:: get ('direccion_1');
 $facturacion->direccion_2 = Input:: get ('direccion_2');
 $facturacion->ciudad = Input:: get ('ciudad');
 $facturacion->estado = Input:: get ('estado');
 $facturacion->c_postal = Input:: get ('c_postal');
 $facturacion->ciudad_2 = Input:: get ('ciudad_2');
 $facturacion->estado_2 = Input:: get ('estado_2');
 $facturacion->c_postal_2 = Input:: get ('c_postal_2');
 $facturacion->f_inicio = Input:: get ('f_inicio');
 $facturacion->s_actual = Input:: get ('s_actual');
 $facturacion->e_actual = Input:: get ('e_actual');
 $facturacion->t_cliente = Input:: get ('t_cliente');
 $facturacion->save();

  return Redirect('/dafer/empresas')->with('status', 'ok_create');
}

public function actualizarempresa($id){
 $input = Input::all();
 if(!$this->tenantName){
 $facturacion = Empresa::find($id);
 }else{
 $facturacion = \DigitalsiteSaaS\Dafer\Tenant\Empresa::find($id);
 }
 $facturacion->tipo = Input::get('tipo');
 $facturacion->n_negocio = Input::get('n_negocio');
 $facturacion->e_legal = Input::get('e_legal');
 $facturacion->t_identificacion = Input::get('t_identificacion');
 $facturacion->n_identificacion = Input::get('n_identificacion');
 $facturacion->representante = Input:: get ('representante');
 $facturacion->tel_1 = Input:: get ('tel_1');
 $facturacion->tel_2 = Input:: get ('tel_2');
 $facturacion->tel_3 = Input:: get ('tel_3');
 $facturacion->email = Input:: get ('email');
 $facturacion->email_dos = Input:: get ('email_dos');
 $facturacion->direccion_1 = Input:: get ('direccion_1');
 $facturacion->direccion_2 = Input:: get ('direccion_2');
 $facturacion->ciudad = Input:: get ('ciudad');
 $facturacion->estado = Input:: get ('estado');
 $facturacion->c_postal = Input:: get ('c_postal');
 $facturacion->ciudad_2 = Input:: get ('ciudad_2');
 $facturacion->estado_2 = Input:: get ('estado_2');
 $facturacion->c_postal_2 = Input:: get ('c_postal_2');
 $facturacion->f_inicio = Input:: get ('f_inicio');
 $facturacion->s_actual = Input:: get ('s_actual');
 $facturacion->e_actual = Input:: get ('e_actual');
 $facturacion->t_cliente = Input:: get ('t_cliente');
 $facturacion->save();

 return Redirect('/dafer/editar-empresa/'.$id)->with('status', 'ok_update');
}

 public function eliminarempresa($id){
 if(!$this->tenantName){
  $facturacion = Empresa::find($id);
 }else{
  $facturacion = \DigitalsiteSaaS\Dafer\Tenant\Empresa::find($id);    
 } 
  $facturacion->delete();
  
  return Redirect('dafer/empresas')->with('status', 'ok_delete');
        }

public function eliminarproducto($id){
 if(!$this->tenantName){
  $facturacion = Producto::find($id);
 }else{
  $facturacion = \DigitalsiteSaaS\Dafer\Tenant\Producto::find($id);    
 } 
  $facturacion->delete();
  return Redirect('dafer/productos')->with('status', 'ok_delete');
        }

  public function eliminarproductoc($id){
 if(!$this->tenantName){
  $facturacion = Infoproducto::find($id);
 }else{
  $facturacion = \DigitalsiteSaaS\Dafer\Tenant\Infoproducto::find($id);   
   $regreso = \DigitalsiteSaaS\Dafer\Tenant\Infoproducto::where('id', '=', $id)->get(); 

 } 
  $facturacion->delete();

 foreach ($regreso as $regreso) {
   $identi = $regreso->empresa_id;
 }
  return Redirect('dafer/informacion-producto/'.$identi)->with('status', 'ok_delete');
        }






  public function eliminarcuenta($id){
 if(!$this->tenantName){
  $facturacion = Cuentas::find($id);
 }else{
  $facturacion = \DigitalsiteSaaS\Dafer\Tenant\Cuentas::find($id);   
   $regreso = \DigitalsiteSaaS\Dafer\Tenant\Cuentas::where('id', '=', $id)->get(); 

 } 
  $facturacion->delete();

 foreach ($regreso as $regreso) {
   $identi = $regreso->empresa_id;
 }
  return Redirect('dafer/cuentas-asignadas/'.$identi)->with('status', 'ok_delete');
        }




  public function eliminarbanco($id){
 if(!$this->tenantName){
  $banco = Banco::find($id);
 }else{
  $banco = \DigitalsiteSaaS\Dafer\Tenant\Banco::find($id);    
 } 
  $banco->delete();
  return Redirect('dafer/bancos')->with('status', 'ok_delete');
        }



  public function eliminarsocio($id){
 if(!$this->tenantName){
  $socio = Socio::find($id);
 }else{
  $socio = \DigitalsiteSaaS\Dafer\Tenant\Socio::find($id);    
 } 
  $socio->delete();
  return Redirect('dafer/socios')->with('status', 'ok_delete');
        }


public function acceso() {
 return View('dafer::acceso.acceso');
}


public function informacion($id){
if(!$this->tenantName){
$datos = Informacion::all();
}
else{
$datos = \DigitalsiteSaaS\Dafer\Tenant\Banco::join('dafer_infobancaria','dafer_infobancaria.banco_id', '=', 'dafer_bancos.id')
         ->where('dafer_infobancaria.empresa_id', '=', $id)->get();
}

return view('dafer::bancos.informacion-bancaria')->with('datos', $datos);
     
}



public function infoproducto($id){
if(!$this->tenantName){
$datos = Producto::all();
}
else{
$datos = \DigitalsiteSaaS\Dafer\Tenant\Producto::join('dafer_infoproductos','dafer_productos.id', '=', 'dafer_infoproductos.producto_id')
         ->where('dafer_infoproductos.empresa_id', '=', $id)->get();
}

return view('dafer::productos.informacion-productos')->with('datos', $datos);
     
}


public function infocuentas($id){
if(!$this->tenantName){
$datos = Cuentas::all();
}
else{
$datos = \DigitalsiteSaaS\Dafer\Tenant\Cuentas::where('empresa_id','=', $id)->get();
}

return view('dafer::cuentas.informacion-cuentas')->with('datos', $datos);
     
}

public function crearinformacion() {
 if(!$this->tenantName){
 $banco = new informacion;
 }
 else{
 $banco = new \DigitalsiteSaaS\Dafer\Tenant\Informacion;  
 }
 $banco->banco_id = Input::get('banco');
 $banco->usuario = Input::get('usuario');
 $banco->password = Input::get('password');
 $banco->informacion = Input::get('informacion');
 $banco->empresa_id = Input::get('empresa_id');
 $banco->save();

  return Redirect('/dafer/informacion-bancaria/'.$banco->empresa_id)->with('status', 'ok_create');
}

public function crearinformacionpro() {
 if(!$this->tenantName){
 $banco = new Infoproducto;
 }
 else{
 $banco = new \DigitalsiteSaaS\Dafer\Tenant\Infoproducto;  
 }
 $banco->producto_id = Input::get('producto');
 $banco->inicio = Input::get('inicio');
 $banco->fin = Input::get('renovacion');
 $banco->empresa_id = Input::get('empresa_id');
 $banco->informacion = Input::get('informacion');
 $banco->save();

  return Redirect('/dafer/informacion-producto/'.$banco->empresa_id)->with('status', 'ok_create');
}



public function editarproductosc($id){
 $input = Input::all();
 if(!$this->tenantName){
 $producto = infoproducto::find($id);
 }else{
 $producto = \DigitalsiteSaaS\Dafer\Tenant\Infoproducto::find($id);
 }
 $producto->producto_id = Input::get('producto');
 $producto->inicio = Input::get('inicio');
 $producto->fin = Input::get('renovacion');
 $producto->empresa_id = Input::get('empresa_id');
 $producto->informacion = Input::get('informacion');
 $producto->save();

 return Redirect('dafer/informacion-producto/'.$producto->empresa_id)->with('status', 'ok_create');
}





public function bancos(){
if(!$this->tenantName){
$bancos = Banco::all();
}
else{
$bancos = \DigitalsiteSaaS\Dafer\Tenant\Banco::all();
}
return view('dafer::bancos.informacion')->with('bancos', $bancos);
     
}


public function socios(){
if(!$this->tenantName){
$socios = \DigitalsiteSaaS\Dafer\Tenant\Socio::all();
$empresas = \DigitalsiteSaaS\Dafer\Tenant\Empresa::all();
}
else{
$socios = \DigitalsiteSaaS\Dafer\Tenant\Socio::all();
$empresas = \DigitalsiteSaaS\Dafer\Tenant\Empresa::all();
}
return view('dafer::socios.socios')->with('socios', $socios)->with('empresas', $empresas);
     
}


public function sociosempresa($id){
if(!$this->tenantName){
$socios = \DigitalsiteSaaS\Dafer\Tenant\Socio::where('id','=',$id)->get();
$empresas = \DigitalsiteSaaS\Dafer\Tenant\Empresa::all();
}
else{
$socios = \DigitalsiteSaaS\Dafer\Tenant\Socio::where('id','=',$id)->get();
$empresas = \DigitalsiteSaaS\Dafer\Tenant\Empresa::all();
}
return view('dafer::socios.socios')->with('socios', $socios)->with('empresas', $empresas);
     
}


public function crearbancos(){
return view('dafer::bancos.crear-bancos');     
}


public function crearsocios(){
if(!$this->tenantName){
$empresas = Empresa::orderBy('n_negocio', 'asc')->get();
 }else{
 $empresas = \DigitalsiteSaaS\Dafer\Tenant\Empresa::orderBy('n_negocio', 'asc')->get();
 }

return view('dafer::socios.crear-socios')->with('empresas', $empresas);    
}

public function notas(){
if(!$this->tenantName){
$notas = Usuario::all();
$empresas = Empresa::all();
$usuarios = Notas::orderBy('id', 'asc')->get();
 }else{
$notas = \DigitalsiteSaaS\Dafer\Tenant\Notas::orderBy('created_at', 'asc')->get();
$usuarios =  \DigitalsiteSaaS\Usuario\Tenant\Usuario::all();
$empresas =  \DigitalsiteSaaS\Dafer\Tenant\Empresa::all();
 }

return view('dafer::notas.notas')->with('notas', $notas)->with('usuarios', $usuarios)->with('empresas', $empresas);    
}

public function notasempresa($id){
if(!$this->tenantName){
$notas = Usuario::where('empresa_id','=',$id)->get();
$empresas = Empresa::all();
$usuarios = Notas::orderBy('id', 'asc')->get();
 }else{
$notas = \DigitalsiteSaaS\Dafer\Tenant\Notas::where('empresa_id','=',$id)->orderBy('created_at', 'asc')->get(); 
$usuarios =  \DigitalsiteSaaS\Usuario\Tenant\Usuario::all();
$empresas =  \DigitalsiteSaaS\Dafer\Tenant\Empresa::all();
 }

return view('dafer::notas.notas-empresa')->with('notas', $notas)->with('usuarios', $usuarios)->with('empresas', $empresas);    
}


public function crearnotas(){
if(!$this->tenantName){
 $empresas = Empresa::orderBy('n_negocio', 'asc')->get();
 }else{
 $empresas = \DigitalsiteSaaS\Dafer\Tenant\Empresa::orderBy('n_negocio', 'asc')->get();
 }

return view('dafer::notas.crear-notas')->with('empresas', $empresas);;    
}


public function detallenota($id){
if(!$this->tenantName){
 $empresas = Empresa::orderBy('n_negocio', 'asc')->get();
 }else{
 $usuarios =  \DigitalsiteSaaS\Usuario\Tenant\Usuario::all();
 $empresas =  \DigitalsiteSaaS\Dafer\Tenant\Empresa::all();
 $notas = \DigitalsiteSaaS\Dafer\Tenant\Notas::where('id','=',$id)->get(); 
 }

return view('dafer::notas.detalle-nota')->with('empresas', $empresas)->with('notas', $notas)->with('usuarios', $usuarios);    
}


public function crearnota() {
 if(!$this->tenantName){
 $banco = new Notas;
 }
 else{
 $banco = new \DigitalsiteSaaS\Dafer\Tenant\Notas;  
 }
 $banco->nota = Input::get('notas');
 $banco->empresa_id = Input::get('empresas');
 $banco->proceso_id = Input::get('procesos');
 $banco->user_id =  Auth::user()->id;
 $banco->save();

  return Redirect('/dafer/notas')->with('status', 'ok_create');
}

public function editarsocios($id){
 $input = Input::all();
 if(!$this->tenantName){
 $socio = Socio::find($id);
 }else{
 $socio = \DigitalsiteSaaS\Dafer\Tenant\Socio::find($id);
 }
 $socio->nombres = Input::get('nombres');
 $socio->apellidos = Input::get('apellidos');
 $socio->cargo = Input::get('cargo');
 $socio->porcentaje = Input::get('porcentaje');
 $socio->empresa_id = Input::get('empresas');
 $socio->save();

 return Redirect('/dafer/socios')->with('status', 'ok_update');
}


public function infobancaria(){
if(!$this->tenantName){
$bancos = Banco::all();
}
else{
$bancos = \DigitalsiteSaaS\Dafer\Tenant\Banco::all();
}
return view('dafer::bancos.crear-infobancaria')->with('bancos', $bancos);
     
}

public function infoproductoweb(){
if(!$this->tenantName){
$productos = Producto::all();
}
else{
$productos = \DigitalsiteSaaS\Dafer\Tenant\Producto::all();
}
return view('dafer::productos.crear-infoproducto')->with('productos', $productos);
     
}

public function crearbanco() {
 if(!$this->tenantName){
 $banco = new Banco;
 }
 else{
 $banco = new \DigitalsiteSaaS\Dafer\Tenant\Banco;  
 }
 $banco->banco = Input::get('banco');
 $banco->save();

  return Redirect('/dafer/bancos')->with('status', 'ok_create');
}

public function crearsocio() {
 if(!$this->tenantName){
 $socio = new Socio;
 }
 else{
 $socio = new \DigitalsiteSaaS\Dafer\Tenant\Socio;  
 }
 $socio->nombres = Input::get('nombres');
 $socio->apellidos = Input::get('apellidos');
 $socio->cargo = Input::get('cargo');
 $socio->porcentaje = Input::get('porcentaje');
 $socio->empresa_id = Input::get('empresas');
 $socio->save();

  return Redirect('/dafer/socios')->with('status', 'ok_create');
}

public function crearcuenta() {
 if(!$this->tenantName){
 $cuenta = new Cuentas;
 }
 else{
 $cuenta = new \DigitalsiteSaaS\Dafer\Tenant\Cuentas;  
 }
 $cuenta->plataforma = Input::get('plataforma');
 $cuenta->correo = Input::get('correo');
 $cuenta->contrasena = Input::get('contrasena');
 $cuenta->empresa_id = Input::get('empresa_id');
 $cuenta->informacion = Input::get('informacion');
 $cuenta->save();

  return Redirect('/dafer/cuentas-asignadas/'.$cuenta->empresa_id)->with('status', 'ok_create');
}



public function editarcuenta($id) {
  $input = Input::all();
 if(!$this->tenantName){

 $cuenta = Cuentas::find($id);;
 }
 else{
 $cuenta = \DigitalsiteSaaS\Dafer\Tenant\Cuentas::find($id);
 }
 $cuenta->plataforma = Input::get('plataforma');
 $cuenta->correo = Input::get('correo');
 $cuenta->contrasena = Input::get('contrasena');
 $cuenta->empresa_id = Input::get('empresa_id');
 $cuenta->informacion = Input::get('informacion');
 $cuenta->save();

  return Redirect('/dafer/cuentas-asignadas/'.$cuenta->empresa_id)->with('status', 'ok_update');

}

public function editcuenta($id){
if(!$this->tenantName){
$cuentas = Cuentas::find($id);
}
else{
$cuentas = \DigitalsiteSaaS\Dafer\Tenant\Cuentas::find($id);
}
return view('dafer::cuentas.editar')->with('cuentas', $cuentas);
     
}



public function productos(){
if(!$this->tenantName){
$productos = Producto::all();
}
else{
$productos = \DigitalsiteSaaS\Dafer\Tenant\Producto::all();
}
return view('dafer::productos.productos')->with('productos', $productos);
     
}


public function cproductos(){
if(!$this->tenantName){
$datos = Informacion::all();
}
else{
$datos = \DigitalsiteSaaS\Dafer\Tenant\Informacion::join('dafer_bancos','dafer_bancos.id', '=', 'dafer_infobancaria.empresa_id')
         ->where('dafer_infobancaria.empresa_id', '=', $id)->get();
}

return view('dafer::bancos.informacion-prodcuto')->with('datos', $datos);
     
}


public function crearproducto() {
 if(!$this->tenantName){
 $producto = new Producto;
 }
 else{
 $producto = new \DigitalsiteSaaS\Dafer\Tenant\Producto;  
 }
 $producto->producto = Input::get('producto');
 $producto->save();

  return Redirect('/dafer/productos')->with('status', 'ok_create');
}

public function crearproductos(){

return view('dafer::productos.crear-producto');
     
}


public function editarproductos($id){
 $input = Input::all();
 if(!$this->tenantName){
 $producto = Producto::find($id);
 }else{
 $producto = \DigitalsiteSaaS\Dafer\Tenant\Producto::find($id);
 }
 $producto->producto = Input::get('producto');
 $producto->save();

 return Redirect('/dafer/productos')->with('status', 'ok_update');
}

public function editarbanco($id){
if(!$this->tenantName){
 $banco = Banco::find($id);
 }else{
 $banco = \DigitalsiteSaaS\Dafer\Tenant\Banco::find($id); 
 }
 return view('dafer::bancos.editar-banco')->with('banco', $banco);
}


public function editarsocio($id){
if(!$this->tenantName){
 $socio = Socio::find($id);
 $empresas = Empresa::orderBy('n_negocio', 'asc')->get();
 }else{
 $socio = \DigitalsiteSaaS\Dafer\Tenant\Socio::find($id);
 $empresas = \DigitalsiteSaaS\Dafer\Tenant\Empresa::orderBy('n_negocio', 'asc')->get(); 
 }

 return view('dafer::socios.editar-socio')->with('socio', $socio)->with('empresas', $empresas);
}

public function editarbancaria($id){
if(!$this->tenantName){
 $banco = Informacion::find($id);
 $bancos = Banco::all();
 }else{
 $banco = \DigitalsiteSaaS\Dafer\Tenant\Informacion::join('dafer_bancos','dafer_bancos.id', '=', 'dafer_infobancaria.banco_id')->where('dafer_infobancaria.id', '=', $id)->get(); 
 $bancos = \DigitalsiteSaaS\Dafer\Tenant\Banco::all();
 }

 return view('dafer::bancos.editar-informacionbancaria')->with('banco', $banco)->with('bancos', $bancos);
}

public function posteditarbancaria($id){
 $input = Input::all();
 if(!$this->tenantName){
 $banco = Informacion::find($id);
 }else{
 $banco = \DigitalsiteSaaS\Dafer\Tenant\Informacion::find($id);
 }
 $banco->banco_id = Input::get('banco');
 $banco->usuario = Input::get('usuario');
 $banco->password = Input::get('password');
 $banco->informacion = Input::get('informacion');
 $banco->empresa_id = Input::get('empresa_id');
 $banco->banco_id = Input::get('banco_id');
 $banco->save();
 return Redirect('/dafer/informacion-bancaria/'.$banco->empresa_id)->with('status', 'ok_update');
}




public function editarbancos($id){
 $input = Input::all();
 if(!$this->tenantName){
 $banco = Banco::find($id);
 }else{
 $banco = \DigitalsiteSaaS\Dafer\Tenant\Banco::find($id);
 }
 $banco->banco = Input::get('banco');
 $banco->save();

 return Redirect('/dafer/bancos')->with('status', 'ok_update');
}



public function detalle($id){
if(!$this->tenantName){
$detalle = Informacion::all();
}
else{
$detalle = \DigitalsiteSaaS\Dafer\Tenant\Empresa::join('dafer_infobancaria','dafer_infobancaria.id', '=', 'dafer_infobancaria.empresa_id')->where('clientes.id', '=', $id)->get();

}
return view('dafer::bancos.informacion-bancaria')->with('datos', $datos);
     
}


public function pagos($id){

if(!$this->tenantName){
 $pagosw = Pagos::find($id);
 }else{
 $pagosw = \DigitalsiteSaaS\Dafer\Tenant\Pagos::join('dafer_empresas','dafer_empresas.id', '=', 'dafer_pagos.empresa_id')->join('dafer_infobancaria','dafer_infobancaria.id', '=', 'dafer_infobancaria.empresa_id')->where('dafer_empresas.id','=',$id)->select('dafer_pagos.id','n_negocio','dafer_pagos.empresa_id','fecha_pago','pago_mensual','banco_id','usuario','password')->orderBy('fecha_pago', 'ASC')->get();

}

$bancos = \DigitalsiteSaaS\Dafer\Tenant\Banco::all();

return view('dafer::pagos.pagos')->with('pagosw', $pagosw)->with('bancos', $bancos);
}

public function crearpagos() {
 if(!$this->tenantName){
 $pagos = new Pagos;
 }
 else{
 $pagos = new \DigitalsiteSaaS\Dafer\Tenant\Pagos;  
 }
 $pagos->fecha_pago = Input::get('fecha');
 $pagos->pago_mensual = Input::get('valor');
 $pagos->notas = Input::get('notas');
 $pagos->empresa_id = Input::get('empresa_id');
 $pagos->user_id = Auth::user()->id;
 $pagos->save();

  return Redirect('/dafer/pagos/'.$pagos->empresa_id)->with('status', 'ok_create');
}

public function eliminarpagos($id){

 if(!$this->tenantName){
  $pagos = Pagos::find($id);
 }else{
  $pagos = \DigitalsiteSaaS\Dafer\Tenant\Pagos::find($id); 
  $delete =   \DigitalsiteSaaS\Dafer\Tenant\Pagos::where('id','=',$id)->get();
  foreach($delete as $delete){
    $eliminar = $delete->empresa_id;
  }
 } 
 
  $pagos->delete();
   return Redirect('dafer/pagos/'.$eliminar)->with('status', 'ok_delete');
}


public function editarpagos($id){
  if(!$this->tenantName){
  $pagos = Pagos::find($id);
  }else{
  $pagos = \DigitalsiteSaaS\Dafer\Tenant\Pagos::find($id); 
  }
  return view('dafer::pagos.editar-pago')->with('pagos', $pagos);
 }


 public function editarpago($id){
 $input = Input::all();
 if(!$this->tenantName){
 $pagos = Pagos::find($id);
 }else{
 $pagos = \DigitalsiteSaaS\Dafer\Tenant\Pagos::find($id);
 }
 $pagos->fecha_pago = Input::get('fecha');
 $pagos->pago_mensual = Input::get('valor');
 $pagos->empresa_id = Input::get('empresa_id');
 $pagos->notas = Input::get('notas');
 $pagos->save();
 return Redirect('/dafer/pagos/'.$pagos->empresa_id)->with('status', 'ok_update');
}





public function special(Request $request){

  $query = $request->input('query');

   if(!$this->tenantName){
 $empresas = Empresa::all();
 }else{
 $user = \DigitalsiteSaaS\Usuario\Tenant\Usuario::all();
 $empresas = \DigitalsiteSaaS\Facturacion\Tenant\Empresa::where('r_social','LIKE',"%{$query}%")->get();
 }

  return view('dresses::special')->with('empresas', $empresas)->with('user', $user);
 }


public function search(Request $request){
       $query = $request->get('query');
        $products = \DigitalsiteSaaS\Dresses\Tenant\Producto::where('nombre', 'LIKE', "%{$query}%")->get();

        return response()->json($products);

       
    }


    public function client(Request $request){
       $query = $request->get('query');
        $products = \DigitalsiteSaaS\Dresses\Tenant\Cliente::where('nombre', 'LIKE', "%{$query}%")->get();

        return response()->json($products);

       
    }



     public function store(Request $request)
    {


        // Crear la venta
        $venta = \DigitalsiteSaaS\Dresses\Tenant\Venta::create([
            'cliente_id' => $request->cliente_id,
            'fecha_compra' => $request->fecha_compra,
            'observaciones' => $request->observaciones,
            'subtotal' => $request->subtotal,
            'impuesto_total' => $request->impuesto_total,
            'total' => $request->total,
            'adelanto' => $request->adelanto,
            'monto_adeudado' => $request->monto_adeudado,
        ]);

        // Guardar los productos asociados a la venta
        foreach ($request->productos as $producto) {
            \DigitalsiteSaaS\Dresses\Tenant\Producto::create([
                'venta_id' => $venta->id,
                'nombre' => $producto['nombre'],
                'precio' => $producto['precio'],
                'cantidad' => $producto['cantidad'],
                'talla' => $producto['talla'],
                'color' => $producto['color'],
                'descuento' => $producto['descuento'],
                'impuesto' => $producto['impuesto'],
            ]);
        }

        return response()->json(['message' => 'Venta guardada correctamente'], 201);
    }




}