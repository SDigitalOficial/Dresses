<?php
namespace DigitalsiteSaaS\Dafer;
use Illuminate\Database\Eloquent\Model;

class Dafer extends Model{

 protected $table = 'users';
 public $timestamps = true;

 protected $fillable = [
 'name', 'compania', 'documento', 'tipo_documento', 'celular', 'pais', 'ciudad', 'email', 'address', 'phone', 'rol_id', 'password', 'remember_token',
 ];

 public function events(){
 return $this->hasMany('\DigitalsiteSaaS\Calendario\Calendar');
 }

 public function fichas(){
 return $this->hasMany('\DigitalsiteSaaS\Pagina\Fichaje');
 }

 protected $hidden = array('password', 'remember_token');

}
