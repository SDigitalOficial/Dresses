<?php

namespace DigitalsiteSaaS\Dresses\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;


class Producto extends Model{

use UsesTenantConnection;

protected $table = 'dresses_productos';
public $timestamps = true;

}