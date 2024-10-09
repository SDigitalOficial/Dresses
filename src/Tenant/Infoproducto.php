<?php

namespace DigitalsiteSaaS\Dafer\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;


class Infoproducto extends Model{

use UsesTenantConnection;

protected $table = 'dafer_infoproductos';
public $timestamps = true;

}