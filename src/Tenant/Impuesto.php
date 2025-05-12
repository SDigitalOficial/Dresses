<?php

namespace DigitalsiteSaaS\Dresses\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;


class Impuesto extends Model{

use UsesTenantConnection;

protected $table = 'dresses_impuestos';
public $timestamps = true;

}