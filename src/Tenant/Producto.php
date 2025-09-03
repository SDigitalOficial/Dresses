<?php

namespace DigitalsiteSaaS\Dresses\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;


class Producto extends Model{

use UsesTenantConnection;

protected $table = 'dresses_productos';
public $timestamps = true;

   protected $fillable = ['nombre','precio','talla','color', 'identificador'];

    public function ordenes()
    {
        return $this->belongsToMany(\DigitalsiteSaaS\Dresses\Tenant\Orden::class)->withPivot('cantidad','fecha_compra', 'talla', 'color', 'descuento', 'impuesto', 'precio_unitario', 'total');
    }

    public function order() {
    return $this->belongsTo(\DigitalsiteSaaS\Dresses\Tenant\Orden::class, 'order_id'); // si el campo se llama order_id
}

public function orders()
{
    return $this->belongsToMany(\DigitalsiteSaaS\Dresses\Tenant\Orden::class, 'orden_producto', 'producto_id', 'orden_id')
                ->withPivot(['cantidad', 'color', 'talla', 'precio_unitario', 'total']); // Opcional
}

}





