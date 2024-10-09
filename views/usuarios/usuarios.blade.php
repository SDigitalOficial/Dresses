@extends ('LayoutDafer.layout')


 @section('ContenidoSite-01')

<div class="col-md-10 offset-md-1">
  <div class="container">
   <?php $status=Session::get('status'); ?>
   @if($status=='ok_create')
    <div class="alert alert-success">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
     <strong>Usuario registrado con éxito</strong> CMS...
    </div>
   @endif

   @if($status=='ok_delete')
    <div class="alert alert-danger">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
     <strong>Usuario eliminado con éxito</strong> CMS...
    </div>
   @endif

   @if($status=='ok_update')
    <div class="alert alert-warning">
     <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
     <strong>Usuario actualizado con éxito</strong> CMS...
    </div>
   @endif
  </div>
</div>


  





                            <div class="row">
                                <div class="col-md-10 offset-md-1">

                                                                 <div class="content-header">
 <ul class="nav-horizontal text-center">

   <a class="btn btn-primary waves-effect waves-light" href="/dafer/crear-usuario"><i class="fa fa-user-plus"></i> Crear Usuario</a>

 </ul>
</div>
                                    <div class="card">
                                        <div class="card-body">
            
                                            <h4 class="mt-0 header-title"><b>USUARIOS REGISTRADOS</b></h4>
                                            <p class="text-muted  font-14">The Buttons extension for DataTables
                                                provides a common set of options, API methods and styling to display
                                                buttons on a page that will interact with a DataTable. The core library
                                                provides the based framework upon which plug-ins can built.
                                            </p>
            
                                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                                <thead>

                                                <tr>
                                                    <th><b>NOMBRE</b></th>
                                                    <th><b>APELLIDO</b></th>
                                                    <th><b>EMAIL</b></th>
                                                    <th><b>DIRECCION</b></th>
                                                    <th><b>TELEFONO</b></th>
                                                    <th><b>ROL</b></th>
                                                    <th><b>ACCIONES</b></th>
                                                </tr>
                                                </thead>
            
            
                                                <tbody>
                                                 @foreach($users as $user)
         <tr>
          <td class="text-center">{{$user->name}}</td>
          <td class="text-center">{{$user->last_name}}</td>
          <td>{{$user->email}}</td>
          <td>{{$user->address}}</td>
          <td>{{$user->phone}}</td>
          <td>{{$user->rol_id}}</td>
          <td class="text-center">
           <div class="btn-group">
           
           <a href="<?=URL::to('dafer/editar/');?>/{{ $user->id }}" style="padding: 1px;"><span  id="tip" data-toggle="tooltip" data-placement="top" title="Editar Usuario" class="btn btn-primary"><i class="fas fa-user-edit"></i></span></a>
           <a href="<?=URL::to('dafer/eliminar/');?>/{{$user->id}}" style="padding: 1px; onclick="return confirm('¿Está seguro que desea eliminar el registro?')"><button ="button" class="btn btn-danger" data-toggle="tooltip" data-placement="right" title="Eliminar Usuario"><i class="fas fa-trash-alt"></i></button></a>
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