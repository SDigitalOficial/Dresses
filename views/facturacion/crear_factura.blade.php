@extends ('LayoutDresses.layout')
  @section('ContenidoSite-01')

 

  <div class="content-header"> 
   <ul class="nav-horizontal text-center"> <a class="btn btn-primary waves-effect waves-light" href="/dresses/factura/crear-facturacion/{{$contenido->id}}"><i class="fa fa-user-plus"></i> Create Invoice</a>
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
                                        <h5>Registered Orders  


</h5>
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
                                             <a href="<?=URL::to('Facturacione');?>/{{ $facturacion->id }}"><span  id="tip" data-toggle="tooltip" data-placement="left" title="Crear productos" class="btn drp-icon btn-rounded btn-primary"><i class="fas fa-tags"></i></span></a>
         <a href="<?=URL::to('gestion/factura/editar-factura');?>/{{ $facturacion->id }}"><span  id="tip" data-toggle="tooltip" data-placement="top" title="Editar factura" class="btn drp-icon btn-rounded btn-warning"><i class="fas fa-edit"></i></span></a>
      <script language="JavaScript">
function confirmar ( mensaje ) {
return confirm( mensaje );}
</script>
   
  <a href="<?=URL::to('dresses/factura/generar-factura/');?>/{{$facturacion->id}}" target="_blank"><span id="tup" data-toggle="tooltip" data-placement="bottom" title="Factura original" class="btn drp-icon btn-rounded btn-success"><span class="fas fa-clipboard-list"></span></span></a>
 
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
                                                     <th class="text-center">Id Order</th>
                                                     <th class="text-center">Bill To</th>
                                                     <th>Fecha Emisión</th>
                                                     <th>Fecha Vencimiento</th>
                                                     <th>User</th>
                                                     <th>Store</th>
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
