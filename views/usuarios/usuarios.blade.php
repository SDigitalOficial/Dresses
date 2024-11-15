@extends ('LayoutDresses.layout')


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


  <div class="content-header"> 
   <ul class="nav-horizontal text-center"> <a class="btn btn-primary waves-effect waves-light" href="/dresses/crear-usuario"><i class="fa fa-user-plus"></i> Create User</a>
   </ul>
  </div>

<div class="container">
 <div class="col-md-10 offset-md-1">
                           
  <div class="card">
   <div class="card-body">
    
    <h4 class="mt-0 header-title"><b>Registered Users</b></h4>
                                           
    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

     <thead>
      <tr>
       <th><b>NAME</b></th>
       <th><b>LAST NAME</b></th>
       <th><b>EMAIL</b></th>
       <th><b>ADDRESS</b></th>
       <th><b>PHONE</b></th>
       <th><b>ROLE</b></th>
       <th><b>ACTIONS</b></th>
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
        <a href="<?=URL::to('dresses/editar/');?>/{{ $user->id }}" style="padding: 1px;"><span  id="tip" data-toggle="tooltip" data-placement="top" title="Edit User" class="btn drp-icon btn-rounded btn-warning"><span class="fas fa-edit"></span></a>
        <a href="<?=URL::to('dresses/eliminar/');?>/{{$user->id}}" style="padding: 1px; onclick="return confirm('¿Está seguro que desea eliminar el registro?')"><button class="btn drp-icon btn-rounded btn-danger" data-toggle="tooltip" data-placement="right" title="Delete User"><span class="fas fa-trash-alt"></span></button></a>
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