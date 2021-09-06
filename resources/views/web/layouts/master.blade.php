<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('web.includes.head')
<body>


<!-- =============== START OF PRELOADER =============== -->
<div class="loading">
    <div class="loading-inner">
        <div class="loading-effect">
            <div class="object"></div>
        </div>
    </div>
</div>
<!-- =============== END OF PRELOADER =============== -->



<!-- =============== START OF RESPONSIVE - MAIN NAV =============== -->
<nav id="main-mobile-nav"></nav>
<!-- =============== END OF RESPONSIVE - MAIN NAV =============== -->



<!-- =============== START OF WRAPPER =============== -->
<div class="wrapper">

    <!-- =============== START OF HEADER NAVIGATION =============== -->
    <!-- Insert the class "sticky" in the header if you want a sticky header -->
    @if(! \Illuminate\Support\Facades\Route::is('password.reset'))
        <header class="header {{Route::is('home') ? 'header-fixed header-transparent text-white' : '' }} ">
            <div class="container-fluid">
                @include('web.includes.navbar')

            </div>
        </header>
    @endif

<!-- =============== END OF HEADER NAVIGATION =============== -->
    @yield('content')
</div>
<!-- =============== END OF WRAPPER =============== -->

<script src="{{ mix('/js/app.js') }}"></script>
<!-- ===== All Javascript at the bottom of the page for faster page loading ===== -->

<script src="{{ asset("js/jquery-3.2.1.min.js") }}"></script>
<script src="{{ asset("js/bootstrap.min.js") }}"></script>
<script src="{{ asset("js/jquery.ajaxchimp.js") }}"></script>
<script src="{{ asset("js/jquery.magnific-popup.min.js") }}"></script>
<script src="{{ asset("js/jquery.mmenu.js") }}"></script>
<script src="{{ asset("js/jquery.inview.min.js") }}"></script>
<script src="{{ asset("js/jquery.countTo.min.js") }}"></script>
<script src="{{ asset("js/jquery.countdown.min.js") }}"></script>
<script src="{{ asset("js/owl.carousel.min.js") }}"></script>
<script src="{{ asset("js/imagesloaded.pkgd.min.js") }}"></script>
<script src="{{ asset("js/isotope.pkgd.min.js") }}"></script>
<script src="{{ asset("js/headroom.js") }}"></script>
<script src="{{ asset("js/custom.js") }}"></script>

<!-- ===== Slider Revolution core JavaScript files ===== -->
<script type="text/javascript" src="{{ asset("revolution/js/jquery.themepunch.tools.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("revolution/js/jquery.themepunch.revolution.min.js") }}"></script>

<!-- ===== Slider Revolution extension scripts ===== -->
<script type="text/javascript" src="{{ asset("revolution/js/extensions/revolution.extension.actions.min.js") }}" ></script>
<script type="text/javascript" src="{{ asset("revolution/js/extensions/revolution.extension.carousel.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("revolution/js/extensions/revolution.extension.kenburn.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("revolution/js/extensions/revolution.extension.layeranimation.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("revolution/js/extensions/revolution.extension.migration.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("revolution/js/extensions/revolution.extension.navigation.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("revolution/js/extensions/revolution.extension.parallax.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("revolution/js/extensions/revolution.extension.slideanims.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("revolution/js/extensions/revolution.extension.video.min.js") }}"></script>

<script>
    $(document).ready(function () {
        if (parseInt('{{session('shouldLogin')}}'))
            $("#loginButton").click();

        /*----------------------------------------------------
              AUTHENTICATION
            ----------------------------------------------------*/

        $("#registration_form").on('submit',(function (event) {
            event.preventDefault();
            let formData = $(this).serializeArray();
            $.ajax({

                type: 'POST',

                url: '{{\Illuminate\Support\Facades\URL::to('register')}}',

                data: formData,

                success: function (data) {

                    window.location.replace(data["redirectTo"]);

                },

                error: function (response){
                    console.log(response);
                    $(this).find(".error").text("");
                    let errors = response.responseJSON.errors;
                    checkAuthenticationErrors(errors,"registration_error_");

                }.bind(this)

            });
        }));

        $("#login_form").on('submit',(function (event) {
            event.preventDefault();
            let formData = $(this).serializeArray();
            $.ajax({

                type: 'POST',

                url: '{{\Illuminate\Support\Facades\URL::to('login')}}',

                data: formData,

                success: function (data) {

                    window.location.replace(data["redirectTo"]);

                },

                error: function (response){
                    console.log(response);
                    $(this).find(".error").text("");
                    let errors = response.responseJSON.errors;
                    checkAuthenticationErrors(errors,"login_error_");

                }.bind(this)

            });
        }));

        $("#forgot_password_form").on('submit',(function (event) {
            event.preventDefault();
            let formData = $(this).serializeArray();
            $.ajax({

                type: 'POST',

                url: '{{route('password.email')}}',

                data: formData,

                success: function (data){
                    $(this).find(".error").text("");
                    if(data.hasOwnProperty("email"))
                        checkAuthenticationErrors(data,"forgot_password_error_");
                    else if (data.hasOwnProperty('status')) {
                        $("#" + "forgot_password_success").text(data["status"]);
                        $("#forgot_password_submit_button").text('');
                    }

                }.bind(this)

            });
        }));


        function checkAuthenticationErrors(jsonErrorsResponse,prefixErrorId){

            Object.entries(jsonErrorsResponse).forEach(function(value) {
                let id = "#" + prefixErrorId + value[0];
                $(id).text(value[1]);
            });


            console.log(jsonErrorsResponse);
        }

    });
</script>
</body>
</html>
