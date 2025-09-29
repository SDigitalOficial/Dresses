<?php

namespace DigitalsiteSaaS\Dresses\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Repositories\HostnameRepository;
use Hyn\Tenancy\Repositories\WebsiteRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Input;

class OrdenController extends Controller
{
 
 protected $tenantName = null;

public function __construct(){
 $this->middleware('auth');
  $hostname = app(\Hyn\Tenancy\Environment::class)->hostname();
  if ($hostname){
  $fqdn = $hostname->fqdn;
  $this->tenantName = explode(".", $fqdn)[0];
 }
}

public function bulkFicha(Request $request)
{
    $data = $request->validate([
        'products' => ['required', 'array', 'min:1', 'max:4'],
    ]);

    $products = \DigitalsiteSaaS\Dresses\Tenant\Producto::whereIn('id', $data['products'])
    ->with([
        'orders' => function ($query) {
            $query->select('ordens.id', 'ordens.cliente_id', 'ordens.fecha_compra');
        },
        'orders.cliente' => function ($query) {
            $query->select('dresses_clientes.id', 'dresses_clientes.nombres', 'dresses_clientes.apellidos', 'dresses_clientes.telefono');
        }
    ])
    ->get();

    // Obtener el número de orden del primer producto (asumiendo que todos pertenecen a la misma orden)
    $orderNumber = $products->isNotEmpty() && $products[0]->orders->isNotEmpty() 
        ? $products[0]->orders[0]->id 
        : 'sin-orden';

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.fichas-productos', compact('products'))
        ->setPaper('a4', 'portrait');
        
    // Nombre del archivo con el número de orden
    $filename = 'pick-list-order' . $orderNumber . '.pdf';

    return $pdf->download($filename);
}



  public function store(Request $request)
    {
        $urlPath = $request->input('url_path');
        // Validar los datos
        $request->validate([
            'cliente_id' => 'nullable', // Asegurar que el cliente_id exista en la tabla clientes
            'fecha_compra' => 'required|date',
            'observaciones' => 'nullable|string',
            'vendedor' => 'nullable|string',
            'productos' => 'required|array',
            'subtotal' => 'required|numeric',
            'impuesto_total' => 'required|numeric',
            'total' => 'required|numeric',
            'adelanto' => 'required|numeric',
            'monto_adeudado' => 'required|numeric',
            'prefijo' => 'string',
            'status' => 'string',
        ]);

        

        if ($urlPath === 'dresses/specialorders') {
        $identidad = 'SO';
        } elseif ($urlPath === 'dresses/layaway') {
          $identidad = 'L';
        }

        // Crear la orden
         $ultimaOrden = \DigitalsiteSaaS\Dresses\Tenant\Orden::where('identidad', $identidad)
        ->orderByDesc('id')
        ->first();

         $prefijo = $ultimaOrden ? $ultimaOrden->prefijo : 0;
         $prefijoIncrementado = $prefijo + 1;
        
        $orden = \DigitalsiteSaaS\Dresses\Tenant\Orden::create([
            'cliente_id' => $request->cliente_id, // Guardar el cliente_id
            'fecha_compra' => $request->fecha_compra,
            'vendedor' => $request->vendedor,
            'observaciones' => $request->observaciones,
            'subtotal' => $request->subtotal,
            'impuesto_total' => $request->impuesto_total,
            'total' => $request->total,
            'adelanto' => $request->adelanto,
            'prefijo' => $prefijoIncrementado,
            'identidad'      => $identidad,
            'monto_adeudado' => $request->monto_adeudado,
            'status' => $request->paymentStatus,
        ]);

        // Guardar los productos de la orden
        foreach ($request->productos as $producto) {
            if (empty($producto['id'])) {
                $orden->productos()->attach($producto['id'], [
                    'cantidad' => $producto['quantity'],
                    'talla' => $producto['size'],
                    'color' => $producto['color'],
                    'descuento' => $producto['discount'],
                    'impuesto' => $producto['tax'],
                    'precio_unitario' => $producto['price'],
                    'total' => $producto['total'],
                ]);
            } else {
                $nuevoProducto = \DigitalsiteSaaS\Dresses\Tenant\Producto::create([
                    'nombre' => $producto['name'],
                    'precio' => $producto['price'],
                    'talla' => $producto['size'],
                    'color' => $producto['color'],
                ]);

                $orden->productos()->attach($nuevoProducto->id, [
                    'cantidad' => $producto['quantity'],
                    'talla' => $producto['size'],
                    'color' => $producto['color'],
                    'descuento' => $producto['discount'],
                    'impuesto' => $producto['tax'],
                    'precio_unitario' => $producto['price'],
                    'total' => $producto['total'],
                ]);
            }
        }

        return response()->json(['message' => 'Orden guardada correctamente'], 201);
    }



