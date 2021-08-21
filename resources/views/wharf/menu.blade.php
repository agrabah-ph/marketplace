<li class="{{ (request()->is('home')) ? 'active' : '' }}">
    <a href="{!! route('home') !!}"><i class="fa fa-tachometer"></i> <span class="nav-label">Home</span></a>
</li>

@if(auth()->user()->can('read-spot-market')  && isCommunityLeader())
    <li class="{{ (request()->is('spot-market*')) && !request()->is('spot-market-winning-bids') ? 'active' : '' }}">
        <a href="#"><i class="fa fa-list-alt"></i> <span class="nav-label">My Spot Market</span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <li class="{{ (request()->is('spot-market')) ? 'active' : '' }}"><a href="{!! route('spot-market.index') !!}">My List</a></li>

            @if(auth()->user()->can('add-spot-market'))
            <li class="{{ (request()->is('spot-market/create')) ? 'active' : '' }}"><a href="{!! route('spot-market.create') !!}">Create</a></li>
            @endif
        </ul>
    </li>
    <li class="{{ (request()->is('spot-market-winning-bids')) ? 'active' : '' }}">
        <a href="{!! route('spot-market.winning_bids') !!}"><i class="fa fa-trophy"></i> <span class="nav-label">Winning Bids</span></a>
    </li>
@endif
@if(auth()->user()->can('browse-spot-market')  && !isCommunityLeader())
    <li class="{{ (request()->is('spot-market')) ? 'active' : '' }}">
        <a href="{!! route('spot-market.index') !!}"><i class="fa fa-list"></i> <span class="nav-label">Spot Market</span></a>
    </li>
    <li class="{{ (request()->is('spot-market-my-orders')) ? 'active' : '' }}">
        <a href="{!! route('spot-market.my_bids') !!}"><i class="fa fa-trophy"></i> <span class="nav-label">My Bids</span></a>
    </li>
@endif
{{--@if(auth()->user()->can('buy-spot-market'))--}}
{{--    <li class="{{ (request()->is('spot-market-cart')) ? 'active' : '' }}">--}}
{{--        <a href="{!! route('spot-market.cart') !!}"><i class="fa fa-shopping-cart"></i> <span class="nav-label">Cart</span></a>--}}
{{--    </li>--}}
{{--@endif--}}
