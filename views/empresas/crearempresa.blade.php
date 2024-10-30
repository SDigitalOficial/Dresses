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

   <div class="content-header">
   <ul class="nav-horizontal text-center">
    <li>
     <a href="/gestion/factura"><i class="fa fa-users"></i> Clientes</a>
    </li>
    <li>
     <a href="/gestion/factura/factura-cliente"><i class="fa fa-user-plus"></i> Crear cliente</a>
    </li>
    <li>
     <a href="/gestion/factura/crear-producto"><i class="fa fa-shopping-basket"></i> Crear producto</a>
    </li>
    <li class="active">
     <a href="/gestion/factura/editar-empresa"><i class="fa fa-building"></i> Configurar empresa</a>
    </li>
    <li>
     <a href="/gestion/factura/control-gastos"><i class="gi gi-money"></i> Gastos</a>
    </li>
    <li>
     <a href="/informe/generar-informe"><i class="fa fa-file-text"></i> Informes</a>
    </li>
   </ul>
  </div>


   




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
                                            <label class="col-md-3 control-label" for="example-text-input">Razón Social</label>
                                            <div class="col-md-9">
                                              {{Form::text('r_social', '', array('class' => 'form-control','placeholder'=>'Ingrese razon social'))}}
                                            </div>
                                        </div>

                                      

                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-select">Dirección</label>
                                            <div class="col-md-9">
                                               {{Form::text('direccion', '', array('class' => 'form-control','placeholder'=>'Ingrese dirección'))}}
                                            </div>
                                        </div>

                                           <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-select">Teléfono</label>
                                            <div class="col-md-9">
                                                {{Form::text('telefono', '', array('class' => 'form-control','placeholder'=>'Ingrese teléfono', ))}}
                                             </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Ciudad</label>
                                            <div class="col-md-9">
                                                 {{Form::text('ciudad', '', array('class' => 'form-control','placeholder'=>'Ingrese ciudad'))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Email</label>
                                            <div class="col-md-9">
                                               {{Form::text('email', '', array('class' => 'form-control','placeholder'=>'Ingrese email' ))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Website</label>
                                            <div class="col-md-9">
                                               {{Form::text('website', '', array('class' => 'form-control','placeholder'=>'Ingrese website' ))}}
                                            </div>
                                        </div>


                                     
                                     
                                      


                                    

                                  

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Prefijo Factura</label>
                                            <div class="col-md-9">
                                                {{Form::text('prefijo', '', array('class' => 'form-control','placeholder'=>'Ingrese resolución factura' ))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Color</label>
                                            <div class="col-md-9">
                                                {{Form::text('color', '', array('id' => 'hue-demo', 'class' => 'form-control demo','data-control'=>'hue'))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Color Secundario</label>
                                            <div class="col-md-9">
                                                {{Form::color('coloruno', '', array('id' => 'hue-demo', 'class' => 'form-control demo','data-control'=>'hue'))}}
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Color fuente</label>
                                            <div class="col-md-9">
                                                {{Form::text('colordos', '', array('id' => 'hue-demo', 'class' => 'form-control demo','data-control'=>'hue'))}}
                                            </div>
                                        </div>



                                           <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Imagen</label>
                                            <div class="col-md-9">
                                                 <input type="text" name="FilePath" readonly="readonly" onclick="openKCFinder(this)" value="" class="form-control" />
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