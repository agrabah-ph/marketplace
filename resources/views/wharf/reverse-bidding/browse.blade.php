@extends('wharf.master')

@section('title', 'Purchase Order')

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
                <small>Minimum Allowance to Bid: {{settings('spot_market_next_bid')}}</small>
                {{--                @include('wharf.reverse-bidding.includes.cart_button')--}}
            </div>
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content">
        <div class="row">
            <div class="col-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="form-group">
                            <label>Areas</label>
                            <select class="form-control" id="areas" name="areas" required>
                                <option value="_all">All</option>
                                @foreach($areas as $id => $area)
                                    <option value="{{$area}}" {{request()->area == $area ?'selected':''}}>{{$area}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @forelse($list as $data)
            @php
              $allowCurrentBid = floatval($data['current_bid'])+settings('spot_market_next_bid');
            @endphp
            <div class="col-md-3 col-sm-6">
                <div class="ibox">
                    <div class="ibox-content product-box">
                        <a href="{{route('reverse-bidding.show', $data['id'])}}" class="">
                        <div class="product-imitation" style="background-image: url('{!! ($data->hasMedia('reverse-bidding')? url('/').$data->getFirstMediaUrl('reverse-bidding'):'')  !!}')">
                        </div>
                        </a>
                        <div class="product-desc">
                            <span class="product-price">
                               {{count($data->bids)>0?'Current Bid':'Starting Bid'}}  <span style="font-weight: 700">₱<span id="current_bid_{{$data->id}}">{{number_format($data['current_bid'],2)}}</span></span>
                            </span>
                            <a href="{{route('reverse-bidding.show', $data->id)}}" class="product-name" style="font-size: 18px"> {{$data->name}}</a>
                            <div class="my-2 text-right">
                                <div class="input-group">
                                    <input type="text" class="form-control money input-bids" data-min="{{(count($data->bids)>0?$allowCurrentBid:$data->asking_price)}}" value="{{(count($data->bids)>0?$allowCurrentBid:$data->asking_price)}}" id="bid_value_{{$data->id}}">
                                    <span class="input-group-append">
                                        <button type="button" class="btn btn-primary btn-bid" id="btn_bid_{{$data->id}}" data-id="{{$data->id}}" data-min="{{(count($data->bids)>0?$allowCurrentBid:$data->asking_price)}}" >Bid</button>
                                    </span>
                                </div>
                            </div>
                            <small class="row">
                                <div class="col-6">
                                    Countdown <br>
                                    <span id="expiration_{{$data->id}}">--:--:--</span>
                                </div>
                                <div class="col-6 text-right">
                                    Expiring At <br>
                                    <span>{{\Carbon\Carbon::parse($data->expiration_time)->format('m/d H:i:s a')}}</span>
                                </div>
                            </small>
                            <pre class="d-none">
                                {{json_encode($data, 128)}}
                            </pre>
                            <div class="small m-t-xs">
                                Bids
                                @if(count($data->bids)>0)
                                    <ol id="bids_list_{{$data->id}}" style="height: 6.38em;overflow-y: auto;padding-left: 1.5em">
                                        @foreach($data->bids as $bids)
                                            <li>₱{{$bids->bid}}{{$bids->user_id == auth()->user()->id?' (your bid)':''}}</li>
                                        @endforeach
                                    </ol>
                                @else
                                    <ol id="bids_list_{{$data->id}}" style="height: 6.38em;overflow-y: auto;padding-left: 1.5em">
                                        <div style="margin-left: -1.5em;display: flex;justify-content: center">- No Bids Yet -</div>
                                    </ol>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
                <div class="col-12">
                    <h1 class="text-center w-100">No Listing Yet</h1>
                </div>
            @endforelse
        </div>
    </div>

    <div style="position: absolute; top: 20px; right: 20px;">

        <div class="toast toast1 toast-bootstrap toast-success" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <i class="fa fa-cart-plus"> </i>
                <strong class="mr-auto m-l-sm">Add to Cart</strong>
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
    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}
    <style>
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
    {!! Html::script('https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js') !!}
    {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}
    <script src="https://js.pusher.com/4.0/pusher.min.js"></script>
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

        $(document).ready(function(){
            $(".money").inputmask({
                alias:"money"
            });

            let toast1 = $('.toast1');
            toast1.toast({
                delay: 5000,
                animation: true
            });

            $('.btn-bid').on('click', function(e){
                e.preventDefault();
                var itemId = $(this).data('id');
                var itemValue = $('#bid_value_'+itemId).val();
                var min = $(this).data('min');
                if(parseFloat(numberRemoveCommas(min)) <= parseFloat(numberRemoveCommas(itemValue))){
                    postBid(itemId, numberRemoveCommas(itemValue));
                }
            })
        });

        $(document).on('change','#areas', function(e){
            var value = this.value;
            window.location.href = "{{route('reverse-bidding.index')}}?area=" + value;
        });

        function postBid(id, value){

            $.ajax({
                url: "{{route('reverse-bidding.post_bid')}}",
                type:"POST",
                data:{
                    id:id,
                    value:value,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success:function(response){
                    var bids = response.bids;
                    if(response.status){
                        $('#bids_list_'+id).empty();
                        for (let i = 0; i < bids.length; i++) {
                            const bid = bids[i];
                            $('#bids_list_'+id).append("<li>"+bid+"</li>");
                        }
                        $('#bid_value_'+id).val(response.next_bid);
                        $('#current_bid_'+id).html(numberWithCommas(value));
                        $('#btn_bid_'+id).data('min', response.next_bid);
                        $('#btn_bid_'+id).attr('data-min', response.next_bid);

                    }else{

                    }
                },
            });
        }

        function refreshBid(id){

            $.ajax({
                url: "{{route('reverse-bidding.refresh_bid')}}",
                type:"POST",
                data:{
                    id:id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success:function(response){
                    var bids = response.bids;
                    var value = response.value;
                    var next_bid = response.next_bid;
                    if(response.status){
                        $('#bids_list_'+id).empty();
                        for (let i = 0; i < bids.length; i++) {
                            const bid = bids[i];
                            $('#bids_list_'+id).append("<li>₱"+bid+"</li>");
                        }
                        $('#bid_value_'+id).val(next_bid);
                        $('#current_bid_'+id).html(numberWithCommas(value));
                        $('#btn_bid_'+id).data('min', next_bid);
                        $('#btn_bid_'+id).attr('data-min', next_bid);

                    }else{

                    }
                },
            });
        }
    </script>

    <!--  Spot Market Countdowns  -->
    <script>
        function finishBid(id){
            console.log(id)
            {{--$.ajax({--}}
            {{--    url: "{{route('reverse-bidding.make_winner')}}",--}}
            {{--    type:"POST",--}}
            {{--    data:{--}}
            {{--        id:id,--}}
            {{--        _token: $('meta[name="csrf-token"]').attr('content')--}}
            {{--    },--}}
            {{--    success:function(response){--}}
                    $("#btn_bid_"+id).hide();
                    $("#bid_value_"+id).hide();
                // },
            // });
        }
        $(document).ready(function(){
            @foreach($list as $data)
            var countDownDate{{$data->id}} = new Date("{{$data->expiration_time}}").getTime();
            var x{{$data->id}} = setInterval(function() {
                var now = new Date().getTime();
                var distance = countDownDate{{$data->id}} - now;
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);


                if(days < 1){
                    days = "";
                }else{
                    days = days > 1 ? days+' days' : days+ 'day';
                }
                hours = hours < 10 ? "0" + hours : hours;
                minutes = minutes < 10 ? "0" + minutes : minutes;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                document.getElementById("expiration_{{$data->id}}").innerHTML =  days+" "+hours + ":" + minutes + ":" + seconds;
                if (distance < 0) {
                    clearInterval(x{{$data->id}});
                    finishBid('{{$data->id}}');
                    document.getElementById("expiration_{{$data->id}}").innerHTML = "Awarding";
                }
            }, 1000);
            @endforeach
        });
    </script>

    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('31cb6af362d7e1f61f7f', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('bid-browse-reverse-bidding');
        channel.bind('update-bid', function(data) {
            console.log('pusher data');
            console.log(data);
            var id = data.id;
            refreshBid(id);
        });
    </script>
@endsection
