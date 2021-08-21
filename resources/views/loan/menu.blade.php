<li class="{{ (request()->is('home')) ? 'active' : '' }}">
    <a href="{!! route('home') !!}"><i class="fa fa-tachometer"></i> <span class="nav-label">Dashboard</span></a>
</li>

@if(auth()->user()->hasRole('loan-provider'))


<li class="{{ (request()->is('products*')) ? 'active' : '' }}">
    <a href="#"><i class="fa fa-list-alt"></i> <span class="nav-label">Loan Products</span><span class="fa arrow"></span></a>
    <ul class="nav nav-second-level collapse">
        <li class="{{ (request()->is('products')) ? 'active' : '' }}"><a href="{!! route('products.index') !!}">List</a></li>
        <li class="{{ (request()->is('products/create')) ? 'active' : '' }}"><a href="{!! route('products.create') !!}">Create</a></li>
    </ul>
</li>

<li class="{{ (request()->is('loan/applicants')) ? 'active' : '' }}">
    <a href="{!! route('loan-applicant') !!}"><i class="fa fa-pencil-square-o"></i> <span class="nav-label">Loan Application</span></a>
</li>

{{--<li class="{{ (request()->is('loan-report')) ? 'active' : '' }}">--}}
{{--    <a href="#"><i class="fa fa-cubes"></i> <span class="nav-label">Reports</span><span class="fa arrow"></span></a>--}}
{{--    <ul class="nav nav-second-level collapse">--}}
{{--        <li class="{{ (request()->is('custom-forms')) ? 'active' : '' }}"><a href="{!! route('custom-forms') !!}">Custom Forms</a></li>--}}
{{--    </ul>--}}
{{--</li>--}}


@endif

@if((auth()->user()->hasRole('farmer')) || (auth()->user()->hasRole('community-leader')))

    <li class="{{ (request()->is('loan/product/list')) ? 'active' : '' }}">
        <a href="{!! route('loan-product-list') !!}"><i class="fa fa-list-alt"></i> <span class="nav-label">Loan Products</span></a>
    </li>

    <li class="{{ (request()->is('my-loans')) ? 'active' : '' }}">
        <a href="{!! route('my-loans') !!}"><i class="fa fa-tasks"></i> <span class="nav-label">My Loans</span></a>
    </li>

{{--    <li class="{{ (request()->is('products*')) ? 'active' : '' }}">--}}
{{--        <a href="#"><i class="fa fa-bank"></i> <span class="nav-label">Loan Selector</span><span class="fa arrow"></span></a>--}}
{{--        <ul class="nav nav-second-level collapse">--}}
{{--            <li class="{{ (request()->is('products')) ? 'active' : '' }}"><a href="{!! route('products.index') !!}">List</a></li>--}}
{{--            <li class="{{ (request()->is('products/create')) ? 'active' : '' }}"><a href="{!! route('products.create') !!}">Create</a></li>--}}
{{--        </ul>--}}
{{--    </li>--}}

@endif
