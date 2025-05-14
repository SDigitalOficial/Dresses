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
                                                    
                                                     <th class="text-center">Name</th>
                                                     <th class="text-center">Last Name</th>
                                                     <th class="text-center">Email</th>
                                                     <th class="text-center">Phone</th>
                                                     <th class="text-center">City</th>
                                                     <th class="text-center">Address</th>
                                                     <th class="text-center">Store</th>
                                                     <th class="text-center">Event Type</th>
                                                     <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  @if($facturacion)
                                         @foreach($facturacion as $facturacion)
                                        <tr>
                                           
                                            <td class="text-center">{{ $facturacion->nombres }}</td>
                                            <td>{{ $facturacion->apellidos }}</td>
                                            <td>{{ $facturacion->email}}</td>
                                            <td>{{ $facturacion->telefono }}</td>
                                            <td>{{ $facturacion->ciudad }}</td>
                                            <td>{{ $facturacion->direccion}}</td>
                                            <td>{{ $facturacion->tienda}}</td>
                                            <td>{{ $facturacion->tipo_evento }}</td>
                                     
                                            <td class="text-center">
                                              

                                             
                                               <a href="<?=URL::to('dresses/editar/cliente');?>/{{ $facturacion->id }}" class="btn drp-icon btn-rounded btn-secondary"
                                                type="button"><i class="fas fa-receipt"></i></a>
                                            
                                              <script language="JavaScript">
                                              function confirmar ( mensaje ) {
                                              return confirm( mensaje );}
                                              </script>
                                              <a href="<?=URL::to('/gestion/factura/eliminar-cliente/');?>/{{$facturacion->id}}" class="btn drp-icon btn-rounded btn-danger"
                                                type="button"  onclick="return confirmar('¿Está seguro que desea eliminar el registro?')"><i class="fas fa-user-edit"></i></a>

                                
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
                                                 <th class="text-center">Name</th>
                                                 <th class="text-center">Last Name</th>
                                                 <th class="text-center">Email</th>
                                                 <th class="text-center">Phone</th>
                                                 <th class="text-center">City</th>
                                                 <th class="text-center">Address</th>
                                                 <th class="text-center">Store</th>
                                                 <th class="text-center">Event Type</th>
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


<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>

    <script src="/adminsite/js/pages/tablesDatatables.js"></script>
        <script>$(function(){ TablesDatatables.init(); });</script>
  

  @stop
