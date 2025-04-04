<?php

namespace DigitalsiteSaaS\Dresses\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;


class Orden_Detalle extends Model{

use UsesTenantConnection;

protected $table = 'orden_producto';
public $timestamps = false;

}