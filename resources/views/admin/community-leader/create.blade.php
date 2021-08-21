@extends('admin.master')

@section('title', 'Community Leader Create')

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
                <button type="button" class="btn btn-primary btn-action" data-action="store">Create Community Leader</button>
            </div>
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content">
        <div class="panel panel-default">
{{--            <div class="panel-heading">--}}
{{--                Basic Info--}}
{{--            </div>--}}
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-4">
                        <form action="{!! route('community-leader.store') !!}" method="post" id="form">@csrf
                        <div class="form-group">
                            <label>Select Farmer</label>
                            <select name="farmer-select" class="form-control select2">
                                <option value=""></option>
                                @foreach($farmers as $farmer)
                                    <option value="{{ $farmer->id }}">[ID# {{ $farmer->account_id }}] {{ $farmer->profile->first_name }} {{ $farmer->profile->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        </form>
                    </div>
                    <div class="col" id="profile-info-box"></div>
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
    {{--{!! Html::style('') !!}--}}
    {{--    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}
    {{--    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}--}}
    {!! Html::style('css/template/plugins/select2/select2.min.css') !!}
    {!! Html::style('css/template/plugins/select2/select2-bootstrap4.min.css') !!}
@endsection

@section('scripts')
    {{--    {!! Html::script('') !!}--}}
    {{--    {!! Html::script(asset('vendor/datatables/buttons.server-side.js')) !!}--}}
    {{--    {!! $dataTable->scripts() !!}--}}
    {{--    {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}--}}
    {{--    {!! Html::script('/js/template/moment.js') !!}--}}
    {!! Html::script('js/template/plugins/select2/select2.full.min.js') !!}
    <script>
        $(document).ready(function(){
            $(document).on('change', 'select[name=farmer-select]', function(){
                $.get('{!! route('select-profile') !!}', {
                    id: $(this).val()
                }, function(data){
                    // console.log(data);
                    $('#profile-info-box').empty().append(displayLoanApplicationDetails(data.profile, null));

                });
            });

            $(document).on('click', '.btn-action', function(){
                switch ($(this).data('action')) {
                    case 'store':
                        console.log(validateForms());
                        if(validateForms() > 0){
                            return false;
                        }
                        $('#form').submit();
                        break;
                }
            });

            function validateForms(){
                var error = 0;
                $('.form-group').removeClass('has-error');
                $('.form-control').each(function(){
                    if($(this).val().length < 1){
                        error += 1;
                        $(this).closest('.form-group').addClass('has-error');
                    }
                });
                return error;
            }

            $(".select2").select2({
                theme: 'bootstrap4',
                placeholder: "Select a Farmer"
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
