<div class="modal fade" id="verify_payment_modal" data-type="" tabindex="-1" role="dialog" aria-hidden="true"
     data-category="" data-variant="" data-bal="">
    <div id="modal-size" class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding: 15px;">
                <h3 class="modal-title">Loan Payment</h3>
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                @include('loan.payment_method_modal')
                <button class="btn btn-primary" id="verify_payment_show">Verify Payment</button>
                <div class="ibox" id="verify_payment">
                    <div class="ibox-heading">
                        <h4 class="ibox-title">Verify Payment</h4>
                    </div>
                    <form action="{{route('verify-loan')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="loan_id" id="verify_loan_id">
                        <div class="ibox-content">
                            <div class="form-group">
                                <label>Proof of Payment</label>
                                <input name="proof_of_payment" id="myFileInput" class="form-control" type="file" accept="image/*;capture=camera">
                            </div>
                            <div class="form-group">
                                <label>Mode of Payment</label>
                                <select name="payment_method" id="payment_method" class="form-control">
                                    <option value="gcash">GCash</option>
                                    <option value="bpi">BPI</option>
                                    <option value="palawan">Palawan</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="btn-group btn-group-sm float-right">
                                    <button type="button" class="btn btn-primary verify_amount_fast_btn verify_amount_fast_monthly" data-amount="">Monthly</button>
                                    <button type="button" class="btn btn-danger verify_amount_fast_btn verify_amount_fast_max" data-amount="">Max</button>
                                </div>
                                <label>Paid Amount</label>
                                <input name="paid_amount" id="verify_amount" type="text" class="form-control money" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Payment Date</label>
                                <input name="paid_date" type="text" class="form-control datepicker" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <label>Reference/Receipt No.</label>
                                <input name="reference_number" type="text" class="form-control" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-green w-100" id="verify_payment_submit">Verify</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                {{--                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>--}}
                {{--                    <button type="button" class="btn btn-primary" id="modal-save-btn">Ver</button>--}}
            </div>
        </div>
    </div>
</div>
