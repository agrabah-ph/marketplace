@extends('wharf.master')

@section('title', 'Edit '.$data->name )

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>@yield('title')</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Dashboard</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('market-place.index') }}">Lists</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>@yield('title')</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-8">
            <div class="title-action">
                <button type="button" class="btn btn-primary btn-action" data-action="inventory">Inventory</button>
                <button type="button" class="btn btn-primary btn-action" data-action="store">Update</button>
            </div>
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content">
        {{ Form::open(['route'=>['market-place.update', $data->id],'id'=>'form','method'=>'put','files'=>true]) }}
        <div class="row">
            <div class="col-sm-12">
                @csrf
                @include('alerts.validation')
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Product Information
                    </div>
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <img src="{{url('/').$data->getFirstMediaUrl('market-place')}}" alt=""
                                         id="image_preview" class="mb-2" style="height: 174px;">
                                    <label class="w-100">Photo</label>
                                    <input accept="image/*" type="file" class="form-control" id="image" name="image">
                                </div>
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" class="form-control" name="name" value="{{$data->name}}"
                                           required>
                                </div>
                                <div class="form-group">
                                    <label>Selling Bid</label>
                                    <input type="text" class="form-control money" name="selling_price"
                                           value="{{$data->selling_price}}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Supplier</label>
                                    <select class="form-control" id="from_user_id" name="from_user_id">
                                        <option value="{{auth()->user()->id}}" {{$data->from_user_id==auth()->user()->id?'selected':''}}>
                                            I'm the supplier
                                        </option>
                                        @foreach($farmers as $farmer)
                                            <option value="{{$farmer->user->id}}" {{$data->from_user_id==$farmer->user->id?'selected':''}}>{{$farmer->user->name??$farmer->user->email}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Inventory</label>
                                    <input type="number" class="form-control" name="quantity" disabled required
                                           value="{{$data->quantity}}">
                                </div>
                                <div class="form-group">
                                    <label>Unit of Measure</label>
                                    <select name="unit_of_measure" id="unit_of_measure" class="form-control">
                                        <option value="kilos" {{$data->unit_of_measure=='kilos'?'selected':''}}>Kilos
                                        </option>
                                        <option value="banyera" {{$data->unit_of_measure=='banyera'?'selected':''}}>
                                            Banyera
                                        </option>
                                        <option value="lot" {{$data->unit_of_measure=='lot'?'selected':''}}>Lot</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea class="summernote" name="description">
                                    {!! $data->description !!}
                                </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}

    </div>

    <div class="modal inmodal fade" id="inventory" data-type="" tabindex="-1" role="dialog" aria-hidden="true"
         data-category="" data-variant="" data-bal="">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header" style="padding: 15px;">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">Inventory</h4>
                </div>
                <div class="modal-body">
                    <div class="ibox">
                        <div class="ibox-content">
                            <div class="row">
                                <div class="col-12">
                                    <form action="{{route('market-place-inventory-actions')}}" method="post">
                                        @csrf
                                        <input type="hidden" value="{{$data->id}}" name="id">
                                        <div class="form-group">
                                            <label for="">Add / Remove</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="document.getElementById('int_qty').stepDown()"><i class="fa fa-minus"></i></button>
                                                </div>
                                                <input type="number" class="form-control text-center" id="int_qty" value="0" name="int_qty">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-sm btn-green" onclick="document.getElementById('int_qty').stepUp()"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </div>
                                            <small class="">*Note: Add <b>minus sign (-)</b> to remove quantity</small>
                                        </div>
                                        Current Inventory: {{number_format($data->quantity)}}
                                        <button type="submit" class="btn btn-primary float-right">Apply</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th class="text-right">Qty</th>
                            <th>User</th>
                            <th>Timestamp</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data->inventory as $inventory)
                            <tr>
                                <td class="text-right">{{number_format($inventory->quantity)}}</td>
                                <td>{{$inventory->user->name??$inventory->user->email}}</td>
                                <td style="white-space: nowrap">{{$inventory->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal inmodal fade" id="modal" data-type="" tabindex="-1" role="dialog" aria-hidden="true"
         data-category="" data-variant="" data-bal="">
        <div id="modal-size">
            <div class="modal-content">
                <div class="modal-header" style="padding: 15px;">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
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
    {!! Html::style('/css/template/plugins/iCheck/custom.css') !!}
    {!! Html::style('/css/template/plugins/summernote/summernote-bs4.css') !!}
    {!! Html::style('/packages/jquery.datetimepicker.css') !!}
    {!! Html::style('/css/template/plugins/select2/select2.min.css') !!}
    {!! Html::style('/css/template/plugins/select2/select2-bootstrap4.min.css') !!}

    {{--    {!! Html::style('/css/template/plugins/dropzone/dropzone.css') !!}--}}
    {{--{!! Html::style('') !!}--}}
    {{--    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}
    {{--    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}--}}
@endsection

@section('scripts')
    {!! Html::script('/js/template/plugins/iCheck/icheck.min.js') !!}
    {!! Html::script('/js/template/plugins/jqueryMask/jquery.mask.min.js') !!}
    {!! Html::script('/js/template/plugins/summernote/summernote-bs4.js') !!}
    {!! Html::script('/js/template/plugins/jquery-ui/jquery-ui.min.js') !!}
    {{--    {!! Html::script('/js/template/plugins/datapicker/bootstrap-datepicker.js') !!}--}}

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    {!! Html::script('/packages/jquery.datetimepicker.full.min.js') !!}
    {!! Html::script('/js/template/plugins/select2/select2.full.min.js') !!}

    {{--    {!! Html::script('/js/template/plugins/dropzone/dropzone.js') !!}--}}
    {{--    {!! Html::script('') !!}--}}
    {{--    {!! Html::script(asset('vendor/datatables/buttons.server-side.js')) !!}--}}
    {{--    {!! $dataTable->scripts() !!}--}}
    {{--    {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}--}}
    {{--    {!! Html::script('/js/template/moment.js') !!}--}}
    <script>

        // Dropzone.options.dropz
        function numberWithCommas(x) {
            return x.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        $(document).ready(function () {
            $('.summernote').summernote();

            $("#from_user_id").select2({
                theme: 'bootstrap4',
                // placeholder: "",
            });

            $('#time').datetimepicker({
                datepicker: false,
                step: 30,
                minTime: '00:00',
                defaultTime: '00:00',
                format: 'H:i'
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
                        break;
                    case 'inventory':
                        $('#inventory').modal('show');
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
