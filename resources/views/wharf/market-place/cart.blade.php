@extends('wharf.master')

@section('title', 'Cart')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
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
        <div class="col-sm-8">
            <div class="title-action">
            </div>
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content cart-container">


        <div class="row">
            <div class="col-md-9">

                <div class="ibox">
                    <div class="ibox-title">
                        <span class="float-right">(<strong id="cart_count">{{getUserSpotMarketCartCount()}}</strong>) items</span>
                        <h5>Items in your cart</h5>
                    </div>
                    @forelse($cart as $cartItem)
                        <div class="ibox-content">
                            <div class="cart-list">
                                <div class="cart-item">
                                    <div class="row align-items-center">
                                        <div class="col-12 col-lg-4">
                                            <div class="column-1 d-flex align-items-center">
                                                <a href="{{route('market-place-show', $cartItem->id)}}">
                                                    <div class="cart-product-imitation">
                                                        {{--                                                    {!! ($cartItem->hasMedia('market-place')? "<img class='img-thumbnail' src='".url('/').$cartItem->getFirstMediaUrl('market-place')."'>":'')  !!}--}}
                                                        <div class="img"
                                                             style="background-image: url({{ url('/').$cartItem->getFirstMediaUrl('market-place') }})"></div>

                                                    </div>
                                                </a>

                                                <h3>
                                                    <a href="#" class="text-navy">
                                                        <a href="{{route('market-place-show', $cartItem->id)}}"
                                                           class="product-name"> {{$cartItem->name}}</a>
                                                        <div class="price">
                                                            ₱{{  number_format($cartItem->selling_price, 2) }}
                                                            {{--                                                            <s class="small text-muted"> ₱{{ number_format($cartItem->original_price,2) }}</s>--}}
                                                        </div>
                                                    </a>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="column-2">
                                                <div class="counter" id="counter_{{ $cartItem->id }}">
                                                    <div class="counter-trigger counter-minus"
                                                         data-id="{{ $cartItem->id }}" data-action="minus"><img
                                                                src="https://img.icons8.com/ios/20/000000/minus-math.png"/>
                                                    </div>
                                                    <input type="text" class="form-control changeSummaryTotal"
                                                           data-inv="{{$cartItem->quantity}}"
                                                           data-id="{{$cartItem->id}}"
                                                           data-cart_id="{{$cartItem->cart_id}}"
                                                           data-target="#sub_total_{{$cartItem->id}}"
                                                           data-price="{{$cartItem->selling_price}}"
                                                           value="{{$cartItem->cart_quantity}}" placeholder="1">
                                                    <div class="counter-trigger counter-plus"
                                                         data-id="{{ $cartItem->id }}" data-action="plus"><img
                                                                src="https://img.icons8.com/ios/20/000000/plus-math.png"/>
                                                    </div>
                                                    <small class="text-muted pl-1 d-flex align-items-center" style="white-space: nowrap">
                                                        {{$cartItem->quantity<0?0:$cartItem->quantity}} stock(s) available
                                                    </small>
                                                </div>
                                                <small class="text-danger cart-qty-errors cart-qty-error-{{$cartItem->id}}"></small>
                                                {{--                                                @if($cartItem->quantity<0)--}}
                                                {{--                                                    <small class="text-danger">Out of stock!</small>--}}
                                                {{--                                                @elseif($cartItem->quantity < $cartItem->cart_quantity)--}}
                                                {{--                                                    <small class="text-danger">{{$cartItem->quantity}} stock{{$cartItem->quantity>1?'s':''}} available!</small>--}}
                                                {{--                                                @endif--}}
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="column-3">
                                                <div class="sub-total-price">
                                                    ₱<span class="sub_total_per_item"
                                                           id="sub_total_{{$cartItem->id}}">{{ number_format($cartItem->selling_price * $cartItem->cart_quantity,2) }}</span>
                                                </div>
                                                <a href="#" class="text-muted remove-item"
                                                   data-id="{{$cartItem->cart_id}}"><i class="fa fa-trash"></i></a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="ibox-content">
                            <h1 class="text-center">--</h1>
                        </div>
                    @endforelse
                    <div class="ibox-content">

                        <button class="btn btn-primary float-right show_confirm_modal"><i
                                    class="fa fa fa-shopping-cart"></i> Confirm Order
                        </button>
                        <a href="{{route('market-place-listing')}}" class="btn btn-white"><i
                                    class="fa fa-arrow-left"></i> Continue shopping</a>

                    </div>
                </div>

            </div>
            <div class="col-md-3">

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Cart Summary</h5>
                    </div>
                    <div class="ibox-content">
                            <span>
                                Total
                            </span>
                        <h2 class="font-bold">
                            ₱<span id="total_summary">0</span>
                        </h2>

                        <hr/>
                        <span class="text-muted small">
                                *For faster transaction we suggest to do the payment via GCash
                            </span>
                        <div class="m-t-sm">
                            <div class="btn-group">
                                <a href="#" class="btn btn-primary btn-sm show_confirm_modal"><i
                                            class="fa fa-shopping-cart"></i> Confirm Order</a>
                                {{--                                <a href="#" class="btn btn-white btn-sm"> Cancel</a>--}}
                            </div>
                        </div>
                    </div>
                </div>

                @if(settings('agrabah-mobile-number'))
                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Support</h5>
                    </div>
                    <div class="ibox-content text-center">
                        <h3><i class="fa fa-phone"></i> {{settings('agrabah-mobile-number')}}</h3>
                        <span class="small">
                                Please contact with us if you have any questions. We are available 24h.
                            </span>
                    </div>
                </div>
                @endif


            </div>
        </div>


    </div>

    <div class="modal inmodal fade" id="confirm_order_modal" data-type="" tabindex="-1" role="dialog" aria-hidden="true"
         data-category="" data-variant="" data-bal="">
        <div id="modal-size" class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="padding: 15px;">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Order Confirmation</h4>
                </div>
                <div class="modal-body">
                    @include('wharf.market-place.includes.how_to_pay')
                    <hr>
                    <div class="card">
                        <div class="card card-body">
                            <p>Once locked in, your order will be brought to <span class="text-info">My Orders</span>
                                page, you cancel anytime if the order is not yet verified or you haven't made a payment.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-save-btn"><i class="fa fa-lock"></i> Lock In
                    </button>
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
                    <strong id="item_added_to_cart"></strong> has been added to cart.
                </div>
                Cart
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
    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}
    <style>
        .cart-product-imitation {
            padding: 0 !important;
        }
    </style>
    {{--{!! Html::style('') !!}--}}
    {{--    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}
    {{--    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}--}}
