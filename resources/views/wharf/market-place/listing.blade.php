@extends('wharf.master')

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
        <div class="row">

            @forelse($marketList as $data)
                <div class="col-md-3">
                    <div class="ibox listing-item">
                        <a href="{{route('market-place-show', $data->id)}}">
                            <div class="card">
                                <div class="card-img">
                                    <div class="img" style="background-image: url({!! ($data->hasMedia('market-place')? url('/').$data->getFirstMediaUrl('market-place'):'')  !!})"></div>
                                    <a href="#" class="add-to-cart float d-none d-lg-block"  data-name="{{$data->name}}" data-id="{{$data->id}}"> <i class="fa fa-cart-plus"></i> Add to Cart  </a>
                                </div>
                                <div class="card-content">
                                    <div class="title">{{$data->name}}</div>
                                    <a href="#" class="add-to-cart d-block d-lg-none"  data-name="{{$data->name}}" data-id="{{$data->id}}"> <i class="fa fa-cart-plus"></i> Add to Cart  </a>
                                </div>
                                <div class="price">₱{{$data->selling_price}}</div>
                            </div>
                        </a>
                    </div>

                    {{--<div class="ibox">--}}
                        {{--<a href="{{route('market-place-show', $data->id)}}" class="" style="color: #000!important;">--}}
                        {{--<div class="ibox-content product-box">--}}
                                {{--<div class="product-imitation" style="background-image: url('{!! ($data->hasMedia('market-place')? url('/').$data->getFirstMediaUrl('market-place'):'')  !!}')">--}}
                                    {{--                            {{$data->name}}--}}
                                {{--</div>--}}
                            {{--<div class="product-desc">--}}
{{--                                <pre>{{json_encode($data, 128)}}</pre>--}}
{{--                                <pre>{!! ($data->hasMedia('market-place')? $data->getFirstMediaUrl('market-place'):'')  !!}</pre>--}}
                                {{--<span class="product-price">--}}
                                   {{--₱{{$data->selling_price}}--}}
                                {{--</span>--}}
                                {{--<small class="text-muted d-none">Category</small>--}}
                                {{--<p href="{{route('market-place-show', $data->id)}}" class="product-name"> {{$data->name}}</p>--}}
                                {{--<div class="small m-t-xs d-none">--}}
                                    {{--{!! $data->description !!}--}}
                                {{--</div>--}}
                                {{--<div class="m-t">--}}
                                    {{--<a href="#" class="btn btn-sm btn-primary w-100 add-to-cart"  data-name="{{$data->name}}" data-id="{{$data->id}}"> <i class="fa fa-cart-plus"></i> Add to Cart  </a>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--</a>--}}
                    {{--</div>--}}

                </div>
            @empty
                <div class="col-12">
                    <h1 class="text-center w-100">No Listing Yet</h1>
                </div>
            @endforelse
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
                    <strong id="item_added_to_cart"></strong> has been added to cart.
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
        $(document).ready(function(){
            $('.footable').footable();

            let toast1 = $('.toast1');
            toast1.toast({
                delay: 5000,
                animation: true
            });

            $('.add-to-cart').on('click', function(e){
                e.preventDefault();
                toast1.toast('show');
                var item = $(this).data('name');
                var itemId = $(this).data('id');
                addToCart(itemId);
                $('#item_added_to_cart').html(item);
            })
        });

        function addToCart(id){

            $.ajax({
                url: "{{route('market-place-add_cart')}}",
                type:"POST",
                data:{
                    id:id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success:function(response){
                    $('#spot_market_cart_count').html(response);

                },
            });
            console.log(id)
        }
    </script>
@endsection
