@extends ('LayoutDresses.layout')


    @section('cabecera')
    @parent

    
 
   <link rel="stylesheet" href="/dresses/assets/css/plugins/bootstrap-datepicker3.min.css">

    @stop

@section('ContenidoSite-01')






<div class="row">
                                <div class="col-md-12 col-xl-10 offset-xl-1">
                                    <div class="content-header">
 <ul class="nav-horizontal text-center">

   <a class="btn btn-primary waves-effect waves-light" href="/dresses/clientes"><i class="fas fa-suitcase"></i> Clients</a>
 

 </ul>
</div>
                                    <div class="card m-b-30">
                                        <div class="card-body">
            
                                            <h4 class="mt-0 header-title">Create User</h4>
                                            
    
   {{ Form::open(array('method' => 'POST','class' => 'form-horizontal','id' => 'defaultForm', 'url' => array('dresses/crear-cliente'))) }}


                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Name</label>
                                            <div class="col-md-">
                                                 {{Form::text('p_nombre', '', array('class' => 'form-control','placeholder'=>'Enter Name' ))}}
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-select">Last Name</label>
                                            <div class="col-md-12">
                                                {{Form::text('p_apellido', '', array('class' => 'form-control','placeholder'=>'Enter Last Name' ))}}
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Document Type</label>
                                            <div class="col-md-12">
                                                 {{ Form::select('t_documento', [
                                                 '2' => 'Cédula ciudadania',
                                                 '3' => 'Cédula extranjería'], null, array('class' => 'form-control','placeholder'=>'-- Select Document Type --')) }}
                                            </div>
                                        </div>

                                          <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Document Number</label>
                                            <div class="col-md-12">
                                                  {{Form::text('documento', '', array('class' => 'form-control','placeholder'=>'Enter Document Number' ))}}
                                            </div>
                                        </div>

                                          <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Birthdate</label>
                                            <div class="col-md-12 date" id="datetimepicker8">
                                                  {{Form::date('start','', array('class' => 'form-control','placeholder'=>'Enter Birthdate'))}}
                                            </div>
                                        </div>

                                          <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Address</label>
                                            <div class="col-md-12">
                                                    {{Form::text('direccion', '', array('class' => 'form-control','placeholder'=>'Enter Address' ))}}
                                            </div>
                                        </div>

                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">City</label>
                                            <div class="col-md-12">
                                                  {{Form::text('ciudad', '', array('class' => 'form-control','placeholder'=>'Enter City' ))}}
                                              </div>
                                            </div>

                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Phone</label>
                                            <div class="col-md-12 date" id="datetimepicker7">
                                                   {{Form::text('telefono', '', array('class' => 'form-control','placeholder'=>'Enter Phone' ))}}
                                            </div>
                                        </div>
                                        
                                         <div class="form-group">
                                            <label class="col-md-3 control-label" for="example-password-input">Email</label>
                                            <div class="col-md-12">
                                                 {{Form::text('email', '', array('class' => 'form-control','placeholder'=>'Enter Email' ))}}
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

     
<script src="/dresses/assets/js/vendor-all.min.js"></script>
<script src="/dresses/assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="/dresses/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/dresses/assets/js/pcoded.min.js"></script>
<script src="/dresses/assets/js/menu-setting.js"></script>
<script src="/dresses/assets/js/plugins/bootstrap-datepicker.min.js"></script>
<script>
    arrows = {
        leftArrow: '<i class="feather icon-chevron-left"></i>',
        rightArrow: '<i class="feather icon-chevron-right"></i>'
    }
    // minimum setup
    $('#pc-datepicker-1').datepicker({
        todayHighlight: true,
        orientation: "bottom left",
        templates: arrows
    });

    // minimum setup for modal demo
    $('#pc-datepicker-1_modal').datepicker({
        todayHighlight: true,
        orientation: "bottom left",
        templates: arrows
    });

    // input group layout
    $('#pc-datepicker-2').datepicker({
        todayHighlight: true,
        orientation: "bottom left",
        templates: arrows
    });

    // input group layout for modal demo
    $('#pc-datepicker-2_modal').datepicker({
        todayHighlight: true,
        orientation: "bottom left",
        templates: arrows
    });

    // enable clear button
    $('#pc-datepicker-3, #pc-datepicker-3_validate').datepicker({
        todayBtn: "linked",
        clearBtn: true,
        todayHighlight: true,
        templates: arrows
    });

    // enable clear button for modal demo
    $('#pc-datepicker-3_modal').datepicker({
        todayBtn: "linked",
        clearBtn: true,
        todayHighlight: true,
        templates: arrows
    });

    // orientation
    $('#pc-datepicker-4_1').datepicker({
        orientation: "top left",
        todayHighlight: true,
        templates: arrows
    });

    $('#pc-datepicker-4_2').datepicker({
        orientation: "top right",
        todayHighlight: true,
        templates: arrows
    });

    $('#pc-datepicker-4_3').datepicker({
        orientation: "bottom left",
        todayHighlight: true,
        templates: arrows
    });

    $('#pc-datepicker-4_4').datepicker({
        orientation: "bottom right",
        todayHighlight: true,
        templates: arrows
    });

    // range picker
    $('#pc-datepicker-5').datepicker({
        todayHighlight: true,
        templates: arrows
    });

    // inline picker
    $('#pc-datepicker-6').datepicker({
        todayHighlight: true,
        templates: arrows
    });
</script>

@stop