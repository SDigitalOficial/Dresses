@extends ('LayoutDafer.layout')
 
 @section('ContenidoSite-01')

 <div class="page-content-wrapper">

                        <div class="container-fluid">

                            <div class="container">
                                <div class="col-sm-12">
                                    <div class="page-title-box">
                                        <div class="float-right">
                                            <div class="dropdown">
                                                <button class="btn btn-secondary btn-round dropdown-toggle px-3" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="mdi mdi-settings mr-1"></i>Settings
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                </div>
                                            </div>
                                        </div>
                                        <h4 class="page-title">NOTA</h4>
                                    </div>
                                </div>
                            </div>
                            <!-- end page title end breadcrumb -->
                            @foreach($notas as $notas)
                            <div class="container d-flex justify-content-center">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body invoice"> 
                                            <div class="float-right">
                                                <h6>ID NOTA : # 
                                                    <strong> {{$notas->id}}</strong>
                                                </h6>
                                                <h6 class="mb-0 ">Fecha Creación:  {{$notas->created_at}}</h6><hr>
                                                <h6><strong>Responsable: </strong>
                                                     @foreach($usuarios as $usuariosa)
          @if($notas->user_id == $usuariosa->id)
          <span class="badge badge-primary">{{$usuariosa->name}}</span>
          @else
          @endif
          @endforeach
                                                 </h6>
                                            </div>
                                            <div class="">
                                                <h4 class="mb-0 align-self-center"><img src="assets/images/logo-sm.png" alt="s"></h4>                                        
                                            </div>                                            
                                            <div class="clearfix"> </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    
                                                    <div class="float-left mt-4">
                                                        <address>
                                                            @foreach($empresas as $empresasa)
         @if($notas->empresa_id == $empresasa->id)
         <strong> {{$empresasa->n_negocio}}</strong>
          @else
          @endif
         @endforeach
                                                            <strong>Empresa</strong><br>
                                                            795 Folsom Ave, Suite 600<br>
                                                            San Francisco, CA 94107<br>
                                                            <abbr title="Phone">P:</abbr> (123) 456-7890
                                                            </address>
                                                    </div>
                                                  
                                                </div>
                                            </div><!--end row-->
                                                                    
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <b>NOTA:</b>
                                                    {{$notas->nota}}
                                                    </div>
                                                </div>
                                            </div><!--end row-->
        
        
                                            <hr>
                                       
                                            
                                        </div>
                                    </div>
                                </div>
                            </div><!--end row-->
                            @endforeach

                        </div><!-- container -->

                    </div> <!-- Page content Wrapper -->

                

@stop