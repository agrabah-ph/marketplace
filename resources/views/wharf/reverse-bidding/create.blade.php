@extends('wharf.master')

@section('title', 'Add Purchase Order')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>@yield('title')</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('reverse-bidding.index') }}">Lists</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>@yield('title')</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <button type="button" class="btn btn-primary btn-action" data-action="review">Submit</button>
            </div>
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content">
        {{--        {{ Form::open(array('route'=>array('farmer.store'), array('id'=>'form'))) }}--}}
        {{--        {{ Form::open(array('route'=>array('farmer.store'), 'method'=>'post', 'id'=>'form')) }}--}}

        {{ Form::open(['route'=>'reverse-bidding.store', 'class'=>'','id'=>'form','files'=>true]) }}
        <div class="row">
            <div class="col-sm-12">
                @include('alerts.validation')
                @csrf
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Purchase Order
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <img src="{{url('img/blank-landscape.jpg')}}" alt="" id="image_preview" class="mb-2"
                                         style="height: 174px;">
                                    <label class="w-100">Cover Photo</label>
                                    <input accept="image/*" type="file" class="form-control" id="image" name="image">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>PO Number</label>
                                    <input type="text" class="form-control" name="po_num" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Tagging/Category</label>
                                    <select name="category" id="category" class="form-control" required>
                                        <option value="">- Select -</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}">{{$category->display_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                            <div class="col-12 po_item_container">
                                <div class="row po_item_orig">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Item</label>
                                            <input type="text" class="form-control" name="item_name[]" required>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <input type="number" class="form-control" name="item_quantity[]" required>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Unit of Measure</label>
                                            <select name="item_unit_of_measure[]" id="unit_of_measure"
                                                    class="form-control">
                                                <option value="kilos">Kilos</option>
                                                <option value="pieces">Pieces</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <button class="btn btn-primary plus_item" type="button"
                                                style="margin-top: 2rem;"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr>
                            </div>
                            <div class="col-6">
                                {{--                                <div class="form-group">--}}
                                {{--                                    <label>Area</label>--}}
                                {{--                                    <input type="text" class="form-control" name="area" value="{{$defaultArea}}" required>--}}
                                {{--                                </div>--}}
                                <div class="form-group">
                                    <label>Area</label>
                                    <input type="text" class="form-control" name="area" id="area"
                                           value="{{$defaultArea}}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 pb-xs-3">
                                            <label>Bid End Date</label>
                                            <input type="text" class="datepicker-bid-end form-control"
                                                   name="bid_end_date">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                            <div style="position: relative">
                                                <label>Bid End Time</label>
                                                <input type="text" id="time" class="form-control timepicker"
                                                       name="bid_end_time"
                                                       required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Delivery Address</label>
                                    <textarea name="delivery_address" class="form-control no-resize"></textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 pb-xs-3">
                                            <label>Delivery Date</label>
                                            <input type="text" class="datepicker-deliver form-control"
                                                   name="delivery_date">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                            <div style="position: relative">
                                                <label>Delivery Time</label>
                                                <input type="text" id="time" class="form-control timepicker"
                                                       name="delivery_time"
                                                       required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="summernote" name="description" required>
                                        <h3>Product Details</h3>
                                        Ang produktong ito ay dekalidad at matibay. It a galing sa pag sisikap nang ating mga natatangin magsasaka. Tangkilikin ang sariling atin.
                                        <br/>
                                        <br/>
                                        <ul>
                                            <li>High quality</li>
                                            <li>Authentic</li>
                                            <li>Legit</li>
                                        </ul>
                                    </textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>


        </div>
        {{ Form::close() }}

        <div class="modal fade" id="purchase_order_review" data-type="" tabindex="-1" role="dialog" aria-hidden="true"
             data-category="" data-variant="" data-bal="">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="padding: 15px;">
                        <h3 class="modal-title">Review Purchase Order</h3>
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                                    class="sr-only">Close</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12" id="form_preview">
                                <div class="text-center">
                                    <img src="{{url('img/blank-landscape.jpg')}}" alt="" class="mb-2 pr-image"
                                         style="height: 174px;">
                                </div>
                                <table class="table table-borderless">
                                    <tbody>
                                    <tr>
                                        <td>PO Number</td>
                                        <td><span class="pr-po_num"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Category</td>
                                        <td><span class="pr-category"></span></td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top;">Items</td>
                                        <td>
                                            <table class="table table-bordered table-condensed">
                                                <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Qty</th>
                                                    <th></th>
                                                </tr>
                                                </thead>
                                                <tbody class="items_table">
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Area</td>
                                        <td><span class="pr-area"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Bid Ends</td>
                                        <td><span class="pr-bid_end_date"></span> <span class="pr-bid_end_time"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Delivery Address</td>
                                        <td><span class="pr-delivery_address"></span></td>
                                    </tr>
                                    <tr>
                                        <td>Delivery Date/Time</td>
                                        <td><span class="pr-delivery_date"></span> <span class="pr-delivery_time"></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align: top;">Description</td>
                                        <td><span class="pr-description"></span></td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-action" data-action="store" >Proceed</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('styles')
    {!! Html::style('/css/template/plugins/iCheck/custom.css') !!}
    {!! Html::style('/css/template/plugins/summernote/summernote-bs4.css') !!}
    {!! Html::style('/packages/jquery.datetimepicker.css') !!}
    {!! Html::style('/css/template/plugins/select2/select2.min.css') !!}
    {!! Html::style('/css/template/plugins/select2/select2-bootstrap4.min.css') !!}
    {!! Html::style('/css/template/plugins/datapicker/datepicker3.css') !!}
