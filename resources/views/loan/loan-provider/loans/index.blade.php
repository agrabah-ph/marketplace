@extends(subdomain_name().'.master')

@section('title', 'Loan Applications')

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

    <div id="app" class="wrapper wrapper-content">

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    {{--                    <div class="ibox-title">--}}
                    {{--                        <h5>Blank <small>page</small></h5>--}}
                    {{--                    </div>--}}
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <div class="loan-product-list project-list">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Applicant</th>
                                        <th class="text-right">Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($loans as $loan)
                                        <tr data-id="{{ $loan->id }}">
                                            <td class="project-title">
                                                <a href="#">{{ $loan->product->name }}</a>
                                                <br/>
                                                <div class="row">
                                                    <div class="col">
                                                        <small>Provider:
                                                            <strong>{{ $loan->provider->profile->bank_name }}</strong></small>
                                                    </div>
                                                    <div class="col">
                                                        <small>Type:
                                                            <strong>{{ $loan->product->type->display_name }}</strong></small>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <small>Amount: <span
                                                                    class="money">{{ currency_format($loan->product->amount) }}</span></small>
                                                    </div>
                                                    <div class="col">
                                                        <small>Term: {{ $loan->product->duration }}mos</small>
                                                    </div>
                                                </div>
                                                <small>Interest: {{ $loan->product->interest_rate }}%</small><br/>
                                            </td>
                                            <td class="project-title">
                                                <a href="project_detail.html">{{ $loan->borrower->profile->first_name }} {{ $loan->borrower->profile->last_name }}</a>
                                                <br/>
                                                <small>{{ getRoleNameByID($loan->borrower->user_id, 'display_name') }}</small>
                                            </td>
                                            <td class="text-right">{{ $loan->status }}</td>
                                            <td class="project-actions">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-white btn-sm btn-action"
                                                            data-action="show"><i class="fa fa-search text-info"></i>
                                                        View
                                                    </button>
                                                    @if($loan->status == 'Pending')
                                                        <button type="button" class="btn btn-white btn-sm btn-action"
                                                                data-action="decline"><i
                                                                    class="fa fa-times text-danger"></i> Decline
                                                        </button>
                                                        <button type="button" class="btn btn-white btn-sm btn-action"
                                                                data-action="pre-approve"><i
                                                                    class="fa fa-thumbs-up text-success"></i> Approve
                                                        </button>
                                                    @endif
                                                    @if($loan->status == 'Active')
                                                        <button type="button"
                                                                class="btn btn-white btn-sm payment_history_modal_trigger"
                                                                data-payments="{{$loan->payments}}"
                                                        ><i class="fa fa-list"></i> Payments
                                                        </button>
                                                    @endif
                                                </div>

                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="99" class="text-center">No Application yet</td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
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
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Financial Production Name</label>
                                        <input type="text" name="name" value="Loan Product 1" class="form-control"
                                               readonly="">
                                    </div>
                                    <div class="form-group">
                                        <label>Loanable Amount</label>
                                        <input name="amount" id="amount" type="text"
                                               class="form-control money changeSchedule"
                                               value="{{currency_format(70000)}}" readonly="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label>Loan Duration (Months)</label>
                                        <input name="duration" id="duration" type="text" data-mask="0#"
                                               class="form-control changeSchedule" value="7" readonly="">
                                    </div>
                                    <div class="form-group">
                                        <label>Interest Rate (%)</label>
                                        <input name="interest_rate" id="interest_rate" type="text" data-mask="##0%"
                                               class="form-control changeSchedule" value="91" readonly="">
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Payment Schedules
                        </div>
                        <div class="panel-body">
                            <div class="schedule_inputs">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                        <tr>
                                            <td>Assuming Approved Date</td>
                                            <td class="text-right">{{now()->toFormattedDateString()}}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Loan Amount</td>
                                            <td id="total_loan_amount" class="text-right">0</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Timing</label>
                                <select name="timing" id="timing" class="form-control changeSchedule">
                                    <option value="day">Day</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="custom">Custom</option>
                                </select>
                            </div>
                            <div class="row hide_on_custom">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>Allowance</label>
                                        <input name="allowance" id="allowance" type="text" data-mask="0#" value="1"
                                               class="form-control changeSchedule">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>1st Payment Allowance</label>
                                        <input name="first_allowance" id="first_allowance" type="text" data-mask="0#"
                                               value="0" class="form-control changeSchedule">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" id="payment_schedules_input_dates">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Due Date</th>
                                    <th class="text-right">Amount</th>
                                </tr>
                                </thead>
                                <tbody id="payment_schedule_review">
                                <tr>
                                    <td colspan="99">--</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-save-btn">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    @include('loan.farmer.loans.modals.payment_history')
@endsection


@section('styles')
    {{--{!! Html::style('') !!}--}}
    {{--    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}
    {{--    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}--}}
    {!! Html::style('/css/template/plugins/datapicker/datepicker3.css') !!}
    <style>
        #payment_schedule_review .datepicker{
            border: none!important;
            outline: none!important;
        }
    </style>

