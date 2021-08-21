@extends('layouts.login')

@section('title', 'Blank')

@section('content')
    <div class="ibox-content">
        <div class="text-center">
            <img src="{{ URL::to('/images/logo.png') }}" alt="agrabah-logo" class="logo img-fluid mt-3" width="250">
        </div>
    </div>

    <section class="container">

        <div class="row mt-5">
            <div class="col">
                <div class="wrapper wrapper-content text-center">
                    <h3 class="mb-0">Reference ID:</h3>
                    <h1 class="mt-0 mb-4">{{ $data->reference }}</h1>
                    {{ QrCode::size(200)->generate($data->url) }}
                    @if(($data->trace == 'Delivered') || ($data->trace == 'Undeliverable'))
                        <div class="wrapper wrapper-content">
                            <div class="ibox-content">
                                <div class="text-center">
                                    <h2><strong>Completed: <small>{{ $data->trace }}</small></strong></h2>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @if(($data->trace == 'Delivered') || ($data->trace == 'Undeliverable'))
            @else
            <div class="col-sm-8">

                <div class="wrapper wrapper-content">
                    <div class="ibox-content ibox-heading">
                        <h3><i class="fa fa-user-o"></i> Trace Info</h3>
                    </div>
                    <div class="ibox-content">
                        <div class="row feed-activity-list">
                            <div class="col-sm-6">
                                <div>
                                    <h3>Receiver:</h3>
                                    <span><i class="fa fa-user"></i> <strong>{{ $data->receiver->value_0 }}</strong></span><br>
                                    <span><i class="fa fa-mobile"></i> {{ $data->receiver->value_1 }}</span><br>
                                    <span><i class="fa fa-map-marker"></i> {{ $data->receiver->text_0 }}</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div>
                                    <h3>Dispatch:</h3>
                                    <span><i class="fa fa-user"></i> <strong>{{ $data->dispatch->value_0 }}</strong></span><br>
                                    <span><i class="fa fa-mobile"></i> {{ $data->dispatch->value_1 }}</span><br><br>
                                    <dl>
                                        <dd>Vehicle Type: {{ $data->dispatch->value_2 }}</dd>
                                        <dd>Plate: {{ $data->dispatch->value_3 }}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="row status-btn-box">
{{--                            <div class="col-sm-12">--}}
{{--                                <p>Please present this CODE upon receiving your package.</p>--}}
{{--                                <table>--}}
{{--                                    <thead>--}}
{{--                                    <tr>--}}
{{--                                        <th colspan="4">Dispatch Information</th>--}}
{{--                                    </tr>--}}
{{--                                    </thead>--}}
{{--                                    <tbody>--}}
{{--                                    <tr>--}}
{{--                                        <td width="150">Driver Name</td>--}}
{{--                                        <td>{{ $data->dispatch->value_0 }}</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>Mobile no.</td>--}}
{{--                                        <td>{{ $data->dispatch->value_1 }}</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>Vehicle Type</td>--}}
{{--                                        <td>{{ $data->dispatch->value_2 }}</td>--}}
{{--                                    </tr>--}}
{{--                                    <tr>--}}
{{--                                        <td>Plate No.</td>--}}
{{--                                        <td>{{ $data->dispatch->value_3 }}</td>--}}
{{--                                    </tr>--}}
{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                            </div>--}}
                            @switch($data->trace)
                                @case('Arrive')
                                <div class="col-sm-6">
                                    <button class="btn btn-block btn-success btn-action p-3" data-id="{{ $data->id }}" data-action="Delivered">DELIVERED</button>
                                </div>
                                <div class="col-sm-6">
                                    <button class="btn btn-block btn-danger btn-action p-3" data-id="{{ $data->id }}" data-action="Undeliverable">UNDELIVERABLE</button>
                                </div>
                                @break
                                @default
                                <div class="col-sm-12">
                                    <button class="btn btn-block btn-success btn-action p-3" data-id="{{ $data->id }}" data-action="{{ $data->trace }}">
                                        @switch($data->trace)
                                            @case('Loaded')
                                            Depart
                                            @break
                                            @case('Transit')
                                            Arrive
                                            @break
                                        @endswitch
                                    </button>
                                </div>
                            @endswitch
                        </div>
                    </div>
                </div>

            </div>
            @endif
        </div>
    </section>


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
                    <button type="button" class="btn btn-primary" id="modal-save-btn">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    {{--{!! Html::style('') !!}--}}
    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}
@endsection

@section('scripts')
    {{--    {!! Html::script('') !!}--}}
        {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}
    <script>
        $(document).ready(function(){
            $(document).on('click', '.btn-action', function(){
                var id = $(this).data('id');
                let action;
                console.log('id: '+ id);
                console.log('action: '+ $(this).data('action'));
                switch ($(this).data('action')){
                    case 'Loaded':
                        action = 'Depart';
                        updateStatus(id, action);
                        break;
                    case 'Transit':
                        action = 'Transit';
                        updateStatus(id, action);
                        break;
                    case 'Arrive':
                        action = 'Arrive';
                        updateStatus(id, action);
                        break;
                    case 'Undeliverable':
                        action = 'Undeliverable';
                        updateStatus(id, action);
                        break;
                    case 'Delivered':
                        action = 'Delivered';
                        clientReference(id, action);
                        break;
                    case 'Reference':
                        var input = $('.status-btn-box').find('input[name=code]');
                        $.get('{!! route('trace-shipped') !!}', {
                            code: input.val()
                        }, function(data){
                            if(data === 'success'){
                                swal({
                                    title: "Good job!",
                                    text: "Package delivered!",
                                    type: "success",
                                    confirmButtonColor: "#5563dd",
                                    confirmButtonText: "ok!",
                                    closeOnConfirm: true
                                },function (isConfirm) {
                                    if (isConfirm) {
                                        location.reload();
                                    }
                                });

                            }else{
                                input.closest('.form-group').addClass('has-error');
                            }
                        });

                        break;
                }




            });

            function updateStatus(id, action){
                swal({
                    title: "Are you sure?",
                    text: "Your will not be able to undo this action!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes!",
                    cancelButtonText: "No!",
                    closeOnConfirm: false,
                    closeOnCancel: false },
                function (isConfirm) {
                    if (isConfirm) {
                        $.get('{!! route('trace-update-status') !!}', {
                            id: id,
                            action: action
                        }, function(){
                            location.reload();
                        });
                    } else {
                        swal("Cancelled", "Trace unchanged", "error");
                    }
                });
            }

            function clientReference(id, action){
                var box = $('.status-btn-box');
                switch (action){
                    case 'Delivered':
                        box.empty().append('' +
                            '<div class="farmer-login text-center">' +
                                '<div class="form-group mb-3">' +
                                    '<input type="text" name="code" class="form-control">' +
                                    '<label><strong class="text-uppercase">receiver REFERENCE ID</strong></label>' +
                                '</div>' +
                                '<button type="submit" class="btn btn-block btn-xl btn-action btn-success p-3" data-action="Reference" data-id="'+ id +'">PROCEED</button>' +
                            '</div>' +
                        '');
                        break;
                    case 'Reference':
                        // box.empty().append('' +
                        //     '<div class="col-sm-6">' +
                        //         '<button class="btn btn-block btn-success btn-action p-3" data-id="" data-action="Delivered">DELIVERED</button>' +
                        //     '</div>' +
                        //     '<div class="col-sm-6">' +
                        //         '<button class="btn btn-block btn-danger btn-action p-3" data-id="" data-action="Returned">UNDELIVERABLE</button>' +
                        //     '</div>' +
                        // '');
                        break;
                }

            }

        });
    </script>
@endsection
