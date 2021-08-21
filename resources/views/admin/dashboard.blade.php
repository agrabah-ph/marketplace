@extends('admin.master')

{{--@section('title', 'Dashboard | '.getRoleName('display_name'))--}}
@section('title', 'Dashboard')

@section('content')
    <div class="wrapper wrapper-content">
        <div class="row">
            <div class="col-lg-3">
                <a href="{{ route('farmer.index') }}">
                    <div class="widget style1 navy-bg">
                        <div class="row">
                            <div class="col-4">
                                <i class="fa fa-users fa-5x"></i>
                            </div>
                            <div class="col-8 text-right">
                                <span> Farmers </span>
                                <h2 class="font-bold">{{ $farmer }}</h2>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3">
                <a href="{{ route('inventory.index') }}">
                    <div class="widget style1 lazur-bg">
                        <div class="row">
                            <div class="col-4">
                                <i class="fa fa-th-list fa-5x"></i>
                            </div>
                            <div class="col-8 text-right">
                                <span> Inventories </span>
                                <h2 class="font-bold">{{ $inventory }}</h2>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3">
                <a href="{{ route('trace.index') }}">
                    <div class="widget style1 yellow-bg">
                        <div class="row">
                            <div class="col-4">
                                <i class="fa fa-truck fa-5x"></i>
                            </div>
                            <div class="col-8 text-right">
                                <span> Trace </span>
                                <h2 class="font-bold">{{ $trace }}</h2>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12 d-none d-sm-block">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5><strong>TRACE</strong> Reports</h5>
                        <div class="ibox-tools">
                            <div class="btn-group">
                                <button type="button" data-action="weekly" class="btn btn-xs btn-white btn-action active">Weekly</button>
                                <button type="button" data-action="monthly" class="btn btn-xs btn-white btn-action">Monthly</button>
                                <button type="button" data-action="annual" class="btn btn-xs btn-white btn-action">Annual</button>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="m-t-sm">
                            <div class="row">
                                <div class="col-md-9">
                                    <div>
                                        <canvas id="lineChart" height="114"></canvas>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <ul class="stat-list m-t-lg">
                                        <li>
                                            <h2 class="no-margins total">0</h2>
                                            <small>Total deliveries</small>
                                        </li>
                                        <li>
                                            <h2 class="no-margins delivered">0</h2>
                                            <small>Delivered</small>
                                        </li>
                                        <li>
                                            <h2 class="no-margins failed">0</h2>
                                            <small>Failed</small>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <div class="ibox-tools">
                            <div class="btn-group table-report-btn">
                                <button type="button" data-action="day" class="btn btn-xs btn-white btn-action active">Day</button>
                                <button type="button" data-action="week" class="btn btn-xs btn-white btn-action">Week</button>
                                <button type="button" data-action="month" class="btn btn-xs btn-white btn-action">Month</button>
                                <button type="button" data-action="range" class="btn btn-xs btn-white btn-action">Range</button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-xs btn-info btn-print text-white"> <i class="fa fa-print text-white"></i> Print</button>
                            </div>
                        </div>
                    </div>
                    <div class="ibox-content" id="trace-table">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3><strong>TRACE REPORT: </strong> <span id="span-length" class="text-success"></span></h3>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group float-right" id="data_5">

                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Reference </th>
                                    <th>Client </th>
                                    <th>Status </th>
                                    <th class="text-right">Inventory Cost </th>
                                </tr>
                                </thead>
                                <tbody id="tbody"></tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="5" align="right" id="total-cost">Total: 00.00</td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div>


        {{ Form::open(array('route' => 'print-report', 'class' => 'sr-only', 'id' => 'form-print', 'target' => '_blank')) }}
            @csrf
            {{ Form::hidden('datas', null) }}
        {{ Form::close() }}


    </div>

@endsection


@section('styles')
    {{--{!! Html::style('') !!}--}}
{{--    {!! Html::style('/css/template/plugins/morris/morris-0.4.3.min.css') !!}--}}
    {!! Html::style('/css/template/plugins/datapicker/datepicker3.css') !!}
    {!! Html::style('/css/template/plugins/daterangepicker/daterangepicker-bs3.css') !!}
@endsection

