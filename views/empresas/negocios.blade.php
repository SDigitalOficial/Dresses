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


<!-- HTML5 Export Buttons table start -->
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header table-card-header">
                                        <h5>Registered Products
</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="dt-responsive table-responsive">
                                            <table id="basic-btn" class="table table-striped table-bordered nowrap">
                                                <thead>
                                                    <tr>
                                                       <th class="text-center">ID</th>
                                            <th class="text-center">Store</th>
                                            <th class="text-center">City</th>
                                            <th>Address</th>
                                            <th>Phone</th>
                                            <th>Actions</th> 
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                     @foreach($facturacion as $facturacion)
                                        <tr>
                                            <td class="text-center">{{ $facturacion->id }}</td>
                                            <td class="text-center">{{ $facturacion->nombre }}</td>
                                            <td class="text-center">{{ $facturacion->ciudad }}</td>
                                            <td class="text-center">{{ $facturacion->prefijo }}</td>
                                            <td class="text-center">{{ $facturacion->telefono }}</td>
                                            <td class="text-center">
                                             <a href="<?=URL::to('/dresses/edit/store');?>/{{ $facturacion->id }}"><span  id="tip" data-toggle="tooltip" data-placement="left" title="Ver Orden" class="btn drp-icon btn-rounded btn-warning"><i class="fas fa-edit"></i></span></a>
                                             <script language="JavaScript">
                                             function confirmar ( mensaje ) {
                                             return confirm( mensaje );}
                                             </script>
                                             @if($facturacion->id == 1)
                                             @else
                                             <a href="<?=URL::to('gestion/factura/eliminar-tienda');?>/{{$facturacion->id}}" onclick="return confirmar('¿Está seguro que desea eliminar el registro?')"><span id="tup" data-toggle="tooltip" data-placement="right" title="Eliminar producto" class="btn drp-icon btn-rounded btn-danger"><i class="fas fa-trash"></i></span></a>
                                             @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                                    
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                      <th class="text-center">ID</th>
                                            <th class="text-center">Store</th>
                                            <th class="text-center">City</th>
                                            <th>Address</th>
                                            <th>Phone</th>
                                            <th>Actions</th> 
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- HTML5 Export Buttons end -->

</div>





  @stop

