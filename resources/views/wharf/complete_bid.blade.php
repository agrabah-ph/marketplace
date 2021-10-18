<div class="modal inmodal fade" id="completed_bid_modal" data-type="" tabindex="-1" role="dialog" aria-hidden="true" data-category="" data-variant="" data-bal="">
    <div id="modal-size" class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="padding: 15px;">
                <button type="button" class="close" data-dismiss="modal"><span
                            aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title">Complete Bid</h4>
            </div>
            <div class="modal-body">
                <form id="completed_bid_form" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="ibox-content">
                        <input type="hidden" name="method" value="transport">
                        <input type="hidden" name="id" id="complete_bid_transport_id">
                        <input type="hidden" name="product" id="complete_bid_transport_product">
                        <input type="hidden" name="quantity" id="complete_bid_transport_quantity">
                        <input type="hidden" name="unit_of_measure" id="complete_bid_transport_unit_of_measure">
                        <div class="form-group">
                            <label>Starting Point of Travel</label>
                            <input name="from" type="text" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Destination</label>
                            <input name="destination" type="text" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Date of Travel</label>
                            <input name="date_of_travel" type="text" class="form-control complete_bid_dates" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Type of vehicle</label>
                            <input name="type_of_vehicle" type="text" class="form-control" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-green w-100" id="complete_bid_submit">Complete
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>