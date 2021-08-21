@extends('admin.master')

@section('title', 'Product Edit')

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
                <button type="button" class="btn btn-primary btn-action" data-action="store">Update</button>
            </div>
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content">

        <div class="row">
            <div class="col-sm-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Product Info</h5>
                    </div>
                    <div class="ibox-content" id="product-info" data-id="{!! $product->id !!}">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" value="{!! $product->display_name !!}" class="form-control" name="name">
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control no-resize">{!! $product->description !!}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Product Unit/s</h5>
                    </div>
                    <div class="ibox-content" id="unit-info">

                        @foreach($product->units as $key => $unit)
                            @if ($key === 0)
                                <div class="row">
                                    <div class="col-sm-7">
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" name="unit-name" value="{{ $unit->name }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <label>Abbreviation</label>
                                            <input type="text" name="unit-abbr" value="{{ $unit->abbr }}" class="form-control">
                                        </div>

                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-sm-7">
                                        <div class="form-group">
                                            <input type="text" name="unit-name" value="{{ $unit->name }}" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-sm-5">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <input type="text" name="unit-abbr" value="{{ $unit->abbr }}" class="form-control">
                                                <span class="input-group-append">
                                                <button type="button" class="btn btn-white btn-action" data-action="remove-unit"><i class="fa fa-minus-circle text-danger"></i></button>
                                            </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        @endforeach
                    </div>
                    <div class="ibox-footer">
                        <button type="button" class="btn btn-block btn-success btn-action" data-action="add-unit">Add another</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection


@section('styles')
    {{--{!! Html::style('') !!}--}}
    {{--    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}
    {{--    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}--}}
@endsection

@section('scripts')
    {{--    {!! Html::script('') !!}--}}
    {{--    {!! Html::script(asset('vendor/datatables/buttons.server-side.js')) !!}--}}
    {{--    {!! $dataTable->scripts() !!}--}}
    {{--    {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}--}}
    {{--    {!! Html::script('/js/template/moment.js') !!}--}}
    <script>
        $(document).ready(function(){
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
                var box = $(this).closest('.ibox').find('.ibox-content');
                console.log($(this).data('action'));
                switch ($(this).data('action')) {
                    case 'add-unit':
                        box.append('' +
                            '<div class="row">' +
                            '<div class="col-sm-7">' +
                            '<div class="form-group">' +
                            '<input type="text" name="unit-name" class="form-control">' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-sm-5">' +
                            '<div class="form-group">' +
                            '<div class="input-group">' +
                            '<input type="text" name="unit-abbr" class="form-control">' +
                            '<span class="input-group-append">' +
                            '<button type="button" class="btn btn-white btn-action" data-action="remove-unit"><i class="fa fa-minus-circle text-danger"></i></button>' +
                            '</span>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '');
                        break;
                    case 'store':
                        var product = new Array();
                        var unit = new Array();
                        $('#product-info').find('.form-control').each(function(){
                            product.push($(this).val());
                        });
                        product.push('update');
                        product.push($('#product-info').data('id'));
                        $('#unit-info').find('.row').each(function(){
                            var unitList = new Array();
                            unitList.push($(this).find('input[name=unit-name]').val());
                            unitList.push($(this).find('input[name=unit-abbr]').val());
                            unit.push(unitList);
                        });
                        console.log(product);
                        console.log(unit);
                        $.post('{!! route('product-store') !!}', {
                            _token: '{!! csrf_token() !!}',
                            product: product,
                            unit: unit
                        }, function(data){
                            window.location.replace(data);
                        });
                        break;
                    case 'remove-unit':
                        $(this).closest('.row').remove();
                        break;
                }
            });
        });
    </script>
@endsection
