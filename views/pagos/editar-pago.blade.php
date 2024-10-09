@extends ('LayoutDafer.layout')

 

  @section('ContenidoSite-01')

@if(Auth::user()->rol_id == 31)

<div class="container text-center">
   <h1>No tienes permisos para editar Pagos, contactate con el Administrador</h1> 
</div>
@else


 <div class="col-md-10 offset-md-1">
     <div class="">
  <?php $status=Session::get('status'); ?>
  @if($status=='ok_create')
   <div class="alert alert-success">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Regsitro Creado Con Exito</strong>
   </div>
  @endif

  @if($status=='ok_delete')
   <div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Registro Eliminado Con Exito</strong>
   </div>
  @endif

  @if($status=='ok_update')
   <div class="alert alert-warning">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <strong>Registro Actualizado Con Exito</strong>
   </div>
  @endif

 </div>

                  <div class="row">
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <h4 class="mt-0 header-title">Registro de Pagos</h4>
                                            <p class="text-muted font-14">Use the <code>.form-inline </code>class to display a series of labels, form controls, and buttons on a single horizontal row. 
                                                Form controls within inline forms vary slightly from their default states..</p>
                                            <div class="general-label">
                                                {{ Form::open(array('method' => 'POST','class' => 'form-horizontal','id' => 'defaultForm1', 'url' => array('dafer/editarpagos/'.$pagos->id))) }}
                                                    <div class="form-group m-l-10">
                                                        <label class="col-md-3 control-label" for="exampleInputPassword2">Valor Pago</label>
                                                        <input type="text" class="form-control ml-2" name="valor" id="exampleInputEmail2" placeholder="Valor Pago" value="{{$pagos->pago_mensual}}" required>
                                                    </div>
                                                        
                                                    <div class="form-group m-l-10">
                                                        <label class="col-md-3 control-label" for="exampleInputPassword2">Fecha  de Pago</label>
                                                        <input type="date" class="form-control ml-2" name="fecha" id="exampleInputPassword2" value="{{$pagos->fecha_pago}}" placeholder="Fecha de Pago" required>
                                                    </div>

                                                    <div class="form-group m-l-10">
                                    

                                                        <input type="hidden" class="form-control ml-2" value="{{$pagos->empresa_id}}" name="empresa_id" id="exampleInputPassword2" placeholder="Password">
                                                    </div>

                                                     <div class="form-group m-l-10">
                                                         <label class="col-md-3 control-label" for="exampleInputPassword2">Información Adicional</label>
                                                        <textarea class="form-control ml-2" name="notas" id="exampleInputPassword2" placeholder="Notas Proceso" required> {{$pagos->notas}}</textarea>
                                                    </div>
                                                   
                                                    <button type="submit" class="btn btn-primary ml-2">Editar Registro</button>
                                               {{ Form::close() }}         
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->



  @foreach($pagos as $pagos)
  @endforeach
     @endif          

  @stop