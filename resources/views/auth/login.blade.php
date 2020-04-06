<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>{{config('app.name')}}</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{asset('theme/vendors/materialdesign-webfont/css/materialdesignicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('theme/vendors/css/vendor.bundle.base.css')}}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{asset('theme/css/vertical-layout-light/style.css')}}">
  <link rel="stylesheet" href="{{asset('theme/css/login.css')}}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{asset('theme/images/favicon.png')}}" />

</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth">
        <div class="row no-gutters w-100">

          <div class="form-login col-12 col-sm-6 col-md-8 col-xl-5 mx-auto">

              @error('email')
                  <div class="alert alert-danger alert-dismissible fade show bg-white" role="alert">
                      <strong>ERREUR !</strong> {{ $message }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button>
                  </div>
              @enderror

            <div class="auth-form-light text-left p-4 border shadow mb-5 bg-white rounded">
                    <div class="brand-logo ">
                            <img class="mx-auto d-block" src="{{asset('theme/images/logo_hi.png')}}" width="100%" alt="logo">
                    </div>

              <h6 class="font-weight-light text-center">Identifiez-vous pour pour continuer</h6>

              <form class="pt-3" action="{{ route('login') }}" method="post">
                @csrf
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i style="font-size: 1.3rem;" class="mdi mdi-account-circle"></i></span>
                        </div>
                        <input placeholder="Email" id="email" type="email" class="form-control form-control-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i style="font-size: 1.3rem;" class="mdi mdi-lock"></i></span></span>
                        </div>
                         <input placeholder="Mot de passe" id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    </div>
                </div>

                    <div class="form-group mt-3 mb-0">
                            <div class="form-check" style="display: inline-block">
                                <label class="form-check-label text-muted">
                                    <input type="checkbox" class="form-check-input">
                                    Rester connecté
                                </label>
                            </div>

                        <div class="float-right">
                            <button type="submit" class="btn btn-primary">
                                Se connecter
                            </button>
                        </div>

                    </div>

               <!-- <div class="my-2 d-flex justify-content-between align-items-center">

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="#">
                                            Mot de passe oublié ?
                                    </a>
                                @endif
                </div>-->
              </form>


            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

  <div class="area" >
      <ul class="circles">
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
          <li></li>
      </ul>
  </div>

  <!-- container-scroller -->

    <script src="{{asset('theme/vendors/js/vendor.bundle.base.js')}}"></script>
    <script src="{{asset('theme/js/template.js')}}"></script>

</body>
</html>
