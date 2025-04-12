@extends ('LayoutDresses.layout')
     @section('cabecera')
    @parent
    <link rel="stylesheet" href="/validaciones/dist/css/bootstrapValidator.css"/>

    <script type="text/javascript" src="/validaciones/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="/validaciones/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/validaciones/dist/js/bootstrapValidator.js"></script>
    @stop


  @section('ContenidoSite-01')




 <div class="container">
  <?php $status=Session::get('status'); ?>
  @if($status=='ok_create')
   <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Producto registrado con éxito</strong>
   </div>
  @endif

  @if($status=='ok_delete')
   <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Producto eliminado con éxito</strong>
   </div>
  @endif

  @if($status=='ok_update')
   <div class="alert alert-warning">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Producto actualizado con éxito</strong>
   </div>
  @endif

 </div>



<div class="container">

<div class="col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Create Product</h5>
                                    </div>
                                    <div class="card-body">
                                       
                                        {{ Form::open(array('method' => 'POST','class' => 'row g-3 needs-validation','id' => 'defaultForm', 'url' => array('/dresses/editar/producto/'.$producto->id))) }}
                                            <div class="col-md-6 position-relative">
                                                <label for="validationTooltip01" class="form-label">Product</label>
                                                {{Form::text('nombre', $producto->nombre, array('class' => 'form-control','placeholder'=>'Enter Product' ))}}
                                                <div class="valid-tooltip"> Looks good! </div>
                                            </div>

                                             <div class="col-md-6 position-relative">
                                                <label for="validationTooltip02" class="form-label">Price</label>
                                                
                                                    {{Form::text('precio', $producto->precio, array('class' => 'form-control','placeholder'=>'Enter Price'))}}
                                                    <div class="invalid-tooltip"> Please choose a unique and valid
                                                        username. </div>
                                              
                                            </div>

                                           
                                           
                                            <div class="col-md-6 position-relative">
                                                <label for="validationTooltip02" class="form-label">Color</label>
                                                
                                                    {{Form::text('color', $producto->color, array('class' => 'form-control','placeholder'=>'Enter Color'))}}
                                                    <div class="invalid-tooltip"> Please choose a unique and valid
                                                        username. </div>
                                              
                                            </div>

                                            <div class="col-md-6 position-relative">
                                                <label for="validationTooltip02" class="form-label">Size</label>
                                                
                                                    {{Form::text('talla', $producto->talla, array('class' => 'form-control','placeholder'=>'Enter Size'))}}
                                                    <div class="invalid-tooltip"> Please choose a unique and valid
                                                        username. </div>
                                              
                                            </div>
                                            
                                            <div class="col-md-6 position-relative">
                                                <label for="validationTooltip03" class="form-label">Identifier</label>
                                                {{Form::text('identificador', $producto->identificador, array('class' => 'form-control','placeholder'=>'Enter Identifier'))}}
                                                <div class="invalid-tooltip"> Please provide a valid city. </div>
                                            </div>

                                             <div class="col-md-6 position-relative">
                                                <label for="validationTooltip03" class="form-label">Quantity</label>
                                                {{Form::text('cantidad', $producto->cantidad, array('class' => 'form-control','placeholder'=>'Enter Identifier'))}}
                                                <div class="invalid-tooltip"> Please provide a valid city. </div>
                                            </div>

                                         


                                            
                                            <div class="col-12">
                                                <button class="btn btn-primary" type="submit">Submit form</button>
                                            </div>
                                         {{Form::close()}}
                                    </div>
                                </div>
                                
                            </div>


</div>






<script src="/adminsite/js/pages/tablesDatatables.js"></script>
<script>$(function(){ TablesDatatables.init(); });</script>

{{ Html::script('//cdnjs.cloudflare.com/ajax/libs/jquery.bootstrapvalidator/0.5.0/js/bootstrapValidator.min.js') }}
<script>
  $('#producto').on('change',function(e){
  console.log(e);
  var cat_id = e.target.value;
  $.get('/{{Request::path()}}/ajax-subcat?cat_id=' + cat_id, function(data){
  $('#v_unitario').empty();
  $.each(data, function(index, subcatObj){
  $('#v_unitario').append('<option value="'+subcatObj.precio+'">'+subcatObj.precio+'</option>');
  });
  $('#iva').empty();
  $.each(data, function(index, subcatObj){
  $('#iva').append('<option value="'+subcatObj.iva+'">'+subcatObj.iva+'</option>');
  });
  $('#product').empty();
  $.each(data, function(index, subcatObj){
  $('#product').append('<option value="'+subcatObj.producto+'">'+subcatObj.producto+'</option>');
  });
  });
  });

    </script>


<script type="text/javascript">
$(document).ready(function() {
    $('#defaultForm').bootstrapValidator({
        message: 'This value is not valid',
        feedbackIcons: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
          
    
            producto: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'Este campo es obligatorio'
                    },
                     stringLength: {
                        min: 2,
                        max: 100,
                        message: 'El campo producto debe contener un minimo de 2 y un maximo de 100 Caracteres'
                    }
                }
            },
           iva: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'Campo obligatorio'
                    },
                     stringLength: {
                        min: 1,
                        max: 3,
                        message: 'El campo IVA debe contener un minimo de 1 y un maximo de 3 Caracteres'
                    },
                    regexp: {
                        regexp: /^[0-9.]+$/,
                        message: 'Campo numerico'
                    }
                }
            },
            precio: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'Este campo es obligatorio'
                    },
                     stringLength: {
                        min: 2,
                        max: 15,
                        message: 'El campo precio debe contener un minimo de 2 y un maximo de 15 Caracteres'
                    },
                    regexp: {
                        regexp: /^[0-9]+$/,
                        message: 'Campo numérico'
                    }
                }
            },
            identificador: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'Este campo es obligatorio'
                    },
                     stringLength: {
                        min: 2,
                        max: 50,
                        message: 'El campo identificador debe contener un minimo de 2 y un maximo de 50 Caracteres'
                    }
                }
            },
    
        }
    });
});
</script>

  @stop