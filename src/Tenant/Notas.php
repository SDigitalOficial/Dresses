<?php

namespace DigitalsiteSaaS\Dafer\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;

class Notas extends Model{

use UsesTenantConnection;

protected $table = 'dafer_notas';
public $timestamps = true;

}