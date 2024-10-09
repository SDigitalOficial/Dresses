<?php

 namespace DigitalsiteSaaS\Dafer\Tenant;
 use Hyn\Tenancy\Traits\UsesTenantConnection;
 use Illuminate\Database\Eloquent\Model;

 class Empresa extends Model{
 use UsesTenantConnection;
 protected $table = 'dafer_empresas';
 public $timestamps = false;

 }
