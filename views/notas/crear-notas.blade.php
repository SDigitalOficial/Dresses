@extends ('LayoutDafer.layout')

@section('ContenidoSite-01')


<div class="row">
                                <div class="col-md-12 col-xl-10 offset-xl-2">
                                    <div class="content-header">
 <ul class="nav-horizontal text-center">

   <a class="btn btn-primary waves-effect waves-light" href="/dafer/notas"><i class="mdi mdi-bank"></i> Notas</a>
 

 </ul>
</div>
                                    <div class="card m-b-30">
                                        <div class="card-body">
            
                                            <h4 class="mt-0 header-title">Crear Nota</h4>

                                            <p class="text-muted font-14">Parsley is a javascript form validation
                                                library. It helps you provide your users with feedback on their form
                                                submission before sending it to your server.</p>
    
    {{ Form::open(array('method' => 'POST','class' => 'form-horizontal','id' => 'defaultForm', 'url' => array('dafer/crearnotas'))) }}

    <div class="form-group">
     <label class="col-md-3 control-label" for="example-text-input">Nota</label>
      <div class="col-md-12">
       {{Form::textarea('notas', '', array('class' => 'form-control summernote','placeholder'=>'Ingrese Nota', 'Required'=>'Required'))}}

      </div>
    </div>    

    <div class="form-group">
     <label class="col-md-3 control-label" for="example-text-input">Cliente Empresa o Cliente Individual</label>
      <div class="col-md-12">
       <select name="empresas" id="cars" class="form-control" required>
        <option value="">Seleccionar Cliente Empresa o Cliente Individual</option>
@foreach($empresas as $empresas)

  <option value="{{$empresas->id}}">{{$empresas->n_negocio}}</option>
@endforeach
</select>
      </div>
    </div>
<div class="form-group">
     <label class="col-md-3 control-label" for="example-text-input">Proceso Relacionado Relacionado</label>
      <div class="col-md-12">
       <select name="procesos" id="cars" class="form-control" required>
        <option value="" selected>Seleccionar Proceso</option>

  <option value="1">Registro de Negocios</option>
  <option value="2">Impuestos Corporativos</option>
  <option value="3">Impuestos Personales</option>
  <option value="4">Contabilidad</option>
  <option value="5">Licencias</option>
  <option value="6">Nómina</option>
  <option value="7">Acuerdos de Pago</option>
  <option value="8">Marketing</option>
  <option value="9">Aplicación de Beneficios</option>
  <option value="10">Auditoria</option>

</select>
      </div>
    </div>



    <div class="form-group form-actions">
     <div class="col-md-10 col-md-offset-3">
      <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Crear Nota</button>
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









                             
@stop