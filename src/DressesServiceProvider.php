<?php

namespace DigitalsiteSaaS\Dresses;

use Illuminate\Support\ServiceProvider;

class DressesServiceProvider extends ServiceProvider{
	
 public function register(){
 $this->app->bind('dresses', function($app){
 return new Dresses;
 });
 }

 public function boot(){
 require __DIR__ . '/Http/routes.php';
 $this->loadViewsFrom(__DIR__ . '/../views', 'dresses');
 $this->publishes([
 __DIR__ . '/migrations/2015_07_25_000000_create_usuario_table.php' => base_path('database/migrations/2015_07_25_000000_create_usuario_table.php'),
 ]);
 }

}