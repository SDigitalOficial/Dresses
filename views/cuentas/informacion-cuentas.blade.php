@extends ('LayoutDafer.layout')

 

  @section('ContenidoSite-01')

@if(Auth::user()->rol_id == 31)


@else
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


 <div class="col-md-10 offset-md-1">
                                <div class="row">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">Inline Form</h4>
                                            <p class="text-muted font-14">Use the <code>.form-inline </code>class to display a series of labels, form controls, and buttons on a single horizontal row. 
                                                Form controls within inline forms vary slightly from their default states..</p>
                                            <div class="general-label">
                                                {{ Form::open(array('method' => 'POST','class' => 'form-horizontal','id' => 'defaultForm1', 'url' => array('dafer/crear-cuentas'))) }}
                                                    <div class="form-group m-l-10">
                                                        <label class="col-md-3 control-label" for="example-select">Plataforma</label>
                                                        <input type="text" class="form-control ml-2" name="plataforma" id="exampleInputEmail2" placeholder="Ingresa Plataforma" required>
                                                    </div>
                                                        
                                                    <div class="form-group m-l-10">
                                                    
                                                        <label class="col-md-3 control-label" for="example-select">Correo/usuario</label>
                                                        <input type="text" class="form-control ml-2" name="correo" id="exampleInputPassword2" placeholder="Ingrese Correo/Usuario" required>
                                                    </div>

                                                    <div class="form-group m-l-10">
                                                        <label class="col-md-3 control-label" for="example-select">Contraseña</label>
                                                        <input type="text" class="form-control ml-2" name="contrasena" id="exampleInputPassword2" placeholder="Ingrese Contraseña" required>

                                                        <input type="hidden" class="form-control ml-2" value="{{Request::segment(3)}}" name="empresa_id" id="exampleInputPassword2" placeholder="Password">
                                                    </div>

                                                    <div class="form-group m-l-10">
                                                        <label class="col-md-3 control-label" for="example-select">Información Adicional</label>
                                                        <textarea class="form-control ml-2" name="informacion" id="exampleInputPassword2" placeholder="Información Adicional" required></textarea>
                                                    </div>
                                                   
                                                    <button type="submit" class="btn btn-primary ml-2">Crear Plataforma</button>
                                               {{ Form::close() }}         
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

@endif

                            <div class="row">
                                <div class="col-md-10 offset-md-1">

                                                                 <div class="content-header">
 
</div>
                                    <div class="card">
                                        <div class="card-body">
            
                                            <h4 class="mt-0 header-title"><b>Clientes Registrados</b></h4>
                                            <p class="text-muted  font-14">The Buttons extension for DataTables
                                                provides a common set of options, API methods and styling to display
                                                buttons on a page that will interact with a DataTable. The core library
                                                provides the based framework upon which plug-ins can built.
                                            </p>
            
                                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                                <thead>

                                                <tr>
                                                    <th><b>Plataforma</b></th>
                                                    <th><b>Correo/Usuario</b></th>
                                                <th><b>Contraseña</b></th>
                                                    <th><b>ACCIONES</b></th>
                                                </tr>
                                                </thead>
            
            
                                                <tbody>
           @foreach($datos as $datos)                                      
         <tr>
          <td class="text-center">{{ $datos->plataforma}}</td>
          <td class="text-center">{{ $datos->correo}}</td>
          <td>{{ $datos->contrasena}}</td>
          <td class="text-center">
           <div class="btn-group">
           

       <a href="<?=URL::to('dafer/editar-cuentas');?>/{{$datos->id}}"><span  id="tip" data-toggle="tooltip" data-placement="top" title="Información Cuentas" class="btn btn-primary"><i class="fas fa-user-edit"></i></span></a>
           <a href="<?=URL::to('dafer/eliminar-cuenta/');?>/{{$datos->id}}" onclick="return confirm('¿Está seguro que desea eliminar el registro?')"><button ="button" class="btn btn-danger" data-toggle="tooltip" data-placement="right" title="Eliminar Usuario"><i class="fas fa-trash-alt"></i></button></a>
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
