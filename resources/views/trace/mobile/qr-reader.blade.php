@extends('layouts.blank-master')

@section('title', 'QR Reader')

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
            <div class="title-action">
                <a href="#" class="btn btn-primary">This is action area</a>
            </div>
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content">

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-title">
                        <h5>Blank <small>page</small></h5>
                    </div>
                    <div class="ibox-content">

                        <div style="width: 500px" id="reader"></div>

                        <video id="preview"></video>

                        <div class="btn-group btn-group-toggle mb-5" data-toggle="buttons">
                            <label class="btn btn-primary active">
                                <input type="radio" name="options" value="1" autocomplete="off" checked> Front Camera
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" name="options" value="2" autocomplete="off"> Back Camera
                            </label>
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
    <style>
        #preview{
            width:500px;
            height: 500px;
            margin:0px auto;
        }

    </style>
    {{--{!! Html::style('') !!}--}}
    {{--    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}
    {{--    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}--}}
@endsection

@section('scripts')
    {{--    {!! Html::script('') !!}--}}
{{--    {!! Html::script('/js/html5-qrcode.min.js') !!}--}}
    {{--    {!! Html::script(asset('vendor/datatables/buttons.server-side.js')) !!}--}}
    {{--    {!! $dataTable->scripts() !!}--}}
    {{--    {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}--}}
    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    {{--    {!! Html::script('/js/template/moment.js') !!}--}}
    <script>
        var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });
        scanner.addListener('scan',function(content){
            alert(content);
            //window.location.href=content;
        });
        Instascan.Camera.getCameras().then(function (cameras){
            if(cameras.length>0){
                scanner.start(cameras[0]);
                $('[name="options"]').on('change',function(){
                    if($(this).val()==1){
                        if(cameras[0]!=""){
                            scanner.start(cameras[0]);
                        }else{
                            alert('No Front camera found!');
                        }
                    }else if($(this).val()==2){
                        if(cameras[1]!=""){
                            scanner.start(cameras[1]);
                        }else{
                            alert('No Back camera found!');
                        }
                    }
                });
            }else{
                console.error('No cameras found.');
                alert('No cameras found.');
            }
        }).catch(function(e){
            console.error(e);
            alert(e);
        });


        {{--$(document).ready(function(){--}}
        {{--    --}}{{--var modal = $('#modal');--}}
        {{--    --}}{{--$(document).on('click', '', function(){--}}
        {{--    --}}{{--    modal.modal({backdrop: 'static', keyboard: false});--}}
        {{--    --}}{{--    modal.modal('toggle');--}}
        {{--    --}}{{--});--}}

        {{--    --}}{{-- var table = $('#table').DataTable({--}}
        {{--    --}}{{--     processing: true,--}}
        {{--    --}}{{--     serverSide: true,--}}
        {{--    --}}{{--     ajax: {--}}
        {{--    --}}{{--         url: '{!! route('') !!}',--}}
        {{--    --}}{{--         data: function (d) {--}}
        {{--    --}}{{--             d.branch_id = '';--}}
        {{--    --}}{{--         }--}}
        {{--    --}}{{--     },--}}
        {{--    --}}{{--     columnDefs: [--}}
        {{--    --}}{{--         { className: "text-right", "targets": [ 0 ] }--}}
        {{--    --}}{{--     ],--}}
        {{--    --}}{{--     columns: [--}}
        {{--    --}}{{--         { data: 'name', name: 'name' },--}}
        {{--    --}}{{--         { data: 'action', name: 'action' }--}}
        {{--    --}}{{--     ]--}}
        {{--    --}}{{-- });--}}

        {{--    --}}{{--table.ajax.reload();--}}




        {{--});--}}
    </script>
@endsection
