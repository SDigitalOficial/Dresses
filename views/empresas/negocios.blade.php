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
                                            <td class="text-center">{{ $facturacion->r_social }}</td>
                                            <td>{{ $facturacion->ciudad }}</td>
                                            <td>{{ $facturacion->direccion }}</td>
                                            <td class="text-center">{{ $facturacion->telefono}}</td>
                                            <td class="text-center">
                                             <a href="<?=URL::to('/dresses/factura/editar-empresa');?>/{{ $facturacion->id }}"><span  id="tip" data-toggle="tooltip" data-placement="left" title="Editar producto" class="btn btn-primary"><i class="fa fa-pencil-square-o sidebar-nav-icon"></i></span></a>
                                             <script language="JavaScript">
                                             function confirmar ( mensaje ) {
                                             return confirm( mensaje );}
                                             </script>
                                             <a href="<?=URL::to('gestion/factura/eliminar-almacen');?>/{{$facturacion->id}}" onclick="return confirmar('¿Está seguro que desea eliminar el registro?')"><span id="tup" data-toggle="tooltip" data-placement="right" title="Eliminar producto" class="btn btn-danger"><i class="hi hi-trash sidebar-nav-icon"></i></span></a>
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

