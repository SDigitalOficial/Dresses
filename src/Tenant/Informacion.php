<?php

namespace DigitalsiteSaaS\Dafer\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;


class Informacion extends Model{

use UsesTenantConnection;

protected $table = 'dafer_infobancaria';
public $timestamps = true;

}