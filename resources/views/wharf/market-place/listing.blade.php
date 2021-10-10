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
            <div class="col-12">
                <div class="ibox">
                    <div class="ibox-content">
                        <div class="form-group">
                            <label>Areas</label>
                            <select class="form-control" id="areas" name="areas" required>
                                <option value="_all">All</option>
                                @foreach($areas as $id => $area)
                                    @if($area)
                                        <option value="{{$area}}" {{request()->area == $area ?'selected':''}}>{{$area}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                    <small class="text-muted"><i class="fa fa-map-marker"></i> {{$data->area??'No Area'}}</small>
                                    <div class="title">{{$data->name}}</div>
                                    <a href="#" class="add-to-cart d-block d-lg-none"  data-name="{{$data->name}}" data-id="{{$data->id}}"> <i class="fa fa-cart-plus"></i> Add to Cart  </a>
                                </div>
                                <div class="price">₱{{$data->selling_price}}</div>
                            </div>
                        </a>
                    </div>
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
        let toast1;
        $(document).on('change','#areas', function(e){
            var value = this.value;
            window.location.href = "{{route('market-place-listing')}}?area=" + value;
        });
        $(document).ready(function(){
            $('.footable').footable();

            toast1 = $('.toast1');
            toast1.toast({
                delay: 5000,
                animation: true
            });

            $('.add-to-cart').on('click', function(e){
                e.preventDefault();
                var itemId = $(this).data('id');
                var item = $(this).data('name');
                addToCart(itemId, item);
            })
        });

        function addToCart(id, item){

            $.ajax({
                url: "{{route('market-place-add_cart')}}",
                type:"POST",
                data:{
                    id:id,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success:function(response){
                    if(response>0){
                        $('#spot_market_cart_count').html(response);
                        $('#item_added_to_cart').html(item);
                        $('#toast-message').html("has been added to cart.");
                        toast1.removeClass('toast-danger');
                        toast1.addClass('toast-success');
                        toast1.toast('show');
                    }else{
                        $('#item_added_to_cart').html("Error");
                        $('#toast-message').html("not enough stocks.");
                        toast1.removeClass('toast-success');
                        toast1.addClass('toast-danger');
                        toast1.toast('show');
                    }

                },
            });
            console.log(id)
        }
    </script>
@endsection
