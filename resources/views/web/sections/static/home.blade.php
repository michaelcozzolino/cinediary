@extends('web.layouts.master')
@section('title') my title @stop

@section('content')


        <!-- =============== START OF SLIDER REVOLUTION SECTION =============== -->
        <section id="slider" class="hero-slider">
            <div class="rev-slider-wrapper fullwidthbanner-container overlay-gradient">
                <!-- Start REVOLUTION SLIDER 5.4.1 fullwidth mode -->
                <div id="hero-slider" class="rev_slider fullwidthabanner" style="display:none" data-version="5.4.1">
                    <ul>

                        <!-- ===== SLIDE NR. 1 ===== -->
                        <li data-transition="fade">
                            <!-- MAIN IMAGE -->
                            <img src="{{ url("css/images/posters/movie-collection.jpg") }}"
                                 alt="Image"
                                 title="slider-bg"
                                 data-bgposition="center center"
                                 data-bgfit="cover"
                                 data-bgrepeat="no-repeat"
                                 data-bgparallax="10"
                                 class="rev-slidebg"
                                 data-no-retina="">
                            <!-- LAYER NR. 1 -->
                            <div class="tp-caption tp-resizeme"
                                 data-x="center"
                                 data-hoffset=""
                                 data-y="middle"
                                 data-voffset="['-80','-80','-80','-80']"
                                 data-responsive_offset="on"
                                 data-fontsize="['60','50','40','30']"
                                 data-lineheight="['60','50','40','30']"
                                 data-whitespace="nowrap"
                                 data-frames='[{"delay":1000,"speed":2000,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:0;s:inherit;e:inherit;","to":"o:1;","ease":"Power2.easeInOut"},{"delay":"wait","speed":500,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'
                                 style="z-index: 5; color: #fff; font-weight: 900;">WELCOME TO MOVIFY
                            </div>


                            <!-- LAYER NR. 2 -->
                            <div class="tp-caption tp-resizeme"
                                 data-x="center"
                                 data-hoffset=""
                                 data-y="middle"
                                 data-voffset="[0]"
                                 data-width="[1200, 992, 768, 98%]"
                                 data-responsive_offset="on"
                                 data-whitespace="nowrap"
                                 data-frames='[{"delay":1000,"speed":2000,"frame":"0","from":"y:[-100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:0;s:inherit;e:inherit;","to":"o:1;","ease":"Power2.easeInOut"},{"delay":"wait","speed":500,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'
                                 style="z-index: 5; color: #fff; font-weight: 900;">

                                @include('components.home.addScreenplaysForm')

                            </div>


                            <!-- LAYER NR. 3 -->
                            <div class="tp-caption tp-resizeme text-center"
                                 data-x="center"
                                 data-hoffset=""
                                 data-y="middle"
                                 data-voffset="['100','100','80','80']"
                                 data-responsive_offset="on"
                                 data-fontsize="['16']"
                                 data-lineheight="['22']"
                                 data-whitespace="nowrap"
                                 data-frames='[{"delay":1000,"speed":2000,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:0;s:inherit;e:inherit;","to":"o:1;","ease":"Power2.easeInOut"},{"delay":"wait","speed":500,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'
                                 style="z-index: 5; color: #fff; font-weight: 400;">
                                Have a look at our top rated <br/>Movies and TV Shows!
                            </div>


                            <!-- LAYER NR. 4 -->
                            <div class="tp-caption tp-resizeme"
                                 data-x="[730, 630, 520, 370]"
                                 data-hoffset=""
                                 data-y="middle"
                                 data-voffset="['115','115','90','500']"
                                 data-responsive_offset="on"
                                 data-fontsize="['16']"
                                 data-lineheight="['22']"
                                 data-whitespace="nowrap"
                                 data-frames='[{"delay":1000,"speed":2000,"frame":"0","from":"y:[100%];z:0;rX:0deg;rY:0;rZ:0;sX:1;sY:1;skX:0;skY:0;opacity:0;","mask":"x:0px;y:0;s:inherit;e:inherit;","to":"o:1;","ease":"Power2.easeInOut"},{"delay":"wait","speed":500,"frame":"999","to":"auto:auto;","ease":"Power3.easeInOut"}]'
                                 style="z-index: 5; color: #fff; font-weight: 400;">
                                <img src="{{ url("css/images/other/banner-arrow.png") }}" alt="">
                            </div>
                        </li>

                    </ul>
                </div>
                <!-- End REVOLUTION SLIDER 5.4.1 fullwidth mode -->
            </div>
            <!-- ===== END OF REV SLIDER WRAPPER ===== -->

        </section>
        <!-- =============== START OF SLIDER REVOLUTION SECTION =============== -->




        <!-- =============== START OF TOP MOVIES SECTION =============== -->
        <section class="top-movies2">
            <div class="container">
                <div class="row">

                    <!-- Movie List Item -->
                    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
                        <div class="movie-box-4">
                            <div class="listing-container">

                                <!-- Movie List Image -->
                                <div class="listing-image">

                                    <!-- Buttons -->
                                    <div class="buttons">
                                        <a href="#" data-original-title="Rate" data-toggle="tooltip" data-placement="bottom" class="like">
                                            <i class="icon-heart"></i>
                                        </a>

                                        <a href="#" data-original-title="Share" data-toggle="tooltip" data-placement="bottom" class="share">
                                            <i class="icon-share"></i>
                                        </a>
                                    </div>

                                    <!-- Rating -->
                                    <div class="stars">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                    </div>

                                    <!-- Image -->
                                    <img src="{{ url("css/images/posters/poster-1.jpg") }}" alt="">
                                </div>

                                <!-- Movie List Content -->
                                <div class="listing-content">
                                    <div class="inner">
                                        <h2 class="title">Star Wars</h2>

                                        <a href="movie-detail.html" class="btn btn-main btn-effect">details</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Movie List Item -->
                    <div class="col-lg-3 col-md-6 col-sm-6 d-none d-sm-block">
                        <div class="movie-box-4">
                            <div class="listing-container">

                                <!-- Movie List Image -->
                                <div class="listing-image">

                                    <!-- Buttons -->
                                    <div class="buttons">
                                        <a href="#" data-original-title="Rate" data-toggle="tooltip" data-placement="bottom" class="like">
                                            <i class="icon-heart"></i>
                                        </a>

                                        <a href="#" data-original-title="Share" data-toggle="tooltip" data-placement="bottom" class="share">
                                            <i class="icon-share"></i>
                                        </a>
                                    </div>

                                    <!-- Rating -->
                                    <div class="stars">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                    </div>

                                    <!-- Image -->
                                    <img src="{{ url("css/images/posters/poster-2.jpg") }}" alt="">
                                </div>

                                <!-- Movie List Content -->
                                <div class="listing-content">
                                    <div class="inner">
                                        <h2 class="title">The Brain</h2>

                                        <a href="movie-detail.html" class="btn btn-main btn-effect">details</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Movie List Item -->
                    <div class="col-lg-3 col-md-6 d-none d-lg-block">
                        <div class="movie-box-4">
                            <div class="listing-container">

                                <!-- Movie List Image -->
                                <div class="listing-image">

                                    <!-- Buttons -->
                                    <div class="buttons">
                                        <a href="#" data-original-title="Rate" data-toggle="tooltip" data-placement="bottom" class="like">
                                            <i class="icon-heart"></i>
                                        </a>

                                        <a href="#" data-original-title="Share" data-toggle="tooltip" data-placement="bottom" class="share">
                                            <i class="icon-share"></i>
                                        </a>
                                    </div>

                                    <!-- Rating -->
                                    <div class="stars">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </div>
                                    </div>

                                    <!-- Image -->
                                    <img src="{{ url("css/images/posters/poster-3.jpg") }}" alt="">
                                </div>

                                <!-- Movie List Content -->
                                <div class="listing-content">
                                    <div class="inner">
                                        <h2 class="title">The Mummy</h2>

                                        <a href="movie-detail.html" class="btn btn-main btn-effect">details</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Movie List Item -->
                    <div class="col-lg-3 col-md-6 d-none d-lg-block">
                        <div class="movie-box-4">
                            <div class="listing-container">

                                <!-- Movie List Image -->
                                <div class="listing-image">

                                    <!-- Buttons -->
                                    <div class="buttons">
                                        <a href="#" data-original-title="Rate" data-toggle="tooltip" data-placement="bottom" class="like">
                                            <i class="icon-heart"></i>
                                        </a>

                                        <a href="#" data-original-title="Share" data-toggle="tooltip" data-placement="bottom" class="share">
                                            <i class="icon-share"></i>
                                        </a>
                                    </div>

                                    <!-- Rating -->
                                    <div class="stars">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-half-o"></i>
                                        </div>
                                    </div>

                                    <!-- Image -->
                                    <img src="{{ url("css/images/posters/poster-5.jpg") }}" alt="">
                                </div>

                                <!-- Movie List Content -->
                                <div class="listing-content">
                                    <div class="inner">
                                        <h2 class="title">Daredevil</h2>

                                        <a href="movie-detail.html" class="btn btn-main btn-effect">details</a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </section>
        <!-- =============== END OF TOP MOVIES SECTION =============== -->




        @include('components.home.howItWorks')






        <!-- =============== START OF LATEST RELEASES SECTION =============== -->
        <section class="latest-releases bg-light ptb100">
            <div class="container">

                <!-- Start of row -->
                <div class="row justify-content-center">
                    <div class="col-md-7 text-center">
                        <h2 class="title">Latest Movies & TV Shows</h2>
                        <h6 class="subtitle">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy consectetuer adipiscing.</h6>
                    </div>
                </div>
                <!-- End of row -->
            </div>
            <!-- End of Container -->

            <!-- Start of Latest Releases Slider -->
            <div class="owl-carousel latest-releases-slider">

                <!-- === Start of Sliding Item 1 === -->
                <div class="item">
                    <div class="movie-box-3">
                        <div class="listing-container">

                            <!-- Movie List Image -->
                            <div class="listing-image">
                                <!-- Image -->
                                <img src="{{ url("css/images/posters/poster-1.jpg") }}" alt="">
                            </div>

                            <!-- Movie List Content -->
                            <div class="listing-content">
                                <div class="inner">

                                    <!-- Play Button -->
                                    <div class="play-btn">
                                        <a href="https://www.youtube.com/watch?v=Q0CbN8sfihY" class="play-video">
                                            <i class="fa fa-play"></i>
                                        </a>
                                    </div>

                                    <h2 class="title">Star Wars</h2>

                                    <!-- Rating -->
                                    <div class="stars">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <span>7.5/10</span>
                                            <span class="category">Action, Fantasy</span>
                                        </div>
                                    </div>

                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua enim ad minim veniam...</p>

                                    <a href="movie-detail.html" class="btn btn-main btn-effect">details</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- === End of Sliding Item 1 === -->

                <!-- === Start of Sliding Item 2 === -->
                <div class="item">
                    <div class="movie-box-3">
                        <div class="listing-container">

                            <!-- Movie List Image -->
                            <div class="listing-image">
                                <!-- Image -->
                                <img src="{{ url("css/images/posters/poster-2.jpg") }}" alt="">
                            </div>

                            <!-- Movie List Content -->
                            <div class="listing-content">
                                <div class="inner">

                                    <!-- Play Button -->
                                    <div class="play-btn">
                                        <a href="https://www.youtube.com/watch?v=Q0CbN8sfihY" class="play-video">
                                            <i class="fa fa-play"></i>
                                        </a>
                                    </div>

                                    <h2 class="title">The Brain</h2>

                                    <!-- Rating -->
                                    <div class="stars">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <span>7.2/10</span>
                                            <span class="category">Action, Comendy</span>
                                        </div>
                                    </div>

                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua enim ad minim veniam...</p>

                                    <a href="movie-detail.html" class="btn btn-main btn-effect">details</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- === End of Sliding Item 2 === -->

                <!-- === Start of Sliding Item 3 === -->
                <div class="item">
                    <div class="movie-box-3">
                        <div class="listing-container">

                            <!-- Movie List Image -->
                            <div class="listing-image">
                                <!-- Image -->
                                <img src="{{ url("css/images/posters/poster-3.jpg") }}" alt="">
                            </div>

                            <!-- Movie List Content -->
                            <div class="listing-content">
                                <div class="inner">

                                    <!-- Play Button -->
                                    <div class="play-btn">
                                        <a href="https://www.youtube.com/watch?v=Q0CbN8sfihY" class="play-video">
                                            <i class="fa fa-play"></i>
                                        </a>
                                    </div>

                                    <h2 class="title">The Mummy</h2>

                                    <!-- Rating -->
                                    <div class="stars">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <span>5.5/10</span>
                                            <span class="category">Action, Fantasy</span>
                                        </div>
                                    </div>

                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua enim ad minim veniam...</p>

                                    <a href="movie-detail.html" class="btn btn-main btn-effect">details</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- === End of Sliding Item 3 === -->

                <!-- === Start of Sliding Item 4 === -->
                <div class="item">
                    <div class="movie-box-3">
                        <div class="listing-container">

                            <!-- Movie List Image -->
                            <div class="listing-image">
                                <!-- Image -->
                                <img src="{{ url("css/images/posters/poster-5.jpg") }}" alt="">
                            </div>

                            <!-- Movie List Content -->
                            <div class="listing-content">
                                <div class="inner">

                                    <!-- Play Button -->
                                    <div class="play-btn">
                                        <a href="https://www.youtube.com/watch?v=Q0CbN8sfihY" class="play-video">
                                            <i class="fa fa-play"></i>
                                        </a>
                                    </div>

                                    <h2 class="title">Daredevil</h2>

                                    <!-- Rating -->
                                    <div class="stars">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <span>8.7/10</span>
                                            <span class="category">Action, Crime</span>
                                        </div>
                                    </div>

                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua enim ad minim veniam...</p>

                                    <a href="movie-detail.html" class="btn btn-main btn-effect">details</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- === End of Sliding Item 4 === -->

                <!-- === Start of Sliding Item 5 === -->
                <div class="item">
                    <div class="movie-box-3">
                        <div class="listing-container">

                            <!-- Movie List Image -->
                            <div class="listing-image">
                                <!-- Image -->
                                <img src="{{ url("css/images/posters/poster-6.jpg") }}" alt="">
                            </div>

                            <!-- Movie List Content -->
                            <div class="listing-content">
                                <div class="inner">

                                    <!-- Play Button -->
                                    <div class="play-btn">
                                        <a href="https://www.youtube.com/watch?v=Q0CbN8sfihY" class="play-video">
                                            <i class="fa fa-play"></i>
                                        </a>
                                    </div>

                                    <h2 class="title">Stranger Things</h2>

                                    <!-- Rating -->
                                    <div class="stars">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <span>9.0/10</span>
                                            <span class="category">Fantasy, Horror</span>
                                        </div>
                                    </div>

                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua enim ad minim veniam...</p>

                                    <a href="movie-detail.html" class="btn btn-main btn-effect">details</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- === End of Sliding Item 5 === -->

                <!-- === Start of Sliding Item 6 === -->
                <div class="item">
                    <div class="movie-box-3">
                        <div class="listing-container">

                            <!-- Movie List Image -->
                            <div class="listing-image">
                                <!-- Image -->
                                <img src="{{ url("css/images/posters/poster-8.jpg") }}" alt="">
                            </div>

                            <!-- Movie List Content -->
                            <div class="listing-content">
                                <div class="inner">

                                    <!-- Play Button -->
                                    <div class="play-btn">
                                        <a href="https://www.youtube.com/watch?v=Q0CbN8sfihY" class="play-video">
                                            <i class="fa fa-play"></i>
                                        </a>
                                    </div>

                                    <h2 class="title">The Flash</h2>

                                    <!-- Rating -->
                                    <div class="stars">
                                        <div class="rating">
                                            <i class="fa fa-star"></i>
                                            <span>8.0/10</span>
                                            <span class="category">Action, Drama</span>
                                        </div>
                                    </div>

                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua enim ad minim veniam...</p>

                                    <a href="movie-detail.html" class="btn btn-main btn-effect">details</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- === End of Sliding Item 6 === -->

            </div>
            <!-- End of Latest Releases Slider -->

        </section>
        <!-- =============== END OF LATEST RELEASES SECTION =============== -->




        <!-- =============== START OF UPCOMING MOVIES SECTION =============== -->
        <section class="upcoming-movies parallax ptb100" data-background="{{ url("css/images/posters/movie-collection.jpg") }}" data-color="#3e4555" data-color-opacity="0.95" >
            <div class="container">

                <!-- Start of row -->
                <div class="row justify-content-center">
                    <div class="col-md-7 text-center">
                        <h2 class="title text-white">Upcoming Movies & TV Shows</h2>
                    </div>
                </div>
                <!-- End of row -->



                <!-- Start of row -->
                <div class="row mt50">

                    <!-- === Start of Upcoming Featured Movies & TV Shows === -->
                    <div class="col-md-8">

                        <!-- Start of Upcoming Featured Item -->
                        <div class="movie-box-1 upcoming-featured-item">

                            <!-- Start of Poster -->
                            <div class="poster">
                                <img src="{{ url("css/images/movies/upcoming-featured-item.jpg") }}" alt="">
                            </div>
                            <!-- End of Poster -->

                            <!-- Start of Buttons -->
                            <div class="buttons">
                                <a href="https://www.youtube.com/watch?v=Q0CbN8sfihY" class="play-video">
                                    <i class="fa fa-play"></i>
                                </a>
                            </div>
                            <!-- End of Buttons -->

                            <!-- Start of Movie Details -->
                            <div class="movie-details">
                                <h4 class="movie-title">
                                    <a href="movie-detail.html">Tomb Raider</a>
                                </h4>
                                <span class="released">Release Date: 15 Mar 2018</span>
                            </div>
                            <!-- End of Movie Details -->
                        </div>
                        <!-- End of Upcoming Featured Item -->

                    </div>
                    <!-- === End of Upcoming Featured Movies & TV Shows === -->


                    <!-- === Start of Upcoming Movies & TV Shows === -->
                    <div class="col-md-4">

                        <!-- Start of Upcoming Item 1 -->
                        <div class="movie-box-1 upcoming-item">

                            <!-- Start of Poster -->
                            <div class="poster">
                                <img src="{{ url("css/images/movies/upcoming-item-1.jpg") }}" alt="">
                            </div>
                            <!-- End of Poster -->

                            <!-- Start of Buttons -->
                            <div class="buttons">
                                <a href="https://www.youtube.com/watch?v=Q0CbN8sfihY" class="play-video">
                                    <i class="fa fa-play"></i>
                                </a>
                            </div>
                            <!-- End of Buttons -->

                            <!-- Start of Movie Details -->
                            <div class="movie-details">
                                <h4 class="movie-title">
                                    <a href="movie-detail.html">The Jungle</a>
                                </h4>
                            </div>
                            <!-- End of Movie Details -->

                        </div>
                        <!-- End of Upcoming Item 1 -->

                        <!-- Start of Upcoming Item 2 -->
                        <div class="movie-box-1 upcoming-item mt20">

                            <!-- Start of Poster -->
                            <div class="poster">
                                <img src="{{ url("css/images/movies/upcoming-item-2.jpg") }}" alt="">
                            </div>
                            <!-- End of Poster -->

                            <!-- Start of Buttons -->
                            <div class="buttons">
                                <a href="https://www.youtube.com/watch?v=Q0CbN8sfihY" class="play-video">
                                    <i class="fa fa-play"></i>
                                </a>
                            </div>
                            <!-- End of Buttons -->

                            <!-- Start of Movie Details -->
                            <div class="movie-details">
                                <h4 class="movie-title">
                                    <a href="movie-detail.html">Fast and Furious</a>
                                </h4>
                            </div>
                            <!-- End of Movie Details -->

                        </div>
                        <!-- End of Upcoming Item 2 -->

                    </div>
                    <!-- === End of Upcoming Movies & TV Shows === -->

                </div>
                <!-- End of row -->

            </div>
        </section>
        <!-- =============== END OF UPCOMING MOVIES SECTION =============== -->




        <!-- =============== END OF BECOME PREMIUM SECTION =============== -->
        <section class="become-premium3 ptb100">
            <div class="container">

                <!-- Start of row -->
                <div class="row justify-content-center">
                    <div class="col-md-7 text-center">
                        <h2 class="title">Become a Premium Member</h2>
                        <h6 class="subtitle">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</h6>
                    </div>
                </div>
                <!-- End of row -->

                <!-- Start of row -->
                <div class="row mt80">
                    <div class="col-md-12">

                        <!-- Start of Pricing Table -->
                        <div class="pricing-table-2">

                            <!-- Pricing Plan 1 -->
                            <div class="plan">

                                <!-- Price -->
                                <div class="plan-price">
                                    <h3>Basic</h3>
                                    <span class="value">Free</span>
                                    <span class="period">Try Movify for FREE for the first 7 days, you can upgrade anytime.</span>
                                </div>

                                <!-- Features -->
                                <div class="plan-features">
                                    <ul>
                                        <li>7 days</li>
                                        <li>720p Resolution</li>
                                        <li>Desktop Only</li>
                                        <li>Limited Support</li>
                                    </ul>
                                    <a class="btn btn-main btn-effect mt30" href="#">Get Started</a>
                                </div>

                            </div>

                            <!-- Featured - Pricing Plan 2 -->
                            <div class="plan featured">

                                <!-- Price -->
                                <div class="plan-price">
                                    <h3>Premium</h3>
                                    <span class="value">$19</span>
                                    <span class="period">Most wanted subscription package by our Movifiers.</span>
                                </div>

                                <!-- Features -->
                                <div class="plan-features">
                                    <ul>
                                        <li>1 Month</li>
                                        <li>Full HD</li>
                                        <li>Lifetime Availability</li>
                                        <li>TV & Desktop</li>
                                        <li>24/7 Support</li>
                                    </ul>
                                    <a class="btn btn-main btn-effect mt30" href="#">Get Started</a>
                                </div>
                            </div>

                            <!-- Pricing Plan 3 -->
                            <div class="plan">

                                <!-- Price -->
                                <div class="plan-price">
                                    <h3>Cinematic</h3>
                                    <span class="value">$39</span>
                                    <span class="period">Watch your favorite movies anywhere and anytime.</span>
                                </div>

                                <!-- Features -->
                                <div class="plan-features">
                                    <ul>
                                        <li>2 Months</li>
                                        <li>Ultra HD</li>
                                        <li>Any Device</li>
                                        <li>24/7 Support</li>
                                    </ul>
                                    <a class="btn btn-main btn-effect mt30" href="#">Get Started</a>
                                </div>
                            </div>

                        </div>
                        <!-- End of Pricing Table -->

                    </div>
                </div>
                <!-- End of row -->

            </div>
        </section>
        <!-- =============== END OF BECOME PREMIUM SECTION =============== -->




        <!-- =============== END OF BLOG SECTION =============== -->
        <section class="blog bg-light ptb100">
            <div class="container">

                <!-- Start of row -->
                <div class="row justify-content-center">
                    <div class="col-md-7 text-center">
                        <h2 class="title">Latest News</h2>
                        <h6 class="subtitle">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy consectetuer adipiscing.</h6>
                    </div>
                </div>
                <!-- End of row -->


                <!-- Start of row -->
                <div class="row mt50">

                    <!-- 1st Blog Item -->
                    <div class="col-md-4">
                        <div class="bloglist-post-holder shadow-hover">

                            <!-- Blog Post Thumbnail -->
                            <a href="blog-post-detail.html" class="bloglist-thumb-link hover-link">
                                <div class="bloglist-post-thumbnail" style="background: url(assets/images/blog/bloglist-1.jpg)"></div>
                            </a>

                            <!-- Blog Post Text Wrapper -->
                            <div class="bloglist-text-wrapper">
                                <!-- Author Avatar -->
                                <span class="circle-img bloglist-avatar">
                                    <img src="{{ url("css/images/user.png") }}" width="50" height="50" alt="author img">
                                </span>

                                <h4 class="bloglist-title">
                                    <a href="blog-post-detail.html">Top 10 Action Movies</a>
                                </h4>

                                <div class="bloglist-meta">
                                    <i class="fa fa-calendar"></i> 01/02/2018
                                </div>

                                <div class="bloglist-excerpt">
                                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis...</p>
                                    <a href="#" class="btn btn-main btn-effect">read more</a>
                                </div>
                            </div>

                        </div>
                    </div>


                    <!-- 2nd Blog Item -->
                    <div class="col-md-4">
                        <div class="bloglist-post-holder shadow-hover">

                            <!-- Blog Post Thumbnail -->
                            <a href="blog-post-detail.html" class="bloglist-thumb-link hover-link">
                                <div class="bloglist-post-thumbnail" style="background: url(css/images/blog/bloglist-2.jpg)"></div>
                            </a>

                            <!-- Blog Post Text Wrapper -->
                            <div class="bloglist-text-wrapper">
                                <!-- Author Avatar -->
                                <span class="circle-img bloglist-avatar">
                                    <img src="{{ url("css/images/user.png") }}" width="50" height="50" alt="author img">
                                </span>

                                <h4 class="bloglist-title">
                                    <a href="blog-post-detail.html">Oscar Awards</a>
                                </h4>

                                <div class="bloglist-meta">
                                    <i class="fa fa-calendar"></i> 01/02/2018
                                </div>

                                <div class="bloglist-excerpt">
                                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis...</p>
                                    <a href="#" class="btn btn-main btn-effect">read more</a>
                                </div>
                            </div>

                        </div>
                    </div>


                    <!-- 3rd Blog Item -->
                    <div class="col-md-4">
                        <div class="bloglist-post-holder shadow-hover">

                            <!-- Blog Post Thumbnail -->
                            <a href="blog-post-detail.html" class="bloglist-thumb-link hover-link">
                                <div class="bloglist-post-thumbnail" style="background: url(css/images/blog/bloglist-3.jpg)"></div>
                            </a>

                            <!-- Blog Post Text Wrapper -->
                            <div class="bloglist-text-wrapper">
                                <!-- Author Avatar -->
                                <span class="circle-img bloglist-avatar">
                                    <img src="{{ url('css/images/user.png') }}" width="50" height="50" alt="author img">
                                </span>

                                <h4 class="bloglist-title">
                                    <a href="blog-post-detail.html">Top Upcoming Movies</a>
                                </h4>

                                <div class="bloglist-meta">
                                    <i class="fa fa-calendar"></i> 01/02/2018
                                </div>

                                <div class="bloglist-excerpt">
                                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis...</p>
                                    <a href="#" class="btn btn-main btn-effect">read more</a>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- End of row -->

            </div>
        </section>
        <!-- =============== END OF BLOG SECTION =============== -->





        <!-- =============== END OF SUBSCRIBE SECTION =============== -->
        <section class="subscribe bg-light2 ptb100">
            <div class="container">

                <!-- Start of row -->
                <div class="row">

                    <div class="col-md-6 col-12">
                        <div class="img-box overlay-gradient mr30">
                            <img src="{{ url("css/images/other/landscape.jpg") }}" alt="" class="img-resonsive img-shadow">
                        </div>
                    </div>

                    <div class="col-md-6 col-12 mt50">
                        <h2 class="title">Join Movify Now!</h2>
                        <h6 class="subtitle">Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy consectetuer adipiscing.</h6>

                        <!-- Subscribe Form -->
                        <form action="#" class="mailchimp mt50" novalidate>

                            <!-- Form -->
                            <div class="form-group">
                                <div class="input-group">
                                    <input type="email" name="EMAIL" class="form-control" id="mc-email" placeholder="Your Email" autocomplete="off">
                                    <label for="mc-email"></label>
                                    <button type="submit" class="btn btn-main btn-effect">Subscribe</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <!-- End of row -->

            </div>
        </section>
        <!-- =============== END OF SUBSCRIBE SECTION =============== -->




        <!-- =============== START OF FOOTER =============== -->
        <footer class="footer1 bg-dark">

            <!-- ===== START OF FOOTER WIDGET AREA ===== -->
            <div class="footer-widget-area ptb100">
                <div class="container">
                    <div class="row">

                        <!-- Start of Widget 1 -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="widget widget-about">

                                <!-- INSERT YOUR LOGO HERE -->
                                <img src="{{ url("css/images/logo.svg") }}" alt="logo" class="logo">
                                <!-- INSERT YOUR WHITE LOGO HERE -->
                                <img src="{{ url("css/images/logo-white.svg") }}" alt="white logo" class="logo-white">
                                <p class="nomargin">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque, ducimus, atque. Praesentium suscipit provident explicabo dignissimos nostrum numquam deserunt earum accusantium et fugit.</p>
                            </div>
                        </div>
                        <!-- End of Widget 1 -->

                        <!-- Start of Widget 2 -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="widget widget-links">
                                <h4 class="widget-title">Useful links</h4>

                                <ul class="general-listing">
                                    <li><a href="#">about movify</a></li>
                                    <li><a href="#">blog</a></li>
                                    <li><a href="#">forum</a></li>
                                    <li><a href="#">my account</a></li>
                                    <li><a href="#">watch list</a></li>
                                </ul>

                            </div>
                        </div>
                        <!-- End of Widget 2 -->

                        <!-- Start of Widget 3 -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="widget widget-blog">
                                <h4 class="widget-title">latest news</h4>

                                <ul class="blog-posts">
                                    <li><a href="#">blog post 1</a><small>januar 13, 2018</small></li>
                                    <li><a href="#">blog post 2</a><small>januar 13, 2018</small></li>
                                    <li><a href="#">blog post 3</a><small>januar 13, 2018</small></li>
                                </ul>
                            </div>
                        </div>
                        <!-- End of Widget 3 -->

                        <!-- Start of Widget 4 -->
                        <div class="col-lg-3 col-md-6 col-sm-12">
                            <div class="widget widget-social">
                                <h4 class="widget-title">follow us</h4>

                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Itaque, ducimus, atque.</p>

                                <!-- Start of Social Buttons -->
                                <ul class="social-btns">
                                    <!-- Social Media -->
                                    <li>
                                        <a href="#" class="social-btn-roll facebook">
                                            <div class="social-btn-roll-icons">
                                                <i class="social-btn-roll-icon fa fa-facebook"></i>
                                                <i class="social-btn-roll-icon fa fa-facebook"></i>
                                            </div>
                                        </a>
                                    </li>

                                    <!-- Social Media -->
                                    <li>
                                        <a href="#" class="social-btn-roll twitter">
                                            <div class="social-btn-roll-icons">
                                                <i class="social-btn-roll-icon fa fa-twitter"></i>
                                                <i class="social-btn-roll-icon fa fa-twitter"></i>
                                            </div>
                                        </a>
                                    </li>

                                    <!-- Social Media -->
                                    <li>
                                        <a href="#" class="social-btn-roll google-plus">
                                            <div class="social-btn-roll-icons">
                                                <i class="social-btn-roll-icon fa fa-google-plus"></i>
                                                <i class="social-btn-roll-icon fa fa-google-plus"></i>
                                            </div>
                                        </a>
                                    </li>

                                    <!-- Social Media -->
                                    <li>
                                        <a href="#" class="social-btn-roll instagram">
                                            <div class="social-btn-roll-icons">
                                                <i class="social-btn-roll-icon fa fa-instagram"></i>
                                                <i class="social-btn-roll-icon fa fa-instagram"></i>
                                            </div>
                                        </a>
                                    </li>
                                </ul>
                                <!-- End of Social Buttons -->

                            </div>
                        </div>
                        <!-- End of Widget 4 -->

                    </div>
                </div>
            </div>
            <!-- ===== END OF FOOTER WIDGET AREA ===== -->


            <!-- ===== START OF FOOTER COPYRIGHT AREA ===== -->
            <div class="footer-copyright-area ptb30">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex">
                                <div class="links">
                                    <ul class="list-inline">
                                        <li class="list-inline-item"><a href="#">Privacy & Cookies</a></li>
                                        <li class="list-inline-item"><a href="#">Terms & Conditions</a></li>
                                        <li class="list-inline-item"><a href="#">Legal Disclaimer</a></li>
                                        <li class="list-inline-item"><a href="#">Community</a></li>
                                    </ul>
                                </div>

                                <div class="copyright ml-auto">All Rights Reserved by <a href="#">Movify</a>.</div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ===== END OF FOOTER COPYRIGHT AREA ===== -->

        </footer>
        <!-- =============== END OF FOOTER =============== -->


        <!-- =============== START OF GENERAL SEARCH WRAPPER =============== -->
        <div class="general-search-wrapper">
            <form class="general-search" role="search" method="get" action="#">
                <input type="text" placeholder="Type and hit enter...">
                <span id="general-search-close" class="ti-close toggle-search"></span>
            </form>
        </div>
        <!-- =============== END OF GENERAL SEARCH WRAPPER =============== -->



        <!-- =============== START OF LOGIN & REGISTER POPUP =============== -->
        <div id="login-register-popup" class="small-dialog zoom-anim-dialog mfp-hide">


            @include('components.home.login')
            @include('components.home.register')
            @include('components.home.forgot-password')

        </div>
        <!-- =============== END OF LOGIN & REGISTER POPUP =============== -->




    <!-- ===== Start of Back to Top Button ===== -->
    <div id="backtotop">
        <a href="#"></a>
    </div>
    <!-- ===== End of Back to Top Button ===== -->


 @stop
