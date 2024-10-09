@extends ('LayoutDafer.layout')

 

  @section('ContenidoSite-01')

@if(Auth::user()->rol_id == 31)

<div class="container text-center">
   <h1>No tienes permisos para editar Cuentas, contactate con el Administrador</h1> 
</div>
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
                                                {{ Form::open(array('method' => 'POST','class' => 'form-horizontal','id' => 'defaultForm1', 'url' => array('/dafer/editar-cuenta',$cuentas->id))) }}

                                                    <div class="form-group m-l-10">
                                                        <label class="col-md-3 control-label" for="example-select">Plataforma</label>
                                                        <input type="text" class="form-control ml-2" name="plataforma" id="exampleInputEmail2" placeholder="Ingresa Plataforma" required value="{{$cuentas->plataforma}}">
                                                    </div>
                                                        
                                                    <div class="form-group m-l-10">
                                                    
                                                        <label class="col-md-3 control-label" for="example-select">Correo/usuario</label>
                                                        <input type="text" class="form-control ml-2" name="correo" id="exampleInputPassword2" placeholder="Ingrese Correo/Usuario" value="{{$cuentas->correo}}" required>
                                                    </div>

                                                    <div class="form-group m-l-10">
                                                        <label class="col-md-3 control-label" for="example-select">Contraseña</label>
                                                        <input type="text" class="form-control ml-2" name="contrasena" id="exampleInputPassword2" placeholder="Ingrese Contraseña" required value="{{$cuentas->contrasena}}">

                                                        <input type="hidden" class="form-control ml-2" value="{{Request::segment(3)}}" name="empresa_id" id="exampleInputPassword2" placeholder="Password">
                                                    </div>

                                                    <div class="form-group m-l-10">
                                                        <label class="col-md-3 control-label" for="example-select">Información Adicional</label>
                                                        <textarea class="form-control ml-2" name="informacion" id="exampleInputPassword2" placeholder="Información Adicional" required>{{$cuentas->informacion}}</textarea>
                                                    </div>
                                                   
                                                    <button type="submit" class="btn btn-primary ml-2">Editar Plataforma</button>
                                               {{ Form::close() }}         
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->


   @foreach($cuentas as $cuentas)
 @endforeach
@endif
  @stop
