<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Trace | @yield('title')</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon_io/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon_io/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon_io/favicon-16x16.png">
    <link rel="manifest" href="/favicon_io/site.webmanifest">

    <link href="/css/app.css" rel="stylesheet">
    <link href="/font-awesome/css/font-awesome.css" rel="stylesheet">

    <link href="/css/template/animate.css" rel="stylesheet">
    <link href="/css/template/style.css" rel="stylesheet">
    @yield('styles')
</head>

<body class="gray-bg">

    <div id="app">
        @yield('page-menu')

        <div id="inSlider" class="carousel slide" data-ride="carousel" >
            <ol class="carousel-indicators">
                <li data-target="#inSlider" data-slide-to="0" class="active"></li>
                <li data-target="#inSlider" data-slide-to="1"></li>
            </ol>
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <div class="container">
{{--                        <div class="carousel-caption">--}}
{{--                            <h1>We craft<br/>--}}
{{--                                brands, web apps,<br/>--}}
{{--                                and user interfaces<br/>--}}
{{--                                we are IN+ studio</h1>--}}
{{--                            <p>Lorem Ipsum is simply dummy text of the printing.</p>--}}
{{--                        </div>--}}
                    </div>
                    <!-- Set background for slide in css -->
                    <div class="header-back one"></div>

                </div>

                <div class="carousel-item">
                    <div class="container">
{{--                        <div class="carousel-caption blank">--}}
{{--                            <h1>We create meaningful <br/> interfaces that inspire.</h1>--}}
{{--                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam.</p>--}}
{{--                        </div>--}}
                    </div>
                    <!-- Set background for slide in css -->
                    <div class="header-back two"></div>
                </div>

                <div class="carousel-item">
                    <div class="container">
{{--                        <div class="carousel-caption blank">--}}
{{--                            <h1>We create meaningful <br/> interfaces that inspire.</h1>--}}
{{--                            <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam.</p>--}}
{{--                        </div>--}}
                    </div>
                    <!-- Set background for slide in css -->
                    <div class="header-back three"></div>
                </div>

            </div>
            <a class="carousel-control-prev" href="#inSlider" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#inSlider" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        @yield('content')

        <section id="contact" class="contact">
            <div class="container">
                <div class="row m-b-lg">
                    <div class="col-lg-12 text-center">
                        <div class="navy-line"></div>
                        <h1>Contact Us</h1>
{{--                        <p>Donec sed odio dui. Etiam porta sem malesuada magna mollis euismod.</p>--}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h3 class="text-success">Agrabah</h3>
                    </div>
                </div>
                <div class="row m-b-lg justify-content-center">
                    <div class="col-lg-3">
                        <address>
                            <strong><span class="text-success">Head Office</span></strong><br/>
                            
                            <abbr title="Phone"><i class="fa fa-phone"></i> : </abbr>
                        </address>
                    </div>
                    <div class="col-lg-3 text-right">
                        <address>
                            <strong><span class="text-success">Ortigas Office</span></strong><br/>
                            10th Floor, Unit 1018,<br/>
                            AIC Burgundy Empire Tower,<br/>
                            ADB Avenue corner Garnet St., Ortigas Center,<br/>
                            Pasig, Metro Manila, <br>
                            Philippines <br>
                            <abbr title="Mobile"><i class="fa fa-mobile-phone"></i> : </abbr> (63) 977 360 1969
                        </address>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <a href="mailto:ltgcreditline.hr@gmail.com" class="btn btn-primary">Send us mail</a>
                        <p class="m-t-sm">
                            Or follow us on social platform
                        </p>
                        <ul class="list-inline social-icon">
                            
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 text-center m-t-lg m-b-lg">
                        <p></p>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <!-- Mainly scripts -->
    <script src="/js/app.js"></script>
    {{--<script src="js/jquery-3.1.1.min.js"></script>--}}
    <script src="/js/template/popper.min.js"></script>
    {{--<script src="js/bootstrap.js"></script>--}}
    <script src="/js/template/plugins/metisMenu/jquery.metisMenu.js"></script>
    <script src="/js/template/plugins/slimscroll/jquery.slimscroll.min.js"></script>

    <!-- Custom and plugin javascript -->
    <script src="/js/template/inspinia.js"></script>
    <script src="/js/template/plugins/pace/pace.min.js"></script>
    <script src="/js/template/plugins/wow/wow.min.js"></script>
    @yield('scripts')

    <script>
        $(document).ready(function(){
            $('body').attr('id', 'page-top').removeClass().addClass('landing-page no-skin-config')
            $('body').scrollspy({
                target: '#navbar',
                offset: 80
            });

            // Page scrolling feature
            $('a.page-scroll').bind('click', function(event) {
                var link = $(this);
                $('html, body').stop().animate({
                    scrollTop: $(link.attr('href')).offset().top - 50
                }, 500);
                event.preventDefault();
                $("#navbar").collapse('hide');
            });
        });
        var cbpAnimatedHeader = (function() {
            var docElem = document.documentElement,
                header = document.querySelector( '.navbar-default' ),
                didScroll = false,
                changeHeaderOn = 200;
            function init() {
                window.addEventListener( 'scroll', function( event ) {
                    if( !didScroll ) {
                        didScroll = true;
                        setTimeout( scrollPage, 250 );
                    }
                }, false );
            }
            function scrollPage() {
                var sy = scrollY();
                if ( sy >= changeHeaderOn ) {
                    $(header).addClass('navbar-scroll')
                }
                else {
                    $(header).removeClass('navbar-scroll')
                }
                didScroll = false;
            }
            function scrollY() {
                return window.pageYOffset || docElem.scrollTop;
            }
            init();

        })();

        // Activate WOW.js plugin for animation on scrol
        new WOW().init();
    </script>
</body>


</html>
