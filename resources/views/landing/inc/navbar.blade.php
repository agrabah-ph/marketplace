
<header>
    <div class="header-left">
        <div class="header-logo">
            <a href="{{ asset('/') }}"><img src="{{ asset('images/landing/logo.png') }}" class="img-fluid logo"></a>
            <a href="{{ asset('/') }}"><img src="{{ asset('images/landing/logo-icon.png') }}" class="img-fluid logo-icon"></a>
        </div>
        <navbar>
            <ul>
                <li>
                    <a href="{{ asset('/') }}#features">How It Works</a>
                </li>
                <li>
                    <a href="{{ route('page_about') }}">About Us</a>
                </li>
                {{--<li>--}}
                    {{--<a href="{{ asset('/') }}">FAQ</a>--}}
                {{--</li>--}}
            </ul>
        </navbar>
    </div>

    <div class="header-right">
        <navbar>
            <ul>
                <li>
                    <a href="{{ route('page_contacts') }}">Contact</a>
                </li>
            </ul>
        </navbar>
        <a href="@include('landing.inc.login_link')"><div class="btn-login">Login</div></a>
        <div class="menu-icon menu_burger d-block d-lg-none">
            <img src="https://img.icons8.com/material-outlined/50/3A8CDD/menu.png"/>
        </div>
    </div>


</header>

<div class="mobile-nav">
    <img src="https://img.icons8.com/ios/70/ffffff/multiply.png" class="d-block ml-auto menu_burger"/>
    <navbar>
        <ul>
            <li>
                <a href="{{ asset('/') }}#features">Features</a>
            </li>
            <li>
                <a href="{{ route('page_about') }}">About Us</a>
            </li>
            {{--<li>--}}
                {{--<a href="{{ asset('/') }}">FAQ</a>--}}
            {{--</li>--}}
            <li>
                <a href="{{ route('page_contacts') }}">Contact</a>
            </li>
        </ul>
    </navbar>
</div>