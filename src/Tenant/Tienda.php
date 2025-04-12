<?php

namespace DigitalsiteSaaS\Dresses\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;


class Tienda extends Model{

use UsesTenantConnection;

protected $table = 'dresses_tienda';
public $timestamps = true;


}
