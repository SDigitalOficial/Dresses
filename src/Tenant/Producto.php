<?php

namespace DigitalsiteSaaS\Dresses\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;


class Producto extends Model{

use UsesTenantConnection;

protected $table = 'dresses_productos';
public $timestamps = true;

   protected $fillable = ['nombre','precio','talla','color'];

    public function ordenes()
    {
        return $this->belongsToMany(\DigitalsiteSaaS\Dresses\Tenant\Orden::class)->withPivot('cantidad', 'talla', 'color', 'descuento', 'impuesto', 'precio_unitario', 'total');
    }

}




