@extends ('LayoutDresses.layout')
 @section('cabecera')
 @parent
    <link rel="stylesheet" href="/validaciones/dist/css/bootstrapValidator.css"/>
    <script type="text/javascript" src="/validaciones/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="/validaciones/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/validaciones/dist/js/bootstrapValidator.js"></script>
    {{ Html::style('modulo-facturacion/css/bootstrap-datetimepicker.min.css') }}
 @stop


 @section('ContenidoSite-01')
  


<div class="container">
 <div class="card m-b-30">
  <div class="card-body">
            
   <h4 class="mt-0 header-title">Crear Usuario</h4>
   <p class="text-muted font-14">Parsley is a javascript form validation library. It helps you provide your users with feedback on their form submission before sending it to your server.</p>
    
    {{Form::open(array('method' => 'POST','class' => 'form-horizontal','id' => 'defaultForm', 'url' => array('dresses/factura/crear-factura'))) }}

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-email-input">Fecha Emisión</label>
                                            <div class="col-md-12 date" id="datetimepicker7">
                                                {{Form::date('start', '', array('class' => 'form-control','placeholder'=>'Ingrese fecha inicio'))}}
                                            </div>
                                        </div>
                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-email-input">Fecha Vencimiento</label>
                                            <div class="col-md-12 date" id="datetimepicker9">
                                               {{Form::date('end', '', array('class' => 'form-control','placeholder'=>'Ingrese fecha finalización'))}} 
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Dirigido</label>
                                            <div class="col-md-12">
                                               {{Form::text('dirigido', '', array('class' => 'form-control','placeholder'=>'Ingrese primer apellido','maxlength' => '50' ))}}
                                            </div>
                                        </div>

                                          <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Estado</label>
                                            <div class="col-md-12">
                                                  {{ Form::select('estado', [
                                                  '0' => 'No pagada',
                                                  '1' => 'Pagada'], null, array('class' => 'form-control')) }}
                                            </div>
                                        </div>
                                
                                        {{Form::hidden('identificador', $contenido->id, array('class' => 'form-control'))}}
                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Observaciones</label>
                                            <div class="col-md-12">
                                                {{Form::textarea('observaciones', '', array('class' => 'form-control','placeholder'=>'Ingrese primer apellido','maxlength' => '50' ))}}
                                            </div>
                                        </div>
                                        
                                        {{Form::hidden('identificador', $contenido->id, array('class' => 'form-control'))}}

                                          <div class="form-group form-actions">
                                            <div class="col-md-9 col-md-offset-3">
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Submit</button>
                                                <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                                            </div>
                                        </div>
                                    {{ Form::close() }}
                                
   </div>
                                    </div>
                                </div>


@stop

