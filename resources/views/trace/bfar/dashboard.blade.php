@extends('trace.master')

{{--@section('title', 'Dashboard | '.getRoleName('display_name'))--}}
@section('title', 'Dashboard')

@section('content')


    <div id="app" class="wrapper wrapper-content">

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form>
                            <div class="row">
                                <div class="col-sm-3 col-md-6 col-lg-3">
                                    <div class="form-group">
                                        <label for="">Date of Travel</label>
                                        <div class="input-daterange input-group" id="datepicker">
                                            <input type="text" class="form-control-sm form-control" name="start" autocomplete="off" value="{{$start}}"/>
                                            <span class="input-group-addon">to</span>
                                            <input type="text" class="form-control-sm form-control" name="end" autocomplete="off" value="{{$end}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-6 col-lg-4">
                                    <div class="form-group">
                                        <div class="mt-4 pt-2">
                                            <button class="btn btn-primary" name="mode" value="generate">Generate</button>
                                            <button class="btn btn-primary" name="mode" value="download">Download</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                                <thead>
                                <tr>
                                    <th>Starting point of travel</th>
                                    <th>Product</th>
                                    <th>Destination</th>
                                    <th>Community Leader</th>
                                    <th>Date of Travel</th>
                                    <th>Type of Vehicle</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($datas as $data)
                                    <tr>
                                        <td>{{$data->from}}</td>
                                        <td>{{$data->product}} - {{$data->quantity}}{{$data->unit_of_measure}}</td>
                                        <td>{{$data->destination}}</td>
                                        <td>{{$data->community_leader->name}}</td>
                                        <td>{{$data->date_of_travel}}</td>
                                        <td>{{$data->type_of_vehicle}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5">
                                        <ul class="pagination pull-right"></ul>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('styles')
    {{--{!! Html::style('') !!}--}}
    {!! Html::style('https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css') !!}
    {!! Html::style('/css/template/plugins/iCheck/custom.css') !!}
    {!! Html::style('/css/template/plugins/steps/jquery.steps.css') !!}
    {!! Html::style('/css/template/plugins/datapicker/datepicker3.css') !!}
    {!! Html::style('/css/template/plugins/daterangepicker/daterangepicker-bs3.css') !!}
    <style>
        .page-register.page-farmers .sign-in .right .steps ul li {
            width: calc(100%/2);
        }
        #datepicker input,
        #datepicker .input-group-addon{
            height: 38px;
            line-height: 28px;
        }
        .pagination{
            justify-content: flex-end;
        }
    </style>
@endsection

@section('scripts')
    {{--{!! Html::script('') !!}--}}
    {!! Html::script('https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.js') !!}
    {!! Html::script('/js/template/plugins/iCheck/icheck.min.js') !!}
    {!! Html::script('/js/template/plugins/steps/jquery.steps.min.js') !!}
    {!! Html::script('/js/template/plugins/validate/jquery.validate.min.js') !!}
    {!! Html::script('/js/template/plugins/slimscroll/jquery.slimscroll.min.js') !!}
    {!! Html::script('/js/template/plugins/datapicker/bootstrap-datepicker.js') !!}
    {!! Html::script('/js/template/plugins/daterangepicker/daterangepicker.js') !!}
    {!! Html::script('/js/template/plugins/dataTables/datatables.min.js') !!}
    {!! Html::script('/js/template/moment.js') !!}
    {!! Html::script('/js/template/numeral.js') !!}
    {!! Html::script('/js/template/numeral.js') !!}


    <script>
        $(document).ready(function(){

            $('.datatables').DataTable({
                pageLength: 25,
                responsive: true,
                "order": [[ 0, "desc" ]]
            });

            $('.input-daterange').datepicker({
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: 'yyyy-mm-dd',
            });
        });
    </script>
@endsection
