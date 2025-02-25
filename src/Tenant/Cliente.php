<?php

namespace DigitalsiteSaaS\Dresses\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;


class Cliente extends Model{

use UsesTenantConnection;

protected $table = 'dresses_clientes';
public $timestamps = true;

}