@extends ('LayoutDafer.layout')

 

  @section('ContenidoSite-01')







                            <div class="row">
                                <div class="col-md-10 offset-md-1">

                                                                 <div class="content-header">
 <ul class="nav-horizontal text-center">

 

   <a class="btn btn-primary waves-effect waves-light" href="/dafer/crear-producto"><i class="fas fa-shopping-bag"></i> Crear Producto</a>

 </ul>

 <div class="container">
  <?php $status=Session::get('status'); ?>
  @if($status=='ok_create')
   <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Producto y/o Servicio Registrado Con Exito</strong>
   </div>
  @endif

  @if($status=='ok_delete')
   <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Producto y/o Servicio Eliminado Con Exito</strong>
   </div>
  @endif

  @if($status=='ok_update')
   <div class="alert alert-warning">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Producto y/o Servicio Actualziado Con Exito</strong>
   </div>
  @endif

 </div>
</div>
                                    <div class="card">
                                        <div class="card-body">
            
                                            <h4 class="mt-0 header-title"><b>Productos y/o Servicios Registrados</b></h4>
                                            <p class="text-muted  font-14">The Buttons extension for DataTables
                                                provides a common set of options, API methods and styling to display
                                                buttons on a page that will interact with a DataTable. The core library
                                                provides the based framework upon which plug-ins can built.
                                            </p>
            
                                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                                <thead>

                                                <tr>
                                                    <th><b>Producto/Servicio</b></th>
                                                    <th><b>Creado</b></th>
                                                    <th><b>Actualziado</b></th>
                                                    <th><b>ACCIONES</b></th>
                                                </tr>
                                                </thead>
            
            
                                                <tbody>
           @foreach($productos as $productos)                                      
         <tr>
          <td class="text-center">{{ $productos->producto}}</td>
        
          <td>{{$productos->created_at}}</td>
   
          <td>{{$productos->updated_at}}</td>
          
          <td class="text-center">
           <div class="btn-group">
           
       <a href="<?=URL::to('dafer/editar-producto');?>/{{$productos->id}}" style="padding: 1px;"><span  id="tip" data-toggle="tooltip" data-placement="top" title="Editar Usuario" class="btn btn-primary"><i class="mdi mdi-tooltip-edit"></i></span></a>
       <!--
           <a href="<?=URL::to('dafer/eliminar-producto/');?>/{{$productos->id}}" style="padding: 1px;" onclick="return confirm('¿Está seguro que desea eliminar el registro?')"><button ="button" class="btn btn-danger" data-toggle="tooltip" data-placement="right" title="Eliminar Usuario"><i class="fas fa-trash-alt"></i></button></a>
       -->
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