      public function verordenes($id){

    if(!$this->tenantName){
     $facturacion = Orden_Detalle::all();
    }else{
     $facturacion = \DigitalsiteSaaS\Dresses\Tenant\Orden_Detalle::where('orden_id','=', $id)->get();
    }

    return view('dresses::empresas.negocios')->with('facturacion', $facturacion);
    }


 

    public function verordenestotal(){

    if(!$this->tenantName){
     $facturacion = Orden::all();
     $users = Usuario::all();
    }else{
     $facturacion = \DigitalsiteSaaS\Dresses\Tenant\Orden::orderBy('created_at', 'desc')->get();
     $users = \DigitalsiteSaaS\Usuario\Tenant\Usuario::all();
     $cliente = \DigitalsiteSaaS\Dresses\Tenant\Cliente::all();
    }
    return view('dresses::ordenes.ordenes')->with('facturacion', $facturacion)->with('users', $users)->with('cliente', $cliente);
    }


     public function vertaxes(){

    if(!$this->tenantName){
     $impuestos = Impuesto::all(); 
    }else{
     $impuestos = \DigitalsiteSaaS\Dresses\Tenant\Impuesto::all();
    }
    return view('dresses::impuestos.index')->with('impuestos', $impuestos);
    }


public function edit($id)
    {
        $orden = \DigitalsiteSaaS\Dresses\Tenant\Orden::with(['productos', 'cliente'])->findOrFail($id);
        $tienda =  \DigitalsiteSaaS\Dresses\Tenant\Tienda::all();
        $vendedores =  \DigitalsiteSaaS\Usuario\Tenant\Usuario::all();
        $impuestos = \DigitalsiteSaaS\Dresses\Tenant\Impuesto::all();

        
        return view('dresses::editspecial', compact('orden', 'tienda', 'vendedores', 'impuestos'));
    }

    /**
     * Actualiza la orden en la base de datos.
     */
   public function update(Request $request, $id)
{
    // Validación mejorada
    $validated = $request->validate([
        'cliente_id' => 'required',
        'fecha_compra' => 'required|date',
        'vendedor' => 'required',
        'observaciones' => 'nullable|string|max:500',
        'productos' => 'required|array|min:1',
        'productos.*.name' => 'required|string|max:255',
        'productos.*.price' => 'required|numeric|min:0',
        'productos.*.quantity' => 'required|integer|min:1',
        'subtotal' => 'required|numeric|min:0',
        'impuesto_total' => 'required|numeric|min:0',
        'total' => 'required|numeric|min:0',
        'adelanto' => 'required|numeric|min:0',
        'adelanto1' => 'required|numeric|min:0',
        'adelanto2' => 'required|numeric|min:0',
        'adelanto3' => 'required|numeric|min:0',
        'date1' => 'string',
        'date2' => 'string',
        'date3' => 'string',
        'user1' => 'string',
        'user2' => 'string',
        'user3' => 'string',
        'method' => 'string',
        'method1' => 'string',
        'method2' => 'string',
        'method3' => 'string',
        'status' => 'string',
        'monto_adeudado' => 'required|numeric|min:0'
    ]);

    try {
        $orden = \DigitalsiteSaaS\Dresses\Tenant\Orden::findOrFail($id);
        
        // Actualizar datos principales
        $orden->update([
            'cliente_id' => $validated['cliente_id'],
            'fecha_compra' => $validated['fecha_compra'],
            'vendedor' => $validated['vendedor'],
            'observaciones' => $validated['observaciones'],
            'subtotal' => $validated['subtotal'],
            'impuesto_total' => $validated['impuesto_total'],
            'total' => $validated['total'],
            'adelanto' => $validated['adelanto'],
            'adelanto1' => $validated['adelanto1'],
            'adelanto2' => $validated['adelanto2'],
            'adelanto3' => $validated['adelanto3'],
            'user1' => $validated['user1'],
            'user2' => $validated['user2'],
            'user3' => $validated['user3'],
            'date1' => $validated['date1'],
            'date2' => $validated['date2'],
            'date3' => $validated['date3'],
            'method' => $validated['method'],
            'method1' => $validated['method1'],
            'method2' => $validated['method2'],
            'method3' => $validated['method3'],
            'status' => $validated['status'],
            'monto_adeudado' => $validated['monto_adeudado']
        ]);

        // Sincronizar productos
        $productosSync = [];
        foreach ($validated['productos'] as $producto) {
            $productoId = $producto['id'] ?? null;
            
            if ($productoId) {
                // Actualizar producto existente
                $productosSync[$productoId] = [
                    'cantidad' => $producto['quantity'],
                    'talla' => $producto['size'],
                    'color' => $producto['color'],
                    'descuento' => $producto['discount'],
                    'impuesto' => $producto['tax'],
                    'precio_unitario' => $producto['price'],
                    'total' => $producto['total']
                ];
            } else {
                // Crear nuevo producto
                $nuevoProducto = Producto::create([
                    'nombre' => $producto['name'],
                    'precio' => $producto['price'],
                    'talla' => $producto['size'],
                    'color' => $producto['color']
                ]);
                
                $productosSync[$nuevoProducto->id] = [
                    'cantidad' => $producto['quantity'],
                    'talla' => $producto['size'],
                    'color' => $producto['color'],
                    'descuento' => $producto['discount'],
                    'impuesto' => $producto['tax'],
                    'precio_unitario' => $producto['price'],
                    'total' => $producto['total']
                ];
            }
        }

        $orden->productos()->sync($productosSync);

        return response()->json([
            'message' => 'Orden actualizada correctamente',
            'orden_id' => $orden->id
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Error al actualizar la orden',
            'error' => $e->getMessage()
        ], 500);
    }
}

