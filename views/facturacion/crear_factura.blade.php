@extends ('LayoutDresses.layout')
  @section('ContenidoSite-01')

   <div class="content-header">
   <ul class="nav-horizontal text-center">
    <li class="active">
     <a href="/dresses/factura/crear-facturacion/{{$contenido->id}}"><i class="hi hi-list-alt"></i> Crear factura</a>
    </li>
    <li>
     <a href="/gestion/factura"><i class="fa fa-users"></i> Clientes</a>
    </li>
    <li>
     <a href="/gestion/factura/factura-cliente"><i class="fa fa-user-plus"></i> Crear cliente</a>
    </li>
    <li>
     <a href="/dresses/factura/crear-producto"><i class="fa fa-shopping-basket"></i> Crear producto</a>
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
    <strong>Factura registrada con éxito</strong>
   </div>
  @endif

  @if($status=='ok_delete')
   <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Factura eliminada con éxito</strong>
   </div>
  @endif

  @if($status=='ok_update')
   <div class="alert alert-warning">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Factura actualizada con éxito</strong>
   </div>
  @endif

 </div>




<div class="container">
  
<!-- HTML5 Export Buttons table start -->
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header table-card-header">
                                        <h5>Registered Orders</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="dt-responsive table-responsive">
                                            <table id="basic-btn" class="table table-striped table-bordered nowrap">
                                                <thead>
                                                    <tr>
                                                     <th class="text-center">Id Order</th>
                                                     <th class="text-center">Bill To</th>
                                                     <th>Fecha Emisión</th>
                                                     <th>Fecha Vencimiento</th>
                                                     <th>User</th>
                                                     <th>Store</th>
                                                     <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if($facturacion)
                                         @foreach($facturacion as $facturacion)
                                        <tr>
                                            <td class="text-center">{{ $facturacion->id }}</td>
                                            <td class="text-center">{{ $facturacion->dirigido }}</td>
                                            <td>{{ $facturacion->f_emision }}</td>
                                            <td>{{ $facturacion->f_vencimiento}}</td>
                                            @foreach($usuarios as $usuariosa)
                                            @if($facturacion->user_id == $usuariosa->id)
                                            <td><span class="badge badge-light-warning">{{ $usuariosa->name}}</span></td>
                                            @endif
                                            @endforeach
                                             @foreach($empresa as $empresas)
                                             @if($facturacion->region_id == $empresas->id)
                                            <td><span class="badge badge-light-primary">{{ $empresas->r_social}}</span></td>
                                            @endif
                                            @endforeach
                                            <td class="text-center">
                                             <a href="<?=URL::to('Facturacione');?>/{{ $facturacion->id }}"><span  id="tip" data-toggle="tooltip" data-placement="left" title="Crear productos" class="btn btn-warning"><i class="fa fa-list-alt sidebar-nav-icon"></i></span></a>
         <a href="<?=URL::to('gestion/factura/editar-factura');?>/{{ $facturacion->id }}"><span  id="tip" data-toggle="tooltip" data-placement="top" title="Editar factura" class="btn btn-primary"><i class="fa fa-pencil-square-o sidebar-nav-icon"></i></span></a>
      <script language="JavaScript">
function confirmar ( mensaje ) {
return confirm( mensaje );}
</script>
   
  <a href="<?=URL::to('dresses/factura/generar-factura/');?>/{{$facturacion->id}}" target="_blank"><span id="tup" data-toggle="tooltip" data-placement="bottom" title="Factura original" class="btn btn-info"><span class="fa fa-file"></span></span></a>
  <a href="<?=URL::to('gestion/factura/generar-facturacopia/');?>/{{$facturacion->id}}" target="_blank"><span id="tup" data-toggle="tooltip" data-placement="right" title="Factura copia" class="btn btn-info"><span class="fa fa-clipboard"></span></span></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                         @else
                                          <div class="alert alert-danger fade in">
                                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                                          <strong>NO</strong> hay usuarios registrados aun.</div>
                                         @endif
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                     <th class="text-center">Id Factura</th>
                                                     <th class="text-center">Dirigido</th>
                                                     <th>Fecha Emisión</th>
                                                     <th>Fecha Vencimiento</th>
                                                     <th class="text-center">Actions</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- HTML5 Export Buttons end -->

</div>




<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
  @stop
