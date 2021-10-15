@extends('wharf.master')

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css">
@section('title', 'Marketplace')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>@yield('title')</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>@yield('title')</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                @include('wharf.market-place.includes.cart_button')
            </div>
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content">
        <div class="banner-section">
            <div class="banner-container-mobile d-block d-lg-none">
                <img src="{{ asset('images/wharf/banners/banner-1.png') }}" alt="banner" class="img-fluid d-block mx-auto">
                <div class="tagline">
                    <h1>Online Marketplace</h1>
                    <h3>@if(isCommunityLeader()) Sell At Retail @else Freshness direct from the farm @endif</h3>
                </div>
            </div>
            <div class="banner-container d-none d-lg-block" style="background-image: url('{{ asset('images/wharf/banners/banner-1.png') }}')">
                <div class="tagline">
                    <h1>Online Marketplace</h1>
                    <h3>@if(isCommunityLeader()) Sell At Retail @else Freshness direct from the farm @endif</h3>
                </div>
            </div>
        </div>
        <div class="row marketplace-container">
            <div class="col-12 col-lg-3 filters">
                <div class="ibox">
                    <div class="ibox-content">
                        <form action="" id="form_search">
                        <div class="form-group">
                            <label class="font-bold" for="null_cat">Search
                                <a href="{{route('market-place-listing')}}" class="float-right font-weight-light small">
                                Clear Filters</a>
                            </label>
                            <input type="text" class="form-control" id="filter" name="filter" value="{{request()->filter}}" placeholder="Input Search">
                        </div>
                        <div class="form-group">
                            <label class="font-bold">Areas</label>
                            <select class="form-control" id="areas" name="areas" required>
                                <option value="_all">All</option>
                                @foreach($areas as $id => $area)
                                    @if($area)
                                        <option value="{{$area}}" {{request()->areas == $area ?'selected':''}}>{{$area}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="font-bold" for="null_cat">Categories
                                <a class="float-right font-weight-light small">
                                <input type="radio" name="cat" class="d-none filter_trigger" id="null_cat" value="_all">
                                Clear Category</a>
                            </label>
                            <ul>
                                @foreach($categories as $category)
                                    <li class="{{request()->cat == $category->id?'active':''}}">
                                        <label for="cat_{{$category->id}}" class="mb-0 w-100">
                                        <div class="gr">
                                            <input type="radio" name="cat" class="d-none filter_trigger" value="{{$category->id}}" id="cat_{{$category->id}}">
                                            <img src="{{config('app.admin_url').$category->logo}}" alt=""> {{$category->display_name}}
                                        </div>
                                        </label>
                                        @if(count($category->childrenCat) > 0)
                                            <ul>
                                                @foreach($category->childrenCat as $childCategory)
                                                    <li class="{{request()->cat == $childCategory->id?'active':''}}">
                                                        <label for="cat_{{$childCategory->id}}" class="mb-0  w-100">
                                                        <input type="radio" name="cat" class="d-none filter_trigger" id="cat_{{$childCategory->id}}" value="{{$childCategory->id}}">
                                                {{$childCategory->display_name}}
                                                        </label>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-9">
                <div class="row">

                    @forelse($marketList as $data)
                        <div class="col-md-4 mb-4">
                            <div class="ibox listing-item">
                                <a href="{{route('market-place-show', $data->id)}}">
                                    <div class="card">
                                        <div class="card-img">
                                            <div class="img" style="background-image: url({!! ($data->hasMedia('market-place')? url('/').$data->getFirstMediaUrl('market-place'):'')  !!})"></div>
                                            {{--<a href="#" class="add-to-cart float d-none d-lg-block"  data-name="{{$data->name}}" data-id="{{$data->id}}">--}}
                                                {{--@if($data->quantity>0)--}}
                                                    {{--<i class="fa fa-cart-plus"></i> Add to Cart--}}
                                                {{--@else--}}
                                                    {{--Sold Out--}}
                                                {{--@endif--}}
                                            {{--</a>--}}
                                        </div>
                                        <div class="card-content">
                                            <div class="title">{{$data->name}}</div>
                                            <small class="text-muted"><i class="fa fa-map-marker"></i> {{$data->area??'No Area'}}</small><br>
                                            <small class="text-muted"><i class="fa fa-tags"></i>
                                            @forelse($data->categoriesRel as $category)
                                                <span class="badge badge-primary">{{$category->display_name}}</span>
                                            @empty
                                                -
                                            @endforelse

                                            </small><br>
                                            <small class="text-muted"><i class="fa fa-cubes"></i> {{$data->quantity>0?$data->quantity.$data->unit_of_measure_short:'Sold out'}}</small><br>

                                            <a href="#" class="add-to-cart @if($data->quantity<0) sold-out @endif"  data-name="{{$data->name}}" data-id="{{$data->id}}">
                                                @if($data->quantity>0)
                                                    <i class="fa fa-cart-plus"></i> Add to Cart
                                                @else
                                                    Sold Out
                                                @endif
                                            </a>
                                        </div>
                                        <div class="price">₱{{$data->selling_price}}</div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <h1 class="text-center w-100">Nothing to show here. </h1>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="cart-icon-container">

        <div class="toast toast1 toast-bootstrap toast-success" role="alert" aria-live="assertive" aria-atomic="true">
            {{--<div class="toast-header">--}}
                {{--<i class="fa fa-cart-plus"> </i>--}}
                {{--<strong class="mr-auto m-l-sm">Add to Cart</strong>--}}
                {{--                <small>2 seconds ago</small>--}}
                {{--<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">--}}
                    {{--<span aria-hidden="true">&times;</span>--}}
                {{--</button>--}}
            {{--</div>--}}
            <div class="toast-body">
                <div class="text">
                    <strong id="item_added_to_cart"></strong> <span id="toast-message">has been added to cart.</span>
                </div> Cart
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>

    </div>

@endsection


@section('styles')
    {!! Html::style('css/template/plugins/footable/footable.core.css') !!}
    {!! Html::style('css/template/plugins/toastr/toastr.min.css') !!}
    <style>
        .cursor-pointer {
            cursor: pointer !important;
        }
        .product-name{
            font-size: 20px!important;
        }
        .product-imitation{
            background-position: center center;
            background-size: contain;
            background-repeat: no-repeat;
        }
        .count-info .label{
            font-size: 12px;
            border-radius: 2em;
            top: 21px!important;
            padding: 4px 7px!important;
        }
    </style>
    {{--{!! Html::style('') !!}--}}
    {{--    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}
    {{--    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}--}}
@endsection

@section('scripts')
    {!! Html::script('js/template/plugins/footable/footable.all.min.js') !!}
    {{--    {!! Html::script('') !!}--}}
    {{--    {!! Html::script(asset('vendor/datatables/buttons.server-side.js')) !!}--}}
    {{--    {!! $dataTable->scripts() !!}--}}
    {{--    {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}--}}
    {{--    {!! Html::script('/js/template/moment.js') !!}--}}
    <script>
        let toast1;
        $(document).on('change','#areas', function(e){
            var value = this.value;
            window.location.href = "{{route('market-place-listing')}}?area=" + value;
        });
        $(document).on('click','.filter_trigger', function(e){
            $('#form_search').submit();
        });
        $(document).on('change','#areas', function(e){
            $('#form_search').submit();
        });

        $(document).ready(function(){
            $('.footable').footable();

            toast1 = $('.toast1');
            toast1.toast({
                delay: 5000,
                animation: true
            });

            $('.add-to-cart').on('click', function(e){
                e.preventDefault();
                var itemId = $(this).data('id');
                var item = $(this).data('name');
                addToCart(itemId, item);
            })
        });

        function addToCart(id, item){

            $.ajax({
                url: "{{route('market-place-add_cart')}}",
                type:"POST",
                data:{
                    id:id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success:function(response){
                    if(response>0){
                        $('#spot_market_cart_count').html(response);
                        $('#item_added_to_cart').html(item);
                        $('#toast-message').html("has been added to cart.");
                        toast1.removeClass('toast-danger');
                        toast1.addClass('toast-success');
                        toast1.toast('show');
                    }else{
                        $('#item_added_to_cart').html("Error");
                        $('#toast-message').html("not enough stocks.");
                        toast1.removeClass('toast-success');
                        toast1.addClass('toast-danger');
                        toast1.toast('show');
                    }

                },
            });
            console.log(id)
        }
    </script>
@endsection