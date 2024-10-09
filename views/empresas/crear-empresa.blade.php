@extends ('LayoutDafer.layout')

    @section('cabecera')
    @parent

    
    <link rel="stylesheet" href="/validaciones/dist/css/bootstrapValidator.css"/>

    <script type="text/javascript" src="/validaciones/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="/validaciones/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/validaciones/dist/js/bootstrapValidator.js"></script>
   
   {{ Html::style('modulo-facturacion/css/bootstrap-datetimepicker.min.css') }}
<script type="text/javascript">
function mostrar(id) {
  if (id == "estudiante") {
    $("#estudiante").show();
    $("#trabajador").hide();
    $("#autonomo").hide();
    $("#paro").hide();
  }
  
  if (id == "trabajador") {
    $("#estudiante").hide();
    $("#trabajador").show();
    $("#autonomo").hide();
    $("#paro").hide();
  }
  
  if (id == "autonomo") {
    $("#estudiante").hide();
    $("#trabajador").hide();
    $("#autonomo").show();
    $("#paro").hide();
  }
  
  if (id == "paro") {
    $("#estudiante").hide();
    $("#trabajador").hide();
    $("#autonomo").hide();
    $("#paro").show();
  }
}
</script>
<script type="text/javascript">
    $(document).ready(function () {
  toggleFields();
  $("#t_identificacion").change(function () {
    toggleFields();
  });
});

function toggleFields() {
  if ($("#t_identificacion").val() === "2") {
    $("#n_identificacion").show();
  } else {
    $("#n_identificacion").hide();
  }
  if ($("#t_identificacion").val() === "3") {
    $("#n_identificacion1").show();
  } else {
    $("#n_identificacion1").hide();
  }
}

</script>

    @stop

@section('ContenidoSite-01')

@if(Auth::user()->rol_id == 31)

<div class="container text-center">
   <h1>No tienes permisos para crear Empresas, contactate con el Administrador</h1> 
</div>
@else

<div class="container">   
 <div class="row">
  <label class="col-md-3 control-label" for="example-select">Tipo de cliente</label>
   <div class="col-md-12">
    <select  class="form-control" name="status" onchange="mostrar(this.value);">
     <option selected>--- Elige persona ---</option>
     <option value="estudiante">Crear Cliente Individual</option>
     <option value="trabajador">Crear Cliente Empresa</option>
    </select>
   <br><br>
  </div>
 </div>
</div>



<div class="container">

