<!DOCTYPE html>

<html
  lang="en"
  class="light-style customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="/"
  data-template="vertical-menu-template-free"
>
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Login</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{url('')}}/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{url('')}}/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{url('')}}/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{url('')}}/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{url('')}}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{url('')}}/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="{{url('')}}/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="/js/config.js"></script>
    {!! NoCaptcha::renderJs() !!}
  </head>

  <body>
    <!-- Content -->

    <div class="container-xxl">
      <div class="row">
        <div class="col-md-6 col-lg-6">
          <div class="authentication-wrapper authentication-basic container-p-y">
            <img style="height:350px;width:auto" src="{{url('img/logo.png')}}" alt="">
          </div>
        </div>
        <div class="col-md-6 col-lg-6">

          <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
              <!-- Register -->
              <div class="card">
                <div class="card-body">
                  <!-- Logo -->
                  <div class="app-brand justify-content-center">
                    <a href="index.html" class="app-brand-link gap-2">
                      <span class="app-brand-logo demo">
                      </span>
                    </a>
                  </div>
                  <!-- /Logo -->
                  <p class="mb-4">Please sign-in</p>

                  @if ($errors->has('g-recaptcha-response'))
                      <span class="help-block">
                          <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                      </span>
                  @endif

                  @if($errors->any())
                    <div class="form-group">
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> {{$errors->first()}}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif

                  <form id="formAuthentication" class="mb-3" action="{{url('login')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                      <label for="email" class="form-label">Username</label>
                      <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" autofocus
                      />
                    </div>
                    <div class="mb-3 form-password-toggle">
                      <div class="d-flex justify-content-between">
                        <label class="form-label" for="password">Password</label>
                      </div>
                      <div class="input-group input-group-merge">
                        <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password"/>
                        <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                      </div>
                    </div>
                    <div class="mb-3">
                      <label for="captcha" class="form-label">Captcha</label>
                      <div class="d-flex ">
                        {!! NoCaptcha::display() !!}
                      </div>
                    </div>
                    <div class="mb-3">
                      <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                    </div>
                  </form>

                </div>
              </div>
              <!-- /Register -->
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{url('/')}}/vendor/libs/jquery/jquery.js"></script>
    <script src="{{url('/')}}/vendor/libs/popper/popper.js"></script>
    <script src="{{url('/')}}/vendor/js/bootstrap.js"></script>
    <script src="{{url('/')}}/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="{{url('/')}}/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{url('/')}}/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
