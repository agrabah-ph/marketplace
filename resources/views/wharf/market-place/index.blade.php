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
                    <a href="{!! route('market-place.create') !!}" class="btn btn-primary">Create</a>
            </div>
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content">

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
{{--                    <div class="ibox-title">--}}
{{--                        <h5>Blank <small>page</small></h5>--}}
{{--                    </div>--}}
                    <div class="ibox-content">

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" class="form-control input-sm m-b-xs" id="filter" placeholder="Search in table">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Farmer</th>
                                <th>Area</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Unit of Measure</th>
                                <th>Starting Bid</th>
                                <th>Added At</th>
                                <th>Expiration</th>
                                <th>Is Expired</th>
                                <th class="text-right" data-sort-ignore="true"><i class="fa fa-cogs text-success"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($spotMarketList as $data)
                                <tr>
                                    <td width="200px">{!! ($data->hasMedia('market-place')? "<img class='img-thumbnail' src='".url('/').$data->getFirstMediaUrl('market-place')."'>":'')  !!}  </td>
                                    <td>{{ $data->name }} </td>
                                    <td style="white-space: nowrap">{{ $data->fromFarmer['name'] }} </td>
                                    <td style="white-space: nowrap">{{ $data->area }} </td>
                                    <td>{!!  $data->description  !!} </td>
                                    <td>{!!  $data->quantity  !!} </td>
                                    <td>{!!  ucfirst($data->unit_of_measure)  !!} </td>
                                    <td class="text-right">{!!  $data->selling_price  !!} </td>
                                    <td style="white-space: nowrap">{!!  \Carbon\Carbon::parse($data->created_at)->format('M d, Y H:i:s')  !!} </td>
                                    <td style="white-space: nowrap">{{ \Carbon\Carbon::parse($data->expiration_time)->format('M d, Y H:i:s')  }} </td>
                                    <td>{!!  $data->is_expired?'Expired':'Active'  !!} </td>
                                    <td class="text-right">
                                        <div class="btn-group text-right">
                                            @if($isCommunityLeader)
                                                <a href="{{route('market-place.edit', $data->id)}}" class="action btn-white btn btn-xs"><i class="fa fa-search text-success"></i> View/Edit</a>
                                            @else
                                                <button class="add-to-cart btn-white btn btn-xs"  data-name="{{$data->name}}" data-id="{{$data->id}}">
                                                    <i class="fa fa-plus text-success"></i> Add to Cart</button>
                                                <button class="buy-to-cart btn-white btn btn-xs" ><i class="fa fa-cart-plus text-success"></i> Buy</button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="99" class="text-center"><a class="btn btn-sm btn-primary" href="{{route('market-place.create')}}">Add Item</a></td>
                                </tr>
                            @endforelse
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="2">
                                    <ul class="pagination pull-right"></ul>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal inmodal fade" id="modal" data-type="" tabindex="-1" role="dialog" aria-hidden="true" data-category="" data-variant="" data-bal="">
        <div id="modal-size">
            <div class="modal-content">
                <div class="modal-header" style="padding: 15px;">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-save-btn">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <div style="position: absolute; top: 20px; right: 20px;">

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
            $('.footable').footable();

            let toast1 = $('.toast1');
            toast1.toast({
                delay: 5000,
                animation: true
            });

            $('.add-to-cart').on('click', function(e){
                e.preventDefault();
                toast1.toast('show');
                var item = $(this).data('name');
                $('#item_added_to_cart').html(item);
            })
        });
    </script>
@endsection
