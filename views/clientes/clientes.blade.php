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
                                                     <th>Document Type</th>
                                                     <th># Document</th>
                                                     <th>City</th>
                                                     <th>Birthdate</th>
                                                     <th class="text-center">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  @if($facturacion)
                                         @foreach($facturacion as $facturacion)
                                        <tr>
                                           
                                            <td class="text-center">{{ $facturacion->p_nombre }} {{ $facturacion->p_apellido }}</td>
                                            <td>
                                              @if($facturacion->t_documento == 1)
                                               NIT
                                              @elseif($facturacion->t_documento == 2)
                                               Cédula Ciudadania
                                              @elseif($facturacion->t_documento == 3)
                                               Cédula  Extranjeria
                                              @endif
                                            </td>
                                            <td>{{ $facturacion->documento}}</td>
                                            <td>{{ $facturacion->ciudad }}</td>
                                            <td>{{ $facturacion->ingreso }}</td>
                                            <td class="text-center">
                                              <a href="<?=URL::to('/dresses/factura/lista-facturas');?>/{{ $facturacion->id }}" class="btn drp-icon btn-rounded btn-primary"
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
                                              <a href="<?=URL::to('/gestion/factura/eliminar-cliente/');?>/{{$facturacion->id}}" class="btn drp-icon btn-rounded btn-warning"
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
                                                     <th>Document Type</th>
                                                     <th># Document</th>
                                                     <th>City</th>
                                                     <th>Birthdate</th>
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
