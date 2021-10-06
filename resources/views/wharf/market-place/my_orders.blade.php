@extends('wharf.master')

@section('title', 'My Orders')

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
            </div>
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content ">
        <div class="row">
            <div class="col-md-12 order-list">

                @include('alerts.validation')


                    <div id="accordion" role="tablist" class="sub_page-content">
                        @foreach($orders as  $order)
                            @php
                                $order_number = $order->order_number;
                            @endphp

                            <div class="card order-item">
                                <div class="card-header" role="tab" id="heading_{{ $order->id }}">
                                    <a data-toggle="collapse" href="#collapse_{{ $order->id }}" aria-expanded="true" aria-controls="collapse_{{ $order->id }}" class="collapsed">
                                        <h5>Order No. #{{$order->order_number}}</h5>
                                        <div class="right">
                                            <span>Ordered at: {{\Carbon\Carbon::parse($order['created_at'])->format('M d, Y')}}</span>
                                            <i class="fa fa-chevron-up" aria-hidden="true"></i>
                                        </div>
                                    </a>
                                </div>

                                <div id="collapse_{{ $order->id }}" class="collapse" role="tabpanel" aria-labelledby="heading_{{ $order->id }}" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="cart-list">
                                            @foreach($order->items as $item)
                                                @php
                                                    $product  = $item->product;
                                                    $image = ($product->hasMedia('market-place')? "<img class='img-thumbnail' src='".url('/').$product->getFirstMediaUrl('market-place')."'>":'')
                                                @endphp

                                                <div class="cart-item">
                                                    <div class="row align-items-center">
                                                        <div class="col-12 col-lg-5">
                                                            <div class="column-1 d-flex align-items-center">
                                                                <a href="{{route('market-place.show', $product->id)}}">
                                                                    <div class="cart-product-imitation">
                                                                        {!! $image !!}
                                                                        {{--                                                    {!! ($cartItem->hasMedia('market-place')? "<img class='img-thumbnail' src='".url('/').$cartItem->getFirstMediaUrl('market-place')."'>":'')  !!}--}}
                                                                        {{--<div class="img" style="background-image: url({!! $image !!})"></div>--}}
                                                                        {{--<div class="img" style="background-image: url({!! ($product->hasMedia('market-place')? url('/').$product->getFirstMediaUrl('market-place'):'')  !!})"></div>--}}

                                                                    </div>
                                                                </a>

                                                                <h3>
                                                                    <a href="#" class="text-navy">
                                                                        <a href="{{route('market-place.show', $product->id)}}" class="product-name">{{$product->name}}</a>
                                                                        <div class="price">
                                                                            ₱{{$product->selling_price}}
                                                                        </div>
                                                                    </a>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-2">
                                                            <div class="column-2">
                                                                {{$item->quantity}}{{$product->unit_of_measure_short}}
                                                            </div>
                                                        </div>
                                                        <div class="col-12 col-lg-5">
                                                            <div class="column-3">
                                                                @php
                                                                    $winningBid = $item->total;
                                                                    $serviceFee = getServiceFee($product->unit_of_measure, $item->quantity, $winningBid, 'market-place');
                                                                @endphp
                                                                <div class="tabulation">
                                                                    <div class="row no-gutters item">
                                                                        <div class="col-4 no-wrap text-muted text-left">Sub Total
                                                                        </div>
                                                                        <div class="col-8 no-wrap text-right">
                                                                            ₱{{number_format($winningBid - $serviceFee, 2)}}</div>
                                                                    </div>
                                                                    <div class="row no-gutters item">
                                                                        <div class="col-4 no-wrap text-muted text-left">Service
                                                                            Fee
                                                                        </div>
                                                                        <div class="col-8 no-wrap text-right">
                                                                            ₱{{number_format($serviceFee, 2)}}</div>
                                                                    </div>
                                                                    <div class="row no-gutters item total">
                                                                        <div class="col-4 no-wrap text-muted text-left">Total</div>
                                                                        <div class="col-8 no-wrap text-right">
                                                                            ₱{{number_format($winningBid, 2)}}</div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                        </div>

                                        <hr>

                                        <div class="ibox-content">
                                            <div class="row align-items-center justify-content-around">
                                                <div class="col-12 col-lg-8 px-3 status-list" >
                                                    <span class="status-item font-bold {{(array_key_exists('new', getMarketplaceOrderStatuses($order->id)) ? "text-green" : "text-muted")}}">Order Placed</span>
                                                    <i class="fa fa-chevron-right text-muted" style="font-size: 14px"></i>

                                                    <span class="status-item font-bold {{(array_key_exists('payment_verified', getMarketplaceOrderStatuses($order->id)) ? "text-green" : "text-muted")}}">Payment Verified</span>
                                                    <i class="fa fa-chevron-right text-muted" style="font-size: 14px"></i>

                                                    <span class="status-item font-bold {{(array_key_exists('approved',getMarketplaceOrderStatuses($order->id)) ? "text-green" : "text-muted")}}">Order Approved</span>
                                                    <i class="fa fa-chevron-right text-muted" style="font-size: 14px"></i>

                                                    <span class="status-item font-bold {{(array_key_exists('delivery', getMarketplaceOrderStatuses($order->id)) ? "text-green" : "text-muted")}}">On Delivery</span>
                                                    <i class="fa fa-chevron-right text-muted" style="font-size: 14px"></i>

                                                    <span class="status-item font-bold {{(array_key_exists('delivered', getMarketplaceOrderStatuses($order->id)) ? "text-green" : "text-muted")}}">Delivered</span>
                                                </div>
                                                <div class="col-12 col-lg-4 text-right">
                                                    <strong class="grand-total">Grand Total: <span class="num">₱{{number_format($order->total ,2)}}</span></strong>
                                                </div>
                                                <div class="col-12">

                                                    @if(!array_key_exists('payment_verified', getMarketplaceOrderStatuses($order->id)))
                                                        <div>
                                                            <button class="btn btn-primary d-block ml-auto mt-3 show_confirm_modal"
                                                                    data-order_number="{{$order->id}}"><i class="fa fa fa-money"></i> Verify
                                                                Payment
                                                            </button>
                                                        </div>

                                                    @endif
                                                    @if($order->status->status == 'delivery')
                                                        <form action="{{route('market-place-delivered')}}" method="post"
                                                              enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" value="{{$order->id}}" name="id">
                                                            <button class="btn btn-primary float-right"><i class="fa fa fa-home"></i>
                                                                Delivered
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="ibox-content">
                                            <h3>Status History</h3>
                                            <table class="table table-scroll small-first-col table-condensed">
                                                <thead>
                                                <tr>
                                                    <th>Status</th>
                                                    <th class="text-right">Timestamp</th>
                                                </tr>
                                                </thead>
                                                @foreach($order->statuses as $status)
                                                    <tr>
                                                        <td>{{$status->name}}</td>
                                                        <td class="text-right">{{$status->created_at}}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>

                @foreach($orders as  $order)
                    @php
                        $order_number = $order->order_number;
                    @endphp


                    {{--<div class="ibox">--}}
                        {{--<div class="ibox-title pr-3">--}}
                            {{--<span class="float-right">Ordered at: {{\Carbon\Carbon::parse($order['created_at'])->format('M d, Y')}}</span>--}}
                            {{--<h5>Order No. #{{$order->order_number}}</h5>--}}
                        {{--</div>--}}
                        {{--@foreach($order->items as $item)--}}
                            {{--@php--}}
                                {{--$product  = $item->product;--}}
                                {{--$image = ($product->hasMedia('market-place')? "<img class='img-thumbnail' src='".url('/').$product->getFirstMediaUrl('market-place')."'>":'')--}}
                            {{--@endphp--}}
                            {{--<div class="ibox-content">--}}
                                {{--                                <pre>{{json_encode($item,128)}}</pre>--}}
                                {{--<div class="table-responsive">--}}
                                    {{--<table class="table shoping-cart-table">--}}
                                        {{--<tbody>--}}
                                        {{--<tr>--}}
                                            {{--<td>--}}
                                                {{--<div class="cart-product-imitation">--}}
                                                    {{--{!! $image !!}--}}
                                                {{--</div>--}}
                                            {{--</td>--}}
                                            {{--<td class="desc">--}}
                                                {{--<h3>--}}
                                                    {{--<a href="#" class="text-navy">--}}
                                                        {{--<a href="{{route('market-place.show', $product->id)}}"--}}
                                                           {{--class="product-name"> {{$product->name}}</a>--}}
                                                    {{--</a>--}}
                                                {{--</h3>--}}
                                                {{--{!! $product->description !!}--}}
                                            {{--</td>--}}

                                            {{--<td>--}}
                                                {{--₱{{$product->selling_price}}--}}
                                            {{--</td>--}}
                                            {{--<td width="65">--}}
                                                {{--{{$item->quantity}}{{$product->unit_of_measure_short}}--}}
                                            {{--</td>--}}
                                            {{--<td>--}}
                                                {{--@php--}}
                                                    {{--$winningBid = $item->total;--}}
                                                    {{--$serviceFee = getServiceFee($product->unit_of_measure, $item->quantity, $winningBid, 'market-place');--}}
                                                {{--@endphp--}}
                                                {{--<div class="tabulation">--}}
                                                    {{--<div class="row">--}}
                                                        {{--<div class="col-4 no-wrap text-muted text-left">Sub Total--}}
                                                        {{--</div>--}}
                                                        {{--<div class="col-8 no-wrap text-right">--}}
                                                            {{--₱{{number_format($winningBid - $serviceFee, 2)}}</div>--}}
                                                    {{--</div>--}}
                                                    {{--<div class="row">--}}
                                                        {{--<div class="col-4 no-wrap text-muted text-left">Service--}}
                                                            {{--Fee--}}
                                                        {{--</div>--}}
                                                        {{--<div class="col-8 no-wrap text-right">--}}
                                                            {{--₱{{number_format($serviceFee, 2)}}</div>--}}
                                                    {{--</div>--}}
                                                    {{--<div class="row total">--}}
                                                        {{--<div class="col-4 no-wrap text-muted text-left">Total</div>--}}
                                                        {{--<div class="col-8 no-wrap text-right">--}}
                                                            {{--₱{{number_format($winningBid, 2)}}</div>--}}
                                                    {{--</div>--}}
                                                {{--</div>--}}
                                                {{--                                                <h4>--}}
                                                {{--                                                    ₱{{$item->total}}--}}
                                                {{--                                                </h4>--}}
                                            {{--</td>--}}
                                        {{--</tr>--}}
                                        {{--</tbody>--}}
                                    {{--</table>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--@endforeach--}}
                        {{--<div class="ibox-content">--}}
                            {{--<div class="row justify-content-around">--}}
                                {{--<div class="col-xs-12 px-3" >--}}
                                    {{--<span class="font-bold {{(array_key_exists('new', getMarketplaceOrderStatuses($order->id)) ? "text-green" : "text-muted")}}">Order Placed</span>--}}
                                    {{--<i class="fa fa-chevron-right text-muted" style="font-size: 14px"></i>--}}

                                    {{--<span class="font-bold {{(array_key_exists('payment_verified', getMarketplaceOrderStatuses($order->id)) ? "text-green" : "text-muted")}}">Payment Verified</span>--}}
                                    {{--<i class="fa fa-chevron-right text-muted" style="font-size: 14px"></i>--}}

                                    {{--<span class="font-bold {{(array_key_exists('approved',getMarketplaceOrderStatuses($order->id)) ? "text-green" : "text-muted")}}">Order Approved</span>--}}
                                    {{--<i class="fa fa-chevron-right text-muted" style="font-size: 14px"></i>--}}

                                    {{--<span class="font-bold {{(array_key_exists('delivery', getMarketplaceOrderStatuses($order->id)) ? "text-green" : "text-muted")}}">On Delivery</span>--}}
                                    {{--<i class="fa fa-chevron-right text-muted" style="font-size: 14px"></i>--}}

                                    {{--<span class="font-bold {{(array_key_exists('delivered', getMarketplaceOrderStatuses($order->id)) ? "text-green" : "text-muted")}}">Delivered</span>--}}
                                {{--</div>--}}
                                {{--<div class="col text-right">--}}
                                    {{--<strong>Grand Total: ₱{{number_format($order->total)}}</strong>--}}
                                    {{--@if(!array_key_exists('payment_verified', getMarketplaceOrderStatuses($order->id)))--}}
                                        {{--<div>--}}
                                            {{--<button class="btn btn-primary  show_confirm_modal"--}}
                                                    {{--data-order_number="{{$order->id}}"><i class="fa fa fa-money"></i> Verify--}}
                                                {{--Payment--}}
                                            {{--</button>--}}
                                        {{--</div>--}}

                                    {{--@endif--}}
                                    {{--@if($order->status->status == 'delivery')--}}
                                        {{--<form action="{{route('market-place-delivered')}}" method="post"--}}
                                              {{--enctype="multipart/form-data">--}}
                                            {{--@csrf--}}
                                            {{--<input type="hidden" value="{{$order->id}}" name="id">--}}
                                            {{--<button class="btn btn-primary float-right"><i class="fa fa fa-home"></i>--}}
                                                {{--Delivered--}}
                                            {{--</button>--}}
                                        {{--</form>--}}
                                    {{--@endif--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--<div class="ibox-content">--}}
                            {{--<h3>Status History</h3>--}}
                            {{--<table class="table table-condensed">--}}
                                {{--<thead>--}}
                                {{--<tr>--}}
                                    {{--<th>Status</th>--}}
                                    {{--<th>Timestamp</th>--}}
                                {{--</tr>--}}
                                {{--</thead>--}}
                                {{--@foreach($order->statuses as $status)--}}
                                    {{--<tr>--}}
                                        {{--<td>{{$status->name}}</td>--}}
                                        {{--<td>{{$status->created_at}}</td>--}}
                                    {{--</tr>--}}
                                {{--@endforeach--}}
                            {{--</table>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                @endforeach


            </div>
            <div class="col-md-3 d-none">

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

    <div class="modal inmodal fade" id="confirm_order_modal" data-type="" tabindex="-1" role="dialog" aria-hidden="true"
         data-category="" data-variant="" data-bal="">
        <div id="modal-size" class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="padding: 15px;">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Verify Payment</h4>
                </div>
                <div class="modal-body">
                    <form action="{{route('market-place-verify_payment')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="order_number" id="verify_order">
                        <div class="ibox-content">
                            <div class="form-group">
                                <label>Proof of Payment</label>
                                <input name="proof_of_payment" id="myFileInput" class="form-control" type="file"
                                       accept="image/*;capture=camera">
                            </div>
                            <div class="form-group">
                                <label>Payment Date</label>
                                <input name="paid_date" type="text" class="form-control datepicker" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Reference/Receipt No.</label>
                                <input name="reference_number" type="text" class="form-control" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-green w-100" id="verify_payment_submit">Verify
                                </button>
                            </div>
                        </div>
                    </form>
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
        .cart-product-imitation {
            padding: 0 !important;
        }

        .no-wrap {
            white-space: nowrap;
        }

        .tabulation {
            font-size: 14px;
        }

        .total {
            font-size: 16px;
            font-weight: 700;
            width: 250px;
        }
    </style>
    {{--{!! Html::style('') !!}--}}
    {{--    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}
    {{--    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}--}}
@endsection

@section('scripts')
    {!! Html::script('js/template/plugins/footable/footable.all.min.js') !!}
    {!! Html::style('/css/template/plugins/datapicker/datepicker3.css') !!}
    {!! Html::script('/js/template/plugins/datapicker/bootstrap-datepicker.js') !!}
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
            let order_number = $(this).data('order_number');
            console.log(order_number)
            $("#verify_order").val(order_number);
        });

        let lockInFields = [];
        $(document).on('click', '#modal-save-btn', function () {
            //spot-market.lock_in_order
            console.log(lockInFields)
            $.ajax({
                url: "{{route('spot-market.lock_in_order')}}",
                type: "POST",
                data: {
                    form: JSON.stringify(lockInFields),
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    window.location.replace("{{route('spot-market.my_orders')}}");
                },
            });
        });
        $(document).ready(function () {

            var mem = $('.datepicker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: 'yyyy-mm-dd',
                placement: 'bottom'
            });

            $('.changeSummaryTotal').on('keyup', function (e) {

                var target = $(this).data('target');
                var price = $(this).data('price');
                var qty = $(this).val();
                if (isNaN(qty) || qty === '') {
                    qty = 1;
                }
                $(target).html(numberWithCommas(parseFloat(numberRemoveCommas(price)) * qty));
                computeTotalSummary();
                computeTotalCount();
            })

            computeTotalSummary()
            computeTotalCount();

        });

        function computeTotalCount() {
            var count = 0;
            lockInFields = [];
            // $('.changeSummaryTotal').each(function(i, e){
            //
            //     var target = $(e).data('target');
            //     var price = $(e).data('price');
            //     var id = $(e).data('id');
            //     var cart_id = $(e).data('cart_id');
            //     var sub_total = parseFloat(numberRemoveCommas($(target).html()));
            //     let qty = parseInt($(e).val());
            //     if(isNaN(qty)){
            //         qty = 1;
            //     }
            //     count += qty;
            //     let array = {id:id,cart_id:cart_id, price:price, qty:qty, sub_total:sub_total};
            //     lockInFields.push(array);
            // });
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
    </script>
@endsection
