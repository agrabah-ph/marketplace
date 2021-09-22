@extends ('layouts.master-landing')


@section ('content')

<main>
    <section class="banner-section" style="background-image: url('{{ asset('images/landing/featured-1.jpg') }}')">
        <div class="max-width">
            <div class="inside">
                <h1 class="banner-title">Lorem ipsum dolor sit amet consectetur</h1>
                <div class="description">Consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</div>
                <a href="{{ asset('/') }}#get_started"><button class="btn-theme">Get Started</button></a>
            </div>
        </div>
    </section>

    {{--<section class="height-100 section-2" id="get_started">--}}
        {{--<div class="max-width padding">--}}
            {{--<h1 class="page-title text-center">Allow Agrabah Ventures to assist you with your agriculture financing requirements.</h1>--}}
            {{--<div class="content">--}}
                {{--<p>Agrabah Finance is an innovative loan aggregation product dedicated to providing farmers, fisherfolk, service providers, merchants, and other participants in the agricultural value chain with fair and transparent financial products and services.</p>--}}
            {{--</div>--}}

            {{--<div class="users-container">--}}
                {{--<a href="@include('landing.inc.login_link')" target="_blank" class="user-box first-el active">--}}
                    {{--<h1 class="page-title">Borrower</h1>--}}
                    {{--<div class="content">Find the right loan package for your agricultural requirements and apply from the convenience of your own home.</div>--}}

                    {{--<div class="img"><img src="{{ asset('images/landing/featured-4.png') }}" class="img-fluid"></div>--}}
                {{--</a>--}}
                {{--<a href="@include('landing.inc.login_link')" target="_blank" class="user-box">--}}
                    {{--<h1 class="page-title">Loan Provider</h1>--}}
                    {{--<div class="content">Find the right loan package for your agricultural requirements and apply from the convenience of your own home.</div>--}}

                    {{--<div class="img"><img src="{{ asset('images/landing/featured-3.png') }}" class="img-fluid"></div>--}}
                {{--</a>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</section>--}}

    <section class="height-100 featured-section" id="features">
        <div class="max-width padding">
            <div class="row align-items-center">
                <div class="col-12 col-lg-6">
                    <h1 class="page-title">How Wharf works?</h1>

                    <ul class="list">
                        <li>
                            <div class="num"><span>1.</span></div>
                            <div class="content">
                                <b>Apply Online</b>
                                <p>Lorem ipsum dolor sit amet, consectetur
                                    adipiscing elit, sed do eiusmod tempor incididunt
                                    ut labore et dolore magna aliqua.</p>
                            </div>
                        </li>
                        <li>
                            <div class="num"><span>2.</span></div>
                            <div class="content">
                                <b>Get Verified</b>
                                <p>Lorem ipsum dolor sit amet, consectetur
                                    adipiscing elit, sed do eiusmod tempor incididunt
                                    ut labore et dolore magna aliqua.</p>
                            </div>
                        </li>
                        <li>
                            <div class="num"><span>3.</span></div>
                            <div class="content">
                                <b>Get Funded</b>
                                <p>Lorem ipsum dolor sit amet, consectetur
                                    adipiscing elit, sed do eiusmod tempor incididunt
                                    ut labore et dolore magna aliqua.</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="col-12 col-lg-6">
                    <img src="{{ asset('images/landing/app-mobile.png') }}" class="img-fluid app-img">
                </div>
            </div>
        </div>
    </section>

    <section class="about-section">
        <div class="row no-gutters">
            <div class="col-12 col-lg-6 about-content">
                <div class="padding">
                    <h1 class="page-title">About Agrabah Ventures</h1>
                    <div class="content">
                        <p>Agrabah Ventures, a managed service provider that offers improved efficiency in agriculture commodities trading, financing, traceability and logistics.</p>
                        <p>68% of the poorest sector under the poverty line are farmers and fisherfolks. Since the lower class are unbanked and lack of credit history, they have little to no access to financial products which pushes them to rely on loan sharks.</p>
                        <p>Agrabah is building an integrated platform that provides farmers and fisherfolks with access to market, finance and logistics. The advantage we have using the platform is getting on the ground data which gives us the power to look into trends. We now have access to data the most institution fail to capture.</p>
                        <p>We can now collect farmer and fisher folk data which includes their transactions. With this data we were able to curate a Risk Rating (Credit Score) tailored for farmers and fisherfolks.</p>
                    </div>
                    <a href="{{ route('page_about') }}" class="link">Read more about us <span class="line"></span></a>
                </div>
            </div>
            <div class="col-12 col-lg-6 about-img" style="background-image: url('{{ asset('images/landing/featured-2.jpg') }}')"></div>
        </div>
    </section>


    <section class="faq-section d-none">
        <div class="max-width padding">
            <h1 class="page-title">FAQ</h1>
            <div class="row">
                <div class="col-12 col-lg-6 mb-5 farmer">
                    <b>Farmer</b>

                    <ul>
                        <li><a href="">How to adipiscing elit, seLorem ipsum dolor sit amet, consectetur adipiscing elit?</a></li>
                        <li><a href="">How to adipiscing elit, seLorem ipsum dolor sit amet, consectetur adipiscing elit?</a></li>
                        <li><a href="">How to adipiscing elit, seLorem ipsum dolor sit amet, consectetur adipiscing elit?</a></li>
                        <li><a href="">How to adipiscing elit, seLorem ipsum dolor sit amet, consectetur adipiscing elit?</a></li>
                        <li><a href="">How to adipiscing elit, seLorem ipsum dolor sit amet, consectetur adipiscing elit?</a></li>
                    </ul>
                </div>
                <div class="col-12 col-lg-6 mb-5 loan-providers">
                    <b>Loan Provider</b>

                    <ul>
                        <li><a href="">How to adipiscing elit, seLorem ipsum dolor sit amet, consectetur adipiscing elit?</a></li>
                        <li><a href="">How to adipiscing elit, seLorem ipsum dolor sit amet, consectetur adipiscing elit?</a></li>
                        <li><a href="">How to adipiscing elit, seLorem ipsum dolor sit amet, consectetur adipiscing elit?</a></li>
                        <li><a href="">How to adipiscing elit, seLorem ipsum dolor sit amet, consectetur adipiscing elit?</a></li>
                        <li><a href="">How to adipiscing elit, seLorem ipsum dolor sit amet, consectetur adipiscing elit?</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</main>


@stop
@section ('scripts')

@endsection
