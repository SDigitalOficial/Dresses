@extends ('LayoutDafer.layout')


    @section('cabecera')
    @parent
   
       <link rel="stylesheet" href="/validaciones/dist/css/bootstrapValidator.css"/>

    <script type="text/javascript" src="/validaciones/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="/validaciones/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/validaciones/dist/js/bootstrapValidator.js"></script>
   
   {{ Html::style('modulo-facturacion/css/bootstrap-datetimepicker.min.css') }}
    @stop

@section('ContenidoSite-01')

@if(Auth::user()->rol_id == 31)

<div class="container text-center">
   <h1>No tienes permisos para editar Empresas, contactate con el Administrador</h1> 
</div>
@else

<div class="container">
  <?php $status=Session::get('status'); ?>
  @if($status=='ok_create')
   <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>CLIENTE REGISTRADO CON EXITO</strong>
   </div>
  @endif

  @if($status=='ok_delete')
   <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>CLIENTE ELIMINADO CON EXITO</strong>
   </div>
  @endif

  @if($status=='ok_update')
   <div class="alert alert-warning">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>CLIENTE ACTUALIZADO CON EXITO</strong>
   </div>
  @endif

 </div>

 <div class="container">
 <div class="blockss">
  <div class="card m-b-30">
   <div class="card-body">

   @if($facturacion->tipo == 1)
    <h4 class="mt-0 header-title">EDITAR CLIENTE EMPRESA</h4>
   @else
    <h4 class="mt-0 header-title">EDITAR CLIENTE INDIVIDUAL</h4>
   @endif
   <br>
   <br>
                                    
   {{ Form::open(array('method' => 'POST','class' => 'form-horizontal','id' => 'defaultForm', 'url' => array('dafer/actualizar-cliente',$facturacion->id))) }}
                                    @if($facturacion->tipo == 1)
                                       <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-email-input">Nombre del Negocio</label>
                                            <div class="col-md-12">
                                                  {{Form::text('n_negocio', $facturacion->n_negocio, array('class' => 'form-control','placeholder'=>'Ingrese nombre o razón social','Required' => 'Required' ))}}
                                            </div>
                                        </div>

                                          <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-select">Estructura Legal</label>
                                            <div class="col-md-12">
                                                 {{ Form::select('e_legal', [$facturacion->e_legal => '$facturacion->e_legal',
                                                 '1' => 'NJ Domestic For-Profit Corporation (DP)',
                                                 '2' => 'NJ Domestic Professional Corporation (PA)',
                                                 '3' => 'NJ Domestic Limited Liability Company (LLC)',
                                                 '4' => 'NJ Domestic Limited Partnership (LLP)',
                                                 '5' => 'NJ Domestic Non-Profit Corporation (NP)',
                                                 '6' => 'NJ Foreign For-Profit Corporation (FR)',
                                                 '7' => 'NJ Foreign Limited Liability Company (FLC)',
                                                 '8' => 'NJ Foreign Limited Partnership (LF)',
                                                 '9' => 'NJ Foreign Limited Liability Partnership (FLP)',
                                                 '10' => 'NJ Foreign Non-Profit Corportion (NF)',
                                                 '11' => 'NJ Domestic Non-Profit Veteran Corporation (NV)',
                                                 '12' => 'S CORPORATION - SCORP'], null, array('class' => 'form-control','Required' => 'Required')) }}
                                             </div>
                                        </div>

                                            <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-select">Tipo identificación</label>
                                            <div class="col-md-12">
                                                 {{ Form::select('t_identificacion', [$facturacion->t_identificacion => $facturacion->t_identificacion,
                                                 '1' => 'EIN'], null, array('class' => 'form-control','Required' => 'Required')) }}
                                             </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Número de identificación</label>
                                            <div class="col-md-12">
                                                {{Form::text('n_identificacion', $facturacion->n_identificacion, array('class' => 'form-control','placeholder'=>'Ingrese número identificación','Required' => 'Required','data-mask' => '99-9999999' ))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Representante empresa</label>
                                            <div class="col-md-9">
                                                {{Form::text('representante', $facturacion->representante, array('class' => 'form-control','placeholder'=>'Nombre Representante','Required' => 'Required' ))}}
                                            </div>
                                        </div>


                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Teléfono (1)</label>
                                            <div class="col-md-12 date" id="datetimepicker7">
                                                   {{Form::text('tel_1', $facturacion->tel_1, array('class' => 'form-control','placeholder'=>'Ingrese Telefono','Required' => 'Required' ))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Teléfono (2)</label>
                                            <div class="col-md-12 date" id="datetimepicker7">
                                                   {{Form::text('tel_2', $facturacion->tel_2, array('class' => 'form-control','placeholder'=>'Ingrese Telefono' ))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Teléfono (3)</label>
                                            <div class="col-md-12 date" id="datetimepicker7">
                                                   {{Form::text('tel_3', $facturacion->tel_3, array('class' => 'form-control','placeholder'=>'Ingrese Telefono' ))}}
                                            </div>
                                        </div>


                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Correo electrónico (1)</label>
                                            <div class="col-md-12">
                                                 {{Form::text('email', $facturacion->email, array('class' => 'form-control','placeholder'=>'Ingrese Correo electronico','Required' => 'Required' ))}}
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Correo electrónico (2)</label>
                                            <div class="col-md-12">
                                                 {{Form::text('email_dos', $facturacion->email_dos, array('class' => 'form-control','placeholder'=>'Ingrese Correo electronico' ))}}
                                            </div>
                                        </div>


                                              <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Dirección</label>
                                            <div class="col-md-12">
                                                    {{Form::text('direccion_1', $facturacion->direccion_1, array('class' => 'form-control','placeholder'=>'Ingrese dirección','Required' => 'Required' ))}}
                                            </div>
                                        </div>


                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Ciudad</label>
                                            <div class="col-md-12">
                                                  {{Form::text('ciudad', $facturacion->ciudad, array('class' => 'form-control','placeholder'=>'Ingrese dirección','Required' => 'Required' ))}}
                                              </div>
                                            </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Estado</label>
                                            <div class="col-md-12">
                                                  {{Form::text('estado', $facturacion->estado, array('class' => 'form-control','placeholder'=>'Ingrese dirección','Required' => 'Required' ))}}
                                              </div>
                                            </div>

                                            <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Código Postal</label>
                                            <div class="col-md-12">
                                                  {{Form::text('c_postal', $facturacion->c_postal, array('class' => 'form-control','placeholder'=>'Ingrese dirección','Required' => 'Required' ))}}
                                              </div>
                                            </div>
                                        
                                          <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Dirección (2)</label>
                                            <div class="col-md-12">
                                                    {{Form::text('direccion_2', $facturacion->direccion_2, array('class' => 'form-control','placeholder'=>'Ingrese dirección' ))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Ciudad (2)</label>
                                            <div class="col-md-12">
                                                  {{Form::text('ciudad_2', $facturacion->ciudad_2, array('class' => 'form-control','placeholder'=>'Ingrese dirección' ))}}
                                              </div>
                                            </div>



                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Estado (2)</label>
                                            <div class="col-md-12">
                                                  {{Form::text('estado_2', $facturacion->estado_2, array('class' => 'form-control','placeholder'=>'Ingrese dirección' ))}}
                                              </div>
                                            </div>

                                            <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Código Postal (2)</label>
                                            <div class="col-md-12">
                                                  {{Form::text('c_postal_2', $facturacion->c_postal_2, array('class' => 'form-control','placeholder'=>'Ingrese dirección' ))}}
                                              </div>
                                            </div>


                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Fecha inicio</label>
                                            <div class="col-md-12 ">
                                                  {{Form::date('f_inicio',$facturacion->f_inicio, array('class' => 'form-control','placeholder'=>'Ingrese fecha inicio','Required' => 'Required'))}}
                                            </div>
                                        </div>


                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Situación Actual</label>
                                            <div class="col-md-12">
                                                 {{ Form::select('s_actual', [$facturacion->s_actual => $facturacion->s_actual,
                                                 '1' => 'Activo',
                                                 '2' => 'Inactivo'], null, array('class' => 'form-control','Required' => 'Required')) }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Situación Actual</label>
                                            <div class="col-md-12">
                                                 {{ Form::select('e_actual', [$facturacion->e_actual => $facturacion->e_actual,
                                                 '1' => 'Al día',
                                                 '2' => 'Saldo Pendiente'], null, array('class' => 'form-control','Required' => 'Required')) }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Tipo Cliente</label>
                                            <div class="col-md-12">
                                                 {{ Form::select('t_cliente', [$facturacion->t_cliente => $facturacion->t_cliente,
                                                 '1' => 'Int',
                                                 '2' => 'Ext'], null, array('class' => 'form-control','Required' => 'Required')) }}
                                            </div>
                                        </div>

                                        {{Form::hidden('tipo', $facturacion->tipo, array('class' => 'form-control','placeholder'=>'Ingrese nombre o razón social' ))}}
    

                                          
                                        <div class="form-group form-actions">
                                            <div class="col-md-9 col-md-offset-3">
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Editar Cliente</button>
                                                <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                                            </div>
                                        </div>
                                        @else
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-email-input">Nombre del Negocio</label>
                                            <div class="col-md-12">
                                                  {{Form::text('n_negocio', $facturacion->n_negocio, array('class' => 'form-control','placeholder'=>'Ingrese nombre o razón social','Required' => 'Required'))}}
                                            </div>
                                        </div>

                                       

                                            <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-select">Tipo identificación</label>
                                            <div class="col-md-12">
                                                 {{ Form::select('t_identificacion', [$facturacion->t_identificacion => $facturacion->t_identificacion,
                                                 '2' => 'Seguro Social',
                                                 '3' => 'Número ITIN'], null, array('class' => 'form-control','Required' => 'Required')) }}
                                             </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Número de identificación</label>
                                            <div class="col-md-12">
                                                {{Form::text('n_identificacion', $facturacion->n_identificacion, array('class' => 'form-control','placeholder'=>'Ingrese número identificación','Required' => 'Required','data-mask' => '999-99-9999' ))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Representante empresa</label>
                                            <div class="col-md-9">
                                                {{Form::text('representante', $facturacion->representante, array('class' => 'form-control','placeholder'=>'Nombre Representante' ))}}
                                            </div>
                                        </div>


                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Teléfono (1)</label>
                                            <div class="col-md-12 date" id="datetimepicker7">
                                                   {{Form::text('tel_1', $facturacion->tel_1, array('class' => 'form-control','placeholder'=>'Ingrese Telefono','Required' => 'Required' ))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Teléfono (2)</label>
                                            <div class="col-md-12 date" id="datetimepicker7">
                                                   {{Form::text('tel_2', $facturacion->tel_2, array('class' => 'form-control','placeholder'=>'Ingrese Telefono' ))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Teléfono (3)</label>
                                            <div class="col-md-12 date" id="datetimepicker7">
                                                   {{Form::text('tel_3', $facturacion->tel_3, array('class' => 'form-control','placeholder'=>'Ingrese Telefono' ))}}
                                            </div>
                                        </div>


                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Correo electrónico</label>
                                            <div class="col-md-12">
                                                 {{Form::text('email', $facturacion->email, array('class' => 'form-control','placeholder'=>'Ingrese Correo electronico','Required' => 'Required' ))}}
                                            </div>
                                        </div>

                                          <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Dirección (1)</label>
                                            <div class="col-md-12">
                                                    {{Form::text('direccion_1', $facturacion->direccion_1, array('class' => 'form-control','placeholder'=>'Ingrese dirección','Required' => 'Required' ))}}
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Ciudad</label>
                                            <div class="col-md-12">
                                                  {{Form::text('ciudad', $facturacion->ciudad, array('class' => 'form-control','placeholder'=>'Ingrese dirección','Required' => 'Required' ))}}
                                              </div>
                                            </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Estado</label>
                                            <div class="col-md-12">
                                                  {{Form::text('estado', $facturacion->estado, array('class' => 'form-control','placeholder'=>'Ingrese Estado' ,'Required' => 'Required'))}}
                                              </div>
                                            </div>

                                            <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Código Postal</label>
                                            <div class="col-md-12">
                                                  {{Form::text('c_postal', $facturacion->c_postal, array('class' => 'form-control','placeholder'=>'Ingrese dirección','Required' => 'Required' ))}}
                                              </div>
                                            </div>

                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Dirección (2)</label>
                                            <div class="col-md-12">
                                                    {{Form::text('direccion_2', $facturacion->direccion_2, array('class' => 'form-control','placeholder'=>'Ingrese dirección' ))}}
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Ciudad (2)</label>
                                            <div class="col-md-12">
                                                  {{Form::text('ciudad_2', $facturacion->ciudad_2, array('class' => 'form-control','placeholder'=>'Ingrese dirección' ))}}
                                              </div>
                                            </div>



                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Estado (2)</label>
                                            <div class="col-md-12">
                                                  {{Form::text('estado_2', $facturacion->estado_2, array('class' => 'form-control','placeholder'=>'Ingrese dirección' ))}}
                                              </div>
                                            </div>

                                            <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Código Postal (2)</label>
                                            <div class="col-md-12">
                                                  {{Form::text('c_postal_2', $facturacion->c_postal_2, array('class' => 'form-control','placeholder'=>'Ingrese dirección' ))}}
                                              </div>
                                            </div>


                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Fecha inicio</label>
                                            <div class="col-md-12 ">
                                                  {{Form::date('f_inicio',$facturacion->f_inicio, array('class' => 'form-control','placeholder'=>'Ingrese fecha inicio','Required' => 'Required'))}}
                                            </div>
                                        </div>


                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Situación Actual</label>
                                            <div class="col-md-12">
                                                 {{ Form::select('s_actual', [$facturacion->s_actual => $facturacion->s_actual,
                                                 '1' => 'Activo',
                                                 '2' => 'Inactivo'], null, array('class' => 'form-control','Required' => 'Required')) }}
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Situación Actual</label>
                                            <div class="col-md-12">
                                                 {{ Form::select('e_actual', [$facturacion->e_actual => $facturacion->e_actual,
                                                 '1' => 'Al día',
                                                 '2' => 'Saldo Pendiente'], null, array('class' => 'form-control','Required' => 'Required')) }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Tipo Cliente</label>
                                            <div class="col-md-12">
                                                 {{ Form::select('t_cliente', [$facturacion->t_cliente => $facturacion->t_cliente,
                                                 '1' => 'Int',
                                                 '2' => 'Ext'], null, array('class' => 'form-control','Required' => 'Required')) }}
                                            </div>
                                        </div>

                                        {{Form::hidden('tipo', $facturacion->tipo, array('class' => 'form-control','placeholder'=>'Ingrese nombre o razón social' ))}}
    

                                          
                                        <div class="form-group form-actions">
                                            <div class="col-md-9 col-md-offset-3">
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Editar Cliente</button>
                                                <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                                            </div>
                                        </div>
                                        @endif
                                    {{ Form::close() }}
 </div>
                                    </div>
                                </div> <!-- end col -->


</div>

@endif
   
@stop