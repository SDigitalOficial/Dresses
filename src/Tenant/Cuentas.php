<?php

namespace DigitalsiteSaaS\Dafer\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;


class Cuentas extends Model{

use UsesTenantConnection;

protected $table = 'dafer_cuentas';
public $timestamps = false;

}