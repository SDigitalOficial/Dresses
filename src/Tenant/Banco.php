<?php

namespace DigitalsiteSaaS\Dafer\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;


class Banco extends Model{

use UsesTenantConnection;

protected $table = 'dafer_bancos';
public $timestamps = true;

}