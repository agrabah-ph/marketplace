@extends('wharf.master')

{{--@section('title', 'Dashboard | '.getRoleName('display_name'))--}}
@section('title', 'Dashboard')

@section('content')

    <section class="container animated fadeInRight">

    </section>

    <div class="wrapper wrapper-content">
        <div class="row">

        </div>
    </div>

@endsection


@section('styles')
    {{--{!! Html::style('') !!}--}}
    {!! Html::style('/css/template/plugins/iCheck/custom.css') !!}
    {!! Html::style('/css/template/plugins/fullcalendar/fullcalendar.css') !!}
    {!! Html::style('/css/template/plugins/fullcalendar/fullcalendar.print.css') !!}
@endsection

@section('scripts')
    {{--{!! Html::script('') !!}--}}
    {!! Html::script('/js/template/plugins/jquery-ui/jquery-ui.min.js') !!}
    {!! Html::script('/js/template/plugins/iCheck/icheck.min.js') !!}
        {!! Html::script('/js/template/plugins/fullcalendar/moment.min.js') !!}
    {!! Html::script('/js/template/plugins/fullcalendar/fullcalendar.min.js') !!}
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
