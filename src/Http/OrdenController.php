<?php

namespace DigitalsiteSaaS\Dresses\Http;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Repositories\HostnameRepository;
use Hyn\Tenancy\Repositories\WebsiteRepository;

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

  public function store(Request $request)
    {
  
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
        ]);

        // Crear la orden
        $orden = \DigitalsiteSaaS\Dresses\Tenant\Orden::create([
            'cliente_id' => $request->cliente_id, // Guardar el cliente_id
            'fecha_compra' => $request->fecha_compra,
            'vendedor' => $request->vendedor,
            'observaciones' => $request->observaciones,
            'subtotal' => $request->subtotal,
            'impuesto_total' => $request->impuesto_total,
            'total' => $request->total,
            'adelanto' => $request->adelanto,
            'monto_adeudado' => $request->monto_adeudado,
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

    dd($facturacion);
    return view('dresses::empresas.negocios')->with('facturacion', $facturacion);
    }

    public function verordenestotal(){

    if(!$this->tenantName){
     $facturacion = Orden::all();
     $users = Usuario::all();
    }else{
     $facturacion = \DigitalsiteSaaS\Dresses\Tenant\Orden::all();
     $users = \DigitalsiteSaaS\Usuario\Tenant\Usuario::all();
     $cliente = \DigitalsiteSaaS\Dresses\Tenant\Cliente::all();
    }
    return view('dresses::ordenes.ordenes')->with('facturacion', $facturacion)->with('users', $users)->with('cliente', $cliente);
    }
}
