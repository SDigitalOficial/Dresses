<?php

namespace DigitalsiteSaaS\Dresses\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;


class Venta extends Model{

use UsesTenantConnection;

protected $table = 'dresses_ventas';
public $timestamps = true;

 protected $fillable = [ 'client_id'];

}