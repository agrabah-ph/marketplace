@extends('admin.master')

@section('title', 'Trace Show')

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
                <a href="{{ route('trace.index') }}" class="btn btn-primary">Back</a>
{{--                <button type="button" class="btn btn-primary btn-action" data-action="store">Store</button>--}}
            </div>
        </div>
    </div>
    {{--    <form action="{!! route('trace.store') !!}" method="post" id="form">--}}
    <div id="app" class="wrapper wrapper-content">

        <div class="row">
            <div class="col-sm-8">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5>Receiver <small>info</small></h5>
                            </div>
                            <div class="panel-body">
                                <div class="mb-2">
                                    <h3 class="mb-0">{{ $trace->receiver->value_0 }}</h3>
                                    <small class="text-success">Name</small>
                                </div>
                                <div class="mb-2">
                                    <h3 class="mb-0">{{ $trace->receiver->value_1 }}</h3>
                                    <small class="text-success">Mobile</small>
                                </div>
                                <div class="mb-2">
                                    <h3 class="mb-0">{{ $trace->receiver->text_0 }}</h3>
                                    <small class="text-success">Address</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5>Dispatch <small>info</small></h5>
                            </div>
                            <div class="panel-body">
                                <div class="mb-2">
                                    <h3 class="mb-0">{{ $trace->dispatch->value_0 }}</h3>
                                    <small class="text-success">Driver Name</small>
                                </div>
                                <div class="mb-2">
                                    <h3 class="mb-0">{{ $trace->dispatch->value_1 }}</h3>
                                    <small class="text-success">Mobile no.</small>
                                </div>
                                <div class="mb-2">
                                    <h3 class="mb-0">{{ $trace->dispatch->value_2 }}</h3>
                                    <small class="text-success">Vehicle Type</small>
                                </div>
                                <div class="mb-2">
                                    <h3 class="mb-0">{{ $trace->dispatch->value_3 }}</h3>
                                    <small class="text-success">Plate No.</small>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5>Reference <small>details</small></h5>
                            </div>
                            <div class="panel-body">
                                <div class="visible-print text-center">
                                    <img src="{{ URL::to($trace->image_path) }}" alt="" class="img-fluid">
{{--                                    <small class="text-success">{{ $trace->url }}</small>--}}
                                    <a href="{{ route('trace-qr-print', array('reference'=>$trace->reference)) }}" target="_blank" class="btn btn-success btn-block mt-2"><i class="fa fa-print"></i> Print QR </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5>Inventory <small>Info</small></h5>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Detail</th>
                                            <th class="text-right">Farmer</th>
                                            <th class="text-right">Community Leader</th>
                                            <th class="text-right">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody id="item-list">
                                        @foreach($trace->inventories as $data)
                                            <tr>
                                                <td>{{ $data->product->display_name }}</td>
                                                <td>{{ $data->quality }}; {{ $data->quantity }} {{ $data->unit }}</td>
                                                <td class="text-right">{{ $data->farmer->profile->first_name }} {{ $data->farmer->profile->last_name }}</td>
                                                <td class="text-right">{{ $data->leader->profile->first_name }} {{ $data->leader->profile->last_name }}</td>
                                                <td class="text-right">{{ $data->status }}</td>
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
            <div class="col-sm-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h5>Timeline <small>info</small></h5>
                    </div>
                    <div class="panel-body inspinia-timeline">
                        @foreach($trace->timeline as $timeline)
                            <div class="timeline-item">
                                <div class="row">
                                    <div class="col-3 date">
{{--                                        <i class="fa fa-file-text"></i>--}}
                                        {{ \Carbon\Carbon::parse($timeline->created_at)->toFormattedDateString() }}
                                        <br/>
                                        <small class="text-navy">{{ \Carbon\Carbon::parse($timeline->created_at)->diffForHumans(\Carbon\Carbon::now()) }}</small>
                                    </div>
                                    <div class="col-7 content">
                                        <p class="m-b-xs"><strong>{{ $timeline->value_0 }}</strong></p>
                                        <p>{{ $timeline->value_1 }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>



    </div>
    {{--    </form>--}}

    <div class="modal inmodal fade" id="modal" data-type="" tabindex="-1" role="dialog" aria-hidden="true" data-category="" data-variant="" data-bal="">
        <div id="modal-size">
            <div class="modal-content">
                <div class="modal-header" style="padding: 15px;">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-action" data-action="list-item">Save changes</button>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('styles')
    {!! Html::style('/css/template/plugins/iCheck/custom.css') !!}
    {{--{!! Html::style('') !!}--}}
    {{--    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}
    {{--    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}--}}
@endsection

@section('scripts')
    {!! Html::script('/js/template/plugins/iCheck/icheck.min.js') !!}
    {{--    {!! Html::script('') !!}--}}
    {{--    {!! Html::script(asset('vendor/datatables/buttons.server-side.js')) !!}--}}
    {{--    {!! $dataTable->scripts() !!}--}}
    {{--    {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}--}}
    {{--    {!! Html::script('/js/template/moment.js') !!}--}}
    <script>
        $(document).ready(function(){

            $(document).on('click', '.btn-action', function(){
                switch ($(this).data('action')) {
                    case 'store':
                        // $('#form').submit();
                        var datas = new Array(), ids = new Array();
                        $('#item-list > tr').each(function(){
                            ids.push($(this).data('id'));
                        });

                        $('.form-control').each(function(){
                            datas.push($(this).val());
                        });
                        // datas.push($('input[name=receiver-name]').val());
                        // datas.push($('input[name=receiver-mobile]').val());
                        // datas.push($('textarea[name=receiver-address]').val());
                        // datas.push($('input[name=driver-name]').val());
                        // datas.push($('input[name=driver-mobile]').val());
                        // datas.push($('input[name=vehicle-type]').val());
                        // datas.push($('input[name=vehicle-plate]').val());
                        // datas.push($('input[name=reference]').val());
                        // datas.push($('input[name=url]').val());
                        datas.push(ids);
                        // datas.push($('input[name=]').val());

                        console.log(datas);

                        $.post('{!! route('trace-store') !!}', {
                            _token: '{!! csrf_token() !!}',
                            datas: datas
                        }, function(data){
                            window.location.replace('{!! route('trace.index') !!}');
                        });

                        break;
                    case 'add-item':
                        getItem();
                        break;
                    case 'list-item':
                        var ids = $('.modal-item:checked').map(function(){
                            return $(this).val();
                        }).toArray();
                        // console.log(ids);
                        var products = new Array();
                        $.get('{!! route('farmer-inventory-list-item') !!}', {
                            ids: ids
                        }, function(data){
                            // console.log(data);
                            if(data.length > 0){
                                for(var a = 0; a < data.length; a++){
                                    products.push('' +
                                        '<tr data-id="'+ data[a].id +'">' +
                                        '<td>'+ data[a].name +'</td>' +
                                        '<td>'+ data[a].details +'</td>' +
                                        '<td class="text-right">'+ data[a].farmer.profile.first_name +' '+ data[a].farmer.profile.last_name +'</td>' +
                                        '<td class="text-right">' +
                                        '<div class="btn-group text-right">' +
                                        '<button class="btn btn-white btn-xs btn-action" data-action="remove-item"><i class="fa fa-times text-danger"></i></button>' +
                                        '</div>' +
                                        '</td>' +
                                        '</tr>' +
                                        '');
                                }
                            }
                            $('#item-list').append(products.join(''));
                        });
                        modal.modal('toggle');
                        break;
                    case 'remove-item':
                        $(this).closest('tr').remove();
                        break;
                }
            });

            var modal = $('#modal');
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

            function getItem() {
                modal.find('.modal-title').text('Farmer Inventory');
                modal.find('#modal-size').removeClass().addClass('modal-dialog modal-lg');
                var products = new Array(), ids = new Array();
                ids.push(0);

                $('#item-list > tr').each(function(){
                    ids.push($(this).data('id'));
                });

                console.log(ids);

                $.get('{!! route('farmer-inventory-list') !!}', {
                    ids: ids
                }, function(data){
                    // console.log(data);
                    if(data.length > 0){
                        for(var a = 0; a < data.length; a++){
                            products.push('' +
                                '<tr>' +
                                '<td>' +
                                '<div class="i-checks">' +
                                '<label>' +
                                '<input type="checkbox" name="" class="modal-item" value="'+ data[a].id +'">' +
                                '<i></i> ' + data[a].name +
                                '</label>' +
                                '</div>' +
                                '</td>' +
                                '<td>'+ data[a].details +'</td>' +
                                '<td class="text-right">'+ data[a].farmer.profile.first_name +' '+ data[a].farmer.profile.last_name +'</td>' +
                                '</tr>' +
                                '');
                        }
                    }

                    modal.find('.modal-body').empty().append('' +
                        '<div class="table-responsive">' +
                        '<table class="table table-striped">' +
                        '<thead>' +
                        '<tr>' +
                        '<th>Product</th>' +
                        '<th>Details</th>' +
                        '<th class="text-right">Farmer</th>' +
                        '</tr>' +
                        '</thead>' +
                        '<tbody>'+ products.join('') +'</tbody>' +
                        '</table>' +
                        '</div>' +
                        '');

                    $('.i-checks').iCheck({
                        checkboxClass: 'icheckbox_square-green',
                        radioClass: 'iradio_square-green',
                    });

                });

                modal.modal({backdrop: 'static', keyboard: false});
            }

        });
    </script>
@endsection
