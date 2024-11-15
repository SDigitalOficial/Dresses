@extends ('LayoutDresses.layout')

    @section('cabecera')
    @parent

   
    <link rel="stylesheet" href="/validaciones/dist/css/bootstrapValidator.css"/>

    <script type="text/javascript" src="/validaciones/vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="/validaciones/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/validaciones/dist/js/bootstrapValidator.js"></script>

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
    <li class="active">
     <a href="/gestion/factura/crear-producto"><i class="fa fa-shopping-basket"></i> Crear producto</a>
    </li>
    <li>
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


<div class="card">

 <div class="card-header">
  <h5>Product Create </h5>
 </div>

<div class="card-body">
    {{Form::open(array('method' => 'POST','oninput' => 'v_total.value=parseInt(v_unitario.value)*parseInt(cantidad.value)', 'class' => 'form-horizontal','id' => 'defaultForm', 'url' => array('/dresses/factura/creacion-producto'))) }}
 <div class="row g-4">



                                      <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                       <div class="form-group">
                                            <label for="example-nf-email">Product</label>
                                                 <select class="form-control input-sm" name="producto" id="producto">
                                             <option value="" disabled selected style="display: none;">Select Product</option>
                                              @foreach($categories as $category)
                                             <option value="{{$category->id}}">{{$category->producto}} - {{$category->identificador}}  </option>
                                              @endforeach
                                            </select>
                                        </div>
                                        </div>

                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                         <div class="form-group">
                                            <label for="example-nf-email">Unit value</label>
                                               <select class="form-control input-sm" name="v_unitario" id="v_unitario">
                                              <option value=""></option>
                                             </select>
                                        </div>
                                        </div>
                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                         <div class="form-group">
                                            <label for="example-nf-email">Tax</label>
                                                <select class="form-control input-sm" name="iva" id="iva">
                                              <option value=""></option>
                                             </select>
                                        </div>
                                        </div>

                                        <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                                        <div class="form-group">
                                            <label for="example-nf-email">Quantity</label>
                                                <input  type="number" class="form-control input-xl" min="1" name="cantidad" width="100%">   
                                        </div>
                                        </div>

                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                        <div class="form-group">
                                            <label for="example-nf-email">Discount</label>
                                              <input type="text" class="form-control input-sm" name="descuento" placeholder="Ingrese identificador">     
                                        </div>
                                        </div>

                                        <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                                        <div class="form-group">
                                            <label for="example-nf-email">Total value</label>
                                             <input class="form-control input-sm" name="v_total" for="v_unitario cantidad">
                                        </div>
                                         </div> 

                                         <div class="col-xs-2 col-sm-2 col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <label for="example-nf-email">Description</label>
                                             <textarea class="form-control input-sm" name="descripcion" placeholder="Enter Description"></textarea>
                                        </div>
                                         </div> 
                                     <div class="form-group hidden-sm hidden-xs hidden-md hidden-lg hidden-xl" style="display:none">
                                         <label for="">Product</label>
                                          <select class="form-control input-sm" name="product" id="product">
                                           <option value=""></option>
                                          </select>
                                        </div>
                                        <input type="hidden" name="identificador" value="{{Request::segment(2)}}">
                                      
                                       @foreach($retefuente as $retefuente)
                                         <input type="hidden" name="retefuente" id="input" class="form-control" value="{{$retefuente->retefuente}}">
                                         <input type="hidden" name="cliente" id="input" class="form-control" value="{{$retefuente->cliente_id}}">
                                        @endforeach

                                          <div class="form-group form-actions">
                                            <div class="col-md-9">
                                                <button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-angle-right"></i> Submit</button>
                                                <button type="reset" class="btn btn-sm btn-warning"><i class="fa fa-repeat"></i> Reset</button>
                                            </div>
                                        </div>
                                   

                                         
 </div>
  {{ Form::close() }}
</div>








<div class="container">
<table class="table table-striped">
  <thead bgcolor="#fafcfc">
    <tr>
       <th>Id</th>
      <th>Producto</th>
      <th>Cantidad</th>
      <th>Iva</th>
      <th>Valor total</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
      @foreach($facturacion as $facturacion)
    <tr>
       <td>{{ $facturacion->id }}</td>
       <td>{{ $facturacion->product }}</td>
       <td>{{ $facturacion->cantidad}}</td>
       <td>{{ $facturacion->iva}} %</td>
       <td>$ {{ number_format($facturacion->v_total,  0, ",", ".")}}</td>
      <td>
       <a href="<?=URL::to('gestion/factura/editar-producto');?>/{{ $facturacion->id }}"><span  id="tip" data-toggle="tooltip" data-placement="left" title="Editar producto" class="btn drp-icon btn-rounded btn-warning"><span class="fas fa-edit"></span></span></a>
        <script language="JavaScript">
        function confirmar ( mensaje ) {
        return confirm( mensaje );}
        </script>
       <a href="<?=URL::to('gestion/factura/eliminar-producto');?>/{{$facturacion->id}}" onclick="return confirmar('¿Está seguro que desea eliminar el registro?')"><span id="tup" data-toggle="tooltip" data-placement="right" title="Eliminar producto" class="btn drp-icon btn-rounded btn-danger"><span class="fas fa-trash-alt"></span></span></a>
      </td>
    </tr>
     @endforeach
  </tbody>
</table>
</div>

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
                    regexp: {
                        regexp: /^[ a-zA-Z0-9_\.ñáéíóú]+$/,
                        message: 'The username can only consist of alphabetical, number, dot and underscore'
                    }
                }
            },
             cantidad: {
                message: 'The username is not valid',
                validators: {
                    notEmpty: {
                        message: 'Este campo es obligatorio'
                    },
                    regexp: {
                        regexp: /^[ a-zA-Z0-9_\.ñáéíóú]+$/,
                        message: 'The username can only consist of alphabetical, number, dot and underscore'
                    }
                }
            },
          
        }
    });
});
</script>


<script src="/adminsite/js/pages/tablesDatatables.js"></script>
<script>$(function(){ TablesDatatables.init(); });</script>

 <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
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

   

  @stop