@endsection

@section('scripts')
    {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}
    {!! Html::script('js/template/plugins/footable/footable.all.min.js') !!}
    {{--    {!! Html::script('') !!}--}}
    {{--    {!! Html::script(asset('vendor/datatables/buttons.server-side.js')) !!}--}}
    {{--    {!! $dataTable->scripts() !!}--}}
    {{--    {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}--}}
    {{--    {!! Html::script('/js/template/moment.js') !!}--}}
    <script>
        function numberWithCommas(x) {
            return x.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function numberRemoveCommas(x) {
            return x.toString().replace(/,/g, "");
        }

        $(document).on('click', '.show_confirm_modal', function () {
            $('#confirm_order_modal').modal('show');
        });

        let lockInFields = [];
        $(document).on('click', '#modal-save-btn', function () {
            //market-place.lock_in_order
            console.log(lockInFields)
            $.ajax({
                url: "{{route('market-place-lock_in_order')}}",
                type: "POST",
                data: {
                    form: JSON.stringify(lockInFields),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log(response)
                    if (response.status) {
                        window.location.replace("{{route('market-place-my_orders')}}");
                    } else {
                        swal("Sorry!", response.msg, "error");

                    }
                },
            });
        });
        $(document).on('click', '.remove-item', function () {
            //market-place.lock_in_order
            var id = $(this).data('id');
            var item = $(this);
            // return 1;
            $.ajax({
                url: "{{route('market-place-remove_item')}}",
                type: "POST",
                data: {
                    id: id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    item.closest('.ibox-content').remove()
                    computeTotalSummary()
                    computeTotalCount();
                },
            });
        });


        function validateCart() {

            $.ajax({
                url: "{{route('market-place-cart-validate')}}",
                type: "POST",
                data: {
                    form: JSON.stringify(lockInFields),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('.cart-qty-errors').html('');
                    if (response.status === false) {
                        let errArr = response.errors;
                        for (let i = 0; i < errArr.length; i++) {
                            const err = errArr[i];
                            console.log(err)
                            $('.cart-qty-error-' + err.id).html(err.msg);
                            let errInput = $('#counter_' + err.id);
                            errInput.find('input').data('inv', err.marketPlace);
                            // errInput.find('input').addClass('disabled');
                            var target = errInput.find('input').data('target');
                            $(target).html(numberWithCommas(0));
                            // errInput.find('.counter-plus').addClass('disabled');
                            // errInput.find('.counter-minus').addClass('disabled');
                        }
                        computeTotalSummary();
                        computeTotalCount();
                        $('.show_confirm_modal').hide();
                    } else {
                        $('.show_confirm_modal').show();
                    }
                },
            });
        }

        $(document).ready(function () {
            $('.changeSummaryTotal').on('keyup', function (e) {

                var target = $(this).data('target');
                var price = $(this).data('price');
                var inv = $(this).data('inv');
                var qty = $(this).val();

                if (isNaN(qty) || qty == '' || qty == 0) {
                    qty = 1;
                    $(this).val(1);
                }
                if(inv < 0){
                    $(this).val(0);
                }
                if (inv >= qty) {
                    $(target).html(numberWithCommas(parseFloat(numberRemoveCommas(price)) * qty));
                }
                computeTotalSummary();
                computeTotalCount();
                validateCart()

            })

            computeTotalSummary()
            computeTotalCount();
            validateCart();

        });

        function computeTotalCount() {
            var count = 0;
            lockInFields = [];
            $('.changeSummaryTotal:not(.disabled)').each(function (i, e) {

                var target = $(e).data('target');
                var price = $(e).data('price');
                var id = $(e).data('id');
                var cart_id = $(e).data('cart_id');
                var sub_total = parseFloat(numberRemoveCommas($(target).html()));
                let qty = parseInt($(e).val());
                if (isNaN(qty)) {
                    qty = 1;
                }
                count += qty;
                let array = {id: id, cart_id: cart_id, price: price, qty: qty, sub_total: sub_total};
                lockInFields.push(array);
            });
            $('#cart_count').html(parseInt(count));
        }

        function computeTotalSummary() {

            var subTotalPerItem = $('.sub_total_per_item');
            var total = 0;
            subTotalPerItem.each(function (i, e) {
                let eVal = parseFloat(numberRemoveCommas(e.innerHTML));
                total += eVal;
            });
            $('#total_summary').html(numberWithCommas(total));

        }

        $(document).on('click', '.counter-trigger:not(.disabled)', function () {
            var id = $(this).data('id');
            var action = $(this).data('action');
            var input = $(this).parent().find('input');
            var inv = input.data('inv');
            var old_value = input.val();
            var new_value = 0;

            if (action === 'plus') {
                new_value = Number(old_value) + 1;
            } else {
                if (old_value !== 0) {
                    new_value = Number(old_value) - 1;
                }
            }

            if(inv < new_value){
                new_value = inv;
            }
            if(new_value < 1){
                new_value = 1;
            }
            input.val(new_value).trigger('keyup');


            console.log('id => ' + id);
            console.log('action => ' + action);
            console.log('old_value => ' + old_value);
            console.log('new_value => ' + new_value);
            console.log('inc => ' + inv);
        });
    </script>
@endsection
