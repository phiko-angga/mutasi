<!DOCTYPE html>
<html lang="en" 
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../public/"
  data-template="vertical-menu-template-free">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
  <title>
    @if(isset($title)){{$title}}
    @else ''
    @endif
  </title>
  <meta content="" name="description">
  <meta content="" name="keywords">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{url('')}}/img/favicon/favicon.ico" />

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

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{url('')}}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <link rel="stylesheet" href="{{url('')}}/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="{{url('')}}/css/custom.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Page CSS -->

    <!-- Helpers -->
    <script src="{{url('')}}/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{url('')}}/js/config.js"></script>

    <style>
      .table th, .table td {
        font-size: 0.70rem;
      }
      .table > :not(caption) > * > * {
        padding: 0.4rem 0.65rem;
      }
    </style>
  @yield('style')

</head>

<body>
  
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->
      @include('layout/_sidebar')

      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->
        @include('layout/_navbar')

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">
            @yield('content')
          </div>

          <!-- ======= Footer ======= -->
          @include('layout/_footer')
          <!-- End Footer -->

          <div class="content-backdrop fade"></div>
        </div>
      <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{url('')}}/vendor/libs/jquery/jquery.js"></script>
    <script src="{{url('')}}/vendor/libs/popper/popper.js"></script>
    <script src="{{url('')}}/vendor/js/bootstrap.js"></script>
    <script src="{{url('')}}/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="{{url('')}}/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="{{url('')}}/vendor/libs/apex-charts/apexcharts.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Main JS -->
    <script src="{{url('')}}/js/main.js"></script>
    <script src="{{url('')}}/js/custom.js"></script>
    <script src="{{url('')}}/js/jquery.masknumber.min.js"></script>
    <script>
      var base_url = '{{url('')}}';
    </script>

    <!-- The core Firebase JS SDK is always required and must be listed first -->
    <!-- <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.3.2/firebase-messaging.js"></script> -->

    <!-- TODO: Add SDKs for Firebase products that you want to use
        https://firebase.google.com/docs/web/setup#available-libraries -->

    <!-- <script>
        // Your web app's Firebase configuration
        var firebaseConfig = {
          apiKey: "AIzaSyBkfgrIy7KtUEpYu-me-JW1EQVeHWsUQJ4",
          authDomain: "quickcount-ac7c7.firebaseapp.com",
          projectId: "quickcount-ac7c7",
          storageBucket: "quickcount-ac7c7.appspot.com",
          messagingSenderId: "841662721696",
          appId: "1:841662721696:web:a69333b4af00e45d01e3c5",
          measurementId: "G-2EN9S9S914"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();
        function initFirebaseMessagingRegistration() {
            messaging.requestPermission().then(function () {
                return messaging.getToken()
            }).then(function(token) {
                
                axios.post(" route('fcmToken') ",{
                    _method:"PATCH",
                    token
                }).then(({data})=>{
                    console.log(data)
                }).catch(({response:{data}})=>{
                    console.error(data)
                })

            }).catch(function (err) {
                console.log(`Token Error :: ${err}`);
            });
        }
        initFirebaseMessagingRegistration();
  
        messaging.onMessage(function({data:{body,title}}){
            new Notification(title, {body});
        });
    </script> -->

    @yield('script')
</body>



