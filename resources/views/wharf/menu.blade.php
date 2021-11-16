<li class="{{ (request()->is('home')) ? 'active' : '' }}">
    <a href="{!! route('home') !!}"><i class="fa fa-tachometer"></i> <span class="nav-label">Home</span></a>
</li>

@if(isCommunityLeader())
    <li class="{{ (request()->is('market-place*')) && !request()->is('market-place-*') ? 'active' : '' }}">
        <a href="#"><i class="fa fa-shopping-bag"></i> <span class="nav-label">Marketplace</span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <li class="{{ (request()->is('market-place-listinbanyerag')) ? 'active' : '' }}"><a href="{!! route('market-place-listing') !!}">Browse</a></li>
            <li class="{{ (request()->is('market-place')) ? 'active' : '' }}"><a href="{!! route('market-place.index') !!}">My List</a></li>
            <li class="{{ (request()->is('market-place/create')) ? 'active' : '' }}"><a href="{!! route('market-place.create') !!}">Create</a></li>
        </ul>
    </li>
    <li class="{{ (request()->is('spot-market*')) && !request()->is('spot-market-winning-bids') ? 'active' : '' }}">
        <a href="#"><i class="fa fa-list-alt"></i> <span class="nav-label">My Auctions</span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <li class="{{ (request()->is('spot-market')) ? 'active' : '' }}"><a href="{!! route('spot-market.index') !!}">My List</a></li>
            <li class="{{ (request()->is('spot-market/create')) ? 'active' : '' }}"><a href="{!! route('spot-market.create') !!}">Create</a></li>
        </ul>
    </li>

    <li class="{{ (request()->is('reverse-bidding')) ? 'active' : '' }}">
        <a href="{!! route('reverse-bidding.index') !!}"><i class="fa fa-list"></i> <span class="nav-label">Purchase Orders</span></a>
    </li>
    <li class="{{ (request()->is('spot-market-winning-bids')) ? 'active' : '' }}">
        <a href="{!! route('spot-market.winning_bids') !!}"><i class="fa fa-trophy"></i> <span class="nav-label">Winning Bids</span></a>
    </li>
{{--    <li class="{{ (request()->is('spot-market-my-orders')) ? 'active' : '' }}">--}}
{{--        <a href="{!! route('reverse-bidding.my_bids') !!}"><i class="fa fa-trophy"></i> <span class="nav-label">My Bids</span></a>--}}
{{--    </li>--}}
    <li class="{{ (request()->is('market-place-orders')) ? 'active' : '' }}">
        <a href="{!! route('market-place-orders') !!}"><i class="fa fa-building"></i> <span class="nav-label">Orders</span></a>
    </li>
    <li class="{{ (request()->is('report')) ? 'active' : '' }}">
        <a href="{!! route('report.index') !!}"><i class="fa fa-table"></i> <span class="nav-label">Report</span></a>
    </li>
@endif
@if(getRoleName() == 'buyer')
    <li class="{{ (request()->is('market-place')) ? 'active' : '' }}">
        <a href="{!! route('market-place-listing') !!}"><i class="fa fa-shopping-bag"></i> <span class="nav-label">Marketplace</span></a>
    </li>
    <li class="{{ (request()->is('spot-market')) ? 'active' : '' }}">
        <a href="{!! route('spot-market.index') !!}"><i class="fa fa-list"></i> <span class="nav-label">Auctions</span></a>
    </li>
    <li class="{{ (request()->is('spot-market-my-orders')) ? 'active' : '' }}">
        <a href="{!! route('spot-market.my_bids') !!}"><i class="fa fa-trophy"></i> <span class="nav-label">My Bids</span></a>
    </li>
    <li class="{{ (request()->is('market-place-my-orders')) ? 'active' : '' }}">
        <a href="{!! route('market-place-my_orders') !!}"><i class="fa fa-shopping-basket"></i> <span class="nav-label">My Orders</span></a>
    </li>
@endif
@if(getRoleName() == 'enterprise-client')
    <li class="{{ (request()->is('reverse-bidding*')) ? 'active' : '' }}">
        <a href="#"><i class="fa fa-list-alt"></i> <span class="nav-label">Purchase Orders</span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <li class="{{ (request()->is('reverse-bidding/')) ? 'active' : '' }}"><a href="{!! route('reverse-bidding.index') !!}">List</a></li>
            <li class="{{ (request()->is('reverse-bidding/create')) ? 'active' : '' }}"><a href="{!! route('reverse-bidding.create') !!}">Create</a></li>
        </ul>
    </li>
    <li class="{{ (request()->is('report')) ? 'active' : '' }}">
        <a href="{!! route('report.index') !!}"><i class="fa fa-table"></i> <span class="nav-label">Report</span></a>
    </li>
@endif
{{--@if(auth()->user()->can('buy-spot-market'))--}}
{{--    <li class="{{ (request()->is('spot-market-cart')) ? 'active' : '' }}">--}}
{{--        <a href="{!! route('spot-market.cart') !!}"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Cart</span></a>--}}
{{--    </li>--}}
{{--@endif--}}
