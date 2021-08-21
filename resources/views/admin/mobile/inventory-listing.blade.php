@extends('layouts.login')

@section('title', 'Inventory Listing')

@section('content')
    <div class="ibox-content">
        <div class="text-center">
            <h1>AGRABAH TRACEABILITY</h1>
        </div>
    </div>

    <section class="container mt-5">
        <div class="row">
            <div class="col-sm-3">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Farmer <small>Info</small></h5>
                    </div>
                    <div class="ibox-content">
                        <div class="mb-2">
                            <h3 class="mb-0">{!! $data->account_id !!}</h3>
                            <small class="text-success">Account ID</small>
                        </div>
                        <div class="mb-2">
                            <h3 class="mb-0">{!! $data->profile->first_name !!} {!! $data->profile->last_name !!}</h3>
                            <small class="text-success">Name</small>
                        </div>
{{--                        <div class="mb-2">--}}
{{--                            <button class="btn btn-block btn-success btn-xl btn-action">Add Item</button>--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>

            <div class="col-sm-9">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Inventory <small>Info</small></h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quality</th>
                                    <th class="text-right" style="width: 100px;">Qty</th>
                                    <th class="text-right" style="width: 50px" data-sort-ignore="true"><i class="fa fa-cogs text-success"></i></th>
                                </tr>
                                </thead>
                                <tbody id="inv-list">
                                @foreach($data->listing as $list)
                                <tr>
                                    <td>{{ $list->product->display_name }}</td>
                                    <td>{{ $list->quality }}</td>
                                    <td class="text-right">{{ $list->quantity }} {{ $list->unit }}</td>
                                    <td class="text-right">
                                        <div class="btn-group text-right">
                                            <button class="btn btn-white btn-xs btn-action" data-action="remove-item" data-id="{{ $list->id }}"><i class="fa fa-times text-danger"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
{{--                                <tr>--}}
{{--                                    <td class="text-right" colspan="4">--}}
{{--                                        <button type="button" class="btn btn-success btn-action" data-action="add-item">Add</button>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
                                </tfoot>
                            </table>
                        </div>
                        <div class="row">
{{--                            <div class="col"></div>--}}
                            <div class="col">
                                <button type="button" class="btn btn-success btn-action btn-block p-2" data-action="add-inventory" data-master="{!! $data->master_id !!}" data-farmer="{!! $data->id !!}"><h2><strong>ADD INVENTORY</strong></h2></button>
                            </div>
{{--                            <div class="col"></div>--}}
                        </div>
                    </div>
                </div>
            </div>

        </div>


    </section>


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
                    <button type="button" class="btn btn-primary btn-action" data-action="store-inventory">Save</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
    {!! Html::style('css/template/plugins/select2/select2.min.css') !!}
    {!! Html::style('css/template/plugins/select2/select2-bootstrap4.min.css') !!}
    {{--{!! Html::style('') !!}--}}
@endsection

@section('scripts')
    {!! Html::script('js/template/plugins/select2/select2.full.min.js') !!}
    {{--    {!! Html::script('') !!}--}}
    <script>
        $(document).ready(function(){
            var modal = $('#modal');
            $(document).on('click', '.btn-action', function(){
                switch($(this).data('action')){
                    case 'add-inventory':
                        var lists = new Array();
                        jQuery.ajaxSetup({async:false});
                        $.get('{!! route('product-list') !!}', function(data){
                            if(data.length > 0){
                                for(var a = 0; a < data.length; a++){
                                    lists.push('<option value="'+ data[a].id +'">'+ data[a].display_name +'</option>');
                                }
                            }
                        });
                        modal.data('master', $(this).data('master'));
                        modal.data('farmer', $(this).data('farmer'));
                        modal.find('.modal-title').text('Inventory Info');
                        modal.find('#modal-size').removeClass().addClass('modal-dialog modal-sm');
                        modal.find('.modal-body').empty().append('' +
                            '<div class="form-group">' +
                                '<label>Products <small class="text-danger">*</small></label>' +
                                // '<select name="product" class="form-control">' +
                                '<select name="product" class="select2 form-control">' +
                                    '<option value=""></option>' +
                                    lists.join('') +
                                '</select>' +
                            '</div>' +
                            '<div class="form-group">' +
                                '<label>Quality <small class="text-danger">*</small></label>' +
                                '<select name="quality" class="form-control">' +
                                    '<option value="">select</option>' +
                                    '<option value="High">High</option>' +
                                    '<option value="Medium">Medium</option>' +
                                    '<option value="Low">Low</option>' +
                                '</select>' +
                            '</div>' +
                            '<div class="row">' +
                                '<div class="col-sm-7 form-group">' +
                                    '<label>Unit <small class="text-danger">*</small></label>' +
                                    '<select name="unit" class="form-control"></select>' +
                                    // '<input type="text" name="unit" class="form-control">' +
                                '</div>' +
                                '<div class="col form-group">' +
                                    '<label>Qty <small class="text-danger">*</small></label>' +
                                    '<input type="text" name="quantity" class="form-control numonly">' +
                                '</div>' +
                            '</div>' +
                            '<div class="form-group">' +
                                '<label>Remark</label>' +
                                '<textarea name="remark" class="form-control no-resize"></textarea>' +
                            '</div>' +
                        '');

                        // $(".select2_demo_3").select2({
                        //     theme: 'bootstrap4',
                        //     placeholder: "Select product",
                        //     allowClear: true
                        // });

                        $(".select2").select2({
                            theme: 'bootstrap4',
                            tags: true,
                            dropdownParent: $("#modal"),
                            placeholder: "Select product"
                        });

                        modal.modal({backdrop: 'static', keyboard: false});
                        break;
                    case 'store-inventory':
                        var invDetails = new Array();
                        invDetails.push(modal.data('master'));
                        invDetails.push(modal.data('farmer'));
                        invDetails.push(modal.find('select[name=product]').val());
                        invDetails.push(modal.find('select[name=quality]').val());
                        invDetails.push(modal.find('select[name=unit]').val());
                        invDetails.push(modal.find('input[name=quantity]').val());
                        invDetails.push(modal.find('textarea[name=remark]').val());

                        console.log(invDetails);

                        $.post('{!! route('inv-listing-store') !!}', {
                            _token: '{!! csrf_token() !!}',
                            details: invDetails
                        }, function(data){
                            console.log(data);
                            $('#inv-list').append('' +
                                '<tr>' +
                                    '<td>'+ data.product.display_name +'</td>' +
                                    '<td>'+ data.quality +'</td>' +
                                    '<td class="text-right">'+ data.quantity +' '+ data.unit +'</td>' +
                                    '<td class="text-right">' +
                                        '<div class="btn-group text-right">' +
                                            '<button class="btn btn-white btn-xs btn-action" data-action="remove-item" data-id="'+ data.id +'"><i class="fa fa-times text-danger"></i></button>' +
                                        '</div>' +
                                    '</td>' +
                                '</tr>' +
                            '');
                            modal.modal('toggle');
                        });

                        break;
                    case 'remove-item':
                        var tr = $(this).closest('tr');
                        $.get('{!! route('inv-listing-delete') !!}', {
                            id: $(this).data('id')
                        }, function(data){
                            tr.remove();

                            console.log('deleted');
                        });
                        break;
                }

                // modal.modal('toggle');
            });

            $(document).on('change', 'select[name=product]', function(){
                console.log('change');
                var lists = new Array();
                jQuery.ajaxSetup({async:false});
                $.get('{!! route('product-unit-list') !!}', {
                    id: $(this).val()
                }, function(data){
                    if(data.length > 0){
                        for(var a = 0; a < data.length; a++){
                            lists.push('<option value="'+ data[a].name +'">'+ data[a].name +'</option>');
                        }
                    }
                });
                modal.find('select[name=unit]').empty().append(lists);
            });


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

        });
    </script>
@endsection
