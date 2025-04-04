<?php

namespace DigitalsiteSaaS\Dresses\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;


class Cliente extends Model{

use UsesTenantConnection;
 
 protected $table = 'dresses_clientes';
 public $timestamps = true;

 protected $fillable = ['nombres','apellidos', 'email','telefono','ciudad','direccion','tienda','tipo_evento','fecha_evento'];

    public function ordenes()
    {
     return $this->hasMany(\DigitalsiteSaaS\Dresses\Tenant\Orden::class);
    }

}