@endsection

@section('scripts')
    {{--    {!! Html::script('') !!}--}}
    {{--    {!! Html::script('/js/template/plugins/jqueryMask/jquery.mask.min.js') !!}--}}
    {{--    {!! Html::script(asset('vendor/datatables/buttons.server-side.js')) !!}--}}
    {{--    {!! $dataTable->scripts() !!}--}}
    {{--    {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}--}}
    {!! Html::script('/js/template/plugins/datapicker/bootstrap-datepicker.js') !!}
    {!! Html::script('/js/template/moment.js') !!}
    <script>

        function numberWithCommas(x) {
            return x.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        $(document).on('click', '.payment_history_modal_trigger', function () {
            $('#payment_history_modal').modal('show');
            var data_payments = $(this).data('payments');

            $('#payment_history_tbody').empty();

            if (data_payments.length < 1) {
                let setRows = '<tr>';
                setRows += '<td colspan="99" class="text-center">';
                setRows += "No payments yet";
                setRows += '</td>';
                setRows += '</tr>';
                $('#payment_history_tbody').append(setRows);
            }
            for (let i = 0; i < data_payments.length; i++) {
                const dataPayment = data_payments[i];
                let setRows = '<tr>';
                setRows += '<td>';
                setRows += dataPayment.paid_date_formatted;
                setRows += '</td>';
                setRows += '<td>';
                setRows += dataPayment.payment_method;
                setRows += '</td>';
                setRows += '<td class="text-right">';
                setRows += numberWithCommas(dataPayment.paid_amount);
                setRows += '</td>';
                setRows += '<td>';
                setRows += dataPayment.reference_number;
                setRows += '</td>';
                setRows += '<td>';
                setRows += '<a target="_blank" href="' + dataPayment.proof_of_payment + '?type=view">View</a> | ';
                setRows += '<a href="' + dataPayment.proof_of_payment + '?type=download">Download</a>';
                setRows += '</td>';
                setRows += '</tr>';
                $('#payment_history_tbody').append(setRows);
            }
        });

        function populateCustomSchedule() {

            $('.datepicker').datepicker({
                startView: 1,
                // todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                autoclose: true,
                format: "M dd,yyyy",
            });
        }

        function populateSchedule() {
            var duration = $('#duration').val();
            var amount = $('#amount').val();
            var interest_rate = $('#interest_rate').val();
            var timing = $('#timing').val();
            var allowance = $('#allowance').val();
            var first_allowance = $('#first_allowance').val();

            $.get('{!! route('generate-schedule') !!}', {
                duration: duration,
                amount: amount,
                interest_rate: interest_rate,
                timing: timing,
                allowance: allowance,
                first_allowance: first_allowance,
            }, function (data) {
                var table = '';
                var total = 0;
                for (let i = 0; i < data.length; i++) {
                    const datum = data[i];
                    table += '<tr>';
                    table += '<td>';
                    table += '<input class="datepicker ps_'+(i+1)+'" name="payment_schedules_input_dates[]" value="' + datum.date + '">';
                    table += '</td>'
                    table += '<td class="text-right">';
                    table += numberWithCommas(datum.amount);
                    table += '</td>';
                    table += '</tr>';
                    total += datum.amount;
                }
                $('#total_loan_amount').html(numberWithCommas(total));
                $('#payment_schedule_review').empty().append(table);
                $('#payment_schedule_input').val(JSON.stringify(data))

            });
        }

        $(document).on('change, input', '.changeSchedule', function () {
            populateSchedule();
        });
        $(document).on('change', '#timing', function () {
            console.log(this.value)
            $('.hide_on_custom').hide();
            if(this.value == 'custom'){
                populateCustomSchedule()
            }else{
                $('.hide_on_custom').show();
                populateSchedule();
            }
        });

        $(document).ready(function () {
            var modal = $('#modal');
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
            // $('.money').mask("#,##0.00", {reverse: true});

            $(document).on('click', '#modal-save-btn', function () {
                var id = modal.data('id');
                var schedules = [];
                $.each(modal.find('.datepicker'),function(i,e){
                    schedules.push(e.value);
                });
                $.get('{!! route('loan-update-status') !!}', {
                    id: id,
                    action: 'approve',
                    amount: modal.find('#amount').val(),
                    duration: modal.find('#duration').val(),
                    interest_rate: modal.find('#interest_rate').val(),
                    timing: modal.find('#timing').val(),
                    allowance: modal.find('#allowance').val(),
                    first_allowance: modal.find('#first_allowance').val(),
                    schedules: schedules,
                }, function (data) {
                    // console.log(data)
                    location.reload();
                });
            });

            $(document).on('click', '.btn-action', function () {
                var action = $(this).data('action');
                var id = $(this).closest('tr').data('id');
                switch (action) {
                    case 'decline':
                        $.get('{!! route('loan-update-status') !!}', {
                            id: id,
                            action: action
                        }, function (data) {
                            location.reload();
                        });
                        break;
                    case 'show':
                        $.get('{!! route('loan-update-status') !!}', {
                            id: id,
                            action: action
                        }, function(data){
                            // console.log(data);
                            modal.data('type', 'show-loan-details');
                            modal.find('.modal-title').text('Loan Application Details');
                            modal.find('#modal-size').removeClass().addClass('modal-dialog modal-xl');
                            modal.find('.modal-body').empty().append(displayLoanApplicationDetails(data.borrower.profile, data.details));
                            modal.find('#modal-save-btn').hide();
                            modal.modal({backdrop: 'static', keyboard: false});
                        });
                        break;
                    case 'pre-approve':
                        var title = 'Create Payment Scheme', body = null;
                        modal.data('id', id);
                        modal.data('type', 'approve-loan');
                        modal.find('#modal-size').removeClass().addClass('modal-dialog modal-lg');
                        modal.find('.modal-title').text(title);
                        modal.find('#modal-save-btn').show();
                        modal.find('#modal-save-btn').text('Approve Loan');
                        jQuery.ajaxSetup({async: false});
                        $.get('{!! route('loan-update-status') !!}', {
                            id: id,
                            action: action
                        }, function (data) {
                            console.log(data);
                            body = '' +
                                '<div class="panel panel-default">' +
                                '<div class="panel-body">' +
                                '<div class="row">' +
                                '<div class="col-lg-6">' +
                                '<div class="form-group">' +
                                '<label>Financial Production Name</label>' +
                                '<input type="text" name="name" value="' + data.product.name + '" class="form-control" readonly="">' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label>Loanable Amount</label>' +
                                '<input name="amount" id="amount" type="text" class="form-control money changeSchedule" value="' + data.amount + '" readonly="">' +
                                '</div>' +
                                '</div>' +
                                '<div class="col-lg-6">' +
                                '<div class="form-group">' +
                                '<label>Loan Duration (Months)</label>' +
                                '<input name="duration" id="duration" type="text" data-mask="0#" class="form-control changeSchedule" value="' + data.duration + '" readonly="">' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label>Interest Rate (%)</label>' +
                                '<input name="interest_rate" id="interest_rate" type="text" data-mask="##0%" class="form-control changeSchedule"  value="' + data.interest_rate + '" readonly="">' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '<div class="panel panel-default">' +
                                '<div class="panel-heading">Payment Schedules</div>' +
                                '<div class="panel-body">' +
                                '<div class="schedule_inputs">' +
                                '<div class="table-responsive">' +
                                '<table class="table table-bordered">' +
                                '<tbody>' +
                                '<tr>' +
                                '<td>Assuming Approved Date</td>' +
                                '<td class="text-right">' + moment() + '</td>' +
                                '</tr>' +
                                '<tr>' +
                                '<td>Total Loan Amount</td>' +
                                '<td id="total_loan_amount" class="text-right">0</td>' +
                                '</tr>' +
                                '</tbody>' +
                                '</table>' +
                                '</div>' +
                                '</div>' +
                                '<div class="form-group">' +
                                '<label>Timing</label>' +
                                '<select name="timing" id="timing" class="form-control changeSchedule">' +
                                '<option value="day">Day</option>' +
                                '<option value="monthly" selected>Monthly</option>' +
                                '</select>' +
                                '</div>' +
                                '<div class="row">' +
                                '<div class="col-6">' +
                                '<div class="form-group">' +
                                '<label>Allowance</label>' +
                                '<input name="allowance" id="allowance" type="text" data-mask="0#" value="' + data.allowance + '" class="form-control changeSchedule">' +
                                '</div>' +
                                '</div>' +
                                '<div class="col-6">' +
                                '<div class="form-group">' +
                                '<label>1st Payment Allowance</label>' +
                                '<input name="first_allowance" id="first_allowance" type="text" data-mask="0#" value="' + data.first_allowance + '" class="form-control changeSchedule">' +
                                '</div>' +
                                '</div>' +
                                '</div>' +
                                '<table class="table table-bordered">' +
                                '<thead>' +
                                '<tr>' +
                                '<th>Due Date</th>' +
                                '<th class="text-right">Amount</th>' +
                                '</tr>' +
                                '</thead>' +
                                '<tbody id="payment_schedule_review">' +
                                '<tr>' +
                                '<td colspan="99">--</td>' +
                                '</tr>' +
                                '</tbody>' +
                                '</table>' +
                                '</div>' +
                                '</div>' +
                                '';
                        });

                        // modal.find('.modal-body').empty().append(body);
                        populateSchedule();
                        modal.modal({backdrop: 'static', keyboard: false});

                        break;
                }
            });

            $(document).on('change, input', '.changeSchedule', function () {
                populateSchedule();
            });

        });
    </script>
@endsection
