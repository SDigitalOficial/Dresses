<?php

namespace DigitalsiteSaaS\Dafer\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;


class Socio extends Model{

use UsesTenantConnection;

protected $table = 'dafer_socios';
public $timestamps = false;
}