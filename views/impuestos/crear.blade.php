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
    <div class="col-md-8 offset-sm-2">
 <div class="card m-b-30">
  <div class="card-body">
            
   <h4 class="mt-0 header-title">Create Tax</h4>
   <p class="text-muted font-14">Parsley is a javascript form validation library. It helps you provide your users with feedback on their form submission before sending it to your server.</p>
    
    {{Form::open(array('method' => 'POST','class' => 'form-horizontal','id' => 'defaultForm', 'url' => array('dresses/crear-impuesto'))) }}

                                        
                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-email-input">City</label>
                                            <div class="col-md-12 date" id="datetimepicker9">
                                               {{Form::text('ciudad', '', array('class' => 'form-control','placeholder'=>'Enter city'))}} 
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Suffix</label>
                                            <div class="col-md-12">
                                               {{Form::text('sufijo', '', array('class' => 'form-control','placeholder'=>'enter suffix','maxlength' => '50' ))}}
                                            </div>
                                        </div>

                                          <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Percentage</label>
                                            <div class="col-md-12">
                                               {{Form::text('porcentaje', '', array('class' => 'form-control','placeholder'=>'Enter percentage','maxlength' => '50' ))}}
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
                                    </div>
                                </div>


@stop






