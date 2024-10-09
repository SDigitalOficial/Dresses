@extends ('LayoutDafer.layout')


 @section('ContenidoSite-01')

@if(Auth::user()->rol_id == 31)

<div class="container text-center">
   <h1>No tienes permisos para editar Usuarios, contactate con el Administrador</h1> 
</div>
@else
<div class="row">
                                <div class="col-md-12 col-xl-10 offset-xl-2">
                                    <div class="content-header">
 <ul class="nav-horizontal text-center">

   <a class="btn btn-primary waves-effect waves-light" href="/dafer/usuarios"><i class="gi gi-parents"></i> Usuarios</a>
 

   <a class="btn btn-primary waves-effect waves-light" href="/dafer/crear-usuario"><i class="fa fa-user-plus"></i> Crear Usuario</a>

 </ul>
</div>
                                    <div class="card m-b-30">
                                        <div class="card-body">
            
                                            <h4 class="mt-0 header-title">Editar Usuario</h4>
                                            <p class="text-muted font-14">Parsley is a javascript form validation
                                                library. It helps you provide your users with feedback on their form
                                                submission before sending it to your server.</p>
    
    
     {{ Form::open(array('method' => 'POST','class' => 'form-horizontal','id' => 'defaultForm', 'url' => array('dafer/actualizar',$usuario->id))) }}

      <div class="form-group">
       <label class="col-md-3 control-label" for="example-text-input">Nombre</label>
        <div class="col-md-12">
         {{Form::text('name', $usuario->name, array('class' => 'form-control','placeholder'=>'Ingrese nombre'))}}
        </div>
      </div>
      
      <div class="form-group">
       <label class="col-md-3 control-label" for="example-email-input">Apellido</label>
        <div class="col-md-12">
         {{Form::text('last_name', $usuario->last_name, array('class' => 'form-control','placeholder'=>'Ingrese apellido'))}}
        </div>
      </div>

      <div class="form-group">
       <label class="col-md-3 control-label" for="example-email-input">Email</label>
        <div class="col-md-12">
         {{Form::text('email', $usuario->email, array('class' => 'form-control','placeholder'=>'Ingrese email'))}}
        </div>
      </div>
      
      <div class="form-group">
       <label class="col-md-3 control-label" for="example-password-input">Dirección de residencia</label>
        <div class="col-md-12">
         {{Form::text('address', $usuario->address, array('class' => 'form-control','placeholder'=>'Ingrese dirección'))}}
        </div>
      </div>

      <div class="form-group">
       <label class="col-md-3 control-label" for="example-password-input">Teléfono Fijo o Célular</label>
        <div class="col-md-12">
         {{Form::text('phone', $usuario->phone, array('class' => 'form-control','placeholder'=>'Ingrese teléfono fijo o célular'))}}
        </div>
      </div>

      <div class="form-group">
       <label class="col-md-3 control-label" for="example-password-input">Rol Usuario</label>
        <div class="col-md-12">
         {{ Form::select('level', [$usuario->rol_id => $usuario->rol_id,
         '1' => 'Administrador',
         '2' => 'Comprador',
         '3' => 'Fichador'], null, array('class' => 'form-control')) }}
        </div>
      </div>

      <div class="form-group form-actions">
       <div class="col-md-9 col-md-offset-3">
        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Editar</button>
        <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Cancelar</button>
       </div>
      </div>
     
     {{ Form::close() }}
     
     @foreach($usuario as $usuario)
     @endforeach
    
     </div>
                                    </div>
                                </div> <!-- end col -->



 <footer>
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
   {{ Html::script('modulo-usuarios/validaciones/crear-usuario.js') }}
  {{ Html::script('//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/js/bootstrapValidator.min.js') }} 
 </footer>
 @endif
@stop


