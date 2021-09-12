@extends('wharf.master')

{{--@section('title', 'Dashboard | '.getRoleName('display_name'))--}}
@section('title', 'Dashboard')

@section('content')

    <div id="app" class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-9">
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
                        @foreach($spotMarketWinningBids as $item)
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
