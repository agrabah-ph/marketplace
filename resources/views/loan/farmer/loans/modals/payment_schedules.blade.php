
<div class="modal fade" id="sched_modal" data-type="" tabindex="-1" role="dialog" aria-hidden="true"
     data-category="" data-variant="" data-bal="">
    <div id="modal-size" class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding: 15px;">
                <h3 class="modal-title">Payment Schedules</h3>
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <button type="button" class="btn btn-sm btn-white mb-2 print_trigger" data-print_target=".paymentSchedules"><i class="fa fa-print"></i></button>
                <table class="table table-bordered paymentSchedules">
                    <thead>
                    <tr>
                        <th>Due Date</th>
                        <th class="text-right">Amount</th>
                        <th class="text-right">Paid Amount</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody id="schedules_tbody">

                    </tbody>

                </table>
            </div>
            <div class="modal-footer">
                {{--                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>--}}
                {{--                    <button type="button" class="btn btn-primary" id="modal-save-btn">Save changes</button>--}}
            </div>
        </div>
    </div>
</div>