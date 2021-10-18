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
                    <a href="{{ route('market-place-listing') }}">Marketplace</a>
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
                        <h2 class="product-main-price"> ₱ {{number_format($data->current_bid, 2)}} </h2>

                        <div class="row">
                            <div class="col-md-5">


                                <div class="product-images">

                                    <div>
                                        <div class="image-imitation" style="background-image: url('{!! ($data->hasMedia('market-place')? url('/').$data->getFirstMediaUrl('market-place'):'')  !!}')">
{{--                                            {!! ($data->hasMedia('market-place')? "<img class='img-thumbnail' src='".url('/').$data->getFirstMediaUrl('market-place')."'>":'')  !!}--}}
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

                                <h2 class="font-bold m-b-xs item-name">
                                    {{$data->name}}
                                </h2>
                                <div class="small"><i class="fa fa-map-marker"></i> {{$data->area??'No Area'}}</div>
                                <div class="small"><i class="fa fa-truck"></i>  {{$data->fromFarmer->name??'No Supplier'}}</div>
                                <small class="text-muted"><i class="fa fa-tags"></i>
                                    @forelse($data->categoriesRel as $category)
                                        <span class="badge badge-primary">{{$category->display_name}}</span>
                                    @empty
                                        -
                                    @endforelse

                                </small><br>
                                <small class="text-muted"><i class="fa fa-cubes"></i> {{$data->quantity>0?$data->quantity.$data->unit_of_measure_short:'Sold out'}}</small><br>


                                <div class="m-t-md">
                                </div>
                                <hr>
                                <div class="content">
                                    {!! $data->description !!}
                                </div>
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
                                    <div class="alert alert-danger out-f-stk" style="display: none">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong id="error_msg">Not Enough stock!</strong>
                                    </div>
                                    <div class="btn-group cart-list">
                                        <div class="counter">
                                            <div class="counter-trigger counter-minus" data-id="{{ $data->id }}" data-action="minus"><img src="https://img.icons8.com/ios/20/000000/minus-math.png"/></div>
                                            <input type="text" class="form-control qty"  data-id="{{$data->id}}" data-qty="{{$data->quantity}}" value="1" placeholder="1">
                                            <div class="counter-trigger counter-plus" data-id="{{ $data->id }}" data-action="plus"><img src="https://img.icons8.com/ios/20/000000/plus-math.png"/></div>
                                        </div>
                                        <a href="#" class="add-to-cart w-100 mt-0"  data-name="{{$data->name}}" data-id="{{$data->id}}"> <i class="fa fa-cart-plus"></i> Add to Cart  </a>
                                        {{--<button class="btn btn-primary btn-sm add-to-cart" data-name="{{$data->name}}" data-id="{{$data->id}}"><i class="fa fa-cart-plus"></i> Add to cart</button>--}}
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
        .count-info .label {
            font-size: 12px;
            border-radius: 2em;
            top: 21px !important;
            padding: 4px 7px !important;
        }
        .product-detail .small .fa{
            width: 18px;
            text-align: center;
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
        $(document).ready(function(){

            toast1 = $('.toast1');
            toast1.toast({
                delay: 5000,
                animation: true
            });

            $('.add-to-cart').on('click', function(e){
                e.preventDefault();
                var itemId = $(this).data('id');
                var item = $(this).data('name');
                var qtyElem = $('.qty');
                var qty =  qtyElem.val();
                var stock = qtyElem.data('qty');

                addToCart(itemId, item, qty);
            })

            function addToCart(id, item, qty){

                $.ajax({
                    url: "{{route('market-place-add_cart')}}",
                    type:"POST",
                    data:{
                        id:id,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        qty:qty,
                    },
                    success:function(response){
                        if(response.status){
                            $('#spot_market_cart_count').html(response.count);
                            $('#item_added_to_cart').html(item);
                            $('#toast-message').html("has been added to cart.");
                            toast1.removeClass('toast-danger');
                            toast1.addClass('toast-success');
                            toast1.toast('show');
                        }else{
                            $('.out-f-stk').show();
                            $('#error_msg').html(response.msg);
                        }

                    },
                });
            }
        });
    </script>

    <script>
        $(document).on('click', '.counter-trigger', function () {
            var id = $(this).data('id');
            var action = $(this).data('action');
            var old_value = $(this).parent().find('input').val();
            var new_value = 0;

            if(action == 'plus') {
                new_value = Number(old_value) + 1;
            }else {
                if(old_value != 0) {
                    new_value = Number(old_value) - 1;
                }
            }
            $(this).parent().find('input').val(new_value).trigger('keyup');




            console.log('id => ' + id);
            console.log('action => ' + action);
            console.log('old_value => ' + old_value);
            console.log('new_value => ' + new_value);
        });
    </script>

@endsection
