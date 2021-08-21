@extends('admin.master')

@section('title', 'Farmer Info')

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
                @if(auth()->user()->hasRole('super-admin'))
                    <a href="{{ route('farmer.edit', array('farmer'=>$data)) }}" class="btn btn-primary">Edit</a>
                @endif
            </div>
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content">

        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Profile <small>info</small></h5>
            </div>
            <div class="ibox-content">

                <div class="row">
                    <div class="col-sm-5">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-2">
                                    <h3 class="mb-0">{{ $data->account_id }}</h3>
                                    <small class="text-success">Name</small>
                                </div>
                                <div class="mb-2">
                                    <h3 class="mb-0">{{ $data->profile->first_name }} {{ $data->profile->last_name }}</h3>
                                    <small class="text-success">Name</small>
                                </div>
                                <div class="mb-2">
                                    <h3 class="mb-0">{{ $data->profile->mobile }}</h3>
                                    <small class="text-success">Mobile</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-2">
                                    <h3 class="mb-0">{{ $data->profile->address }}</h3>
                                    <small class="text-success">Address</small>
                                </div>
                                <div class="mb-2">
                                    <h3 class="mb-0">{{ $data->profile->education }}</h3>
                                    <small class="text-success">Education</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-2">
                                    <h3 class="mb-0">{{ join(', ',$group) }}</h3>
                                    <small class="text-success">Membership / Group</small>
                                </div>
                                <div class="mb-2">
                                    <h3 class="mb-0">{{ $data->profile->organization }}</h3>
                                    <small class="text-success">Organization</small>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-2">
                                    <h3 class="mb-0">{{ $data->profile->farm_lot }}</h3>
                                    <small class="text-success">Farm Lot</small>
                                </div>
                                <div class="mb-2">
                                    <h3 class="mb-0">{{ $data->profile->farming_since }}</h3>
                                    <small class="text-success">Farming Since</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="visible-print text-center">
                            <img src="{{ URL::to($data->profile->qr_image_path) }}" alt="{{ $data->profile->qr_image_path }}" class="img-fluid">
                            <a href="{{ route('farmer-qr-print', array('account'=>$data->account_id)) }}" target="_blank" class="btn btn-success btn-block mt-2"><i class="fa fa-print"></i> Print QR </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Inventory <small>list</small></h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input type="text" class="form-control input-sm m-b-xs" id="filter" placeholder="Search in table">
                                </div>
                            </div>
                        </div>
                        <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Details</th>
                                <th class="text-right">Status</th>
{{--                                <th class="text-right" data-sort-ignore="true"><i class="fa fa-cogs text-success"></i></th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($inventories as $data)
                                <tr>
                                    <td>{{ $data->product->display_name }}</td>
                                    <td>{{ $data->quality }}; {{ $data->quantity }} {{ $data->unit }}</td>
                                    <td class="text-right">{{ $data->status }}</td>
{{--                                    <td class="text-right">--}}
{{--                                        <div class="btn-group text-right">--}}
{{--                                            <a href="" class="action btn-white btn btn-xs"><i class="fa fa-search text-success"></i> Show</a>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <td colspan="4">
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

            $(document).on('click', '.btn-action', function(){
                switch ($(this).data('action')) {
                    case 'store':
                        $('#form').submit();
                        break;
                }
            });
        });
    </script>
@endsection