@section('scripts')
    {{--{!! Html::script('') !!}--}}
{{--    {!! Html::script('/js/template/plugins/peity/jquery.peity.min.js') !!}--}}

    <!-- Flot -->
    {!! Html::script('/js/template/plugins/flot/jquery.flot.js') !!}
    {!! Html::script('/js/template/plugins/flot/jquery.flot.tooltip.min.js') !!}
    {!! Html::script('/js/template/plugins/flot/jquery.flot.resize.js') !!}

    <!-- ChartJS-->
    {!! Html::script('/js/template/plugins/chartJs/Chart.min.js') !!}

    <!-- Date range picker -->
    {!! Html::script('/js/template/plugins/datapicker/bootstrap-datepicker.js') !!}
    {!! Html::script('/js/template/plugins/daterangepicker/daterangepicker.js') !!}
    {!! Html::script('/js/template/moment.js') !!}
    {!! Html::script('/js/template/numeral.js') !!}

    <script>
        $(document).ready(function() {

            $(document).on('click', '.btn-action', function(){
                $('.btn-action').removeClass('active');
                $(this).addClass('active');
                var action = $(this).data('action');
                switch(action) {
                    case 'day':
                        $('#data_5').empty();
                        loadTable('day');
                        break;
                    case 'week':
                        $('#data_5').empty();
                        loadTable('week');
                        break;
                    case 'month':
                        $('#data_5').empty();
                        loadTable('month');
                        break;
                    case 'range':
                        $('#data_5').empty().append('' +
                            '<div class="input-daterange input-group" id="datepicker">' +
                            '<input type="text" class="form-control-sm form-control range-input" name="start" value="'+ moment().format('M/DD/YYYY') +'"/>' +
                            '<span class="input-group-addon p-1"> &nbsp; to &nbsp; </span>' +
                            '<input type="text" class="form-control-sm form-control range-input" name="end" value="'+ moment().add(7, 'days').format('M/DD/YYYY') +'" />' +
                            '</div>' +
                        '');
                        $('#data_5 .input-daterange').datepicker({
                            keyboardNavigation: false,
                            forceParse: false,
                            autoclose: true
                        });
                        loadTable('range', $('input[name=start]').val(), $('input[name=end]').val());
                        break;
                    default:
                        loadChart(action);
                        break;
                }

            });

            $(document).on('click', '.btn-print', function(){
                var action = $('.table-report-btn').find('.btn-action.active').data('action'),
                    datas = new Array(),
                    form = $('#form-print');

                datas.push(action);
                if(action === 'range'){
                    var datepicker = $('#datepicker');
                    datas.push(datepicker.find('input[name=start]').val());
                    datas.push(datepicker.find('input[name=end]').val());
                }else{
                    datas.push(null);
                    datas.push(null);
                }
                console.log(datas);

                form.find('input[name=datas]').val(datas);
                form.submit();
            });

            $(document).on('change', '.range-input', function(){
                loadTable('range', $('input[name=start]').val(), $('input[name=end]').val());
            });

            loadTable('day');
            function loadTable(action, start, end){
                console.log('action: '+ action);
                var list = new Array(), total = 0;
                jQuery.ajaxSetup({async:false});
                $.get('{!! route('trace-table-report') !!}', {
                    length: action,
                    start: start,
                    end: end
                }, function(data){
                    console.log(data);
                    $('#span-length').text(data[1] + ' to '+ data[2]);
                    for(var a = 0; a < data[0].length; a++){
                        var cost = 0;
                        for(var b = 0; b < data[0][a].inventories.length; b++){
                            cost += parseFloat(data[0][a].inventories[b].total);
                        }
                        list.push('' +
                            '<tr>' +
                            '<td>'+ moment(data[0][a].created_at).format('M/DD/YYYY') +'</td>' +
                            '<td>'+ data[0][a].reference +'</td>' +
                            '<td>'+ data[0][a].receiver.value_0 +'</td>' +
                            '<td>'+ data[0][a].status +'</td>' +
                            '<td class="text-right">'+ numeral(cost).format('0,0.00') +'</td>' +
                            '</tr>' +
                        '');
                        total += cost;
                    }
                });

                $('#tbody').empty().append(list.join(''));
                $('#total-cost').text('Total: ' + numeral(total).format('0,0.00'));
            }

            loadChart('weekly');
            function loadChart(action){
                // console.log(action);
                var dataLength = null;
                var dataTotal = null;
                var dataSuccess = null;
                var dataFailed = null;
                jQuery.ajaxSetup({async:false});
                $.get('{!! route('trace-report') !!}', {
                    length: action
                }, function(data){
                    // console.log(data);
                    (data[1] === null) ? 0 : $('.stat-list').find('.total').text(data[1].reduce((a, b) => a + b, 0));
                    (data[2] === null) ? 0 : $('.stat-list').find('.delivered').text(data[2].reduce((a, b) => a + b, 0));
                    (data[3] === null) ? 0 : $('.stat-list').find('.failed').text(data[3].reduce((a, b) => a + b, 0));
                    dataLength = data[0];
                    dataTotal = data[1];
                    dataSuccess = data[2];
                    dataFailed = data[3];
                });

                // console.log(dataLength);
                var lineData = {
                    labels: dataLength,
                    datasets: [
                        {
                            label: "Total Deliveries",
                            backgroundColor: "rgba(220,220,220,0.5)",
                            borderColor: "rgba(220,220,220,1)",
                            pointBackgroundColor: "rgba(220,220,220,1)",
                            pointBorderColor: "#fff",
                            data: dataTotal
                        },
                        {
                            label: "Delivery Success",
                            backgroundColor: "rgba(26,179,148,0.5)",
                            borderColor: "rgba(26,179,148,0.7)",
                            pointBackgroundColor: "rgba(26,179,148,1)",
                            pointBorderColor: "#fff",
                            data: dataSuccess
                        },
                        {
                            label: "Delivery Failed",
                            backgroundColor: "rgba(220,0,0,0.5)",
                            borderColor: "rgb(220,63,74)",
                            pointBackgroundColor: "rgb(220,118,118)",
                            pointBorderColor: "#fff",
                            data: dataFailed
                        }
                    ]
                };

                var lineOptions = {
                    responsive: true
                };

                var ctx = document.getElementById("lineChart").getContext("2d");
                new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});

            }

        });
    </script>
@endsection