    /**
     * Muestra una orden específica.
     */
  
     public function show($id)
    {

        if(!$this->tenantName){
        $orden = Orden::with(['productos', 'cliente'])->findOrFail($id);
        }else{
         $orden = \DigitalsiteSaaS\Dresses\Tenant\Orden::with(['productos', 'cliente'])->findOrFail($id); 
        }
        return view('dresses::ordenes.show', compact('orden'));
    }



   public function ordendelete($id) {
    if(!$this->tenantName){
     $orden = Orden::find($id);
    }else{
     $orden = \DigitalsiteSaaS\Dresses\Tenant\Orden::find($id);
    }
     $orden->delete();
     return Redirect('dresses/ver-ordenes')->with('status', 'ok_delete');
    }

public function productdelete($id) {
    if(!$this->tenantName){
     $producto = Producto::find($id);
    }else{
     $producto = \DigitalsiteSaaS\Dresses\Tenant\Producto::find($id);
    }
     $producto->delete();
     return Redirect('dresses/factura/crear-producto')->with('status', 'ok_delete');
    }

public function impuestodelete($id) {
    if(!$this->tenantName){
     $producto = Impuesto::find($id);
    }else{
     $producto = \DigitalsiteSaaS\Dresses\Tenant\Impuesto::find($id);
    }
     $producto->delete();
     return Redirect('/dresses/ver-taxes')->with('status', 'ok_delete');
    }


    public function negociodelete($id) {
    if(!$this->tenantName){
     $producto = Tienda::find($id);
    }else{
     $producto = \DigitalsiteSaaS\Dresses\Tenant\Tienda::find($id);
    }
     $producto->delete();
     return Redirect('/dresses/factura/negocios')->with('status', 'ok_delete');
    }

  public function impuestos()
    {
        $impuestos = \DigitalsiteSaaS\Dresses\Tenant\Impuesto::all();
        return view('dresses::impuestos.index', compact('impuestos'));
    }


    public function creartaxes()
    {
        return view('dresses::impuestos.crear');
    }


public function createimpuesto() {

 if(!$this->tenantName){
 $facturacion = new Impuesto;
 }else{
 $facturacion = new \DigitalsiteSaaS\Dresses\Tenant\Impuesto;  
 }
 $facturacion->ciudad =  Input::get('ciudad');
 $facturacion->sufijo = Input::get('sufijo');
 $facturacion->valor = Input::get('porcentaje');
 $facturacion->save();
 return Redirect('/dresses/ver-taxes')->with('status', 'ok_create');
}

   


public function generatePDF($id, $download = false)
{
    $orden = \DigitalsiteSaaS\Dresses\Tenant\Orden::with(['cliente', 'productos', 'vendedor'])->findOrFail($id);
    $tienda = \DigitalsiteSaaS\Dresses\Tenant\Tienda::find(1);
    $totalAdvances = $orden->adelanto + $orden->adelanto1 + $orden->adelanto2 + $orden->adelanto3;
    
    $pdf = PDF::loadView('dresses::ordenes.pdf', compact('orden', 'totalAdvances', 'tienda'));
    $pdf->setOption('jpegQuality', 100); // Máxima calidad
    
    if($download) {
        return $pdf->download('orden_'.$orden->id.'.pdf');
    }
    
    return $pdf->stream('orden_'.$orden->id.'.pdf'); // Muestra en el navegador
}





}
