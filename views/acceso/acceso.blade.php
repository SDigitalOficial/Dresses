<!DOCTYPE html>
<html lang="en">

<head>

    <title>Dasho - Bootstrap 5 Admin Template</title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description"
        content="Dasho Bootstrap admin template made using Bootstrap 5 and it has huge amount of ready made feature, UI components, pages which completely fulfills any dashboard needs." />
    <meta name="keywords"
        content="admin templates, bootstrap admin templates, bootstrap 5, dashboard, dashboard templets, sass admin templets, html admin templates, responsive, bootstrap admin templates free download,premium bootstrap admin templates, Dasho, Dasho bootstrap admin template">
    <meta name="author" content="Phoenixcoded" />

    <!-- Favicon icon -->
    <link rel="icon" href="/dresses/assets/images/favicon.svg" type="image/x-icon">
    <!-- fontawesome icon -->
    <link rel="stylesheet" href="/dresses/assets/fonts/fontawesome/css/fontawesome-all.min.css">
    <!-- animation css -->
    <link rel="stylesheet" href="/dresses/assets/plugins/animation/css/animate.min.css">
    <!-- vendor css -->
    <link rel="stylesheet" href="/dresses/assets/css/style.css">

</head>

<!-- [ signin-img ] start -->
<div class="auth-wrapper aut-bg-img-side cotainer-fiuid align-items-stretch">
    <div class="row align-items-center w-100 align-items-stretch bg-white">
        <div class="d-none d-lg-flex col-md-8 aut-bg-img d-md-flex justify-content-center">
            <div class="col-md-8 d-flex">
                <div class="auth-content d-flex align-items-stretch">
                    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                        <ol class="carousel-indicators justify-content-start mx-0">
                            <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"></li>
                            <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"></li>
                            <li data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <h1 class="text-white mb-5">Login in Elite Able</h1>
                                <p class="text-white">Lorem Ipsum is simply dummy text of the printing and typesetting
                                    industry. Lorem Ipsum has been the industry's standard dummy text ever.</p>
                            </div>
                            <div class="carousel-item">
                                <h1 class="text-white mb-5">Login in Elite Able</h1>
                                <p class="text-white">Lorem Ipsum is simply dummy text of the printing and typesetting
                                    industry. Lorem Ipsum has been the industry's standard dummy text ever.</p>
                            </div>
                            <div class="carousel-item">
                                <h1 class="text-white mb-5">Login in Elite Able</h1>
                                <p class="text-white">Lorem Ipsum is simply dummy text of the printing and typesetting
                                    industry. Lorem Ipsum has been the industry's standard dummy text ever.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 align-items-stret h-100 ad-flex justify-content-center">
            <div class=" auth-content">
                <img src="https://www.quincedresses.com/cdn/shop/files/QD_HorizontalPositivo1.png?pad_color=fff&v=1683183863&width=533" alt="" class="img-fluid mb-4">
                <h4 class="mb-3 f-w-400">Login into your account</h4>

                <form action="{{ url('/login') }}" method="post" id="form-login" class="form-horizontal form-bordered form-control-borderless">
                {{ csrf_field() }}

                <div class="form-group mb-2">
                    <label class="form-label">Enter Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@sitename.com">
                    @if ($errors->has('email'))
                    <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>


                <div class="form-group mb-3">
                    <label class="form-label">Enter Password</label>
                    <input id="password" name="password" type="password" class="form-control  @error('password') is-invalid @enderror" required autocomplete="current-password" placeholder="Allow only max 14 character">
                    @if ($errors->has('password'))
                    <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group mt-2">
                    <div class="checkbox checkbox-primary d-inline">
                        <input type="checkbox" name="checkbox-p-1" id="checkbox-p-1" checked="">
                        <label for="checkbox-p-1" class="cr">Save credentials</label>
                    </div>
                </div>
                <button class="btn btn-primary mb-4">Login</button>

                </form>

                <p class="mb-2 text-muted">Forgot password? <a href="{{ url('/password/reset') }}" class="f-w-400">Reset</a>
                </p>
                
            </div>
        </div>
    </div>
</div>
<!-- [ signin-img ] end -->

<!-- Required Js -->
<script src="/dresses/assets/js/vendor-all.min.js"></script>
<script src="/dresses/assets/plugins/bootstrap/js/bootstrap.min.js"></script>


<div class="footer-fab">
    <div class="b-bg">
        <i class="fas fa-question"></i>
    </div>
    <div class="fab-hover">
        <ul class="list-unstyled">
            <li><a href="../doc/index-bc-package.html" target="_blank" data-text="UI Kit" class="btn btn-icon btn-rounded btn-info m-0"><i class="feather icon-layers"></i></a></li>
            <li><a href="../doc/index.html" target="_blank" data-text="Document" class="btn btn-icon btn-rounded btn-primary m-0"><i class="feather icon feather icon-book"></i></a></li>
        </ul>
    </div>
</div>


</body>

</html>