<div id="trabajador" class="element" style="display: none;">

 <div class="blockss">
  <div class="card m-b-30">
   <div class="card-body">
    <h4 class="mt-0 header-title"><b>CREAR CLIENTE EMPRESA</b><br></h4>
                                            <p class="text-muted font-14"></p>
                                    
                                    <!-- Basic Form Elements Content -->
                                  {{ Form::open(array('method' => 'POST','class' => 'form-horizontal','id' => 'defaultForm1', 'url' => array('dafer/crear-empresa'))) }}

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-email-input">Nombre del Negocio</label>
                                            <div class="col-md-12">
                                                  {{Form::text('n_negocio', '', array('class' => 'form-control','placeholder'=>'Ingrese nombre o razón social', 'Required' => 'Required' ))}}
                                            </div>
                                        </div>

                                          <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-select">Estructura Legal</label>
                                            <div class="col-md-12">
                                                 {{ Form::select('e_legal', [
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
                                                 '12' => 'S CORPORATION - SCORP'], null, array('class' => 'form-control','placeholder'=>'-- Seleccione tipo identificación --','Required' => 'Required')) }}
                                             </div>
                                        </div>

                                            <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-select">Tipo identificación</label>
                                            <div class="col-md-12">
                                                 {{ Form::select('t_identificacion', [
                                                 '1' => 'EIN'], null, array('class' => 'form-control','placeholder'=>'-- Seleccione tipo identificación --', 'Required' => 'Required')) }}
                                             </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Número de identificación</label>
                                            <div class="col-md-12">
                                                {{Form::text('n_identificacion', '', array('class' => 'form-control','placeholder'=>'Ingrese número identificación','Required' => 'Required','data-mask' => '99-9999999' ))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Representante empresa</label>
                                            <div class="col-md-9">
                                                {{Form::text('representante', '', array('class' => 'form-control','placeholder'=>'Nombre Representante','Required' => 'Required' ))}}
                                            </div>
                                        </div>


                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Teléfono (1)</label>
                                            <div class="col-md-12 date" id="datetimepicker7">
                                                   {{Form::text('tel_1', '', array('class' => 'form-control','placeholder'=>'Ingrese Telefono', 'Required' => 'Required' ))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Teléfono (2)</label>
                                            <div class="col-md-12 date" id="datetimepicker7">
                                                   {{Form::text('tel_2', '', array('class' => 'form-control','placeholder'=>'Ingrese Telefono' ))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Teléfono (3)</label>
                                            <div class="col-md-12 date" id="datetimepicker7">
                                                   {{Form::text('tel_3', '', array('class' => 'form-control','placeholder'=>'Ingrese Telefono' ))}}
                                            </div>
                                        </div>


                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Correo electrónico (1)</label>
                                            <div class="col-md-12">
                                                 {{Form::email('email', '', array('class' => 'form-control','placeholder'=>'Ingrese Correo electronico', 'Required' => 'Required','parsley-type'=>'email' ))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Correo electrónico (2)</label>
                                            <div class="col-md-12">
                                                 {{Form::email('email_dos', '', array('class' => 'form-control','placeholder'=>'Ingrese Correo electronico', 'parsley-type'=>'email'))}}
                                            </div>
                                        </div>

                                        
                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Dirección</label>
                                            <div class="col-md-12">
                                                    {{Form::text('direccion_1', '', array('class' => 'form-control','placeholder'=>'Ingrese dirección', 'Required' => 'Required' ))}}
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Ciudad</label>
                                            <div class="col-md-12">
                                                  {{Form::text('ciudad', '', array('class' => 'form-control','placeholder'=>'Ingrese dirección', 'Required' => 'Required' ))}}
                                              </div>
                                            </div>



                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Estado</label>
                                            <div class="col-md-12">
                                                  {{Form::text('estado', '', array('class' => 'form-control','placeholder'=>'Ingrese dirección', 'Required' => 'Required' ))}}
                                              </div>
                                            </div>

                                            <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Código Postal</label>
                                            <div class="col-md-12">
                                                  {{Form::text('c_postal', '', array('class' => 'form-control','placeholder'=>'Ingrese dirección','Required' => 'Required' ))}}
                                              </div>
                                            </div>

                                          

                                          <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Dirección (2)</label>
                                            <div class="col-md-12">
                                                    {{Form::text('direccion_2', '', array('class' => 'form-control','placeholder'=>'Ingrese dirección' ))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Ciudad (2)</label>
                                            <div class="col-md-12">
                                                  {{Form::text('ciudad_2', '', array('class' => 'form-control','placeholder'=>'Ingrese dirección' ))}}
                                              </div>
                                            </div>



                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Estado (2)</label>
                                            <div class="col-md-12">
                                                  {{Form::text('estado_2', '', array('class' => 'form-control','placeholder'=>'Ingrese dirección' ))}}
                                              </div>
                                            </div>

                                            <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Código Postal (2)</label>
                                            <div class="col-md-12">
                                                  {{Form::text('c_postal_2', '', array('class' => 'form-control','placeholder'=>'Ingrese dirección' ))}}
                                              </div>
                                            </div>
                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Fecha de Creación</label>
                                            <div class="col-md-12 ">
                                                  {{Form::date('f_inicio','', array('class' => 'form-control','placeholder'=>'Ingrese fecha inicio','Required' => 'Required'))}}
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Situación Actual</label>
                                            <div class="col-md-12">
                                                 {{ Form::select('s_actual', [
                                                 '1' => 'Activo',
                                                 '2' => 'Inactivo'], null, array('class' => 'form-control','placeholder'=>'-- Seleccione situación cliente --','Required' => 'Required')) }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Estado de Cuenta</label>
                                            <div class="col-md-12">
                                                 {{ Form::select('e_actual', [
                                                 '1' => 'Al dia',
                                                 '2' => 'Saldo Pendiente'], null, array('class' => 'form-control','placeholder'=>'-- Seleccione estado de cuenta --','Required' => 'Required')) }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Tipo Cliente</label>
                                            <div class="col-md-12">
                                                 {{ Form::select('t_cliente', [
                                                 '1' => 'Int',
                                                 '2' => 'Ext'], null, array('class' => 'form-control','placeholder'=>'-- Seleccione estado de cuenta --','Required' => 'Required')) }}
                                            </div>
                                        </div>

                                        {{Form::hidden('tipo', '1', array('class' => 'form-control','placeholder'=>'Ingrese nombre o razón social' ))}}
    

                                          
                                        <div class="form-group form-actions">
                                            <div class="col-md-9 col-md-offset-3">
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Crear Cliente</button>
                                                <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                                            </div>
                                        </div>
                                    {{ Form::close() }}
                                
 </div>
                                    </div>
                                </div> <!-- end col --></div>


    <div id="estudiante" class="element" style="display: none;">
                                <div class="block">

                                    <div class="card m-b-30">
                                        <div class="card-body">
            
                                            <h4 class="mt-0 header-title"><b>CREAR CLIENTE INDIVUDUAL<br><br></b></h4>
                                            <p class="text-muted font-14"></p>
                                    
                                    <!-- Basic Form Elements Content -->
                                  {{ Form::open(array('method' => 'POST','class' => 'form-horizontal','id' => 'defaultForm1', 'url' => array('dafer/crear-empresa'))) }}


                                        
        

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-email-input">Nombre del Cliente</label>
                                            <div class="col-md-12">
                                                  {{Form::text('n_negocio', '', array('class' => 'form-control','placeholder'=>'Ingrese nombre o razón social','Required' => 'Required' ))}}
                                            </div>
                                        </div>
                                        <!--
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-select">Estructura Legal</label>
                                            <div class="col-md-12">
                                                 {{ Form::select('t_documento', [
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
                                                 '11' => 'NJ Domestic Non-Profit Veteran Corporation (NV)'], null, array('class' => 'form-control','placeholder'=>'-- Seleccione tipo identificación --')) }}
                                             </div>
                                        </div>
                                        -->

                                            <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-select">Tipo identificación</label>
                                            <div class="col-md-12">
                                                 {{ Form::select('t_identificacion', [
                                                 '2' => 'Seguro Social',
                                                 '3' => 'Número ITIN'], null, array('class' => 'form-control','placeholder'=>'-- Seleccione tipo identificación --','Required' => 'Required', 'id' => 't_identificacion')) }}
                                             </div>
                                        </div>


                                          <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Número de identificación</label>
                                            <div class="col-md-12">
                                                {{Form::text('n_identificacion', '', array('class' => 'form-control','placeholder'=>'Ingrese número identificación', 'data-mask' => '999-99-9999','id' => 'n_identificacion'  ))}}

                                                 
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Representante empresa</label>
                                            <div class="col-md-9">
                                                {{Form::text('representante', '', array('class' => 'form-control','placeholder'=>'Nombre Representante','Required' => 'Required' ))}}
                                            </div>
                                        </div>


                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Teléfono (1)</label>
                                            <div class="col-md-12 date" id="datetimepicker7">
                                                   {{Form::text('tel_1', '', array('class' => 'form-control','placeholder'=>'Ingrese Telefono','Required' => 'Required' ))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Teléfono (2)</label>
                                            <div class="col-md-12 date" id="datetimepicker7">
                                                   {{Form::text('tel_2', '', array('class' => 'form-control','placeholder'=>'Ingrese Telefono' ))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Teléfono (3)</label>
                                            <div class="col-md-12 date" id="datetimepicker7">
                                                   {{Form::text('tel_3', '', array('class' => 'form-control','placeholder'=>'Ingrese Telefono' ))}}
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Correo electrónico</label>
                                            <div class="col-md-12">
                                                 {{Form::email('email', '', array('class' => 'form-control','placeholder'=>'Ingrese Correo electronico','Required' => 'Required','parsley-type'=>'email' ))}}
                                            </div>
                                        </div>

                                           <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Correo electrónico (2)</label>
                            <div class="col-md-12">
        {{Form::email('email_dos', '', array('class' => 'form-control','placeholder'=>'Ingrese Correo electronico','parsley-type'=>'email'))}}
                                            </div>
                                        </div>

                                          


                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Ciudad</label>
                                            <div class="col-md-12">
                                                  {{Form::text('ciudad', '', array('class' => 'form-control','placeholder'=>'Ingrese dirección','Required' => 'Required' ))}}
                                              </div>
                                            </div>
                                              <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Dirección (1)</label>
                                            <div class="col-md-12">
                                                    {{Form::text('direccion_1', '', array('class' => 'form-control','placeholder'=>'Ingrese dirección','Required' => 'Required' ))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Estado</label>
                                            <div class="col-md-12">
                                                  {{Form::text('estado', '', array('class' => 'form-control','placeholder'=>'Ingrese dirección','Required' => 'Required' ))}}
                                              </div>
                                            </div>

                                            <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Código Postal</label>
                                            <div class="col-md-12">
                                                  {{Form::text('c_postal', '', array('class' => 'form-control','placeholder'=>'Ingrese dirección','Required' => 'Required' ))}}
                                              </div>
                                            </div>



                                          <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Dirección (2)</label>
                                            <div class="col-md-12">
                                                    {{Form::text('direccion_2', '', array('class' => 'form-control','placeholder'=>'Ingrese dirección' ))}}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Ciudad (2)</label>
                                            <div class="col-md-12">
                                                  {{Form::text('ciudad_2', '', array('class' => 'form-control','placeholder'=>'Ingrese dirección' ))}}
                                              </div>
                                            </div>



                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Estado (2)</label>
                                            <div class="col-md-12">
                                                  {{Form::text('estado_2', '', array('class' => 'form-control','placeholder'=>'Ingrese dirección' ))}}
                                              </div>
                                            </div>

                                            <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Código Postal (2)</label>
                                            <div class="col-md-12">
                                                  {{Form::text('c_postal_2', '', array('class' => 'form-control','placeholder'=>'Ingrese dirección' ))}}
                                              </div>
                                            </div>

                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Fecha de Creación</label>
                                            <div class="col-md-12 ">
                                                  {{Form::date('f_inicio','', array('class' => 'form-control','placeholder'=>'Ingrese fecha inicio','Required' => 'Required'))}}
                                            </div>
                                        </div>


                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Situación Actual</label>
                                            <div class="col-md-12">
                                                 {{ Form::select('s_actual', [
                                                 '1' => 'Activo',
                                                 '2' => 'Inactivo'], null, array('class' => 'form-control','placeholder'=>'-- Seleccione situación cliente --','Required' => 'Required')) }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Estado de Cuenta</label>
                                            <div class="col-md-12">
                                                 {{ Form::select('e_actual', [
                                                 '1' => 'Al dia',
                                                 '2' => 'Saldo Pendiente'], null, array('class' => 'form-control','placeholder'=>'-- Seleccione estado de cuenta --','Required' => 'Required')) }}
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Tipo Cliente</label>
                                            <div class="col-md-12">
                                                 {{ Form::select('t_cliente', [
                                                 '1' => 'Int',
                                                 '2' => 'Ext'], null, array('class' => 'form-control','placeholder'=>'-- Seleccione estado de cuenta --','Required' => 'Required')) }}
                                            </div>
                                        </div>

                                        
                                        {{Form::hidden('tipo', '2', array('class' => 'form-control','placeholder'=>'Ingrese nombre o razón social' ))}}

                                          
                                        <div class="form-group form-actions">
                                            <div class="col-md-9 col-md-offset-3">
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Crear Cliente</button>
                                                <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                                            </div>
                                        </div>
                                    {{ Form::close() }}
                                
 </div>
                                    </div>
                                </div> <!-- end col --></div>

</div>
    
@endif
 <!-- Parsley js -->
     


@stop