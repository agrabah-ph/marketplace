<!DOCTYPE html>
<html>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.9.4/invoice_print.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 20 May 2021 14:16:50 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ subdomain_title(null) }}</title>

{{--    {!! Html::style('/css/app.css') !!}--}}
    {!! Html::style('/css/template/bootstrap.min.css') !!}
    {!! Html::style('/css/styles.css') !!}
    {!! Html::style('/font-awesome/css/font-awesome.css') !!}
    {!! Html::style('/css/template/animate.css') !!}
    {!! Html::style('/css/template/style.css') !!}

</head>

<body class="white-bg">
<div class="wrapper wrapper-content p-xl" data-type="{{ $datas[0] }}" data-start="{{ $datas[1] }}" data-end="{{ $datas[2] }}">
    <div class="ibox-content p-xl" id="trace-table">
        <div class="row">
            <div class="col-sm-6">
                <h3><strong>TRACE REPORT: </strong> <span id="span-length" class="text-success"></span></h3>
            </div>
            <div class="col-sm-6">
                <div class="form-group float-right">
                    <img src="{{ URL::to('/images/logo-colored.png') }}" alt="agrabah-logo" width="250">
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

<!-- Mainly scripts -->
{{--{!! Html::script('/js/app.js') !!}--}}
{!! Html::script('/js/template/jquery-3.1.1.min.js') !!}
{!! Html::script('/js/template/popper.min.js') !!}
{!! Html::script('/js/template/bootstrap.js') !!}
{!! Html::script('/js/template/plugins/metisMenu/jquery.metisMenu.js') !!}
{!! Html::script('/js/template/plugins/slimscroll/jquery.slimscroll.min.js') !!}

<!-- Custom and plugin javascript -->
{!! Html::script('/js/template/inspinia.js') !!}
{!! Html::script('/js/template/moment.js') !!}
{!! Html::script('/js/template/numeral.js') !!}

<script>

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

        {{--var datas = new Array(), wrap = $('.wrapper');--}}
        {{--datas.push(wrap.data('type'));--}}
        {{--datas.push(wrap.data('start'));--}}
        {{--datas.push(wrap.data('end'));--}}
        {{--$.post('{!! route('print-report-data') !!}', {--}}
        {{--    _token: '{!! csrf_token() !!}',--}}
        {{--    datas: datas--}}
        {{--}, function(data){--}}
        {{--    console.log(data);--}}
        {{--    // window.print();--}}
        {{--});--}}

        loadTable();

        function loadTable(){
            // console.log('action: '+ action);
            var list = new Array(), total = 0, wrap = $('.wrapper'), start = null, end = null;

            jQuery.ajaxSetup({async:false});
            $.get('{!! route('trace-table-report') !!}', {
                length: wrap.data('type'),
                start: wrap.data('start'),
                end: wrap.data('end')
            }, function(data){
                start = data[1];
                end = data[2];
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

            $('#trace-table').empty().append('' +
                '<div class="row">' +
                    '<div class="col-sm-6">' +
                        '<h3><strong>TRACE REPORT: </strong> <span id="span-length" class="text-success">'+ start +' to '+ end +'</span></h3>' +
                    '</div>' +
                    '<div class="col-sm-6">' +
                        '<div class="form-group float-right" id="data_5">' +
                            '<img src="{!! URL::to('/images/logo-colored.png') !!}" alt="agrabah-logo" width="250">' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="table-responsive">' +
                    '<table class="table table-striped">' +
                        '<thead>' +
                            '<tr>' +
                                '<th>Date</th>' +
                                '<th>Reference </th>' +
                                '<th>Client </th>' +
                                '<th>Status </th>' +
                                '<th class="text-right">Inventory Cost </th>' +
                            '</tr>' +
                        '</thead>' +
                        '<tbody>'+ list.join('') +'</tbody>' +
                        '<tfoot>' +
                            '<tr>' +
                                '<td colspan="5" align="right" id="total-cost">Total: '+ numeral(total).format('0,0.00') +'</td>' +
                            '</tr>' +
                        '</tfoot>' +
                    '</table>' +
                '</div>' +
            '');


            window.print();
        }

    });

</script>

</body>


<!-- Mirrored from webapplayers.com/inspinia_admin-v2.9.4/invoice_print.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 20 May 2021 14:16:50 GMT -->
</html>
