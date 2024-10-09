@extends ('LayoutDafer.layout')

 

  @section('ContenidoSite-01')

 <div class="row">
  <div class="col-md-10 offset-md-1">
   <div class="content-header">
 
   <ul class="nav-horizontal text-center">
   <a class="btn btn-primary waves-effect waves-light" href="/dafer/crear-socio"><i class="mdi mdi-bank"></i> Crear Socio</a>

 </ul>
  <div class="container">
  <?php $status=Session::get('status'); ?>
  @if($status=='ok_create')
   <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Banco registrado con éxito</strong>
   </div>
  @endif

  @if($status=='ok_delete')
   <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Banco eliminado con éxito</strong>
   </div>
  @endif

  @if($status=='ok_update')
   <div class="alert alert-warning">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Banco actualizado con éxito</strong>
   </div>
  @endif

 </div>
</div>

<div class="card">
 <div class="card-body">
  
  <h4 class="mt-0 header-title"><b>Socios Registrados</b></h4>
   
   <p class="text-muted  font-14">The Buttons extension for DataTables provides a common set of options, API methods and styling to display buttons on a page that will interact with a DataTable. The core library provides the based framework upon which plug-ins can built.
   </p>
            
   <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" width="100%" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    
    <thead>
     <tr>
      <th><b>Nombres</b></th>
      <th><b>Apellidos</b></th>
      <th><b>Cargo</b></th>
      <th><b>Porcentaje participación</b></th>
      <th><b>Empresa</b></th>
      <th><b>ACCIONES</b></th>
     </tr>
    </thead>
    
    <tbody>
     @foreach($socios as $socios)                                      
      <tr>
       <td class="text-center">{{ $socios->nombres}}</td>
       <td class="text-center">{{ $socios->apellidos}}</td>
       <td class="text-center">{{ $socios->cargo}}</td>
       <td class="text-center">{{ $socios->porcentaje}}%</td>
       @foreach($empresas as $empresass)
       @if($empresass->id == $socios->empresa_id)
       <td class="text-center">{{ $empresass->n_negocio}}</td>
       @endif
       @endforeach
       <td class="text-center">
       
       <div class="btn-group">
        <a href="<?=URL::to('dafer/editar-socio');?>/{{$socios->id}}" style="padding: 1px;"><span  id="tip" data-toggle="tooltip" data-placement="top" title="Editar Usuario" class="btn btn-primary"><i class="mdi mdi-tooltip-edit"></i></span></a>
        <a href="<?=URL::to('dafer/eliminar-socio/');?>/{{$socios->id}}" style="padding: 1px;" onclick="return confirm('¿Está seguro que desea eliminar el registro?')"><button ="button" class="btn btn-danger" data-toggle="tooltip" data-placement="right" title="Eliminar Usuario"><i class="fas fa-trash-alt"></i></button></a>
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