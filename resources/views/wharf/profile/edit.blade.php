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
                            <form id="form" action="{{ route('profile-update') }}" method="post" enctype="multipart/form-data" class="wizard-big">
                                <input type="hidden" name="id" value="{{$profile->id}}">
                                @csrf
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <div class="file-manager text-center profile_info" data-title="Profile Picture" data-name="image">
                                                <div id="image-upload" data-submit="" class="portrait-img-sm img-cropper-sm"></div>
                                                <small class="text-success">click frame to select image</small>
                                                <div class="clearfix mt-3"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="first_name">First name *</label>

                                            <input name="first_name" type="text" data-title="First name" class="profile_info form-control required" id="first_name" value="{{$profile->first_name}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="middle_name">Middle name *</label>

                                            <input name="middle_name" type="text" data-title="Middle name" class="profile_info form-control required" id="middle_name" value="{{$profile->middle_name}}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="last_name">Last name *</label>

                                            <input name="last_name" type="text" data-title="Last name" class="profile_info form-control required" id="last_name" value="{{$profile->last_name}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="form-group">
                                                    <label for="dob">Date of Birth *</label>

                                                    <input name="dob" type="text" data-title="Date of Birth" class="profile_info dob-input form-control required" id="dob" value="{{\Carbon\Carbon::parse($profile->dob)->format('m/d/Y')}}" required>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="age">Age</label>
                                                    <input name="age" type="text" class="form-control" id="age"  value="{{\Carbon\Carbon::parse($profile->dob)->age}}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group">
                                                    <label for="civil_status">Civil Status *</label>
                                                    <select name="civil_status" data-title="Civil Status" class="profile_info form-control required" id="civil_status" required>
                                                        <option value="" readonly></option>
                                                        <option {{$profile->civil_status=='Single'?'selected':''}} value="Single">Single</option>
                                                        <option {{$profile->civil_status=='Married'?'selected':''}} value="Married">Married</option>
                                                        <option {{$profile->civil_status=='Widow/er'?'selected':''}} value="Widow/er">Widower</option>
                                                        <option {{$profile->civil_status=='Separated'?'selected':''}} value="Separated">Separated</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="gender">Gender *</label>
                                                    <select name="gender" data-title="Gender" class="profile_info form-control required" id="gender" required>
                                                        <option value="" readonly></option>
                                                        <option {{$profile->gender =='Male'?'selected':''}} value="Male">Male</option>
                                                        <option {{$profile->gender =='Female'?'selected':''}} value="Female">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <button class="btn btn-primary">Submit</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="land-line">Land Line</label>
                                            <input name="landline" type="text" data-title="Land Line" class="profile_info form-control" id="land-line" value="{{$profile['landline']}}">
                                        </div>
                                        <div class="form-group">
                                            <label for="mobile">Mobile</label>
                                            <input name="mobile" type="text" data-title="Mobile" class="profile_info form-control" id="mobile" required value="{{$profile->mobile}}">
                                        </div>
                                    </div>
                                </div>
                            </form>
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
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css') !!}
    {!! Html::style('/css/template/plugins/datapicker/datepicker3.css') !!}
    {!! Html::style('/css/template/plugins/daterangepicker/daterangepicker-bs3.css') !!}
    <style>

        #image-upload{
            background: #FFFFFF url("{{authProfilePic()}}") center center no-repeat!important;
        }
    </style>
@endsection

@section('scripts')
    {{--    {!! Html::script('') !!}--}}
    {{--    {!! Html::script(asset('vendor/datatables/buttons.server-side.js')) !!}--}}
    {{--    {!! $dataTable->scripts() !!}--}}
    {{--    {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}--}}
    {{--    {!! Html::script('/js/template/moment.js') !!}--}}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js') !!}
    {!! Html::script('/js/template/plugins/datapicker/bootstrap-datepicker.js') !!}
    {!! Html::script('/js/template/plugins/daterangepicker/daterangepicker.js') !!}
    {!! Html::script('/js/template/moment.js') !!}
    {!! Html::script('/js/template/numeral.js') !!}
    <script>

        $(document).on('click', '#modal-save-btn', function(){
            setTimeout(function(){
            var profile_pic = $('#img-cropper-result').attr('src');
            $('#form').append('<input type="hidden" name="profile_pic" value="'+profile_pic+'">');
            },1000)

        });
        $(document).on('change', '#dob', function(){
            var dob = moment($(this).val());
            $('input[name=age]').val(moment().diff(dob, 'years')).trigger('focus');
            $(this).trigger('focus');
        });
        $(document).ready(function(){
            setTimeout(function(){
                $('#image-upload-input').attr('name','file')

            },1000)
            $('.dob-input').datepicker({
                startView: 2,
                todayBtn: false,
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "mm/dd/yyyy"
            });
        });
    </script>
@endsection
