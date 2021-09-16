@extends('wharf.master')

{{--@section('title', 'Dashboard | '.getRoleName('display_name'))--}}
@section('title', 'Dashboard')

@section('content')

    <div id="app" class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-9">
                @if($isCommunityLeader)
                    <div class="ibox">
                        <div class="ibox-title">
                            <div class="ibox-tools">
                            </div>
                            <h5>Active Purchase Orders</h5>
                        </div>
                        <div class="ibox-content">
                            @foreach($products as $product)
                                <div class="row">
                                    <div class="col-12">
                                        <a href="" class="float-left mr-2 d-block">
                                            <img src="{{url('/').$product->getFirstMediaUrl('reverse-bidding')}}" alt=""
                                                 class="img-md"></a>
                                        <div class="ml-1">
                                            <strong>{{$product->user->name??$product->user->email}}</strong> selling
                                            <strong>{{$product->name}}</strong> for
                                            <strong>{{number_format($product->asking_price)}}</strong> current bid
                                            <strong>{{number_format($product->current_bid)}}</strong>. <br>
                                            <small class="text-muted">{{Carbon\Carbon::parse($product->expiration_time)->diffForHumans()}}
                                                at {{Carbon\Carbon::parse($product->expiration_time)->format('h:ia')}}</small>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <hr>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="ibox">
                        <div class="ibox-title">
                            <div class="ibox-tools">
                            </div>
                            <h5>Winning Bids</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="tabs-container">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li><a class="nav-link active" data-toggle="tab" href="#tab-1"> Marketplace</a></li>
                                    <li><a class="nav-link" data-toggle="tab" href="#tab-2"> Auctions</a></li>
                                    <li><a class="nav-link" data-toggle="tab" href="#tab-3"> Purchase Order</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div role="tabpanel" id="tab-1" class="tab-pane active">
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table shoping-cart-table">
                                                    <tbody>
                                                    @foreach($winningBidsMarketplace as $item)
                                                        @php
                                                            $winner = $item->bids->first()->user;
                                                            $winningBid = $item->bids->first()->bid;
                                                            $serviceFee = getServiceFee($item->unit_of_measure, $item->quantity, $winningBid, 'market_place');
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                <div class="cart-product-imitation">
                                                                    {!! ($item->hasMedia('market-place')? "<img class='img-thumbnail' src='".url('/').$item->getFirstMediaUrl('market-place')."'>":'')  !!}
                                                                </div>
                                                            </td>
                                                            <td class="text-left">
                                                                Winner: {{$winner->name??$winner->email}}
                                                            </td>
                                                            <td class="desc">
                                                                <h3>
                                                                    <a href="#" class="text-navy">
                                                                        <a href="{{route('market-place.show', $item->id)}}"
                                                                           class="product-name"> {{$item->name}}</a>
                                                                    </a>
                                                                </h3>
                                                                {!! $item->description !!}
                                                            </td>
                                                            <td>
                                                                <h4>
                                                                    {{$item->quantity}}{{$item->unit_of_measure_short}}
                                                                </h4>
                                                            </td>
                                                            <td style="width: 250px;">
                                                                <div class="tabulation">
                                                                    <div class="row">
                                                                        <div class="col-4 no-wrap text-muted text-left">Sub
                                                                            Total
                                                                        </div>
                                                                        <div class="col-8 no-wrap text-right">
                                                                            ₱{{number_format($winningBid - $serviceFee, 2)}}</div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 no-wrap text-muted text-left">
                                                                            Service Fee
                                                                        </div>
                                                                        <div class="col-8 no-wrap text-right">
                                                                            ₱{{number_format($serviceFee, 2)}}</div>
                                                                    </div>
                                                                    <div class="row total">
                                                                        <div class="col-4 no-wrap text-muted text-left">
                                                                            Total
                                                                        </div>
                                                                        <div class="col-8 no-wrap text-right">
                                                                            ₱{{number_format($winningBid, 2)}}</div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-left">
                                                                @if($item->status == 0)
                                                                    <form action="{{route('market-place.complete_bid')}}"
                                                                          method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="id"
                                                                               value="{{$item->id}}">
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
                                                                        <button class="btn btn-primary mt-3">Complete
                                                                        </button>
                                                                    </form>
                                                                @elseif($item->status == 1)
                                                                    <span class="text-green">{{$item->method=='transport'?'Transported':'Completed'}}</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" id="tab-2" class="tab-pane">
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table shoping-cart-table">
                                                    <tbody>
                                                    @foreach($winningBids as $item)
                                                        @php
                                                            $winner = $item->spot_market_bids->first()->user;
                                                            $winningBid = $item->spot_market_bids->first()->bid;
                                                            $serviceFee = getServiceFee($item->unit_of_measure, $item->quantity, $winningBid, 'spot_market');
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                <div class="cart-product-imitation">
                                                                    {!! ($item->hasMedia('spot-market')? "<img class='img-thumbnail' src='".url('/').$item->getFirstMediaUrl('spot-market')."'>":'')  !!}
                                                                </div>
                                                            </td>
                                                            <td class="text-left">
                                                                Winner: {{$winner->name??$winner->email}}
                                                            </td>
                                                            <td class="desc">
                                                                <h3>
                                                                    <a href="#" class="text-navy">
                                                                        <a href="{{route('spot-market.show', $item->id)}}"
                                                                           class="product-name"> {{$item->name}}</a>
                                                                    </a>
                                                                </h3>
                                                                {!! $item->description !!}
                                                            </td>
                                                            <td>
                                                                <h4>
                                                                    {{$item->quantity}}{{$item->unit_of_measure_short}}
                                                                </h4>
                                                            </td>
                                                            <td style="width: 250px;">
                                                                <div class="tabulation">
                                                                    <div class="row">
                                                                        <div class="col-4 no-wrap text-muted text-left">Sub
                                                                            Total
                                                                        </div>
                                                                        <div class="col-8 no-wrap text-right">
                                                                            ₱{{number_format($winningBid - $serviceFee, 2)}}</div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 no-wrap text-muted text-left">
                                                                            Service Fee
                                                                        </div>
                                                                        <div class="col-8 no-wrap text-right">
                                                                            ₱{{number_format($serviceFee, 2)}}</div>
                                                                    </div>
                                                                    <div class="row total">
                                                                        <div class="col-4 no-wrap text-muted text-left">
                                                                            Total
                                                                        </div>
                                                                        <div class="col-8 no-wrap text-right">
                                                                            ₱{{number_format($winningBid, 2)}}</div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-left">
                                                                @if($item->status == 0)
                                                                    <form action="{{route('spot-market.complete_bid')}}"
                                                                          method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="id"
                                                                               value="{{$item->id}}">
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
                                                                        <button class="btn btn-primary mt-3">Complete
                                                                        </button>
                                                                    </form>
                                                                @elseif($item->status == 1)
                                                                    <span class="text-green">{{$item->method=='transport'?'Transported':'Completed'}}</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div role="tabpanel" id="tab-3" class="tab-pane">
                                        <div class="panel-body">
                                            <div class="table-responsive">
                                                <table class="table shoping-cart-table">
                                                    <tbody>
                                                    @foreach($winningBidsReverseBidding as $item)
                                                        @php
                                                            $winner = $item->bids->first()->user;
                                                            $winningBid = $item->bids->first()->bid;
                                                            $serviceFee = getServiceFee($item->unit_of_measure, $item->quantity, $winningBid, 'reverse');
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                <div class="cart-product-imitation">
                                                                    {!! ($item->hasMedia('reverse-bidding')? "<img class='img-thumbnail' src='".url('/').$item->getFirstMediaUrl('reverse-bidding')."'>":'')  !!}
                                                                </div>
                                                            </td>
                                                            <td class="text-left">
                                                                Winner: {{$winner->name??$winner->email}}
                                                            </td>
                                                            <td class="desc">
                                                                <h3>
                                                                    <a href="#" class="text-navy">
                                                                        <a href="{{route('reverse-bidding.show', $item->id)}}"
                                                                           class="product-name"> {{$item->name}}</a>
                                                                    </a>
                                                                </h3>
                                                                {!! $item->description !!}
                                                            </td>
                                                            <td>
                                                                <h4>
                                                                    {{$item->quantity}}{{$item->unit_of_measure_short}}
                                                                </h4>
                                                            </td>
                                                            <td style="width: 250px;">
                                                                <div class="tabulation">
                                                                    <div class="row">
                                                                        <div class="col-4 no-wrap text-muted text-left">Sub
                                                                            Total
                                                                        </div>
                                                                        <div class="col-8 no-wrap text-right">
                                                                            ₱{{number_format($winningBid - $serviceFee, 2)}}</div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 no-wrap text-muted text-left">
                                                                            Service Fee
                                                                        </div>
                                                                        <div class="col-8 no-wrap text-right">
                                                                            ₱{{number_format($serviceFee, 2)}}</div>
                                                                    </div>
                                                                    <div class="row total">
                                                                        <div class="col-4 no-wrap text-muted text-left">
                                                                            Total
                                                                        </div>
                                                                        <div class="col-8 no-wrap text-right">
                                                                            ₱{{number_format($winningBid, 2)}}</div>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-left">
                                                                @if($item->status == 0)
                                                                    <form action="{{route('reverse-bidding.complete_bid')}}"
                                                                          method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="id"
                                                                               value="{{$item->id}}">
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
                                                                        <button class="btn btn-primary mt-3">Complete
                                                                        </button>
                                                                    </form>
                                                                @elseif($item->status == 1)
                                                                    <span class="text-green">{{$item->method=='transport'?'Transported':'Completed'}}</span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else

                    <div class="ibox">
                        <div class="ibox-title">
                            <div class="ibox-tools">
                            </div>
                            <h5>Marketplace</h5>
                        </div>
                        <div class="ibox-content">
                            @foreach($myBidsMarketplace as $item)
                                @php
                                    $winner = $item->bids->first()->user;
                                    $winningBid = $item->bids->first()->bid;
                                    $serviceFee = getServiceFee($item->unit_of_measure, $item->quantity, $winningBid, 'market_place');
                                @endphp
                                <div class="row">
                                    <div class="col-12">
                                        <a href="" class="float-left mr-2 d-block">
                                            <img src="{{url('/').$item->getFirstMediaUrl('market-place')}}" alt=""
                                                 class="img-md"></a>
                                        <div class="ml-1">
                                            @if($item->status)
                                                <small class="text-muted float-right">{{\Carbon\Carbon::parse($item->expiration_time)->diffForHumans()}} </small>
                                            @else
                                                <a href="{{route('spot-market.winning_bids')}}" class="btn btn-primary btn-xs float-right">Award</a>
                                            @endif

                                            <strong>{{$winner->name??$winner->email}}</strong> won the
                                            <strong>{{$item->name}}</strong> for
                                            <strong>₱{{number_format($winningBid, 2)}}</strong>. <br>

                                            @if($item->status == 0)
                                                <small class="text-muted">Please complete via clicking the award button. </small>
                                            @else
                                                <small class="text-muted">Transaction completed </small><br>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <hr>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="ibox">
                        <div class="ibox-title">
                            <div class="ibox-tools">
                            </div>
                            <h5>Auction</h5>
                        </div>
                        <div class="ibox-content">
                            @foreach($myBidsSpotMarket as $item)
                                @php
                                    $winner = $item->spot_market_bids->first()->user;
                                    $winningBid = $item->spot_market_bids->first()->bid;
                                    $serviceFee = getServiceFee($item->unit_of_measure, $item->quantity, $winningBid, 'spot_market');
                                @endphp
                                <div class="row">
                                    <div class="col-12">
                                        <a href="" class="float-left mr-2 d-block">
                                            <img src="{{url('/').$item->getFirstMediaUrl('spot-market')}}" alt=""
                                                 class="img-md"></a>
                                        <div class="ml-1">
                                            @if($item->status)
                                                <small class="text-muted float-right">{{\Carbon\Carbon::parse($item->expiration_time)->diffForHumans()}} </small>
                                            @else
                                                <a href="{{route('spot-market.winning_bids')}}" class="btn btn-primary btn-xs float-right">Award</a>
                                            @endif

                                            <strong>{{$winner->name??$winner->email}}</strong> won the
                                            <strong>{{$item->name}}</strong> for
                                            <strong>₱{{number_format($winningBid, 2)}}</strong>. <br>

                                            @if($item->status == 0)
                                                <small class="text-muted">Please complete via clicking the award button. </small>
                                            @else
                                                <small class="text-muted">Transaction completed </small><br>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <hr>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="ibox-tools">
                            {{--                            <span class="label label-success float-right">Total</span>--}}
                        </div>
                        <h5>Product Count</h5>
                    </div>
                    <div class="ibox-content">
                        <table class="table table-bordered" id="count_table">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Marketplace</th>
                                <th>Auction</th>
                                <th>Purchase Order</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Today</td>
                                <td>{{$marketplaceCountToday}}</td>
                                <td>{{$spotMarketCountToday}}</td>
                                <td>{{$reverseBiddingCountToday}}</td>
                            </tr>
                            <tr>
                                <td>Week</td>
                                <td>{{$marketplaceCountWeek}}</td>
                                <td>{{$spotMarketCountWeek}}</td>
                                <td>{{$reverseBiddingCountWeek}}</td>
                            </tr>
                            <tr>
                                <td>Month</td>
                                <td>{{$marketplaceCountMonth}}</td>
                                <td>{{$spotMarketCountMonth}}</td>
                                <td>{{$reverseBiddingCountMonth}}</td>
                            </tr>
                            </tbody>


                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div>

            </div>
        </div>
    </div>

@endsection


@section('styles')
    {{--{!! Html::style('') !!}--}}
    {!! Html::style('/css/template/plugins/iCheck/custom.css') !!}
    {!! Html::style('/css/template/plugins/fullcalendar/fullcalendar.css') !!}
    {!! Html::style('/css/template/plugins/fullcalendar/fullcalendar.print.css') !!}
    <style>
        #count_table {

        }

        #count_table th {
            font-size: 12px;
            vertical-align: middle;
            text-align: center;
            font-weight: 500;
        }

        #count_table td {
            font-size: 12px;
            vertical-align: middle;
            text-align: center;
            font-weight: 400;
        }
    </style>
@endsection

@section('scripts')
    {{--{!! Html::script('') !!}--}}
    {!! Html::script('/js/template/plugins/jquery-ui/jquery-ui.min.js') !!}
    {!! Html::script('/js/template/plugins/iCheck/icheck.min.js') !!}
    {!! Html::script('/js/template/plugins/fullcalendar/moment.min.js') !!}
    {!! Html::script('/js/template/plugins/fullcalendar/fullcalendar.min.js') !!}
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection
