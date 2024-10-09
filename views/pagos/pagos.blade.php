@extends ('LayoutDafer.layout')

 

  @section('ContenidoSite-01')
@if(Auth::user()->rol_id == 31)

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
                                                {{ Form::open(array('method' => 'POST','class' => 'form-horizontal','id' => 'defaultForm1', 'url' => array('dafer/crear-pagos'))) }}
                                                    <div class="form-group m-l-10">
                                                         <label class="col-md-3 control-label" for="exampleInputPassword2">Valor Pago</label>
                                                        <input type="text" class="form-control ml-2" name="valor" id="exampleInputEmail2" placeholder="Valor Pago" required>
                                                    </div>
                                                        
                                                    <div class="form-group m-l-10">
                                                        <label class="col-md-3 control-label" for="exampleInputPassword2">Fecha  de Pago</label>
                                                        <input type="date" class="form-control ml-2" name="fecha" id="exampleInputPassword2" placeholder="Fecha de Pago" required>
                                                    </div>

                                                    <div class="form-group m-l-10">
                                                         <label class="col-md-3 control-label" for="exampleInputPassword2">Información Adicional</label>
                                                        <textarea class="form-control ml-2" name="notas" id="exampleInputPassword2" placeholder="Notas Proceso" required> </textarea>
                                                    </div>

                                                    <div class="form-group m-l-10">
                                    

                                                        <input type="hidden" class="form-control ml-2" value="{{Request::segment(3)}}" name="empresa_id" id="exampleInputPassword2" placeholder="Password">
                                                    </div>
                                                   
                                                    <button type="submit" class="btn btn-primary ml-2">Crear Registro</button>
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
            
                                            <h4 class="mt-0 header-title"><b>Datos Registrados</b></h4>
                                            <p class="text-muted  font-14">The Buttons extension for DataTables
                                                provides a common set of options, API methods and styling to display
                                                buttons on a page that will interact with a DataTable. The core library
                                                provides the based framework upon which plug-ins can built.
                                            </p>
            
                                            <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                                <thead>

                                                <tr>
                                                    <th><b>Compañía</b></th>
                                                    <th><b>Fecha de Pago</b></th>
                                                <th><b>Valor</b></th>
                                                <th><b>Información</b></th>
                                                    <th><b>ACCIONES</b></th>
                                                </tr>
                                                </thead>
            
            
                                                <tbody>
         @foreach($pagosw as $pagosw)                                 
         <tr>
          <td class="text-center">{{$pagosw->n_negocio}}</td>
          <td class="text-center">{{$pagosw->fecha_pago}}</td>
          <td>{{ number_format($pagosw->pago_mensual,0,",",".") }} </td>
          <td>
            @foreach($bancos as $bancoss)
            @if($pagosw->banco_id == $bancoss->id)
            <b>{{$bancoss->banco}}</b>
            @else
            @endif
            @endforeach
            <br>{{$pagosw->usuario}}<br>{{$pagosw->password}}</td>
          <td class="text-center">
           <div class="btn-group">
       <a href="<?=URL::to('dafer/editar-pago');?>/{{$pagosw->id}}"><span  id="tip" data-toggle="tooltip" data-placement="top" title="Información Bancaria" class="btn btn-primary"><i class="fas fa-user-edit"></i></span></a>
           <a href="<?=URL::to('dafer/eliminar-pago/');?>/{{$pagosw->id}}" onclick="return confirm('¿Está seguro que desea eliminar el registro?')"><button ="button" class="btn btn-danger" data-toggle="tooltip" data-placement="right" title="Eliminar Usuario"><i class="fas fa-trash-alt"></i></button></a>
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