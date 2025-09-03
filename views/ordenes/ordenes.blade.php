@extends ('LayoutDresses.layout')
 @section('ContenidoSite-01')


 <div class="container">
  <?php $status=Session::get('status'); ?>
  @if($status=='ok_create')
   <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Cliente registrado con éxito</strong>
   </div>
  @endif

  @if($status=='ok_delete')
   <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Ciente eliminado con éxito</strong>
   </div>
  @endif

  @if($status=='ok_update')
   <div class="alert alert-warning">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Cliente actualizado con éxito</strong>
   </div>
  @endif

 </div>



<div class="container">
 <div class="col-sm-12">
  <div class="card">
   
   <div class="card-header table-card-header">
   <h5>Registered Clients</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="dt-responsive table-responsive">
                                            <table id="basic-btn" class="table table-striped table-bordered nowrap">
                                                <thead>
                                                    <tr>
                                                    
                                                     <th class="text-center">ID</th>
                                                     <th class="text-center">Order Date</th>
                                                     <th class="text-center">Event Date</th>
                                                     <th class="text-center">Client</th>
                                                     <th class="text-center">Seller</th>
                                                     <th class="text-center">Status</th>
                                                     <th class="text-center">Total</th>
                                                     <th class="text-center">Advance</th>
                                                     <th class="text-center">Amount Owed</th>
                                                     
                                                  
                                                     <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  @if($facturacion)
                                         @foreach($facturacion as $facturacion)
                                        <tr>
                                           
                                            <td class="text-center">{{ $facturacion->prefijo }}</td>
                                            <td class="text-center">{{ $facturacion->created_at->format('m-d-Y') }}</td>
                                            <td class="text-center"><span style="color:#FF00FF">{{ $facturacion->fecha_compra->format('m-d-Y') }}</span></td>
                                            @foreach($cliente as $clientes)
                                            @if($facturacion->cliente_id == $clientes->id)
                                            <td class="text-center">{{ $clientes->nombres}} {{ $clientes->apellidos}}</td>
                                            @endif
                                            @endforeach
                                            @foreach($users as $usersa)
                                            @if($facturacion->vendedor == $usersa->id)
                                            <td class="text-center">{{ $usersa->name }}</td>
                                            @endif
                                            @endforeach
                                            <td class="text-center">
                                             @if($facturacion->status == 'cancel')
                                               <span class="badge bg-danger"> Cancel</span>
                                             @elseif($facturacion->status == 'closed')
                                             <span class="badge bg-dark"> Closed</span> 
                                             @elseif($facturacion->status == 'ordered')
                                             <span class="badge bg-success"> Ordered</span> 
                                             @elseif($facturacion->status == 'storage') 
                                             <span class="badge bg-info"> Storage</span>
                                             @elseif($facturacion->status == 'open') 
                                             <span class="badge bg-warning"> Open</span>
                                             @endif 

                                            </td>
                                            <td class="text-center">{{ $facturacion->total}} USD</td>
                                             <td class="text-center">{{ $facturacion->adelanto + $facturacion->adelanto1 + $facturacion->adelanto2 + $facturacion->adelanto3 }} USD</td>
                                            <td class="text-center">
                                                @if($facturacion->monto_adeudado == 0)
                                                <span class="badge bg-success">full payment </span>
                                                @else
                                                <span class="badge bg-warning ">{{ $facturacion->monto_adeudado}} USD </span>
                                                @endif
                                          </td>
                                     
                                            <td class="text-center">
                                              <a href="<?=URL::to('orders/'. $facturacion->id.'/edit');?>" class="btn drp-icon btn-rounded btn-primary"
                                                type="button"><i class="fas fa-receipt"></i></a>

                                             @if($facturacion->t_persona =='natural')
                                               <a href="<?=URL::to('/gestion/factura/editar-cliente');?>/{{ $facturacion->id }}" class="btn drp-icon btn-rounded btn-secondary"
                                                type="button"><i class="fas fa-receipt"></i></a>
                                             @elseif($facturacion->t_persona =='juridica')
                                             <a href="<?=URL::to('gestion/factura/editar-cliente/juridica');?>/{{ $facturacion->id }}" class="btn drp-icon btn-rounded btn-secondary"
                                                type="button"><i class="fas fa-receipt"></i></a>
                                             @endif
                                              <script language="JavaScript">
                                              function confirmar ( mensaje ) {
                                              return confirm( mensaje );}
                                              </script>
                                              <a href="<?=URL::to('/orden/delete');?>/{{$facturacion->id}}" class="btn drp-icon btn-rounded btn-danger"
                                                type="button"  onclick="return confirmar('¿Está seguro que desea eliminar la Orden?')"><i class="fas fa-user-edit"></i></a>

                                
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
                                                 <th class="text-center">ID</th>
                                                 <th class="text-center">Order Date</th>
                                                 <th class="text-center">Event Date</th>
                                                 <th class="text-center">Client</th>
                                                 <th class="text-center">Seller</th>
                                                 <th class="text-center">Status</th>
                                                 <th class="text-center">Debt</th>
                                                 <th class="text-center">Total</th>
                                                 <th class="text-center">Amount Owed</th>
                                              
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




  @stop
