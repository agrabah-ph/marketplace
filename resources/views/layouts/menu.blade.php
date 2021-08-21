<li class="{{ (request()->is('home')) ? 'active' : '' }}">
    <a href="{!! route('home') !!}"><i class="fa fa-tachometer"></i> <span class="nav-label">Dashboard</span></a>
</li>

<li class="{{ (request()->is('purchase-order*')) ? 'active' : '' }}">
    <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Purchase Order</span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="{{ (request()->is('purchase-order')) ? 'active' : '' }}"><a href="{!! route('purchase-order.index') !!}">List</a></li>
        <li class="{{ (request()->is('purchase-order/create')) ? 'active' : '' }}"><a href="{!! route('purchase-order.create') !!}">Create</a></li>
    </ul>
</li>
{{--<li class="">--}}
{{--    <a href="#"><i class="fa fa-user-circle-o"></i> <span class="nav-label">Personnel</span><span class="fa arrow"></span></a>--}}
{{--    <ul class="nav nav-second-level collapse">--}}
{{--        <li class=""><a href="{!! route('personnel.index') !!}">List</a></li>--}}
{{--        @if(auth()->user()->can('add-personnel'))--}}
{{--            <li class=""><a href="{!! route('personnel.create') !!}">Create</a></li>--}}
{{--        @endif--}}
{{--    </ul>--}}
{{--</li>--}}


@if(auth()->user()->hasRole('master-farmer'))

    <li class="{{ (request()->is('farmer*')) ? 'active' : '' }}">
        <a href="{!! route('farmer.index') !!}"><i class="fa fa-users"></i> <span class="nav-label">Farmer</span></a>
    </li>

{{--    <li class="{{ (request()->is('farmer*')) ? 'active' : '' }}">--}}
{{--        <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Farmer</span><span class="fa arrow"></span></a>--}}
{{--        <ul class="nav nav-second-level collapse">--}}
{{--            <li class="{{ (request()->is('farmer')) ? 'active' : '' }}"><a href="{!! route('farmer.index') !!}">List</a></li>--}}
{{--            <li class="{{ (request()->is('farmer/create')) ? 'active' : '' }}"><a href="{!! route('farmer.create') !!}">Create</a></li>--}}
{{--        </ul>--}}
{{--    </li>--}}

    <li class="{{ (request()->is('inventory*')) ? 'active' : '' }}">
        <a href="{!! route('inventory.index') !!}"><i class="fa fa-list-alt"></i> <span class="nav-label">Inventory</span></a>
    </li>

{{--    <li class="{{ (request()->is('inventory*')) ? 'active' : '' }}">--}}
{{--        <a href="#"><i class="fa fa-list-alt"></i> <span class="nav-label">Inventory</span><span class="fa arrow"></span></a>--}}
{{--        <ul class="nav nav-second-level collapse">--}}
{{--            <li class="{{ (request()->is('inventory')) ? 'active' : '' }}"><a href="{!! route('inventory.index') !!}">List</a></li>--}}
{{--            <li class="{{ (request()->is('inventory/create')) ? 'active' : '' }}"><a href="{!! route('inventory.create') !!}">Create</a></li>--}}
{{--        </ul>--}}
{{--    </li>--}}

    <li class="{{ (request()->is('product*')) ? 'active' : '' }}">
        <a href="{!! route('product.index') !!}"><i class="fa fa-cubes"></i> <span class="nav-label">Products</span></a>
    </li>

{{--    <li class="{{ (request()->is('product*')) ? 'active' : '' }}">--}}
{{--        <a href="#"><i class="fa fa-cubes"></i> <span class="nav-label">Products</span><span class="fa arrow"></span></a>--}}
{{--        <ul class="nav nav-second-level collapse">--}}
{{--            <li class="{{ (request()->is('product')) ? 'active' : '' }}"><a href="{!! route('product.index') !!}">List</a></li>--}}
{{--            <li class="{{ (request()->is('product/create')) ? 'active' : '' }}"><a href="{!! route('product.create') !!}">Create</a></li>--}}
{{--        </ul>--}}
{{--    </li>--}}

    <li class="{{ (request()->is('trace*')) ? 'active' : '' }}">
        <a href="#"><i class="fa fa-truck"></i> <span class="nav-label">Trace</span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <li class="{{ (request()->is('trace')) ? 'active' : '' }}"><a href="{!! route('trace.index') !!}">List</a></li>
            <li class="{{ (request()->is('trace/create')) ? 'active' : '' }}"><a href="{!! route('trace.create') !!}">Create</a></li>
        </ul>
    </li>

@endif


@if(auth()->user()->hasRole('super-admin'))

    <li class="{{ (request()->is('community-leader*')) ? 'active' : '' }}">
        <a href="#"><i class="fa fa-users"></i> <span class="nav-label">Community Leader</span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <li class="{{ (request()->is('master-farmer')) ? 'active' : '' }}"><a href="{!! route('community-leader.index') !!}">List</a></li>
            <li class="{{ (request()->is('master-farmer/create')) ? 'active' : '' }}"><a href="{!! route('community-leader.create') !!}">Create</a></li>
        </ul>
    </li>

    <li class="{{ (request()->is('farmer*')) ? 'active' : '' }}">
        <a href="{!! route('farmer.index') !!}"><i class="fa fa-user-circle"></i> <span class="nav-label">Farmer</span></a>
    </li>

    <li class="{{ (request()->is('product*')) ? 'active' : '' }}">
        <a href="#"><i class="fa fa-cubes"></i> <span class="nav-label">Products</span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <li class="{{ (request()->is('product')) ? 'active' : '' }}"><a href="{!! route('product.index') !!}">List</a></li>
            <li class="{{ (request()->is('product/create')) ? 'active' : '' }}"><a href="{!! route('product.create') !!}">Create</a></li>
        </ul>
    </li>

    <li class="{{ (request()->is('inventory*')) ? 'active' : '' }}">
        <a href="{!! route('inventory.index') !!}"><i class="fa fa-list-alt"></i> <span class="nav-label">Inventory</span></a>
    </li>

    <li class="{{ (request()->is('trace*')) ? 'active' : '' }}">
        <a href="{!! route('trace.index') !!}"><i class="fa fa-truck"></i> <span class="nav-label">Trace</span></a>
    </li>

{{--    <li class="">--}}
{{--        <a href="#"><i class="fa fa-gears"></i> <span class="nav-label">Administrator</span><span class="fa arrow"></span></a>--}}
{{--        <ul class="nav nav-second-level collapse">--}}
{{--            <li>--}}
{{--                <a href="#">Third Level <span class="fa arrow"></span></a>--}}
{{--                <ul class="nav nav-third-level">--}}
{{--                    <li><a href="#">Third Level Item</a></li>--}}
{{--                    <li><a href="#">Third Level Item</a></li>--}}
{{--                    <li><a href="#">Third Level Item</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}
{{--            <li class=""><a href="{!! route('role') !!}">Roles & Permissions</a></li>--}}
{{--        </ul>--}}
{{--    </li>--}}

@endif








