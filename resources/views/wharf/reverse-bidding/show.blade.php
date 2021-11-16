@extends('wharf.master')

@section('title', $data->po_num)

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-6">
            <h2>@yield('title')</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <a href="{{ route('reverse-bidding.index') }}">Reverse Biddings</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>@yield('title')</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-6">
            <div class="title-action">
            </div>
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content ">

        <div class="row">
            <div class="col-lg-12">

                @include('alerts.validation')

                <div class="ibox product-detail">
                    <div class="ibox-content">

                        <div class="row">
                            <div class="col-md-5">
                                <div class="product-images">
                                    <div>
                                        <div class="image-imitation"
                                             style="background-image: url({!! ($data->hasMedia('reverse-bidding')? url('/').$data->getFirstMediaUrl('reverse-bidding'):url("img/blank-landscape.jpg"))  !!})">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <h2 class="font-bold m-b-xs">
                                    PO# {{$data->po_num}}
                                </h2>
                                <div class="row">
                                    <div class="col-6">
                                        Category
                                    </div>
                                    <div class="col-6">
                                        {{optional($data->category)->display_name}}
                                    </div>
                                    <div class="col-6">
                                        Area
                                    </div>
                                    <div class="col-6">
                                        {{$data->area}}
                                    </div>
                                    <div class="col-6">
                                        Bidding Ends
                                    </div>
                                    <div class="col-6">
                                        {{\Carbon\Carbon::parse($data->expiration_time)->format('M d, Y H:i:s a')}}
                                    </div>
                                    <div class="col-6">
                                        Delivery Date/Time
                                    </div>
                                    <div class="col-6">
                                        {{\Carbon\Carbon::parse($data->delivery_date)->format('M d, Y')}}
                                        {{\Carbon\Carbon::parse($data->delivery_type)->format('H:i:s a')}}
                                    </div>
                                    <div class="col-6">
                                        Delivery Address
                                    </div>
                                    <div class="col-6">
                                        {{$data->delivery_address}}
                                    </div>
                                </div>
                                Line Items
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($data->items as $item)
                                        <tr>
                                            <td>{{$item->item_name}} </td>
                                            <td>{{$item->quantity}} </td>
                                            <td>{{$item->unit_of_measure}} </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <hr>
                                {!! $data->description !!}
                                <hr>
                            </div>
                            <div class="col-md-7">
                                <div>
                                    @if(\Carbon\Carbon::parse($data->expiration_time)->isFuture())
                                        <div id="expiration" class="timer">
                                        </div>
                                    @else
                                        @if($data->lowest_bid_user)
                                            @if($data->lowest_bid_user->id == auth()->user()->id)
                                                <h1 class="mb-0">Congratulation you won the Bid!</h1>
                                                @if($data->status == 0)
                                                    <p class="text-muted font-weight-light">Please complete the transaction</p>
                                                    <form action="{{route('reverse-bidding.complete_bid')}}"
                                                          method="POST" class="complete_bid"
                                                          data-id="{{$data->id}}"
                                                          data-product="{{$data->name}}"
                                                          data-qty="{{$data->quantity}}"
                                                          data-uom="{{$data->unit_of_measure_short}}">
                                                        @csrf
                                                        <input type="hidden" name="id"
                                                               value="{{$data->id}}">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                   name="method" id="method_local"
                                                                   value="local" checked="">
                                                            <label class="form-check-label"
                                                                   for="method_local">
                                                                Local
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio"
                                                                   name="method" id="method_transport"
                                                                   value="transport">
                                                            <label class="form-check-label"
                                                                   for="method_transport">
                                                                Transport
                                                            </label>
                                                        </div>
                                                        <button class="btn btn-primary mt-3">Complete</button>
                                                    </form>
                                                @elseif($data->status == 1)
                                                    <span class="text-green">{{$data->method=='transport'?'Transported':'Completed'}}</span>
                                                @endif
                                            @else
                                                <h1 class="text-center">Bidding Ended</h1>
                                            @endif
                                        @else
                                            <h1 class="text-center">Bidding Ended</h1>
                                        @endif
                                    @endif
                                </div>
                                <hr>
                                @if(count($data->offers))
                                    @if(getRoleName() != 'farmer')
                                        @if($data->lowest_bid_user)
                                            <strong class="d-block mb-3 text-center">Winning Bid
                                                <br>{{$data->lowest_bid_user->name??$data->lowest_bid_user->email}}
                                            </strong>
                                        @endif
                                    @endif
                                    <h1>
                                        @if(getRoleName() == 'farmer')
                                            <strong class="pull-right">Rank: <span
                                                        id="ranking_span">{{$data->user_rank??' - '}}</span> </strong>
                                        @endif
                                        Bids
                                    </h1>
                                    <div class="ibox" id="offers_container">
                                        @include('wharf.reverse-bidding.offers', ['offers'=>$data->offers])
                                    </div>
                                @else
                                    <div class="no_bids_yet">
                                        - No Bids Yet-
                                    </div>
                                @endif
                                @if(getRoleName() == 'farmer')
                                    @if(\Carbon\Carbon::parse($data->expiration_time)->isFuture())
                                        <button type="button" class="btn btn-primary btn-bid-show w-100">Bid</button>
                                    @endif
                                @endif

                                {{ Form::open(['route'=>'reverse-bidding.submit_offer', 'class'=>'','id'=>'form','files'=>true]) }}
                                <div class="ibox ibox-content bidding_panel">
                                    <table class="table bidding_table">
                                        <thead>
                                        <tr>
                                            <th class="small nowrap">Item name</th>
                                            <th class="small">Quantity</th>
                                            <th class="small text-right">Unit Price</th>
                                            <th class="small text-right">Cost</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($data->items as $item)
                                            <tr>
                                                <td>{{$item->item_name}} <input type="hidden" name="item_id[]"
                                                                                value="{{$item->id}}"></td>
                                                <td class="nowrap">{{$item->quantity}} {{$item->unit_of_measure_short}} </td>
                                                <td><input type="text"
                                                           name="item_price[]"
                                                           data-qty="{{$item->quantity}}"
                                                           data-oum="{{$item->unit_of_measure}}"
                                                           class="w-100 money bid_price bid_price_{{$item->id}}"
                                                           data-id="{{$item->id}}" required></td>
                                                <td><input type="text"
                                                           name="item_cost[]"
                                                           data-qty="{{$item->quantity}}"
                                                           data-oum="{{$item->unit_of_measure}}"
                                                           class="w-100 money bid_cost bid_cost_{{$item->id}}"
                                                           data-id="{{$item->id}}" required></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="summary_bidding">
                                        <table>
                                            <tbody>
                                            <tr>
                                                <td>Gross Total:</td>
                                                <td>₱ <span id="gross_total">0</span></td>
                                            </tr>
                                            <tr>
                                                <td>Transaction Fee(<span
                                                            id="transaction_fee">{{settings('service_fee_percentage', 3)}}</span>%):
                                                </td>
                                                <td>₱ <span id="transaction_fee_display">0</span></td>
                                            </tr>
                                            <tr>
                                                <td>Value Added Tax(<span
                                                            id="vat_fee">{{settings('po_value_added_tax', 12)}}</span>%):
                                                </td>
                                                <td>₱ <span id="vat_display">0</span></td>
                                            </tr>
                                            <tr>
                                                <td>Total Bid:</td>
                                                <td>₱ <span id="total_bid_display">0</span></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <input type="hidden" name="po_id" value="{{$data->id}}" required>
                                        <input type="hidden" name="total_bid" id="total_bid" required>
                                        <input type="hidden" name="vat" id="post_vat" required>
                                        <input type="hidden" name="transaction_fee" id="post_service_fee" required>
                                        <input type="hidden" name="gross_total" id="post_gross_total" required>
                                        <br>
                                        <div class="bid-disclosure card">
                                            <div class="card card-body">
                                                <h4>Bid Disclosure</h4>

                                                <div class="i-checks">
                                                    <label>{{ Form::checkbox('agree[]', 1, false, ['required'=>true]) }}
                                                        <p>I agree to deliver the quality and quantity required by the
                                                            client. I
                                                            hereby acknowledge that the product required will be
                                                            delivered on
                                                            time specified in this bid document.</p></label>
                                                </div>
                                                <div class="i-checks">
                                                    <label>{{ Form::checkbox('agree[]', 1, false, ['required'=>true]) }}
                                                        <p>Failure to deliver expectation may result to cancellation of
                                                            order or
                                                            penalty.</p></label>
                                                </div>
                                                <button type="submit" class="btn btn-primary">Submit Offer</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{ Form::close() }}
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


    <div class="modal inmodal fade" id="bidding_disclosure" data-type="" tabindex="-1" role="dialog" aria-hidden="true"
         data-category="" data-variant="" data-bal="">
        <div id="modal-size" class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="padding: 15px;">
                    {{--                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>--}}
                    <h4 class="modal-title">Bid Disclosure</h4>
                </div>
                <div class="modal-body">
                    <div class="card">
                        <div class="card card-body">
                            <p>I agree to deliver the quality and quantity required by the client. I hereby acknowledge
                                that the product required will be delivered on time specified in this bid document.</p>
                            <p>Failure to deliver expectation may result to cancellation of order or penalty.</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="dis_i_agree">I Agree</button>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('styles')
    {!! Html::style('css/template/plugins/footable/footable.core.css') !!}
    {!! Html::style('css/template/plugins/toastr/toastr.min.css') !!}
    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}
    <style>
        .offer_table tr td,
        .offer_summary tr td {
            font-size: 14px;
        }

        .offer-box {
            padding: 0.5em 1em !important;
        }

        .nowrap {
            white-space: nowrap;
        }

        .bid-disclosure {

        }

        .bid-disclosure .i-checks > label {
            display: flex;
        }

        .bid-disclosure input[type=checkbox] {
            margin: .5em;
        }

        .summary_bidding {
        }

        .offer_summary,
        .summary_bidding table {
            width: 100%;
        }

        .offer_summary tr td,
        .summary_bidding table tr td {
            text-align: right;
            padding-right: 0.6em;
        }

        .summary_bidding table tr:last-child td {
            font-size: 2em;
            padding-right: .35rem;
        }

        .summary_bidding table tr td:first-child {
            text-align: right;
        }

        .money {
            border: none;
            outline: none;
        }

        .money:hover {
            border-bottom: 1px solid #e7eaec;
            margin-bottom: -1px;
        }

        .bidding_panel {
            display: none;
            margin-top: 1em;
        }

        .bidding_table {

        }

        .no_bids_yet {
            display: flex;
            color: #3a8cdd;
            font-size: 2rem;
            font-weight: 100;
            font-family: 'Roboto', serif;
            margin: 0.1rem;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .count-info .label {
            font-size: 12px;
            border-radius: 2em;
            top: 21px !important;
            padding: 4px 7px !important;
        }

        .timer {
            display: flex;
            justify-content: center;
        }

        .timer .time {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 1em;;
        }

        .timer .time .digit {
            color: #3a8cdd;
            font-size: 2rem;
            font-weight: 100;
            font-family: 'Roboto', serif;
            margin: 0.1rem;
            text-align: center;
        }

        .timer .time .text {

        }
    </style>
    {{--{!! Html::style('') !!}--}}
    {{--    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}
    {{--    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}--}}
@endsection

@section('scripts')
    {!! Html::script('js/template/plugins/footable/footable.all.min.js') !!}
    {!! Html::script('https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js') !!}
    {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}
    <script src="https://js.pusher.com/4.0/pusher.min.js"></script>
    {!! Html::style('/css/template/plugins/datapicker/datepicker3.css') !!}
    {!! Html::script('/js/template/plugins/datapicker/bootstrap-datepicker.js') !!}
    {{--    {!! Html::script('') !!}--}}
    {{--    {!! Html::script(asset('vendor/datatables/buttons.server-side.js')) !!}--}}
    {{--    {!! $dataTable->scripts() !!}--}}
    {{--    {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}--}}
    {{--    {!! Html::script('/js/template/moment.js') !!}--}}
    <script>

        function numberRemoveCommas(x) {
            return x.toString().replace(/,/g, "");
        }

        function numberWithCommas(x) {
            return parseFloat(x).toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function getVat(raw, servicePercent, vatPercent) {

            return raw * (vatPercent / 100);
            //Heroku GetVat COmupation
            return Math.round((raw / (1 - servicePercent / 100) / (1 - vatPercent / 100) - raw / (1 - servicePercent / 100)) * 100) / 100;
        }

        function getTotal() {
            let gross_total = 0;
            $('.bid_cost').each(function (i, elem) {
                let solo_bid_cost = numberRemoveCommas($(elem).val());
                if (solo_bid_cost) {
                    gross_total += parseFloat(solo_bid_cost);
                    console.log(solo_bid_cost)
                }
            });
            $('#gross_total').html(numberWithCommas(gross_total));
            let transaction_fee = numberRemoveCommas($('#transaction_fee').html());
            let transaction_fee_value = gross_total * (transaction_fee / 100);
            $('#transaction_fee_display').html(numberWithCommas(transaction_fee_value));
            let vat_fee = numberRemoveCommas($('#vat_fee').html());
            let vat = getVat(gross_total, transaction_fee, vat_fee);
            $('#vat_display').html(numberWithCommas(vat));
            let total_bid = gross_total + vat + transaction_fee_value;
            $('#total_bid_display').html(numberWithCommas(total_bid));
            $('#total_bid').val(total_bid);
            $('#post_vat').val(vat);
            $('#post_service_fee').val(transaction_fee_value);
            $('#post_gross_total').val(gross_total);
        }

        $(document).on('keyup', '.bid_price', function () {
            let this_elem = $(this);
            let id = this_elem.data('id');
            let other_half = $('.bid_cost_' + id);
            let item_qty = this_elem.data('qty');
            other_half.val(numberRemoveCommas(item_qty) * numberRemoveCommas(this_elem.val()))
            getTotal();
        });
        $(document).on('keyup', '.bid_cost', function () {
            let this_elem = $(this);
            let id = this_elem.data('id');
            let other_half = $('.bid_price_' + id);
            let item_qty = this_elem.data('qty');
            other_half.val(numberRemoveCommas(this_elem.val()) / numberRemoveCommas(item_qty))
            getTotal();
        });
        Inputmask.extendAliases({
            pesos: {
                prefix: "₱ ",
                groupSeparator: ".",
                alias: "numeric",
                placeholder: "0",
                autoGroup: true,
                digits: 2,
                digitsOptional: false,
                clearMaskOnLostFocus: false
            },
            money: {
                prefix: "",
                groupSeparator: ".",
                alias: "numeric",
                placeholder: "0",
                autoGroup: true,
                digits: 2,
                digitsOptional: true,
                clearMaskOnLostFocus: false
            }
        });
        $(document).ready(function () {

            $(".money").inputmask({
                alias: "money"
            });

            let toast1 = $('.toast1');
            toast1.toast({
                delay: 5000,
                animation: true
            });

            $(document).on('keyup', '.btn-action', function () {
                switch ($(this).data('action')) {
                    case 'store':
                        $('#form').submit();
                        break;
                }
            });

            var countDownDate = new Date("{{$data->expiration_time}}").getTime();
            @if(\Carbon\Carbon::parse($data->expiration_time)->isFuture())
            var x = setInterval(function () {
                var now = new Date().getTime();
                var distance = countDownDate - now;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);


                if (days < 1) {
                    days = "0";
                } else {
                    days = days > 1 ? days : days;
                }
                hours = hours < 10 ? "0" + hours : hours;
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                let time = "<div class='time'>" +
                    "<p class='digit'>" + days + "</p>" +
                    "<p class='text'>Days</p>" +
                    "</div>" +
                    "<div class='time'>" +
                    "<p class='digit'>" + hours + "</p>" +
                    "<p class='text'>Hours</p>" +
                    "</div>" +
                    "<div class='time'>" +
                    "<p class='digit'>" + minutes + "</p>" +
                    "<p class='text'>Minutes</p>" +
                    "</div>" +
                    "<div class='time'>" +
                    "<p class='digit'>" + seconds + "</p>" +
                    "<p class='text'>Seconds</p>" +
                    "</div>";

                try {
                    document.getElementById("expiration").innerHTML = time;
                    if (distance < 0) {
                        clearInterval(x);
                        finishBid();
                        document.getElementById("expiration").innerHTML = "Awarding";
                    }
                }catch (e){
                    console.log("Expiration Not Found")
                }
            }, 1000);
            @endif
            var itemId;
            var itemValue;
            var min;

            $('.btn-bid-show').on('click', function (e) {
                $('.bidding_panel').show();
                $(this).hide();
            })
            $('.btn-bid').on('click', function (e) {
                itemId = $(this).data('id');
                itemValue = $('#bid_value_' + itemId).val();
                min = $(this).data('min');
                e.preventDefault();
                $('#bidding_disclosure').modal({
                    backdrop: 'static',
                    keyboard: false
                });
            })


            $('#dis_i_agree').on('click', function (e) {
                if (parseFloat(numberRemoveCommas(min)) >= parseFloat(numberRemoveCommas(itemValue))) {
                    postBid(itemId, numberRemoveCommas(itemValue));
                    $('#bidding_disclosure').modal('hide');
                }
            })
            {{--var modal = $('#modal');--}}
            {{--$(document).on('click', '', function(){--}}
            {{--    modal.modal({backdrop: 'static', keyboard: false});--}}
            {{--    modal.modal('toggle');--}}
            {{--});--}}

            {{-- var table = $('#table').DataTable({--}}
            {{--     processing: true,--}}
            {{--     serverSide: true,--}}
            {{--     ajax: {--}}
            {{--         url: '{!! route('') !!}',--}}
            {{--         data: function (d) {--}}
            {{--             d.branch_id = '';--}}
            {{--         }--}}
            {{--     },--}}
            {{--     columnDefs: [--}}
            {{--         { className: "text-right", "targets": [ 0 ] }--}}
            {{--     ],--}}
            {{--     columns: [--}}
            {{--         { data: 'name', name: 'name' },--}}
            {{--         { data: 'action', name: 'action' }--}}
            {{--     ]--}}
            {{-- });--}}

            {{--table.ajax.reload();--}}

            $(document).on('click', '.btn-action', function () {
                switch ($(this).data('action')) {
                    case 'store':
                        $('#form').submit();
                        break;
                }
            });
        });

        function postBid(id, value) {

            $.ajax({
                url: "{{route('reverse-bidding.post_bid')}}",
                type: "POST",
                data: {
                    id: id,
                    value: value,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    var bids = response.bids;
                    console.log(response)
                    if (response.status) {
                        $('#bids_list_' + id).empty();
                        for (let i = 0; i < bids.length; i++) {
                            const bid = bids[i];
                            console.log(bid)
                            $('#bids_list_' + id).append("<li>" + bid + "</li>");
                        }
                        $('#bid_value_' + id).val(response.next_bid);
                        $('#current_bid_' + id).html(numberWithCommas(value));
                        $('#btn_bid_' + id).data('min', response.next_bid);
                        $('#btn_bid_' + id).attr('data-min', response.next_bid);

                    } else {
                        // window.location.reload();
                    }
                },
            });
        }

        function refreshBid(id) {

            $.ajax({
                url: "{{route('reverse-bidding.refresh_bid')}}",
                type: "POST",
                data: {
                    id: id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#offers_container').html(response.view);
                    $('#ranking_span').html(response.rank);
                },
            });
        }

        function finishBid(id) {
            console.log(id)
            $("#btn_bid_" + id).hide();
            $("#bid_value_" + id).hide();
        }

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('31cb6af362d7e1f61f7f', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('bid-browse-reverse-bidding');
        channel.bind('update-bid', function (data) {
            var id = data.id;
            refreshBid(id);
        });
    </script>
@endsection
