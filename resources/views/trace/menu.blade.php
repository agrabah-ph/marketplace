<li class="{{ (request()->is('home')) ? 'active' : '' }}">
    <a href="{!! route('home') !!}"><i class="fa fa-tachometer"></i> <span class="nav-label">Dashboard</span></a>
</li>

@if(auth()->user()->hasRole('community-leader'))

    <li class="{{ (request()->is('farmer*')) ? 'active' : '' }}">
        <a href="{!! route('farmer.index') !!}"><i class="fa fa-users"></i> <span class="nav-label">Farmer</span></a>
    </li>

    <li class="{{ (request()->is('inventory*')) ? 'active' : '' }}">
        <a href="{!! route('inventory.index') !!}"><i class="fa fa-list-alt"></i> <span class="nav-label">Inventory</span></a>
    </li>

    <li class="{{ (request()->is('product*')) ? 'active' : '' }}">
        <a href="{!! route('product.index') !!}"><i class="fa fa-cubes"></i> <span class="nav-label">Products</span></a>
    </li>

    <li class="{{ (request()->is('trace*')) ? 'active' : '' }}">
        <a href="#"><i class="fa fa-truck"></i> <span class="nav-label">Trace</span><span class="fa arrow"></span></a>
        <ul class="nav nav-second-level collapse">
            <li class="{{ (request()->is('trace')) ? 'active' : '' }}"><a href="{!! route('trace.index') !!}">List</a></li>
            <li class="{{ (request()->is('trace/create')) ? 'active' : '' }}"><a href="{!! route('trace.create') !!}">Create</a></li>
        </ul>
    </li>

@endif
