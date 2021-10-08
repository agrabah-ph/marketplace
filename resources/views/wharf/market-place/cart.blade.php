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
                                        <div class="col-12 col-lg-6">
                                            <div class="column-1 d-flex align-items-center">
                                                <a href="{{route('market-place-show', $cartItem->id)}}">
                                                    <div class="cart-product-imitation">
    {{--                                                    {!! ($cartItem->hasMedia('market-place')? "<img class='img-thumbnail' src='".url('/').$cartItem->getFirstMediaUrl('market-place')."'>":'')  !!}--}}
                                                        <div class="img" style="background-image: url({{ url('/').$cartItem->getFirstMediaUrl('market-place') }})"></div>

                                                    </div>
                                                </a>

                                                <h3>
                                                    <a href="#" class="text-navy">
                                                        <a href="{{route('market-place-show', $cartItem->id)}}" class="product-name"> {{$cartItem->name}}</a>
                                                        <div class="price">
                                                            ₱{{  number_format($cartItem->selling_price, 2) }}
                                                            <s class="small text-muted"> ₱{{ number_format($cartItem->original_price,2) }}</s>
                                                        </div>
                                                    </a>
                                                </h3>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-2">
                                            <div class="column-2">
                                                <div class="counter" id="counter_{{ $cartItem->id }}">
                                                    <div class="counter-trigger counter-minus" data-id="{{ $cartItem->id }}" data-action="minus"><img src="https://img.icons8.com/ios/20/000000/minus-math.png"/></div>
                                                    <input type="text" class="form-control changeSummaryTotal"  data-id="{{$cartItem->id}}" data-cart_id="{{$cartItem->cart_id}}" data-target="#sub_total_{{$cartItem->id}}" data-price="{{$cartItem->selling_price}}" value="{{$cartItem->cart_quantity}}" placeholder="1">
                                                    <div class="counter-trigger counter-plus" data-id="{{ $cartItem->id }}" data-action="plus"><img src="https://img.icons8.com/ios/20/000000/plus-math.png"/></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-4">
                                            <div class="column-3">
                                                <div class="sub-total-price">
                                                    ₱<span class="sub_total_per_item" id="sub_total_{{$cartItem->id}}">{{ number_format($cartItem->selling_price * $cartItem->cart_quantity,2) }}</span>
                                                </div>
                                                <a href="#" class="text-muted remove-item" data-id="{{$cartItem->cart_id}}"><i class="fa fa-trash"></i></a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="table-responsive">--}}
                                {{--<table class="table shoping-cart-table">--}}
                                    {{--<tbody>--}}
                                    {{--<tr>--}}
                                        {{--<td width="90">--}}
                                            {{--<div class="cart-product-imitation">--}}
                                                {{--{!! ($cartItem->hasMedia('market-place')? "<img class='img-thumbnail' src='".url('/').$cartItem->getFirstMediaUrl('market-place')."'>":'')  !!}--}}

                                            {{--</div>--}}
                                        {{--</td>--}}
                                        {{--<td class="desc">--}}
                                            {{--<h3>--}}
                                                {{--<a href="#" class="text-navy">--}}
                                                    {{--<a href="{{route('market-place.show', $cartItem->id)}}" class="product-name"> {{$cartItem->name}}</a>--}}
                                                    {{--<div class="price">--}}
                                                        {{--₱{{$cartItem->selling_price}}--}}
                                                        {{--<s class="small text-muted"> ₱{{$cartItem->original_price}}</s>--}}
                                                    {{--</div>--}}
                                                {{--</a>--}}
                                            {{--</h3>--}}


                                            {{--<div class="m-t-sm">--}}
                                                {{--<a href="#" class="text-muted"><i class="fa fa-gift"></i> Add gift package</a>--}}
                                                {{--|--}}
                                                {{--<a href="#" class="text-muted remove-item" data-id="{{$cartItem->cart_id}}"><i class="fa fa-trash"></i> Remove item</a>--}}
                                            {{--</div>--}}
                                        {{--</td>--}}

                                        {{--<td>--}}
                                        {{--</td>--}}
                                        {{--<td width="65">--}}
                                            {{--<input type="text" class="form-control changeSummaryTotal"  data-id="{{$cartItem->id}}" data-cart_id="{{$cartItem->cart_id}}" data-target="#sub_total_{{$cartItem->id}}" data-price="{{$cartItem->selling_price}}" value="{{$cartItem->cart_quantity}}" placeholder="1">--}}
                                        {{--</td>--}}
                                        {{--<td>--}}
                                            {{--<h4>--}}
                                                {{--₱<span class="sub_total_per_item" id="sub_total_{{$cartItem->id}}">{{$cartItem->selling_price * $cartItem->cart_quantity}}</span>--}}
                                            {{--</h4>--}}
                                        {{--</td>--}}
                                        {{--<td></td>--}}
                                    {{--</tr>--}}
                                    {{--</tbody>--}}
                                {{--</table>--}}
                            {{--</div>--}}
                        </div>
                    @empty
                        <div class="ibox-content">
                            <h1 class="text-center">--</h1>
                        </div>
                    @endforelse
                    <div class="ibox-content">

                        <button class="btn btn-primary float-right show_confirm_modal"><i class="fa fa fa-shopping-cart"></i> Confirm Order</button>
                        <a  href="{{route('market-place-listing')}}" class="btn btn-white"><i class="fa fa-arrow-left"></i> Continue shopping</a>

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
                                <a href="#" class="btn btn-primary btn-sm show_confirm_modal"><i class="fa fa-shopping-cart"></i> Confirm Order</a>
                                <a href="#" class="btn btn-white btn-sm"> Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ibox">
                    <div class="ibox-title">
                        <h5>Support</h5>
                    </div>
                    <div class="ibox-content text-center">
                        <h3><i class="fa fa-phone"></i> +43 100 783 001</h3>
                        <span class="small">
                                Please contact with us if you have any questions. We are available 24h.
                            </span>
                    </div>
                </div>


            </div>
        </div>




    </div>

    <div class="modal inmodal fade" id="confirm_order_modal" data-type="" tabindex="-1" role="dialog" aria-hidden="true" data-category="" data-variant="" data-bal="">
        <div id="modal-size" class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="padding: 15px;">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Order Confirmation</h4>
                </div>
                <div class="modal-body">
                    @include('wharf.market-place.includes.how_to_pay')
                    <hr>
                    <div class="card">
                        <div class="card card-body">
                                <p>Once locked in, your order will be brought to <span class="text-info">My Orders</span> page, you cancel anytime if the order is not yet verified or you haven't made a payment.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-save-btn"><i class="fa fa-lock"></i> Lock In</button>
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
    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}
    <style>
        .cart-product-imitation{
            padding: 0!important;
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

        $(document).on('click', '.show_confirm_modal', function(){
            $('#confirm_order_modal').modal('show');
        });

        let lockInFields = [];
        $(document).on('click', '#modal-save-btn', function(){
            //market-place.lock_in_order
            console.log(lockInFields)
            $.ajax({
                url: "{{route('market-place-lock_in_order')}}",
                type:"POST",
                data:{
                    form: JSON.stringify(lockInFields),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success:function(response){
                    console.log(response)
                    if(response.status){
                        window.location.replace("{{route('market-place-my_orders')}}");
                    }else{
                        swal("Sorry!", response.msg, "error");

                    }
                },
            });
        });
        $(document).on('click', '.remove-item', function(){
            //market-place.lock_in_order
            var id = $(this).data('id');
            var item = $(this);
            // return 1;
            $.ajax({
                url: "{{route('market-place-remove_item')}}",
                type:"POST",
                data:{
                    id: id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success:function(response){
                    item.closest('.ibox-content').remove()
                    computeTotalSummary()
                    computeTotalCount();
                },
            });
        });
        $(document).ready(function(){

            $('.changeSummaryTotal').on('keyup', function(e){

                var target = $(this).data('target');
                var price = $(this).data('price');
                var qty = $(this).val();
                if(isNaN(qty) || qty === ''){
                    qty = 1;
                }
                $(target).html(numberWithCommas(parseFloat(numberRemoveCommas(price)) * qty));
                computeTotalSummary();
                computeTotalCount();
            })

            computeTotalSummary()
            computeTotalCount();

        });
        function computeTotalCount(){
            var count = 0;
            lockInFields = [];
            $('.changeSummaryTotal').each(function(i, e){

                var target = $(e).data('target');
                var price = $(e).data('price');
                var id = $(e).data('id');
                var cart_id = $(e).data('cart_id');
                var sub_total = parseFloat(numberRemoveCommas($(target).html()));
                let qty = parseInt($(e).val());
                if(isNaN(qty)){
                    qty = 1;
                }
                count += qty;
                let array = {id:id,cart_id:cart_id, price:price, qty:qty, sub_total:sub_total};
                lockInFields.push(array);
            });
            $('#cart_count').html(parseInt(count));
        }
        function computeTotalSummary(){

            var subTotalPerItem = $('.sub_total_per_item');
            var total = 0;
            subTotalPerItem.each(function(i, e){
                let eVal = parseFloat(numberRemoveCommas(e.innerHTML));
                total += eVal;
            });
            $('#total_summary').html(numberWithCommas(total));

        }
    </script>
    <script>
        $(document).on('click', '.counter-trigger', function () {
           var id = $(this).data('id');
           var action = $(this).data('action');
           var old_value = $(this).parent().find('input').val();
           var new_value = 0;

           if(old_value != 0) {
               if(action == 'plus') {
                   new_value = Number(old_value) + 1;
               }else {
                   new_value = Number(old_value) - 1;
               }
               $(this).parent().find('input').val(new_value).trigger('keyup');

           }



           console.log('id => ' + id);
           console.log('action => ' + action);
           console.log('old_value => ' + old_value);
           console.log('new_value => ' + new_value);
        });
    </script>
@endsection
