<?php

namespace DigitalsiteSaaS\Dresses\Http;

use Illuminate\Http\Request;
use App\Cliente;

use App\Http\Controllers\Controller;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Repositories\HostnameRepository;
use Hyn\Tenancy\Repositories\WebsiteRepository;




class ClienteController extends Controller
{
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

        // Crear el cliente
        $cliente = \DigitalsiteSaaS\Dresses\Tenant\Cliente::create([
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