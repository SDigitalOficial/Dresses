<?php

namespace DigitalsiteSaaS\Dresses\Http;

use Illuminate\Http\Request;
use DigitalsiteSaaS\Dresses\Tenant\Cliente;
use App\Http\Controllers\Controller;

class ClienteController extends Controller
{
    /**
     * Actualizar el cliente especificado
     */
    public function update(Request $request, $id)
    {
        // Validar los datos
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'telefono' => 'nullable|string|max:20',
            'telefono2' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'direccion' => 'nullable|string|max:500',
            'ciudad' => 'nullable|string|max:100',
            'tienda' => 'nullable|integer',
            'tipo_evento' => 'nullable|string|max:100',
            'fecha_evento' => 'nullable|date',
        ]);
        
        try {
            // Buscar el cliente - usando el modelo de tu namespace
            $cliente = Cliente::findOrFail($id);
            
            // Actualizar los datos
            $cliente->update([
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'telefono' => $request->telefono,
                'telefono2' => $request->telefono2,
                'email' => $request->email,
                'direccion' => $request->direccion,
                'ciudad' => $request->ciudad,
                'tienda' => $request->tienda,
                'tipo_evento' => $request->tipo_evento,
                'fecha_evento' => $request->fecha_evento,
            ]);
            
            // Retornar respuesta JSON
            return response()->json([
                'success' => true,
                'message' => 'Cliente actualizado correctamente',
                'cliente' => $cliente
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar el cliente: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function store(Request $request)
    {
        // Validar los datos
        $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clientes,email',
            'telefono' => 'nullable|string|max:20',
            'telefono2' => 'nullable|string|max:20',
            'ciudad' => 'nullable|string|max:100',
            'direccion' => 'nullable|string|max:255',
            'tienda' => 'nullable|string|max:100',
            'tipo_evento' => 'nullable|string|max:100',
            'fecha_evento' => 'nullable|date',
        ]);

        // Crear el cliente - usando el modelo de tu namespace
        $cliente = Cliente::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'telefono' => $request->telefono,
            'telefono2' => $request->telefono2,
            'email' => $request->email,
            'ciudad' => $request->ciudad,
            'direccion' => $request->direccion,
            'tienda' => $request->tienda,
            'tipo_evento' => $request->tipo_evento,
            'fecha_evento' => $request->fecha_evento,
        ]);

        // Devolver una respuesta JSON con el cliente creado
        return response()->json($cliente, 201);
    }
}