<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <title>TheSquad.Space App</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
    <link href="{{asset('dist/css/style.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('dist/css/jquery.toast.min.css')}}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="//fat.github.io/zoom.js/css/zoom.css">
    <link rel="apple-touch-icon" sizes="57x57" href="/fav/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/fav/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/fav/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/fav/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/fav/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/fav/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/fav/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/fav/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/fav/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/fav/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/fav/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/fav/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#0A2042">
    <meta name="theme-color" content="#0A2042">
    <meta name="msapplication-navbutton-color" content="#0A2042">
    <meta name="apple-mobile-web-app-status-bar-style" content="#0A2042">
</head>

<body>
    <!-- Preloader -->
    <div class="preloader-it">
        <div class="loader-pendulums"></div>
    </div>
    <!-- /Preloader -->
    
    <!-- HK Wrapper -->
    <div class="hk-wrapper" :class="{'hk-vertical-nav':currentRouteName!='register' && currentRouteName!='login' && currentRouteName!='error404' && currentRouteName!='start' && currentRouteName!='about'}" id="app">
        <template v-if="currentRouteName!='register' && currentRouteName!='login' && currentRouteName!='error404' && currentRouteName!='start' && currentRouteName!='about'">
            @include('includes.TopNavbar')
            @include('includes.Navbar')
        </template>
        <!-- Vertical Nav -->
        
        <!-- /Vertical Nav -->

    

        <!-- Main Content -->
        <div class="hk-pg-wrapper  px-0" :class="{'hk-auth-wrapper':currentRouteName=='register' || currentRouteName=='login' || currentRouteName=='error404' || currentRouteName=='start' || currentRouteName=='about'}">
         
            <main-app></main-app>

            <!-- Footer -->
            <div  class="hk-footer-wrap container" v-if="false">
                <footer class="footer">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <p>Pampered by <a href="https://hencework.com/" class="text-dark" target="_blank"></a> © 2019</p>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <p class="d-inline-block">Follow us</p>
                            <a href="#" class="d-inline-block btn btn-icon btn-icon-only btn-indigo btn-icon-style-4"><span class="btn-icon-wrap"><i class="fa fa-facebook"></i></span></a>
                            <a href="#" class="d-inline-block btn btn-icon btn-icon-only btn-indigo btn-icon-style-4"><span class="btn-icon-wrap"><i class="fa fa-twitter"></i></span></a>
                            <a href="#" class="d-inline-block btn btn-icon btn-icon-only btn-indigo btn-icon-style-4"><span class="btn-icon-wrap"><i class="fa fa-google-plus"></i></span></a>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- /Footer -->

        </div>
        <!-- /Main Content -->

    </div>
   <!-- /HK Wrapper -->
    <!-- jQuery -->
    <script src="{{ asset('js/app.js')}}"></script>
    <script src="{{asset('dist/js/jquery.slimscroll.js')}}"></script>
    <!-- Fancy Dropdown JS -->
    <script src="{{asset('dist/js/dropdown-bootstrap-extended.js')}}"></script>
    <!-- FeatherIcons JavaScript -->
    <script src="{{asset('dist/js/feather.min.js')}}"></script>
    <!-- Toggles JavaScript -->
    <script src="{{asset('dist/js/toggles.min.js')}}"></script>
    <script src="{{asset('dist/js/toggle-data.js')}}"></script>
    <script src="{{asset('dist/js/owl.carousel/dist/owl.carousel.min.js')}}"></script>
    <script src="{{asset('dist/js/init.js')}}"></script>
    <script src="{{asset('dist/js/login-data.js')}}"></script>
        <!-- Toastr JS -->
   <script src="{{asset('dist/js/jquery.toast.min.js')}}"></script>
   <script src="//fat.github.io/zoom.js/js/zoom.js"></script>
 
    <script src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
</body>

</html>