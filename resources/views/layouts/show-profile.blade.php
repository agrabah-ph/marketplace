@extends('wharf.master')
@section('title', 'Profile')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-4">
            <h2>@yield('title')</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="\">Dashboard</a>
                </li>
                <li class="breadcrumb-item active">
                    <strong>@yield('title')</strong>
                </li>
            </ol>
        </div>
        <div class="col-sm-8">
            {{--            <div class="title-action">--}}
            {{--                <a href="#" class="btn btn-primary">This is action area</a>--}}
            {{--            </div>--}}
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content animated fadeInRight">


        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content" id="profile-info-box">
                        <div class="panel-body">
                            <h2 class="text-success"><strong>Personal Information</strong></h2>
                            <div class="row">
                                <div class="col-3">
                                    <img src="{{$profile->image??'/img/img-icon.png'}}" alt="profile-picture" class="img-fluid">
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <dl>
                                                <dt>First name</dt>
                                                <dd>{{$profile->first_name}}</dd>
                                            </dl>
                                            <dl>
                                                <dt>Middle name</dt>
                                                <dd>{{$profile->middle_name}}</dd>
                                            </dl>
                                            <dl>
                                                <dt>Last name</dt>
                                                <dd>{{$profile->last_name}}</dd>
                                            </dl>
                                        </div>
                                        <div class="col">
                                            <dl>
                                                <dt>Date of Birth</dt>
                                                <dd>{{$profile->bday}}</dd>
                                            </dl>
                                            <dl>
                                                <dt>Age</dt>
                                                <dd>{{\Carbon\Carbon::parse($profile->bday)->age}}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="row">
                                        <div class="col ">
                                            <dl>
                                                <dt>Civil Status</dt>
                                                <dd>{{$profile->civil_status}}</dd>
                                            </dl>
                                        </div>
                                        <div class="col">
                                            <dl>
                                                <dt>Gender</dt>
                                                <dd>{{$profile->gender}}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <dl>
                                                <dt>Land Line</dt>
                                                <dd>{{$profile->landline}}</dd>
                                            </dl>
                                        </div>
                                        <div class="col">
                                            <dl>
                                                <dt>Mobile</dt>
                                                <dd>{{$profile->mobile}}</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
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


        function displayLoanApplicationDetails(profile, loanDetail) {
            console.log(profile);
            console.log(loanDetail);
            var dependents = new Array();


            var content = ''
            return content;
        };
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
            loadProfile();
            function loadProfile(){
                $.get('{!! route('get-my-profile') !!}', function(data){
                    console.log(data);
                    // $('#profile-info-box').empty().append(displayLoanApplicationDetails(data.profile, null));
                });
            }

        });
    </script>
@endsection
