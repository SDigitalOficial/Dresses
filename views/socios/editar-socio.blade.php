@extends ('LayoutDafer.layout')

@section('ContenidoSite-01')
@if(Auth::user()->rol_id == 31)

<div class="container text-center">
   <h1>No tienes permisos para editar Socios, contactate con el Administrador</h1> 
</div>
@else

<div class="row">
                                <div class="col-md-12 col-xl-10 offset-xl-2">
                                    <div class="content-header">
 <ul class="nav-horizontal text-center">

   <a class="btn btn-primary waves-effect waves-light" href="/dafer/bancos"><i class="mdi mdi-bank"></i> Bancos</a>
 

 </ul>
</div>
                                    <div class="card m-b-30">
                                        <div class="card-body">
            
                                            <h4 class="mt-0 header-title">Editar Socio</h4>

                                            <p class="text-muted font-14">Parsley is a javascript form validation
                                                library. It helps you provide your users with feedback on their form
                                                submission before sending it to your server.</p>
    
 
   {{ Form::open(array('method' => 'POST','class' => 'form-horizontal','id' => 'defaultForm', 'url' => array('dafer/editarsocios',$socio->id))) }}


    <div class="form-group">
     <label class="col-md-3 control-label" for="example-text-input">Nombres</label>
      <div class="col-md-12">
       {{Form::text('nombres', $socio->nombres, array('class' => 'form-control','placeholder'=>'Ingrese Nombres de Socio', 'Required'=>'Required'))}}
      </div>
    </div>

     <div class="form-group">
     <label class="col-md-3 control-label" for="example-text-input">Apellidos</label>
      <div class="col-md-12">
       {{Form::text('apellidos', $socio->apellidos, array('class' => 'form-control','placeholder'=>'Ingrese Apellidos del Socio', 'Required'=>'Required'))}}
      </div>
    </div>

     <div class="form-group">
     <label class="col-md-3 control-label" for="example-text-input">Cargo</label>
      <div class="col-md-12">
       {{Form::text('cargo', $socio->cargo, array('class' => 'form-control','placeholder'=>'Ingrese Cargo del Socio', 'Required'=>'Required'))}}
      </div>
    </div>

     <div class="form-group">
     <label class="col-md-3 control-label" for="example-text-input">Porcentaje Participación</label>
      <div class="col-md-12">
       {{Form::number('porcentaje', $socio->porcentaje, array('class' => 'form-control','placeholder'=>'Ingrese Porcentaje de participación', 'Required'=>'Required'))}}
      </div>
    </div>


    <div class="form-group">
     <label class="col-md-3 control-label" for="example-text-input">Porcentaje Participación</label>
      <div class="col-md-12">
       <select name="empresas" id="cars" class="form-control" required>

@foreach($empresas as $empresas)
@if($socio->empresa_id == $empresas->id)
 <option value="{{$socio->id}}" selected>{{$empresas->n_negocio}}</option>
@endif
  <option value="{{$empresas->id}}">{{$empresas->n_negocio}}</option>
@endforeach
</select>
      </div>
    </div>



    <div class="form-group form-actions">
     <div class="col-md-9 col-md-offset-3">
      <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Crear Socio</button>
      <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Cancelar</button>
     </div>
    </div>
    
    {{ Form::close() }}
                                
   </div>
                                    </div>
                                </div> <!-- end col -->

<footer>
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
 {{ Html::script('modulo-usuarios/validaciones/crear-usuario.js') }}
 {{ Html::script('//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/js/bootstrapValidator.min.js') }} 
</footer>




 @foreach($socio as $socio)
  @endforeach
               

@endforeach


                             
@stop
