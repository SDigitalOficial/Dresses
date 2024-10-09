@extends ('LayoutDafer.layout')
 
 @section('ContenidoSite-01')

<div class="container">
 <div class="col-md-12">
  <div class="content-header">
     <ul class="nav-horizontal text-center">
      <a class="btn btn-primary waves-effect waves-light" href="/dafer/crear-notas"><i class="fas fa-store"></i> Crear Nota</a>
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
 </div>    
</div>                            


<div class="container">
<div class="card">
 <div class="card-body">
  <h4 class="mt-0 header-title"><b>NOTAS REGISTRADAS</b></h4>
   <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

    <thead>
     <tr> 
      <th><b>ID</b></th>
      <th><b>Nota</b></th>
      <th><b>Usuario</b></th>
      <th><b>Proceso</b></th>
      <th><b>Fecha Creación</b></th>
      <th><b>Empresa</b></th>
      <th><b>Creación</b></th>
      <th><b>ACCIONES</b></th>
     </tr>
    </thead>
            
    <tbody>
      @foreach($notas as $notas)                        
      <tr>
       <td class="text-center"> {{$notas->id}}</td>
        <td class="text-center">
          {!! str_limit(strip_tags($notas->nota), 100) !!}
         </td>
        <td class="text-center">
          @foreach($usuarios as $usuariosa)
          @if($notas->user_id == $usuariosa->id)
          <span class="badge badge-primary">{{$usuariosa->name}}</span>
          @else
          @endif
          @endforeach
        </td>
        <td>
        @if($notas->proceso_id == 1)
         Registro de Negocios
        @elseif($notas->proceso_id == 2)
         Impuestos Corporativos
        @elseif($notas->proceso_id == 3)
         Impuestos Personales
        @elseif($notas->proceso_id == 4)
         Contabilidad
        @elseif($notas->proceso_id == 5)
         Licencias
        @elseif($notas->proceso_id == 6)
         Nómina
        @elseif($notas->proceso_id == 7)
         Acuerdos de Pago
        @elseif($notas->proceso_id == 8)
         Marketing
        @elseif($notas->proceso_id == 9)
         Aplicación de Beneficios
        @endif
    
        </td>
        <td>{{$notas->created_at}}</td>
        <td>
         @foreach($empresas as $empresasa)
         @if($notas->empresa_id == $empresasa->id)
         <span class="badge badge-dark"> {{$empresasa->n_negocio}}</span>
          @else
          @endif
         @endforeach
        </td>
        <td>
          {{$notas->updated_at}}
        </td>
        <td class="text-center">
        <div class="btn-group">
         <a href="<?=URL::to('/dafer/detalle-nota');?>/{{$notas->id}}" style="padding: 1px;"><span  id="tip" data-toggle="tooltip" data-placement="top" title="Cuentas Asignadas" class="btn btn-primary"><i class="far fa-list-alt"></i></span></a>
         <a href="<?=URL::to('dafer/eliminar-empresa/');?>/" style="padding: 1px;" onclick="return confirm('¿Está seguro que desea eliminar el registro?')"><button class="btn btn-danger" data-toggle="tooltip" data-placement="right" title="Eliminar Usuario"><i class="fas fa-trash-alt"></i></button></a>
        </div>
        </td>
       </tr>
       @endforeach
     
    </tbody>
   </table>
            
   </div>
  </div>
</div>
@stop

  