@endsection

@section('scripts')
    {!! Html::script('/js/template/plugins/iCheck/icheck.min.js') !!}
    {!! Html::script('/js/template/plugins/jqueryMask/jquery.mask.min.js') !!}
    {!! Html::script('/js/template/plugins/summernote/summernote-bs4.js') !!}
    {!! Html::script('/js/template/plugins/jquery-ui/jquery-ui.min.js') !!}
    {!! Html::script('/js/template/plugins/datapicker/bootstrap-datepicker.js') !!}

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    {!! Html::script('/packages/jquery.datetimepicker.full.min.js') !!}
    {!! Html::script('/js/template/plugins/select2/select2.full.min.js') !!}
    <script>

        function previewForm(form) {

            $('.pr-po_num').html($('[name="po_num"]').val());
            let image_default = "{{url('img/blank-landscape.jpg')}}";
            if($('#image').val()){
                $('.pr-image').attr('src', $('#image_preview').attr('src'));

            }
            $('.pr-category').html($('#category option:selected').text());

            let quantity = $("[name='item_quantity[]']");
            let uom = $("[name='item_unit_of_measure[]']");
            var row = "";
            $("[name='item_name[]']").each(function(i, e){
                let eachName = $(e).val();
                let eachQuantity = $(quantity[i]).val();
                let eachUom = $(uom[i]).val();
                row+='<tr>';
                row+='<td>';
                row+= eachName;
                row+='</td>';
                row+='<td>';
                row+= eachQuantity;
                row+='</td>';
                row+='<td>';
                row+= eachUom;
                row+='</td>';
                row+='</tr>';
            })


            $('.items_table').empty().append(row);
            $('.pr-area').html($('[name="area"]').val());
            $('.pr-bid_end_date').html($('[name="bid_end_date"]').val());
            $('.pr-bid_end_time').html($('[name="bid_end_date"]').val());
            $('.pr-delivery_address').html($('[name="delivery_address"]').val());
            $('.pr-delivery_date').html($('[name="delivery_date"]').val());
            $('.pr-delivery_time').html($('[name="delivery_time"]').val());
            $('.pr-description').html($('[name="description"]').val());
        }

        // Dropzone.options.dropz
        function numberWithCommas(x) {
            return x.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        $(document).ready(function () {

            /**
             * po_item_container
             po_item_orig
             plus_item
             */

            $(".plus_item").on('click', function () {
                let clone_po_items = $('.po_item_orig').clone();
                clone_po_items.removeClass('po_item_orig');
                clone_po_items.find('input').empty();
                clone_po_items.find('input').val('');
                clone_po_items.find('.plus_item').on('click', function () {
                    $(this).closest('.row').remove();
                });
                clone_po_items.find('.plus_item')
                    .removeClass('plus_item')
                    .addClass('remove_item')
                    .removeClass('btn-primary')
                    .addClass('btn-danger');
                clone_po_items.find('.fa-plus').removeClass('fa-plus').addClass('fa-minus')
                $('.po_item_container').append(clone_po_items);
            });


            $('.summernote').summernote();

            $("#from_user_id").select2({
                theme: 'bootstrap4',
                // placeholder: "",
            });

            $('.timepicker').datetimepicker({
                datepicker: false,
                step: 30,
                minTime: '00:00',
                defaultTime: '00:00',
                format: 'H:i',
            });

            $('.datepicker-deliver').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "mm/dd/yyyy"
            });
            $('.datepicker-bid-end').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "mm/dd/yyyy",
            }).on("change", function () {
                $('.datepicker-deliver').datepicker('destroy');
                $('.datepicker-deliver').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    autoclose: true,
                    format: "mm/dd/yyyy",
                    startDate: new Date(this.value)
                });
            });


            var imgInp = document.getElementById('image');
            var imgPre = document.getElementById('image_preview');

            imgInp.onchange = evt => {
                const [file] = imgInp.files
                if (file) {
                    imgPre.src = URL.createObjectURL(file)
                }
            }

            $('.money').mask("#,##0.00", {reverse: true});

            $(document).on('click', '.btn-action', function () {
                switch ($(this).data('action')) {
                    case 'review':
                        previewForm($('#form'));
                        $('#purchase_order_review').modal('show')
                        break;
                    case 'store':
                        $('#form').submit();

                        // console.log($('input[name=four_ps]').val());
                        // console.log($('input[name=pwd]').val());
                        // console.log($('input[name=indigenous]').val());
                        // console.log($('input[name=livelihood]').val());
                        break;
                }
            });


            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });


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

        });
    </script>
@endsection
