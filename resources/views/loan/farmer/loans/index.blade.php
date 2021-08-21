@extends(subdomain_name().'.master')

@section('title', 'My Loans')

@section('content')

    <div class="row wrapper border-bottom white-bg page-heading">
        <div class="col-sm-6">
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
        <div class="col-sm-6">
            {{--            <div class="title-action">--}}
            {{--                <a href="#" class="btn btn-primary">This is action area</a>--}}
            {{--            </div>--}}
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content">

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <div class="loan-product-list project-list">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Bank</th>
                                        <th>Loan Name</th>
                                        <th class="text-right">Amount</th>
                                        <th>Interest</th>
                                        <th>Term</th>
                                        <th class="text-right">Total Loan Amount</th>
                                        <th class="text-right">Amortization</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($loans as $loan)
                                        <tr class="d-none">
                                            <td colspan="99">
                                                <pre>{{json_encode($loan,128)}}</pre>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                {{$loan->provider->profile->bank_name}}
                                                <br/>
                                                <small>Branch:
                                                    <strong>{{ $loan->provider->profile->branch_name }}</strong></small><br/>
                                                <small>Address: <span
                                                            class="">{{ $loan->provider->profile->address_line }}</span></small><br/>
                                            </td>
                                            <td class="project-title">
                                                {{$loan->name}}
                                            </td>
                                            <td class="text-right">{{currency_format($loan->amount)}}</td>
                                            <td>{{$loan->interest_rate}}%</td>
                                            <td>{{$loan->duration}} Months</td>
                                            <td class="text-right">{{currency_format(computeAmortization($loan->amount, $loan->duration, $loan->interest_rate, 2) * $loan->duration)}}</td>

                                            <td class="text-right">{{currency_format(computeAmortization($loan->amount, $loan->duration, $loan->interest_rate, 2))}}</td>
                                            @if($loan->status == 'Active')
                                                <td class=" text-center text-green">{{$loan->status}}</td>
                                            @elseif($loan->status == 'Pending')
                                                <td class="text-center text-warning">{{$loan->status}}</td>
                                            @else
                                                <td class="text-center text-danger">{{$loan->status}}</td>
                                            @endif
                                            <td class="project-actions">
                                                <div class="btn-group">
                                                    @if($loan->status != 'Declined')
                                                    <a href="#" class="btn btn-success btn-sm sched_modal_trigger"
                                                       data-schedule="{{$loan->payment_schedules}}"><i
                                                                class="fa fa-calendar"></i> Schedules </a>
                                                    <a href="#" class="btn btn-primary btn-sm payment_modal_trigger"
                                                       data-amount_monthly="{{currency_format(computeAmortization($loan->amount, $loan->duration, $loan->interest_rate, 2))}}"
                                                       data-amount_max="{{currency_format(computeAmortization($loan->amount, $loan->duration, $loan->interest_rate, 2) * $loan->duration)}}"
                                                       data-id="{{$loan->id}}"
                                                       data-status="{{$loan->status}}"
                                                    ><i class="fa fa-money"></i> Pay </a>
                                                    <a href="#" class="btn btn-warning btn-sm payment_history_modal_trigger"
                                                       data-payments="{{$loan->payments}}"
                                                       data-status="{{$loan->status}}"
                                                    ><i class="fa fa-list"></i> Payments </a>
                                                    @endif
                                                    @if($loan->status == 'Pending')
                                                        <button type="button" class="btn btn-sm btn-danger">Cancel</button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="empty_row">
                                            <td colspan="99" class="text-center">No Loans Yet</td>
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

    <div class="modal fade" id="modal" data-type="" tabindex="-1" role="dialog" aria-hidden="true" data-category=""
         data-variant="" data-bal="">
        <div id="modal-size">
            <div class="modal-content">
                <div class="modal-header" style="padding: 15px;">
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
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
    @include('loan.farmer.loans.modals.payment_schedules')
    @include('loan.farmer.loans.modals.payment_verification')
    @include('loan.farmer.loans.modals.payment_history')

@endsection


@section('styles')
    {{--{!! Html::style('') !!}--}}
    {{--    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}
    {{--    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}--}}
    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}
    {!! Html::style('/css/template/plugins/datapicker/datepicker3.css') !!}

    <style>
        #verify_payment{
            display: none;
        }
    </style>
@endsection

