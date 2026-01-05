<?php

namespace DigitalsiteSaaS\Dresses\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
  use UsesTenantConnection;
    protected $table = 'ordens';
    
    protected $fillable = [
        'cliente_id',
        'fecha_compra',
        'fecha_compraO',
        'vendedor',
        'identidad',
        'observaciones',
        'subtotal',
        'impuesto_total',
        'total',
        'adelanto',
        'adelanto1',
        'adelanto2',
        'adelanto3',
        'user1',
        'user2',
        'user3',
        'date1',
        'date2',
        'date3',
        'method',
        'method1',
        'method2',
        'method3',
        'status',
        'prefijo',
        'monto_adeudado',

    ];

    protected $dates = ['fecha_compra','fecha_compraO'];

    // Relación con cliente
    public function cliente()
    {
        return $this->belongsTo(\DigitalsiteSaaS\Dresses\Tenant\Cliente::class, 'cliente_id');
    }

    public function vendedor()
{
    return $this->belongsTo(\DigitalsiteSaaS\Usuario\Tenant\Usuario::class, 'users');
}

    // Relación muchos a muchos con productos
    public function productos()
    {
        return $this->belongsToMany(\DigitalsiteSaaS\Dresses\Tenant\Producto::class, 'orden_producto')
            ->withPivot([
                'cantidad',
                'talla',
                'color',
                'descuento',
                'impuesto',
                'precio_unitario',
                'total'
            ]);
    }
}