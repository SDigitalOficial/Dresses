@extends ('LayoutDafer.layout')

 

  @section('ContenidoSite-01')


 



                            <div class="row">
                                <div class="col-md-12">

                                                                 <div class="content-header">
 <ul class="nav-horizontal text-center">
  <a class="btn btn-primary waves-effect waves-light" href="/dafer/crear-empresa"><i class="fas fa-store"></i> Crear Cliente</a>
</ul>
<div class="container">
  <?php $status=Session::get('status'); ?>
  @if($status=='ok_create')
   <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>CLIENTE REGISTRADO CON EXITO</strong>
   </div>
  @endif

  @if($status=='ok_delete')
   <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>CLIENTE ELIMINADO CON EXITO</strong>
   </div>
  @endif

  @if($status=='ok_update')
   <div class="alert alert-warning">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>CLIENTE ACTUALIZADO CON EXITO</strong>
   </div>
  @endif

 </div>
</div>
                                    <div class="card">
                                        <div class="card-body">
            
                                            <h4 class="mt-0 header-title"><b>CLIENTES REGISTRADOS</b></h4>
                                            
            
                                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                                <thead>

                                                <tr> 
                                                    <th><b>Detalle</b></th>
                                                    <th><b>Tipo</b></th>
                                                    <th><b>Cliente</b></th>
                                                    <th><b>Tipo ID</b></th>
                                                    <th><b>Número ID</b></th>

                                                    <th><b>Representante</b></th>
                                                    <th><b>Estado</b></th>
                                                    <th><b>ACCIONES</b></th>
                                                </tr>
                                                </thead>
            
            
                                                <tbody>
           @foreach($facturacion as $facturacion)                                      
         <tr>
            <td> <a href="<?=URL::to('dafer/resumen-cliente');?>/{{$facturacion->id}}" style="padding: 1px;"><span  id="tip" data-toggle="tooltip" data-placement="left" title="Detalle Empresa" class="btn btn-primary"><i class="mdi mdi-eye"></i></span></a></td>
          <td class="text-center">
            @if($facturacion->tipo == 1)
            <a href="/dafer/notas-empresa/{{$facturacion->id}}"> <span class="badge badge-secondary">Empresa</span></td></a>
            @else
            <a href="/dafer/notas-empresa/{{$facturacion->id}}"> <span class="badge badge-primary">Individual</span></td></a>
            @endif
          <td class="text-center">
              {{$facturacion->n_negocio}}
          </td>
          <td>
              @if($facturacion->t_identificacion == '1')
              EIN
              @elseif($facturacion->t_identificacion == '2')
              Seguro Social
              @elseif($facturacion->t_identificacion == '3')
              Número ITIN
              @endif
          </td>
          <td>{{ $facturacion->n_identificacion}}</td>
          <td>{{ $facturacion->representante}}</td>
          <td>
            @if($facturacion->s_actual == 1)
            <span class="badge badge-success">Activo</span>
            @elseif($facturacion->s_actual == 2)
            <span class="badge badge-primary">Inactivo</span>
            @else
            <span class="badge badge-danger"> Saldo Pendiente</span>
            @endif
        </td>
          <td class="text-center">
           <div class="btn-group">
        <a href="<?=URL::to('dafer/socios-empresa');?>/{{$facturacion->id}}" style="padding: 1px;"><span  id="tip" data-toggle="tooltip" data-placement="left" title="Ver Socios" class="btn btn-primary"><i class="fas fa-users"></i></span></a>   
       <a href="<?=URL::to('dafer/editar-empresa');?>/{{$facturacion->id}}" style="padding: 1px;"><span  id="tip" data-toggle="tooltip" data-placement="top" title="Editar Empresa" class="btn btn-primary"><i class="mdi mdi-tooltip-edit"></i></span></a>
       <a href="<?=URL::to('dafer/pagos');?>/{{$facturacion->id}}" style="padding: 1px;"><span  id="tip" data-toggle="tooltip" data-placement="bottom" title="Registrar Pagos Contables" class="btn btn-primary"><i class="fas fa-money-check"></i></span></a>
       <a href="<?=URL::to('dafer/informacion-bancaria');?>/{{$facturacion->id}}" style="padding: 1px;"><span  id="tip" data-toggle="tooltip" data-placement="top" title="Información Bancaria" class="btn btn-primary"><i class="mdi mdi-bank"></i></span></a>
       <a href="<?=URL::to('dafer/informacion-producto');?>/{{$facturacion->id}}" style="padding: 1px;"><span  id="tip" data-toggle="tooltip" data-placement="bottom" title="Productos/Servicios" class="btn btn-primary"><i class="fas fa-shopping-bag"></i></span></a>
       <a href="<?=URL::to('dafer/cuentas-asignadas');?>/{{$facturacion->id}}" style="padding: 1px;"><span  id="tip" data-toggle="tooltip" data-placement="top" title="Cuentas Asignadas" class="btn btn-primary"><i class="far fa-list-alt"></i></span></a>
           <a href="<?=URL::to('dafer/eliminar-empresa/');?>/{{$facturacion->id}}" style="padding: 1px;" onclick="return confirm('¿Está seguro que desea eliminar el registro?')"><button class="btn btn-danger" data-toggle="tooltip" data-placement="right" title="Eliminar Usuario"><i class="fas fa-trash-alt"></i></button></a>
           </div>
          </td>
         </tr>
         @endforeach
     
                                                </tbody>
                                            </table>
            
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->
  

  @stop

  
     