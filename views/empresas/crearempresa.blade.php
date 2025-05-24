@extends ('LayoutDresses.layout')

    @section('cabecera')
    @parent
     <link rel="stylesheet" href="/validaciones/dist/css/bootstrapValidator.css"/>

    <script type="text/javascript" src="/validaciones/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="/validaciones/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/validaciones/dist/js/bootstrapValidator.js"></script>
     {{ Html::style('Calendario/css/bootstrap-datetimepicker.min.css') }}
      {{ Html::style('EstilosSD/dist/css/jquery.minicolors.css') }}
    @stop

@section('ContenidoSite-01')

  



   <div class="row">
 <div class="col-md-12 col-xl-10 offset-xl-1">
  
  <div class="content-header">
   <ul class="nav-horizontal text-center">
    <a class="btn btn-primary waves-effect waves-light" href="/dafer/usuarios"><i class="gi gi-parents"></i> Usuarios</a>
    <a class="btn btn-primary waves-effect waves-light" href="/dafer/crear-usuario"><i class="fa fa-user-plus"></i> Crear Usuario</a>
   </ul>
  </div>

  <div class="card m-b-30">
   <div class="card-body">
    
    <h4 class="mt-0 header-title">Create Company</h4>
                                        
     {{ Form::open(array('method' => 'POST','class' => 'form-horizontal','id' => 'defaultForm', 'url' => array('dresses/factura/crear-empresa'))) }}
                                        
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-text-input">Company Name</label>
                                            <div class="col-md-12">
                                              {{Form::text('nombre', '', array('class' => 'form-control','placeholder'=>'Enter Company Name'))}}
                                            </div>
                                        </div>

                                      

                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-select">Address</label>
                                            <div class="col-md-12">
                                               {{Form::text('direccion', '', array('class' => 'form-control','placeholder'=>'Enter Address'))}}
                                            </div>
                                        </div>

                                           <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-select">Phone</label>
                                            <div class="col-md-12">
                                                {{Form::text('telefono', '', array('class' => 'form-control','placeholder'=>'Enter Phone', ))}}
                                             </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">City</label>
                                            <div class="col-md-12">
                                                 {{Form::text('ciudad', '', array('class' => 'form-control','placeholder'=>'Enter City'))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Email</label>
                                            <div class="col-md-12">
                                               {{Form::text('email', '', array('class' => 'form-control','placeholder'=>'Enter email' ))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Website</label>
                                            <div class="col-md-12">
                                               {{Form::text('website', '', array('class' => 'form-control','placeholder'=>'Enter website' ))}}
                                            </div>
                                        </div>
                  

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Invoice Prefix</label>
                                            <div class="col-md-12">
                                                {{Form::text('prefijo', '', array('class' => 'form-control','placeholder'=>'Enter Invoice Prefix' ))}}
                                            </div>
                                        </div>

                                        

                                        <div class="form-group form-actions">
                                            <div class="col-md-9 col-md-offset-3">
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Submit</button>
                                                <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                                            </div>
                                        </div>
                                    {{ Form::close() }}
                                
   </div>
  </div>
 </div> <!-- end col -->
</div>
@stop