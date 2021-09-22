@extends('wharf.master')

@section('title', $data->name)

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-6">
            <h2>@yield('title')</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ route('market-place.index') }}">Marketplace</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>@yield('title')</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-6">
            <div class="title-action">
                @include('wharf.market-place.includes.cart_button')
            </div>
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content ">

        <div class="row">
            <div class="col-lg-12">

                <div class="ibox product-detail">
                    <div class="ibox-content">

                        <div class="row">
                            <div class="col-md-5">


                                <div class="product-images">

                                    <div>
                                        <div class="image-imitation">
                                            {!! ($data->hasMedia('market-place')? "<img class='img-thumbnail' src='".url('/').$data->getFirstMediaUrl('market-place')."'>":'')  !!}
                                        </div>
                                    </div>
{{--                                    <div>--}}
{{--                                        <div class="image-imitation">--}}
{{--                                            [IMAGE 2]--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div>--}}
{{--                                        <div class="image-imitation">--}}
{{--                                            [IMAGE 3]--}}
{{--                                        </div>--}}
{{--                                    </div>--}}


                                </div>

                            </div>
                            <div class="col-md-7">

                                <h2 class="font-bold m-b-xs">
                                    {{$data->name}}
                                </h2>
{{--                                <small>Many desktop publishing packages and web page editors now.</small>--}}
                                <div class="m-t-md">
                                    <h2 class="product-main-price"> ₱ {{number_format($data->current_bid, 2)}} </h2>
                                </div>
                                <hr>
                                {!! $data->description !!}
                                <hr>
{{--                                <div class="row">--}}
{{--                                    <div class="col-6">--}}
{{--                                        Selling Price--}}
{{--                                    </div>--}}
{{--                                    <div class="col-6">--}}
{{--                                        ₱{{currency_format($data->selling_price)}}--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div>
                                    <div class="btn-group">
                                        <button class="btn btn-primary btn-sm add-to-cart" data-name="{{$data->name}}" data-id="{{$data->id}}"><i class="fa fa-cart-plus"></i> Add to cart</button>
{{--                                        <button class="btn btn-white btn-sm"><i class="fa fa-star"></i> Add to wishlist <small>Coming Soon!</small></button>--}}
{{--                                        <button class="btn btn-white btn-sm"><i class="fa fa-envelope"></i> Contact with author </button>--}}
                                    </div>
                                </div>



                            </div>
                        </div>

                    </div>
                    <div class="ibox-footer d-none">
                            <span class="float-right">
                                Full stock - <i class="fa fa-clock-o"></i> 14.04.2016 10:04 pm
                            </span>
                        The generated Lorem Ipsum is therefore always free
                    </div>
                </div>

            </div>
        </div>
    </div>


    <div style="position: absolute; top: 60px; right: 20px;">

        <div class="toast toast1 toast-bootstrap toast-success" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="fa fa-cart-plus"> </i>
                <strong class="mr-auto m-l-sm">Add to Cart</strong>
                {{--                <small>2 seconds ago</small>--}}
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="toast-body">
                <strong id="item_added_to_cart"></strong> has been added to Cart.
            </div>
        </div>

    </div>
@endsection


@section('styles')
    {!! Html::style('css/template/plugins/footable/footable.core.css') !!}
    {!! Html::style('css/template/plugins/toastr/toastr.min.css') !!}
    <style>
        .count-info .label {
            font-size: 12px;
            border-radius: 2em;
            top: 21px !important;
            padding: 4px 7px !important;
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
            }
        });
    </script>
@endsection
