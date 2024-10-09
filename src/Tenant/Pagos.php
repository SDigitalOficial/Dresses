<?php

namespace DigitalsiteSaaS\Dafer\Tenant;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;


class Pagos extends Model{

use UsesTenantConnection;

protected $table = 'dafer_pagos';
public $timestamps = false;

}