@section('scripts')
    {{--    {!! Html::script('') !!}--}}
    {!! Html::script('/js/template/plugins/jqueryMask/jquery.mask.min.js') !!}
    {!! Html::script('/js/template/moment.js') !!}
    {!! Html::script('/js/template/numeral.js') !!}
    {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}
    {!! Html::script('/js/template/plugins/jqueryMask/jquery.mask.min.js') !!}
    {!! Html::script('/js/template/plugins/datapicker/bootstrap-datepicker.js') !!}


    {{--    {!! Html::script(asset('vendor/datatables/buttons.server-side.js')) !!}--}}
    {{--    {!! $dataTable->scripts() !!}--}}
    {{--    {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}--}}
    {{--    {!! Html::script('/js/template/moment.js') !!}--}}
    <script>

        function numberWithCommas(x) {
            return x.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        $(document).on('click', '.payment_history_modal_trigger', function () {
            $('#payment_history_modal').modal('show');
            var data_payments = $(this).data('payments');
            var data_status = $(this).data('status');

            $('#payment_history_tbody').empty();

            let setRows = '<tr>';
            setRows += '<td colspan="99" class="text-center">';
            setRows += "Loan Not Approved yet";
            setRows += '</td>';
            setRows += '</tr>';
            $('#payment_history_tbody').append(setRows);

            if (data_status == 'Active' || data_status == 'Completed') {
                if(data_payments.length > 0){
                    $('#payment_history_tbody').empty();
                    for (let i = 0; i < data_payments.length; i++) {
                        const dataPayment = data_payments[i];
                        console.log(dataPayment)
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
                        setRows += '<a target="_blank" href="'+dataPayment.proof_of_payment+'?type=view">View</a> | ';
                        setRows += '<a href="'+dataPayment.proof_of_payment+'?type=download">Download</a>';
                        setRows += '</td>';
                        setRows += '</tr>';
                        $('#payment_history_tbody').append(setRows);
                    }
                }
            }
        });

        $(document).on('click', '.payment_modal_trigger', function () {
            verifyDisbursement($(this).data('id'), $('#verify_payment_modal'), $(this).data('amount_monthly'), $(this).data('amount_max'), $(this).data('status'));


            // var data_id = $(this).data('id');
            // var verify_payment_modal = $('#verify_payment_modal');
            // verify_payment_modal.modal('show');
            // var data_monthly = $(this).data('amount_monthly');
            // var data_max = $(this).data('amount_max');
            // var data_status = $(this).data('status');
            // $('#verify_payment_show').hide();
            // if(data_status == 'Active'){
            //     $('#verify_payment_show').show();
            // }
            // $('.verify_amount_fast_monthly').attr('data-amount', data_monthly);
            // $('.verify_amount_fast_max').attr('data-amount', data_max);
            // $('#verify_loan_id').val(data_id);


        });

        $(document).on('click', '#verify_payment_show', function () {
            $('#verify_payment').show();
            $(this).hide();

        });

        $(document).on('click', '.verify_amount_fast_btn', function () {
            var data_amount = $(this).data('amount');
             $('#verify_amount').val(data_amount);
        });

        $(document).on('click', '.sched_modal_trigger', function () {
            var sched_modal = $('#sched_modal');
            sched_modal.modal('show');
            $('#schedules_tbody').empty();
            var data_schedules = $(this).data('schedule')

            if (data_schedules.length < 1) {
                let setRows = '<tr>';
                setRows += '<td colspan="99" class="text-center">';
                setRows += "Loan Not Approved yet";
                setRows += '</td>';
                setRows += '</tr>';
                $('#schedules_tbody').append(setRows);
            }
            for (let i = 0; i < data_schedules.length; i++) {
                const dataSchedule = data_schedules[i];

                let setRows = '<tr>';
                setRows += '<td>';
                setRows += dataSchedule.due_date_display;
                setRows += '</td>';
                setRows += '<td class="text-right">';
                setRows += numberWithCommas(dataSchedule.payable_amount);
                setRows += '</td>';
                setRows += '<td class="text-right">';
                if(dataSchedule.paid_amount > 0){
                    setRows += numberWithCommas(dataSchedule.paid_amount);
                }
                setRows += '</td>';
                setRows += '<td>';
                setRows += dataSchedule.status_display;
                setRows += '</td>';
                setRows += '</tr>';
                $('#schedules_tbody').append(setRows);
            }
        });

        $(document).ready(function () {


            var mem = $('.datepicker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: 'yyyy-mm-dd',
                placement: 'bottom'
            });


            var myInput = document.getElementById('myFileInput');

            function sendPic() {
                var file = myInput.files[0];

                // Send file here either by adding it to a `FormData` object
                // and sending that via XHR, or by simply passing the file into
                // the `send` method of an XHR instance.
            }

            myInput.addEventListener('change', sendPic, false);

            $('.money').mask("#,##0.00", {reverse: true});

            var verify_payment_modal = $('#verify_payment_modal');
            verify_payment_modal.on('hidden.bs.modal', function () {
                $('#verify_payment').hide();
                $('#verify_payment_show').show();
            });
            // var modal = $('#modal');
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

        function verifyDisbursement(loanID, verify_payment_modal, data_monthly, data_max, data_status){
            $.get('{!! route('verify-disbursement') !!}', {
                id: loanID,
                type: 'check'
            }, function(data){
                console.log('data: '+ data);

                if( (data > 0) && (data_status === 'Active') ){
                    swal({
                        title: "Verify Loan Disbursement!",
                        text: "Please verify if received to continue in payments!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#5563dd",
                        confirmButtonText: "Loan Received!",
                        closeOnConfirm: true
                    },function (isConfirm) {
                        if (isConfirm) {
                            updateDisbursement(loanID, verify_payment_modal, data_monthly, data_max, data_status);
                        }
                    });
                }else{
                    verify_payment_modal.modal('show');
                    $('#verify_payment_show').hide();
                    if(data_status === 'Active'){
                        $('#verify_payment_show').show();
                    }
                    $('.verify_amount_fast_monthly').attr('data-amount', data_monthly);
                    $('.verify_amount_fast_max').attr('data-amount', data_max);
                    $('#verify_loan_id').val(loanID);
                }
            });
        }

        function updateDisbursement(loanID, verify_payment_modal, data_monthly, data_max, data_status){
            $.get('{!! route('verify-disbursement') !!}', {
                id: loanID,
                type: 'update'
            }, function(){
                swal({
                    title: "Success!",
                    text: "Loan disbursement verified.",
                    type: "success",
                    confirmButtonColor: "#5563dd",
                    confirmButtonText: "ok!",
                    closeOnConfirm: true
                },function (isConfirm) {
                    if (isConfirm) {
                        verifyDisbursement(loanID, verify_payment_modal, data_monthly, data_max, data_status);
                    }
                });

                // swal("Success", "Loan disbursement verified.", "success");
            });
        }

    </script>
@endsection
