<?php

namespace DigitalsiteSaaS\Dresses\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{

use UsesTenantConnection;

  protected $table = 'ordens';
  public $timestamps = true;
  
  protected $fillable = [
   'cliente_id', 'fecha_compra','vendedor','observaciones', 'subtotal', 'impuesto_total', 'total', 'adelanto', 'monto_adeudado'
  ];

  public function cliente(){
   return $this->belongsTo(\DigitalsiteSaaS\Dresses\Tenant\Cliente::class);
  }

  public function productos(){
   return $this->belongsToMany(\DigitalsiteSaaS\Dresses\Tenant\Producto::class)->withPivot('cantidad', 'talla', 'color', 'descuento', 'impuesto', 'precio_unitario', 'total');
  }

}