<?php

namespace DigitalsiteSaaS\Dafer\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;


class Producto extends Model{

use UsesTenantConnection;

protected $table = 'dafer_productos';
public $timestamps = true;

}