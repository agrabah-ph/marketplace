@extends('wharf.master')

@section('title', 'Edit Purchase Order')

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
                <button type="button" class="btn btn-primary btn-action" data-action="store">Update</button>
            </div>
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content">
        {{--        {{ Form::open(array('route'=>array('farmer.store'), array('id'=>'form'))) }}--}}
        {{--        {{ Form::open(array('route'=>array('farmer.store'), 'method'=>'post', 'id'=>'form')) }}--}}

        {{ Form::open(['route'=>['reverse-bidding.update', $data->id],'id'=>'form','method'=>'put','files'=>true]) }}
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
                                    <img src="{{url('/').$data->getFirstMediaUrl('reverse-bidding')}}" alt="" id="image_preview" class="mb-2" style="height: 174px;">
                                    <label class="w-100">Cover Photo</label>
                                    <input accept="image/*" type="file" class="form-control" id="image" name="image">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>PO Number</label>
                                    <input type="text" class="form-control" name="po_num" value="{{$data->po_num}}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Tagging/Category</label>
                                    <select name="category" id="category" class="form-control" required>
                                        <option value="">- Select -</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" {{$category->id == $data->category_id?'selected':''}}>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                            <div class="col-12 po_item_container">
                                @foreach($data->items as $item_keys => $item)
                                <div class="row {{$item_keys==0?'po_item_orig':''}}">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Item</label>
                                            <input type="text" class="form-control" name="item_name[]" value="{{$item->item_name}}" required>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Quantity</label>
                                            <input type="number" class="form-control" name="item_quantity[]" value="{{$item->quantity}}" required>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Unit of Measure</label>
                                            <select name="item_unit_of_measure[]" id="unit_of_measure" class="form-control">
                                                <option value="kilos" {{$item->unit_of_measure == 'kilos'?'selected':''}}>Kilos</option>
                                                <option value="pieces" {{$item->unit_of_measure == 'pieces'?'selected':''}}>Pieces</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        @if($item_keys==0)
                                            <button class="btn btn-primary plus_item" type="button" style="margin-top: 2rem;"><i class="fa fa-plus"></i></button>
                                        @else
                                            <button type="button" class="btn remove_item btn-danger" style="margin-top: 2rem;"><i class="fa fa-minus"></i></button>
                                        @endif
                                    </div>
                                </div>
                                @endforeach

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
                                           value="{{$data->area}}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 pb-xs-3">
                                            <label>Bid End Date</label>
                                            <input type="text" class="datepicker-bid-end form-control" name="bid_end_date" value="{{\Carbon\Carbon::parse($data->expiration_time)->format('m/d/Y')}}">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                            <div style="position: relative">
                                                <label>Bid End Time</label>
                                                <input type="text" id="time" class="form-control timepicker" name="bid_end_time" value="{{\Carbon\Carbon::parse($data->expiration_time)->format('H:i')}}"
                                                       required autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Delivery Address</label>
                                    <textarea name="delivery_address" class="form-control no-resize">{{$data->delivery_address}}</textarea>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6 pb-xs-3">
                                            <label>Delivery Date</label>
                                            <input type="text" class="datepicker-deliver form-control" name="delivery_date" value="{{\Carbon\Carbon::parse($data->delivery_date_time)->format('m/d/Y')}}">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-6">
                                            <div style="position: relative">
                                                <label>Delivery Time</label>
                                                <input type="text" id="time" class="form-control timepicker"  name="delivery_time" value="{{\Carbon\Carbon::parse($data->delivery_date_time)->format('H:i')}}"
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

        <div class="modal inmodal fade" id="modal" data-type="" tabindex="-1" role="dialog" aria-hidden="true"
             data-category="" data-variant="" data-bal="">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header" style="padding: 15px;">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span
                                    class="sr-only">Close</span></button>
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

            $(".plus_item").on('click',function(){
                let clone_po_items = $('.po_item_orig').clone();
                clone_po_items.removeClass('po_item_orig');
                clone_po_items.find('input').empty();
                clone_po_items.find('input').val('');
                clone_po_items.find('.plus_item').on('click',function(){
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
                format:'H:i'
                // format: 'h:i a',
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
            }).on("change", function() {
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
