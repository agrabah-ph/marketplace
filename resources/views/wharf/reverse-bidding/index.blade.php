@extends('wharf.master')

@section('title', 'Purchase Orders')

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
                    <a href="{!! route('reverse-bidding.create') !!}" class="btn btn-primary">Create</a>
            </div>
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content">


        @if(getRoleName() == 'enterprise-client')
            <div class="banner-section mb-4">
                <div class="banner-container-mobile">
                    <img src="{{ asset('images/wharf/banners/banner-7.png') }}" alt="banner" class="img-fluid d-block mx-auto">
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>Area</th>
                                <th>Items</th>
                                <th>Description</th>
                                <th>Added At</th>
                                <th>Expiration</th>
                                <th>Is Expired</th>
                                <th class="text-right" data-sort-ignore="true"><i class="fa fa-cogs text-success"></i></th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($list as $data)
                                <tr>
                                    <td width="200px">{!! ($data->hasMedia('reverse-bidding')? "<img class='img-thumbnail' src='".url('/').$data->getFirstMediaUrl('reverse-bidding')."'>":'')  !!}  </td>
                                    <td style="white-space: nowrap">{{ $data->area }} </td>
                                    <td style="white-space: nowrap">
                                        <ol>
                                        @foreach($data->items as $item)
                                            <li>{{$item->item_name}} - {{$item->quantity}} {{$item->unit_of_measure_short}}
                                            </li>
                                        @endforeach
                                        </ol>
                                    </td>
                                    <td>{!!  $data->description  !!} </td>
                                    <td style="white-space: nowrap">{!!  \Carbon\Carbon::parse($data->created_at)->format('M d, Y H:i:s')  !!} </td>
                                    <td style="white-space: nowrap">{{ \Carbon\Carbon::parse($data->expiration_time)->format('M d, Y H:i:s')  }} </td>
                                    <td>{!!  $data->is_expired?'Expired':'Active'  !!} </td>
                                    <td class="text-right">
                                        <div class="btn-group text-right">
                                            @if($isCommunityLeader)
                                                <a href="{{route('reverse-bidding.show', $data->id)}}" class="action btn-white btn btn-xs"><i class="fa fa-search text-success"></i> View</a>
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
                                    <td colspan="99" class="text-center"><a class="btn btn-sm btn-primary" href="{{route('reverse-bidding.create')}}">Add Item</a></td>
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
