@extends('admin.master')

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
                                                        <small>Provider: <strong>{{ $loan->provider->profile->bank_name }}</strong></small>
                                                    </div>
                                                    <div class="col">
                                                        <small>Type: <strong>{{ $loan->product->type->display_name }}</strong></small>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <small>Amount: <span class="money">{{ currency_format($loan->product->amount) }}</span></small>
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
                                                    <button type="button" class="btn btn-white btn-sm btn-action" data-action="show"><i class="fa fa-search text-info"></i> View </button>
                                                @if($loan->accept == 0)
                                                    <button type="button" class="btn btn-white btn-sm btn-action" data-action="decline"><i class="fa fa-times text-danger"></i> Decline </button>
                                                    <button type="button" class="btn btn-white btn-sm btn-action" data-action="accept"><i class="fa fa-thumbs-up text-success"></i> Accept </button>
                                                @endif
                                                @if($loan->status == 'Active')
                                                    <button type="button" class="btn btn-white btn-sm payment_history_modal_trigger"
                                                            data-payments="{{$loan->payments}}"
                                                    ><i class="fa fa-list"></i> Payments </button>
                                                @endif
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

    <div class="modal inmodal fade" id="modal" data-type="" tabindex="-1" role="dialog" aria-hidden="true" data-category="" data-variant="" data-bal="">
        <div id="modal-size">
            <div class="modal-content">
                <div class="modal-header" style="padding: 15px;">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                    <img src="" class="img-fluid" alt="">
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
@endsection

@section('scripts')
    {{--    {!! Html::script('') !!}--}}
{{--    {!! Html::script('/js/template/plugins/jqueryMask/jquery.mask.min.js') !!}--}}
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
                setRows += '<a target="_blank" href="'+dataPayment.proof_of_payment+'?type=view">View</a> | ';
                setRows += '<a href="'+dataPayment.proof_of_payment+'?type=download">Download</a>';
                setRows += '</td>';
                setRows += '</tr>';
                $('#payment_history_tbody').append(setRows);
            }
        });

        $(document).ready(function(){
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

            $(document).on('click', '.btn-action', function(){
                var action = $(this).data('action');
                var id = $(this).closest('tr').data('id');
                switch(action){
                    case 'decline':
                        $.get('{!! route('loan-update-status') !!}', {
                            id: id,
                            action: action
                        }, function(data){
                            location.reload();
                        });
                        break;
                    case 'accept':
                        $.get('{!! route('loan-update-status') !!}', {
                            id: id,
                            action: action
                        }, function(data){
                            location.reload();
                        });
                        break;
                    case 'show':
                        $.get('{!! route('loan-update-status') !!}', {
                            id: id,
                            action: action
                        }, function(data){
                            console.log(data);
                            modal.data('type', 'show-loan-details');
                            modal.find('.modal-title').text('Loan Application Details');
                            modal.find('#modal-size').removeClass().addClass('modal-dialog modal-xl');
                            modal.find('.modal-body').empty().append(displayLoanApplicationDetails(data.borrower.profile, data.details));
                            modal.find('#modal-save-btn').hide();
                            modal.modal({backdrop: 'static', keyboard: false});
                        });
                        break;
                }
            });

        });
    </script>
@endsection
