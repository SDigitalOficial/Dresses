<?php

namespace DigitalsiteSaaS\Dresses\Http;

use Illuminate\Http\Request;

class VentaController extends Controller
{
     public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha_compra' => 'required|date',
            'observaciones' => 'nullable|string',
            'productos' => 'required|array',
            'subtotal' => 'required|numeric',
            'impuesto_total' => 'required|numeric',
            'total' => 'required|numeric',
            'adelanto' => 'required|numeric',
            'monto_adeudado' => 'required|numeric',
        ]);

        // Crear la venta
        $venta =  \DigitalsiteSaaS\Dresses\Tenant\Venta::create([
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
