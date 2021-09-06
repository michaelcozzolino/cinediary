<!-- =============== START OF HOW IT WORKS SECTION =============== -->
<section class="how-it-works3 ptb100">
    <div class="container">

        <!-- Start of row -->
        <div class="row justify-content-center">
            <div class="col-md-7 text-center">
                <h2 class="title">How it works?</h2>
                <h6 class="subtitle">{{ env("APP_NAME") }}, a web app thought for cinema lovers aims in tracking and not making you forget about your watched Movies and TV Series.</h6>
            </div>
        </div>
        <!-- End of row -->

        <!-- Start of row -->
        <div class="row mt50">

            <!-- Start of Tab Menu -->
            <div class="col-lg-4 col-sm-12">
                <ul class="nav features-tab">
                    <!-- Menu Item -->
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" aria-controls="home" aria-expanded="false">
                            <div class="icon-wrapper">
                                <i class="icon-login"></i>
                            </div>
                            <div>
                                <h5 class="title">Create an Account</h5>
                                <h6 class="subtitle">Create your account with a few simple steps.</h6>
                            </div>
                        </a>
                    </li>


                    <!-- Menu Item -->
                    <li class="nav-item">
                        <a class="nav-link" id="movie-tab" data-toggle="tab" href="#search" aria-controls="home" aria-expanded="false">
                            <div class="icon-wrapper">
                                <i class="icon-magnifier"></i>
                            </div>
                            <div>
                                <h5 class="title">Add your Movies and TV Series</h5>
                                <h6 class="subtitle">Search for your favorite Movies or TV Series and add them to your diary.</h6>
                            </div>
                        </a>
                    </li>

                    <!-- Menu Item -->
                    <li class="nav-item">
                        <a class="nav-link" id="enjoy-tab" data-toggle="tab" href="#enjoy" aria-controls="home" aria-expanded="false">
                            <div class="icon-wrapper">
                                <i class="icon-emotsmile"></i>
                            </div>
                            <div>
                                <h5 class="title">Enjoy {{ env("APP_NAME") }}</h5>
                                <h6 class="subtitle">Don't forget anymore by the Movies or TV Series you watched after adding them to your diary.</h6>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- End of Tab Menu -->

            <!-- Start of Tab Content -->
            <div class="col-lg-7 ml-auto">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="home" role="tabpanel" aria-expanded="false">
                        <img src="{{ url("css/images/other/signup.png") }}" alt="">
                        <p class="mt20">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                    </div>



                    <div class="tab-pane fade" id="search" role="tabpanel">
                        <img src="{{ url("css/images/other/find-movie.png") }}" alt="">
                        <p class="mt20">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                        <a class="btn btn-main btn-effect" href="#">View More</a>
                    </div>

                    <div class="tab-pane fade" id="enjoy" role="tabpanel">
                        <img src="{{ url("css/images/other/enjoy-movify.png") }}" alt="">
                        <p class="mt20">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                        <a class="btn btn-main btn-effect" href="#">View More</a>
                    </div>
                </div>
            </div>
            <!-- End of Tab Content -->
        </div>
        <!-- End of row -->

    </div>
</section>
<!-- =============== END OF HOW IT WORKS SECTION =============== -->
