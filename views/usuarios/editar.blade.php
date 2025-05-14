@extends ('LayoutDresses.layout')
@section('ContenidoSite-01')


<div class="row">
 <div class="col-md-12 col-xl-10 offset-xl-1">
  
  <div class="content-header">
   <ul class="nav-horizontal text-center">
    <a class="btn btn-primary waves-effect waves-light" href="/dafer/usuarios"><i class="gi gi-parents"></i> Uers</a>
    <a class="btn btn-primary waves-effect waves-light" href="/dafer/crear-usuario"><i class="fa fa-user-plus"></i> Create User</a>
   </ul>
  </div>


  <div class="card m-b-30">
   <div class="card-body">
    <h4 class="mt-0 header-title">Editar Usuario</h4>
        
     {{ Form::open(array('method' => 'POST','class' => 'form-horizontal','id' => 'defaultForm', 'url' => array('dresses/actualizar',$usuario->id))) }}

      <div class="form-group">
       <label class="col-md-3 control-label" for="example-text-input">Name</label>
        <div class="col-md-12">
         {{Form::text('name', $usuario->name, array('class' => 'form-control','placeholder'=>'Enter Name'))}}
        </div>
      </div>
      
      <div class="form-group">
       <label class="col-md-3 control-label" for="example-email-input">Last Name</label>
        <div class="col-md-12">
         {{Form::text('last_name', $usuario->last_name, array('class' => 'form-control','placeholder'=>'Enter Last Name'))}}
        </div>
      </div>

      <div class="form-group">
       <label class="col-md-3 control-label" for="example-email-input">Email</label>
        <div class="col-md-12">
         {{Form::text('email', $usuario->email, array('class' => 'form-control','placeholder'=>'Enter Email'))}}
        </div>
      </div>
      
      <div class="form-group">
       <label class="col-md-3 control-label" for="example-password-input">Address</label>
        <div class="col-md-12">
         {{Form::text('address', $usuario->address, array('class' => 'form-control','placeholder'=>'Enter Address'))}}
        </div>
      </div>

      <div class="form-group">
       <label class="col-md-3 control-label" for="example-password-input">Phone</label>
        <div class="col-md-12">
         {{Form::text('phone', $usuario->phone, array('class' => 'form-control','placeholder'=>'Enter Phone'))}}
        </div>
      </div>

       <div class="form-group">
       <label class="col-md-3 control-label" for="example-password-input">Store</label>
        <div class="col-md-12">
         <select name="store" class="form-control">
            @foreach($empresas as $empresasa)
            @if($usuario->region == $empresasa->id)
            <option value="{{$empresasa->id}}" selected>{{$empresasa->nombre}}</option>
            @endif
            <option value="{{$empresasa->id}}">{{$empresasa->nombre}}</option>
            @endforeach
         </select>
        </div>
      </div>

      <div class="form-group">
       <label class="col-md-3 control-label" for="example-password-input">User Role</label>
        <div class="col-md-12">
         {{ Form::select('level', [$usuario->rol_id => $usuario->rol_id,
         '1' => 'Administrador',
         '2' => 'Comprador',
         '3' => 'Fichador'], null, array('class' => 'form-control')) }}
        </div>
      </div>

      <div class="form-group form-actions">
       <div class="col-md-9 col-md-offset-3">
        <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Edit</button>
        <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Cancel</button>
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

@stop


