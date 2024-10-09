@extends ('LayoutDafer.layout')

    @section('cabecera')
    @parent

    

    @stop

@section('ContenidoSite-01')

 <div class="container">
<div class="row">


                                <div class="col-lg-12 col-xl-6 offset-3">

                                    @foreach($empresa as $empresa)
                                    <div class="card m-b-30">
                                        <div class="card-body">
                                            <img src="assets/images/users/avatar-1.jpg" alt="" class="rounded-circle  mx-auto d-block w-80">
                                            <div class="text-center">
                                                <h5 class="mt-2 mb-0">{{$empresa->n_negocio}}</h5>
                                                <p class="text-muted">{{$empresa->n_identificacion}}</p>
                                                <p class="text-muted mb-2"><b>{{$empresa->representante}}</b></p>
                                                <p class="text-muted mb-2">{{$empresa->email}}</p>
                                                <p class="text-muted mb-2">{{$empresa->tel_1}}</p>
                                                <p class="text-muted mb-2">{{$empresa->ciudad}}</p>
                                                <p class="text-muted mb-2">{{$empresa->estado}}</p>
                                                <p class="text-muted mb-2">{{$empresa->c_postal}}</p>
                                                <button class="btn btn-primary btn-block mb-2 col-2 offset-5" >Follow</button>
                                            </div>

                                        </div>
                                    </div>

                                    @endforeach

                                        
                                    <div class="card m-b-30">
                                         @foreach($bancos as $bancos)
                                        <div class="card-body">
                                            <img src="assets/images/users/avatar-1.jpg" alt="" class="rounded-circle  mx-auto d-block w-80">
                                            <div class="text-center">
                                                <h3 class="mt-2 mb-2"> {{$bancos->banco}}</h3>
                                                <h6 class="text-muted pt-2">Usuario: {{$bancos->usuario}}</h6>
                                                <h6 class="text-muted">Password:{{$bancos->password}}</h6>
                                                <p class="text-muted"><strong>Información:</strong><br>{{$bancos->informacion}}</p>

                                               
                                                <button class="btn btn-primary btn-block mb-2 col-2 offset-5" >Follow</button>
                                            </div>

                                        </div> @endforeach
                                    </div>

                                   
                                          <div class="card m-b-30">
                                         @foreach($productos as $productos)
                                        <div class="card-body">
                                            <img src="assets/images/users/avatar-1.jpg" alt="" class="rounded-circle  mx-auto d-block w-80">
                                            <div class="text-center">
                                                <h3 class="mt-2 mb-2"> {{$productos->producto}}</h3>
                                                 <p class="text-muted mb-2">Inicio: {{$productos->inicio}}</p>
                                                <p class="text-muted mb-2">Fin: {{$productos->fin}}</p>
                        
                                                <button class="btn btn-primary btn-block mb-2 col-2 offset-5" >Follow</button>
                                            </div>

                                        </div> @endforeach
                                    </div>

                                

                                   

                                    </div>
                                </div></div>
s
     


@stop