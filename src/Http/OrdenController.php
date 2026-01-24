<?php

namespace DigitalsiteSaaS\Dresses\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Repositories\HostnameRepository;
use Hyn\Tenancy\Repositories\WebsiteRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use DigitalsiteSaaS\Dresses\Tenant\Producto;
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
        'products' => ['required', 'array', 'min:1', 'max:20'],
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

public function print($id)
{
    $orden = \DigitalsiteSaaS\Dresses\Tenant\Orden::with(['cliente', 'productos', 'vendedor'])->findOrFail($id);
    $tienda = \DigitalsiteSaaS\Dresses\Tenant\Tienda::find(1);
    $totalAdvances = $orden->adelanto + $orden->adelanto1 + $orden->adelanto2 + $orden->adelanto3;
    
    $pdf = PDF::loadView('dresses::ordenes.pdf', compact('orden', 'totalAdvances', 'tienda'));
    $pdf->setOption('jpegQuality', 100);
    $pdf->setOption('javascript-delay', 2000); // Esperar que se ejecute el JavaScript
    
    return $pdf->stream('orden_'.$orden->id.'.pdf');
}


  public function store(Request $request)
    {
        $urlPath = $request->input('url_path');
        // Validar los datos
        $request->validate([
            'cliente_id' => 'nullable', // Asegurar que el cliente_id exista en la tabla clientes
            'fecha_compra' => 'required|date',
            'fecha_compraO' => 'required|date',
            'pickDate' => 'date',
            'returnDate' => 'date',
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
        } elseif ($urlPath === 'dresses/rentals') {
          $identidad = 'RENTAL';
        }

        

        // Obtener el último prefijo numérico para ESTA identidad específica
$ultimaOrden = \DigitalsiteSaaS\Dresses\Tenant\Orden::where('identidad', $identidad)
    ->orderByRaw('CAST(prefijo AS UNSIGNED) DESC')
    ->first();

if (!$ultimaOrden || !$ultimaOrden->prefijo) {
    $prefijo = '0001';
} else {
    // Convertir el prefijo actual a número (solo los dígitos)
    // Esto maneja casos como "0001", "0254", etc.
    $numeroActual = (int) $ultimaOrden->prefijo;
    $nuevoNumero = $numeroActual + 1;
    
    // Determinar cuántos ceros necesitamos
    if ($identidad === 'RENTAL') {
        // Para RENTAL, mantener 4 dígitos
        $prefijo = str_pad($nuevoNumero, 4, '0', STR_PAD_LEFT);
    } else {
        // Para SO y L, no forzar ceros a la izquierda o mantener según necesidad
        $prefijo = (string) $nuevoNumero;
    }
}
        
        $orden = \DigitalsiteSaaS\Dresses\Tenant\Orden::create([
            'cliente_id' => $request->cliente_id, // Guardar el cliente_id
            'fecha_compra' => $request->fecha_compra,
            'fecha_compraO' => $request->fecha_compraO,
            'pickDate' => $request->pickDate,
            'returnDate' => $request->returnDate,
            'vendedor' => $request->vendedor,
            'observaciones' => $request->observaciones,
            'subtotal' => $request->subtotal,
            'impuesto_total' => $request->impuesto_total,
            'total' => $request->total,
            'adelanto' => $request->adelanto,
            'prefijo' => $prefijo,
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

       return response()->json([
    'id' => $orden->id,
    'message' => 'Orden guardada correctamente'
], 201);
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
        $cliente = $orden->cliente; // 👈 aquí se define
        
        return view('dresses::editspecial', compact('orden', 'tienda', 'vendedores', 'impuestos', 'cliente'));
    }

    /**
     * Actualiza la orden en la base de datos.
     */
   public function update(Request $request, $id)
{
    // Validación mejorada con campos opcionales
    $validated = $request->validate([
        'cliente_id' => 'required',
        'fecha_compra' => 'required|date',
        'fecha_compraO' => 'required|date',
        'pickDate' => 'date',
        'returnDate' => 'date',
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
        'adelanto1' => 'nullable|numeric|min:0', // Cambiado a nullable
        'adelanto2' => 'nullable|numeric|min:0', // Cambiado a nullable
        'adelanto3' => 'nullable|numeric|min:0', // Cambiado a nullable
        'date1' => 'nullable|string',
        'date2' => 'nullable|string',
        'date3' => 'nullable|string',
        'user1' => 'nullable|string',
        'user2' => 'nullable|string',
        'user3' => 'nullable|string',
        'method' => 'nullable|string',
        'method1' => 'nullable|string',
        'method2' => 'nullable|string',
        'method3' => 'nullable|string',
        'status' => 'nullable|string',
        'monto_adeudado' => 'required|numeric|min:0'
    ]);

    try {
        $orden = \DigitalsiteSaaS\Dresses\Tenant\Orden::findOrFail($id);
        
        // Actualizar datos principales con valores por defecto para campos nullable
        $orden->update([
            'cliente_id' => $validated['cliente_id'],
            'fecha_compra' => $validated['fecha_compra'],
            'fecha_compraO' => $validated['fecha_compraO'],
            'vendedor' => $validated['vendedor'],
            'observaciones' => $validated['observaciones'],
            'subtotal' => $validated['subtotal'],
            'impuesto_total' => $validated['impuesto_total'],
            'total' => $validated['total'],
            'adelanto' => $validated['adelanto'],
            'adelanto1' => $validated['adelanto1'] ?? 0,
            'adelanto2' => $validated['adelanto2'] ?? 0,
            'adelanto3' => $validated['adelanto3'] ?? 0,
            'user1' => $validated['user1'] ?? null,
            'user2' => $validated['user2'] ?? null,
            'user3' => $validated['user3'] ?? null,
            'date1' => $validated['date1'] ?? null,
            'date2' => $validated['date2'] ?? null,
            'date3' => $validated['date3'] ?? null,
            'method' => $validated['method'] ?? 'cash',
            'method1' => $validated['method1'] ?? 'cash',
            'method2' => $validated['method2'] ?? 'cash',
            'method3' => $validated['method3'] ?? 'cash',
            'status' => $validated['status'] ?? 'open',
            'monto_adeudado' => $validated['monto_adeudado']
        ]);

        // Sincronizar productos - LÓGICA CORREGIDA
        $productosSync = [];
        
        foreach ($validated['productos'] as $producto) {
            $productoId = $producto['id'] ?? null;
            
            // Si el ID es numérico y mayor que 1000, es un ID real de la base de datos
            // Si es null o un número temporal grande, es un producto manual
            if ($productoId && $productoId < 1000000) { // ID real de base de datos
                $productosSync[$productoId] = [
                    'cantidad' => $producto['quantity'],
                    'talla' => $producto['size'] ?? '',
                    'color' => $producto['color'] ?? '',
                    'descuento' => $producto['discount'] ?? 0,
                    'impuesto' => $producto['tax'] ?? 0,
                    'precio_unitario' => $producto['price'],
                    'total' => $producto['total'] ?? $producto['price'] * $producto['quantity']
                ];
            } else {
                // Crear nuevo producto manual
                $nuevoProducto = Producto::create([
                    'nombre' => $producto['name'],
                    'precio' => $producto['price'],
                    'talla' => $producto['size'] ?? '',
                    'color' => $producto['color'] ?? '',
                    'es_manual' => true // Si tienes este campo
                ]);
                
                $productosSync[$nuevoProducto->id] = [
                    'cantidad' => $producto['quantity'],
                    'talla' => $producto['size'] ?? '',
                    'color' => $producto['color'] ?? '',
                    'descuento' => $producto['discount'] ?? 0,
                    'impuesto' => $producto['tax'] ?? 0,
                    'precio_unitario' => $producto['price'],
                    'total' => $producto['total'] ?? $producto['price'] * $producto['quantity']
                ];
            }
        }

        $orden->productos()->sync($productosSync);

        return response()->json([
            'message' => 'Orden actualizada correctamente',
            'orden_id' => $orden->id,
            'id' => $orden->id // Añade esto para que coincida con lo que espera el frontend
        ], 200);

    } catch (\Exception $e) {
        \Log::error('Error updating order: ' . $e->getMessage());
        \Log::error('Request data: ', $request->all());
        
        return response()->json([
            'message' => 'Error al actualizar la orden',
            'error' => $e->getMessage()
        ], 500);
    }
}



public function updatea(Request $request, $id)
{
    // Validación mejorada con campos opcionales
    $validated = $request->validate([
        'cliente_id' => 'required',
        'fecha_compra' => 'required|date',
        'fecha_compraO' => 'required|date',
        'pickDate' => 'date',
        'returnDate' => 'date',
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
        'adelanto1' => 'nullable|numeric|min:0', // Cambiado a nullable
        'adelanto2' => 'nullable|numeric|min:0', // Cambiado a nullable
        'adelanto3' => 'nullable|numeric|min:0', // Cambiado a nullable
        'date1' => 'nullable|string',
        'date2' => 'nullable|string',
        'date3' => 'nullable|string',
        'user1' => 'nullable|string',
        'user2' => 'nullable|string',
        'user3' => 'nullable|string',
        'method' => 'nullable|string',
        'method1' => 'nullable|string',
        'method2' => 'nullable|string',
        'method3' => 'nullable|string',
        'status' => 'nullable|string',
        'monto_adeudado' => 'required|numeric|min:0'
    ]);

    try {
        $orden = \DigitalsiteSaaS\Dresses\Tenant\Orden::findOrFail($id);
        
        // Actualizar datos principales con valores por defecto para campos nullable
        $orden->update([
            'cliente_id' => $validated['cliente_id'],
            'fecha_compra' => $validated['fecha_compra'],
            'fecha_compraO' => $validated['fecha_compraO'],
            'pickDate' => $validated['pickDate'],
            'returnDate' => $validated['returnDate'],
            'vendedor' => $validated['vendedor'],
            'observaciones' => $validated['observaciones'],
            'subtotal' => $validated['subtotal'],
            'impuesto_total' => $validated['impuesto_total'],
            'total' => $validated['total'],
            'adelanto' => $validated['adelanto'],
            'adelanto1' => $validated['adelanto1'] ?? 0,
            'adelanto2' => $validated['adelanto2'] ?? 0,
            'adelanto3' => $validated['adelanto3'] ?? 0,
            'user1' => $validated['user1'] ?? null,
            'user2' => $validated['user2'] ?? null,
            'user3' => $validated['user3'] ?? null,
            'date1' => $validated['date1'] ?? null,
            'date2' => $validated['date2'] ?? null,
            'date3' => $validated['date3'] ?? null,
            'method' => $validated['method'] ?? 'cash',
            'method1' => $validated['method1'] ?? 'cash',
            'method2' => $validated['method2'] ?? 'cash',
            'method3' => $validated['method3'] ?? 'cash',
            'status' => $validated['status'] ?? 'open',
            'monto_adeudado' => $validated['monto_adeudado']
        ]);

        // Sincronizar productos - LÓGICA CORREGIDA
        $productosSync = [];
        
        foreach ($validated['productos'] as $producto) {
            $productoId = $producto['id'] ?? null;
            
            // Si el ID es numérico y mayor que 1000, es un ID real de la base de datos
            // Si es null o un número temporal grande, es un producto manual
            if ($productoId && $productoId < 1000000) { // ID real de base de datos
                $productosSync[$productoId] = [
                    'cantidad' => $producto['quantity'],
                    'talla' => $producto['size'] ?? '',
                    'color' => $producto['color'] ?? '',
                    'descuento' => $producto['discount'] ?? 0,
                    'impuesto' => $producto['tax'] ?? 0,
                    'precio_unitario' => $producto['price'],
                    'total' => $producto['total'] ?? $producto['price'] * $producto['quantity']
                ];
            } else {
                // Crear nuevo producto manual
                $nuevoProducto = Producto::create([
                    'nombre' => $producto['name'],
                    'precio' => $producto['price'],
                    'talla' => $producto['size'] ?? '',
                    'color' => $producto['color'] ?? '',
                    'es_manual' => true // Si tienes este campo
                ]);
                
                $productosSync[$nuevoProducto->id] = [
                    'cantidad' => $producto['quantity'],
                    'talla' => $producto['size'] ?? '',
                    'color' => $producto['color'] ?? '',
                    'descuento' => $producto['discount'] ?? 0,
                    'impuesto' => $producto['tax'] ?? 0,
                    'precio_unitario' => $producto['price'],
                    'total' => $producto['total'] ?? $producto['price'] * $producto['quantity']
                ];
            }
        }

        $orden->productos()->sync($productosSync);

        return response()->json([
            'message' => 'Orden actualizada correctamente',
            'orden_id' => $orden->id,
            'id' => $orden->id // Añade esto para que coincida con lo que espera el frontend
        ], 200);

    } catch (\Exception $e) {
        \Log::error('Error updating order: ' . $e->getMessage());
        \Log::error('Request data: ', $request->all());
        
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
    $orden = \DigitalsiteSaaS\Dresses\Tenant\Orden::with(['cliente', 'productos', 'vendedorRelacion'])->findOrFail($id);
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
