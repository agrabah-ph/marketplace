@extends(subdomain_name().'.master')

@section('title', 'Loan Products')

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

        <div class="ibox-content m-b-sm border-bottom">
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="col-form-label" for="status">Loan Type</label>
                        <select name="type" class="form-control loan_input">
                            <option value="" selected>Select type</option>
                            @foreach($loanTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->display_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <span id="term_value" class="float-right mt-2"></span>
                        <label class="col-form-label" for="product_name">Loan Term</label>
                        <div id="term_slider"></div>
                        {{--                        <input type="range" name="term" min="4" max="60" value="4" placeholder="How many months?" class="form-control loan_input">--}}
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <span id="amount_value" class="float-right mt-2"></span>
                        <label class="col-form-label" for="price">Loanable Amount</label>
                        <div id="amount_slider"></div>
                        {{--                        <input type="range" name="amount"  value="" placeholder="Enter Amount" class="form-control money loan_input">--}}
                    </div>
                </div>
            </div>

        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">

                        <div class="table-responsive">
                            <div class="loan-product-list project-list">
                                <table class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>Loan Product Name</th>
                                        <th>Lending Partner</th>
                                        <th>Interest</th>
                                        <th>Term</th>
                                        <th class="text-right">Max Loan Amount</th>
                                        <th class="text-right">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td class="project-title">
                                            <a href="project_detail.html">Contract with Zender Company</a>
                                            <br/>
                                            <small>Created 14.08.2014</small>
                                        </td>
                                        <td>Interest</td>
                                        <td>Terms</td>
                                        <td>Amount</td>
                                        <td class="project-actions">
                                            <a href="#" class="btn btn-white btn-sm"><i class="fa fa-folder"></i> View
                                            </a>
                                            <a href="#" class="btn btn-white btn-sm"><i class="fa fa-pencil"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
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

                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="row">
                                <div class="col form-group">
                                    <label class="i-checks"> <input type="radio" name="account_type" value="GCash" checked> GCash </label>
                                </div>
                                <div class="col form-group">
                                    <label class="i-checks"> <input type="radio" name="account_type" value="Konect2"> Konect2 </label>
                                </div>
                                <div class="col form-group">
                                    <label class="i-checks"> <input type="radio" name="account_type" value="Sulit Padala"> Sulit Padala </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Account Name</label>
                                        <input type="text" name="account_name" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Account Number</label>
                                        <input type="text" name="account_number" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <h3>Reference ID's</h3>
                            <div class="row info-loan-detail" data-title="Reference ID's">
                                <div class="col">
                                    <div class="form-group">
                                        <label>ID #1 <span class="text-danger">*</span></label>
                                        <input type="file" name="reference_id_a" class="form-control required" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>ID #2 <span class="text-danger">*</span></label>
                                        <input type="file" name="reference_id_b" class="form-control required" required>
                                    </div>
                                </div>
                            </div>
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


    <div class="modal fade" id="application_modal" data-type="" tabindex="-1" role="dialog" aria-hidden="true"
         data-category="" data-variant="" data-bal="">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{route('loan-submit-form')}}" method="post">
                <input type="hidden" name="id" id="loan_submit_id">
                @csrf
                <div class="modal-header" style="padding: 15px;">
                    <h4 class="modal-title">Loan Application Form</h4>
                    <button type="button" class="close" data-dismiss="modal"><span
                                aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                </div>
                <div class="modal-body">
                    <pre class="d-none">{{json_encode($farmer, 128)}}</pre>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>First name</label>
                                {{ Form::text('first_name', $farmer->profile->first_name, array('class'=>'form-control')) }}
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Middle name</label>
                                {{ Form::text('middle_name', $farmer->profile->middle_name, array('class'=>'form-control')) }}
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Last name</label>
                                {{ Form::text('last_name', $farmer->profile->last_name, array('class'=>'form-control')) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Date of Birth</label>
                                {{ Form::text('dob', $farmer->profile->dob, array('class'=>'form-control datepicker')) }}
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Place of Birth</label>
                                {{ Form::text('pob', $farmer->profile->pob, array('class'=>'form-control')) }}
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Gender</label>
                                {{ Form::select('gender',  ['M'=>'Male','F'=>'Female'], $farmer->profile->gender, array('class'=>'form-control')) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Civil Status</label>
                                {{ Form::select('civil_status',  ['single'=>'Single','married'=>'Married','separated'=>'Separated','annulled_divorced'=>'Annulled/Divorced','widower'=>'Window/er'], $farmer->profile->civil_status, array('class'=>'form-control')) }}
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Citizenship</label>
                                {{ Form::text('citizenship', $farmer->profile->citizenship, array('class'=>'form-control')) }}
                            </div>
                        </div>
                        <div class="col">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Address</label>
                                {{ Form::textarea('address', $farmer->profile->address, array('class'=>'form-control','rows'=>3,'style'=>'resize:none')) }}
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Mobile</label>
                                {{ Form::text('mobile', $farmer->profile->mobile, array('class'=>'form-control')) }}
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Email</label>
                                {{ Form::text('email', $farmer->user->email, array('class'=>'form-control','disabled')) }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label>Gross Monthly Income</label>
                                {{ Form::text('gross_monthly_income', $farmer->profile->gross_monthly_income, array('class'=>'form-control ')) }}
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label>Estimate Monthly Expenses</label>
                                {{ Form::text('monthly_expenses', $farmer->profile->monthly_expenses, array('class'=>'form-control ')) }}
                            </div>
                        </div>
                        <div class="col">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="bg-muted p-4">
                                <strong>Naiintindihan ng humihiram na eto ay market testing sa pakikipag ugnayan ng Agrabah at CARD BDSFI na kung saan:</strong>
                                <br>
                                <br>
                                <p>1. Eto ay pilot testing/market testing na kung saan maaring one time lang ang pag hiram at ang mga susunod na pag hiram ay sa CARD BANK or ibang insitutition na ng CARD MRI pwedeng gawin</p>
                                <p>2. Ang hinihiram ay babayaran sa loob ng tatlong (3) buwan na may voluntary contribution na 2.5% ng prinsipal kada buwan, Kaugnay nito kung may pambayad na ang humihiram bago sumapit ang ikatlong buwan, maari nila itong bayaran ng buo or "partial"</p>

                                <p>3. Pumapayag at naiintindihan ng humihiram na ang disbursement at collection ay via Konect2 CARD, CARD Sulit Padala or GCASH. Ang ACCOUNT Number ng CARD BDSFI na kung saan maari itong bayaran ay ibibigay sa humhiram matapos "madisburse" and pera."</p>
                                <div class="text-center"><label><input type="checkbox" class="" id="terms_agree"> Naiintindihan</label></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button  class="btn btn-primary" disabled id="submit_app_loan">Submit</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="view-modal-layout d-none ">
        <div class="ibox">
            {{--            <div class="ibox-content">--}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="m-b-md">
                        {{--                    <a href="#" class="btn btn-white btn-xs float-right">Edit project</a>--}}
                        <h2 class="loan-name">Loan product name</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    {{--                        <dl class="row mb-0">--}}
                    {{--                            <div class="col-sm-6 text-sm-right">--}}
                    {{--                                <dt>Status:</dt>--}}
                    {{--                            </div>--}}
                    {{--                            <div class="col-sm-6 text-sm-left">--}}
                    {{--                                <dd class="mb-1 loan-status">--}}
                    {{--                                    <span class="label label-primary">Active</span>--}}
                    {{--                                </dd>--}}
                    {{--                            </div>--}}
                    {{--                        </dl>--}}
                    <dl class="row mb-0">
                        <div class="col-sm-6 text-sm-right">
                            <dt>Bank:</dt>
                        </div>
                        <div class="col-sm-6 text-sm-left">
                            <dd class="mb-1 loan-provider">Alex Smith</dd>
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-6 text-sm-right">
                            <dt>Amount:</dt>
                        </div>
                        <div class="col-sm-6 text-sm-left">
                            <dd class="mb-1 loan-amount"> 30,000</dd>
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-6 text-sm-right">
                            <dt>Terms:</dt>
                        </div>
                        <div class="col-sm-6 text-sm-left">
                            <dd class="mb-1 loan-terms"> 6 Months</dd>
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-6 text-sm-right">
                            <dt>Interest:</dt>
                        </div>
                        <div class="col-sm-6 text-sm-left">
                            <dd class="mb-1 loan-interest"> 10%</dd>
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-6 text-sm-right">
                            <dt>Amortization Rate:</dt>
                        </div>
                        <div class="col-sm-6 text-sm-left">
                            <dd class="mb-1 loan-amor"></dd>
                        </div>
                    </dl>

                </div>
                <div class="col-lg-6" id="cluster_info">

                    <dl class="row mb-0">
                        <div class="col-sm-6 text-sm-right">
                            <dt>Type:</dt>
                        </div>
                        <div class="col-sm-6 text-sm-left">
                            <dd class="mb-1 loan-type"> Short Term</dd>
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-6 text-sm-right">
                            <dt>Payment:</dt>
                        </div>
                        <div class="col-sm-6 text-sm-left">
                            <dd class="project-people mb-1">
                                <span class="badge badge-primary">Manual</span>
                                <span class="badge badge-primary">GCash</span>
                                <span class="badge badge-primary">Palawan</span>
                                <span class="badge badge-primary">Bank</span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
            {{--            </div>--}}
        </div>
    </div>


@endsection


@section('styles')
    {{--{!! Html::style('') !!}--}}
    {{--    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}
    {{--    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}--}}
    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}
    {!! Html::style('/css/template/plugins/nouslider/jquery.nouislider.css') !!}
    {!! Html::style('/css/template/plugins/datapicker/datepicker3.css') !!}
    {!! Html::style('/css/template/plugins/iCheck/custom.css') !!}

@endsection

@section('scripts')
    {{--    {!! Html::script('') !!}--}}
    {!! Html::script('/js/template/plugins/jqueryMask/jquery.mask.min.js') !!}
    {!! Html::script('/js/template/moment.js') !!}
    {!! Html::script('/js/template/numeral.js') !!}
    {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}
    {!! Html::script('/js/template/plugins/nouslider/jquery.nouislider.min.js') !!}
    {!! Html::script('/js/template/plugins/datapicker/bootstrap-datepicker.js') !!}
    {!! Html::script('/js/template/plugins/iCheck/icheck.min.js') !!}

    {{--    {!! Html::script(asset('vendor/datatables/buttons.server-side.js')) !!}--}}
    {{--    {!! $dataTable->scripts() !!}--}}
    {{--    {!! Html::script('/js/template/plugins/sweetalert/sweetalert.min.js') !!}--}}
    {{--    {!! Html::script('/js/template/moment.js') !!}--}}
    <script>
        // $(document).on('click', '.show_application', function () {
        //     $('#application_modal').modal('show');
        //     $('#loan_submit_id').val($(this).data('id'));
        // });
        $(document).on('change', '#terms_agree', function () {

            $('#submit_app_loan').prop('disabled', !this.checked);
        });

        $(document).ready(function () {
            var modal = $('#modal');
            function checkBxInit(){
                $('.i-checks').iCheck({
                    checkboxClass: 'icheckbox_square-green',
                    radioClass: 'iradio_square-green',
                });
            }

            var mem = $('.datepicker').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true,
                format: 'yyyy-mm-dd',
                placement: 'bottom',
                startView: 2
            });


            var term_slider = document.getElementById('term_slider');

            noUiSlider.create(term_slider, {
                start: 80,
                behaviour: 'tap',
                connect: 'lower',
                step: 1,
                range: {
                    'min': 2,
                    'max': 90
                },
                format: {
                    // 'to' the formatted value. Receives a number.
                    to: function (value) {
                        return parseInt(value);
                    },
                    // 'from' the formatted value.
                    // Receives a string, should return a number.
                    from: function (value) {
                        return parseInt(value);
                    }
                }
            });
            $('#term_value').html(term_slider.noUiSlider.get());
            term_slider.noUiSlider.on('slide', function () {
                $('#term_value').html(term_slider.noUiSlider.get())
                getList($('select[name=type]').val(), term_slider.noUiSlider.get(), range_slider.noUiSlider.get())
            });

            var range_slider = document.getElementById('amount_slider');

            noUiSlider.create(range_slider, {
                start: [10000, 500000],
                behaviour: 'drag',
                connect: true,
                range: {
                    'min': 10000,
                    'max': 1000000
                },
                step: 10000,
                format: {
                    // 'to' the formatted value. Receives a number.
                    to: function (value) {
                        return parseInt(Math.round(value));
                    },
                    // 'from' the formatted value.
                    // Receives a string, should return a number.
                    from: function (value) {
                        return parseInt(Math.round(value));
                    }
                }
            });

            var range_value = range_slider.noUiSlider.get();
            $('#amount_value').html(numberWithCommas(range_value[0]) + " - " + numberWithCommas(range_value[1]));
            range_slider.noUiSlider.on('slide', function () {
                var range_value = range_slider.noUiSlider.get();
                $('#amount_value').html(numberWithCommas(range_value[0]) + " - " + numberWithCommas(range_value[1]));
                getList($('select[name=type]').val(), term_slider.noUiSlider.get(), range_value)
            });


            // var term_slider = document.getElementById("term_slider");
            // var term_value = document.getElementById("term_value");
            // term_value.innerHTML = term_slider.value; // Display the default slider value
            // term_slider.oninput = function() {
            //     term_value.innerHTML = this.value;
            // }
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

            getList(null, null, null);

            $(document).on('change keyup', '.loan_input', function () {
                getList($('select[name=type]').val(), $('input[name=term]').val(), $('input[name=amount]').val());
            });

            function numberWithCommas(x) {
                return x.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            $(document).on('click', '.show_loan', function () {

                var name = $(this).data('name');
                var provider = $(this).data('provider');
                var amount = $(this).data('amount');
                var type = $(this).data('type');
                var duration = $(this).data('duration');
                var interest_rate = $(this).data('interest_rate');

                var title = 'Loan Product 1';
                modal.find('#modal-size').removeClass().addClass('modal-dialog modal-lg');
                modal.find('.modal-title').text(title);
                modal.find('#modal-save-btn').addClass('d-none');

                var loan_view_layout = $('.view-modal-layout').clone().removeClass('d-none')
                var lvl_name = loan_view_layout.find('.loan-name');
                var lvl_status = loan_view_layout.find('.loan-status');
                var lvl_provider = loan_view_layout.find('.loan-provider');
                var lvl_amount = loan_view_layout.find('.loan-amount');
                var lvl_terms = loan_view_layout.find('.loan-terms');
                var lvl_type = loan_view_layout.find('.loan-type');
                var lvl_interest = loan_view_layout.find('.loan-interest');
                var lvl_amor = loan_view_layout.find('.loan-amor');

                lvl_name.html(name);
                // lvl_status.text.name);
                lvl_provider.text(provider);
                lvl_amount.text(amount);
                lvl_terms.text(duration);
                lvl_type.text(type);
                lvl_interest.text(interest_rate);
                var loan_amor = (amount + (interest_rate/100) * amount) / duration;
                lvl_amor.text(numberWithCommas(loan_amor));
                /**
                 * amount: 30000
                 created_at: "2021-07-06T13:59:53.000000Z"
                 description: "et"
                 duration: 29
                 id: 1
                 interest_rate: 64
                 loan_provider_id: 1
                 loan_type_id: 2
                 name: "Loan Product 1"
                 provider:
                 account_id: "00001"
                 created_at: "2021-07-06T13:59:53.000000Z"
                 id: 1
                 profile: {id: 21, model_id: 1, model_type: "App\\LoanProvider", first_name: "Emory", middle_name: "Hartmann", …}
                 updated_at: "2021-07-06T13:59:53.000000Z"
                 user_id: 22
                 __proto__: Object
                 type:
                 created_at: "2021-07-06T13:59:53.000000Z"
                 display_name: "Long Term Loan"
                 id: 2
                 name: "long-term-loan"
                 updated_at: "2021-07-06T13:59:53.000000Z"
                 __proto__: Object
                 updated_at: "2021-07-06T13:59:53.000000Z"
                 */

                modal.find('.modal-body').empty().append(loan_view_layout.html());
                modal.modal('show');
            });

            $(document).on('ifClicked', '.collateral', function () {
                var type = $(this).data('type');
                // console.log("You clicked " + type);
                var boxs = $('#collateral-box');
                switch (type) {
                    case 'land-title':
                        console.log('land-title');
                        boxs.empty().append('' +
                            '<div class="form-group">' +
                            '<div class="i-checkss">' +
                            '<label class="check-labels"><input type="radio" value="Residential"><i></i> Residential</label>' +
                            '</div>' +
                            '<div class="i-checkss">' +
                            '<label class="check-labels"><input type="radio" value="Agracultural"><i></i> Agracultural</label>' +
                            '</div>' +
                            '</div>' +
                            '');
                        break;
                    case 'vehicle':
                        console.log('vehicle');
                        boxs.empty().append('' +
                            '<div class="form-group">' +
                            '<label>Vehicle Model</label>' +
                            '<input type="text" name="" class="form-control required">' +
                            '</div>' +
                            '<div class="form-group row">' +
                            '<div class="col i-checkss">' +
                            '<label class="check-labels"><input type="radio" name="vehicle-status" value="Brand new"><i></i> Brand new</label>' +
                            '</div>' +
                            '<div class="col i-checkss">' +
                            '<label class="check-labels"><input type="radio" name="vehicle-status" value="2nd Hand"><i></i> 2nd Hand</label>' +
                            '</div>' +
                            '</div>' +
                            '');
                        break;
                    default:
                        boxs.empty();
                        break
                }
                $('.i-checkss').iCheck({
                    radioClass: 'iradio_square-green'
                });
            });

            $(document).on('ifClicked', '.disbursement_type', function () {
                var type = $(this).val();
                console.log("You clicked " + type);
                var boxs = modal.find('#disbursement_info_box');
                switch (type) {
                    case 'Konect2':
                        boxs.empty().append('' +
                            '<h2 class="text-center text-danger">Not Available</h2>' +
                        '');
                        break;
                    case 'Sulit Padala':
                        boxs.empty().append('' +
                            '<h2 class="text-center text-danger">Not Available</h2>' +
                            '');
                        break;
                    default:
                        boxs.empty().append('' +
                            '<div class="form-group">' +
                            '<label>Account Name</label>' +
                            '<input type="text" name="account_name" class="form-control">' +
                            '</div>' +
                            '<div class="form-group">' +
                            '<label>Account Number</label>' +
                            '<input type="text" name="account_number" class="form-control">' +
                            '</div>' +
                        '');
                        break;
                }
                $('.i-checkss').iCheck({
                    radioClass: 'iradio_square-green'
                });
            });

            $(document).on('click', '#modal-save-btn', function(){
                var type = modal.data('type');
                console.log(type);
                switch(type){
                    case 'loan-application-detail':
                        $('.has-error-box').removeClass('has-error-box');
                        var inputs = new Array(), error = 0;
                        inputs.push(modal.data('id'));
                        var info_loan_detail = new Array();
                        $('.info-loan-detail').each(function(){
                            var forms = new Array();
                            var title = $(this).data('title');
                            var value = new Array();
                            switch (title) {
                                case 'Purpose of Loan':
                                    $(this).find('input[type=checkbox]:checked').each(function(){
                                        value.push($(this).val());
                                    });
                                    if($(this).find('input[type=checkbox]:checked').length < 1){
                                        $(this).closest('.form-group').addClass('has-error-box');
                                        error += 1;
                                    }
                                    break;
                                case 'Primary User':
                                    value.push(($(this).val().length < 1) ? 'N/A': $(this).val());
                                    break;
                                case 'Relationship to Applicant':
                                    value.push(($(this).val().length < 1) ? 'N/A': $(this).val());
                                    break;
                                case 'Place of use':
                                    $(this).find('input[type=checkbox]:checked').each(function(){
                                        value.push($(this).val());
                                    });
                                    if($(this).find('input[type=checkbox]:checked').length < 1){
                                        $(this).addClass('has-error-box');
                                        error += 1;
                                    }
                                    break;
                                case 'Collateral':
                                    var innerValue = new Array();
                                    var box = $('#collateral-box');
                                    if($(this).find('input[type=radio]:checked').val() === 'None'){
                                        innerValue.push(box.find('input[type=radio]:checked').val());
                                    }
                                    if($(this).find('input[type=radio]:checked').val() === 'Land Title: TCT No.'){
                                        innerValue.push(box.find('input[type=radio]:checked').val());
                                    }
                                    if($(this).find('input[type=radio]:checked').val() === 'Motor Vehicle'){
                                        innerValue.push(box.find('input[type=radio]:checked').val());
                                        // innerValue.push(box.find('input[type=text]').val());
                                        innerValue.push((box.find('input[type=text]').val().length < 1) ? 'N/A': box.find('input[type=text]').val());
                                        if(box.find('input[type=text]').val().length < 1){
                                            box.find('input[type=text]').closest('.form-group').addClass('has-error');
                                            error += 1;
                                        }
                                    }
                                    value.push($(this).find('input[type=radio]:checked').val());
                                    value.push(innerValue);
                                    break;
                            }

                            forms.push(title);
                            forms.push(value);
                            info_loan_detail.push(forms);
                        });
                        inputs.push(info_loan_detail);

                        var credit_financial_info = new Array();
                        $('.credit-financial-info').each(function(){
                            var forms = new Array();
                            var title = $(this).data('title');
                            var value = new Array();

                            $(this).find('.form-repeater').each(function(){
                                var innerValue = new Array();
                                $(this).find('.form-control').each(function(){
                                    var innestValue = new Array();
                                    innestValue.push($(this).data('title'), $(this).val());
                                    innerValue.push(innestValue);
                                });


                                value.push(innerValue);
                            });

                            forms.push(title);
                            forms.push(value);
                            credit_financial_info.push(forms);
                        });
                        inputs.push(credit_financial_info);

                        var trade_reference_info = new Array();
                        $('.trade-reference-info').each(function(){
                            var forms = new Array();
                            var title = $(this).data('title');
                            var value = new Array();

                            $(this).find('.form-repeater').each(function(){
                                var innerValue = new Array();
                                $(this).find('.form-control').each(function(){
                                    var innestValue = new Array();
                                    innestValue.push($(this).data('title'), $(this).val());
                                    innerValue.push(innestValue);
                                });
                                value.push(innerValue);
                            });
                            forms.push(title);
                            forms.push(value);
                            trade_reference_info.push(forms);
                        });
                        inputs.push(trade_reference_info);

                        var reference_ids = new Array();
                        $('.reference-ids').each(function(){
                            var forms = new Array();
                            var title = $(this).data('title');
                            var value = new Array();

                            $(this).find('.form-control').each(function(){
                                var innestValue = new Array();
                                if($(this).data('base').length > 0){
                                    innestValue.push($(this).data('title'), $(this).data('base'), $(this).val());
                                    // innestValue.push($(this).data('title'), $(this).val(), $(this).val());
                                    value.push(innestValue);
                                }
                            });

                            forms.push(title);
                            forms.push(value);
                            reference_ids.push(forms);
                        });
                        inputs.push(reference_ids);

                        console.log(inputs);
                        console.log('error: '+ error);
                        if(error > 0){
                            return false;
                        }

                        if($('#terms_agree').prop('checked')){
                            // modal.modal('toggle');
                            $.post('{!! route('loan-submit-form') !!}', {
                                _token: '{!! csrf_token() !!}',
                                inputs: inputs
                            }, function(data){
                                console.log(data);
                                window.location.replace(data);
                            });
                        }else{
                            $('#terms_agree').closest('.form-group').addClass('has-error');
                        }


                        break;
                    case 'create-disbursement':
                        var datas = new Array(), error = 0;
                        datas.push(modal.find('input[name=account_type]:checked').val());
                        datas.push(modal.find('input[name=account_name]').val());
                        datas.push(modal.find('input[name=account_number]').val());
                        modal.find('.form-group').removeClass('has-error');
                        modal.find('.form-control').each(function(){
                            if($(this).val().length < 1){
                                $(this).closest('.form-group').addClass('has-error');
                                error += 1;
                            }
                        });

                        if( modal.find('#disbursement_info_box').children().length < 2 ) {
                            error += 1;
                        }
                        console.log(error);
                        if(error > 0){
                            return false;
                        }

                        console.log(datas);

                        $.post('{!! route('store-disbursement') !!}', {
                            _token: '{!! csrf_token() !!}',
                            datas: datas
                        }, function(data){
                            modal.modal('toggle');
                            swal("Success!", "You may proceed to Loan Application.", "success");
                        });

                        break;
                }
            });

            $(document).on('click', '.btn-action', function () {
                var loanProductID = $(this).data('id');
                var loanProductDiscolsure = $('#disclosure_'+loanProductID).html();
                switch ($(this).data('action')) {
                    case 'apply-loan':
                        if(checkDisbursement() > 0){
                            return false;
                        }
                        modal.data('type', 'loan-application-detail');
                        modal.data('id', loanProductID);

                        // modal.find('.modal-title').text('Loan Application Details');
                        // modal.find('#modal-size').removeClass().addClass('modal-dialog modal-lg');
                        // modal.modal({backdrop: 'static', keyboard: false});
                        // return false;

                        modal.find('.modal-body').empty().append('' +
                            '<div class="panel panel-default" id="loan-details">' +
                                '<div class="panel-body">' +
                                    '<strong><h2 class="text-success">LOAN DETAILS</h2></strong>' +
                                    '<h3>Purpose of Loan</h3>' +
                                    '<div class="row">' +
                                        '<div class="col">' +
                                            '<div class="form-group row info-loan-detail" data-title="Purpose of Loan">' +
                                                '<div class="col">' +
                                                    '<div class="i-checks">' +
                                                        '<label class="check-labels"><input type="checkbox" value="Auto Financing"><i></i> Auto Financing</label>' +
                                                    '</div>' +
                                                '</div>' +
                                                '<div class="col">' +
                                                    '<div class="i-checks">' +
                                                        '<label class="check-labels"><input type="checkbox" value="Housing"><i></i> Housing</label>' +
                                                    '</div>' +
                                                '</div>' +
                                                '<div class="col">' +
                                                    '<div class="i-checks">' +
                                                        '<label class="check-labels"><input type="checkbox" value="Working Capital"><i></i> Working Capital</label>' +
                                                    '</div>' +
                                                '</div>' +
                                                '<div class="col">' +
                                                    '<div class="i-checks">' +
                                                        '<label class="check-labels"><input type="checkbox" value="Other"><i></i> Other</label>' +
                                                    '</div>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                    // '<div class="row">' +
                                    //     '<div class="col-lg-6">' +
                                    //         '<div class="form-group">' +
                                    //             '<h3>Primary User</h3>' +
                                    //             '<input type="text" name="primary-user" class="form-control info-loan-detail" data-title="Primary User">' +
                                    //         '</div>' +
                                    //     '</div>' +
                                    //     '<div class="col-lg-6">' +
                                    //         '<div class="form-group">' +
                                    //             '<h3>Relationship to Applicant</h3>' +
                                    //             '<input type="text" name="relationship" class="form-control info-loan-detail" data-title="Relationship to Applicant">' +
                                    //         '</div>' +
                                    //     '</div>' +
                                    // '</div>' +
                                    '<h3>Place of use</h3>' +
                                    '<div class="row info-loan-detail" data-title="Place of use">' +
                                        '<div class="col">' +
                                            '<div class="form-group">' +
                                                '<div class="i-checks">' +
                                                    '<label class="check-labels"><input type="checkbox" value="Residential"><i></i> Residential</label>' +
                                                '</div>' +
                                            '</div>' +
                                            '<div class="form-group">' +
                                                '<div class="i-checks">' +
                                                    '<label class="check-labels"><input type="checkbox" value="Agricultural"><i></i> Agricultural</label>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                        '<div class="col">' +
                                            '<div class="form-group">' +
                                                '<div class="i-checks">' +
                                                    '<label class="check-labels"><input type="checkbox" value="Residential / Commercial"><i></i> Residential / Commercial</label>' +
                                                '</div>' +
                                            '</div>' +
                                            '<div class="form-group">' +
                                                '<div class="i-checks">' +
                                                    '<label class="check-labels"><input type="checkbox" value="Clean Loan / No Collateral"><i></i> Clean Loan / No Collateral</label>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                        '<div class="col">' +
                                            '<div class="form-group">' +
                                                '<div class="i-checks">' +
                                                    '<label class="check-labels"><input type="checkbox" value="Commercial"><i></i> Commercial</label>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                    '<h3>Collateral</h3>' +
                                    '<div class="row">' +
                                        '<div class="col-lg-4">' +
                                            '<div class="form-group info-loan-detail" data-title="Collateral">' +
                                                '<div class="i-checks">' +
                                                    '<label class="check-labels"><input type="radio" name="collateral" class="collateral" data-type="none" value="None" checked><i></i> None</label>' +
                                                '</div>' +
                                                '<div class="i-checks">' +
                                                    '<label class="check-labels"><input type="radio" name="collateral" class="collateral" data-type="land-title" value="Land Title: TCT No."><i></i> Land Title: TCT No.</label>' +
                                                '</div>' +
                                                '<div class="i-checks">' +
                                                    '<label class="check-labels"><input type="radio" name="collateral" class="collateral" data-type="vehicle" value="Motor Vehicle"><i></i> Motor Vehicle</label>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                        '<div class="col-lg-8" id="collateral-box"></div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +

                            '<div class="panel panel-default" id="credit">' +
                                '<div class="panel-body">' +
                                    '<strong><h2 class="text-success">CREDIT / FINANCIAL INFORMATION</h2></strong>' +
                                    '<div class="row">' +
                                        '<div class="col-lg-6 form-repeat-box-parent">' +
                                            '<h3>Bank Accounts</h3>' +
                                            '<div class="form-repeat-box credit-financial-info" data-title="Bank Accounts">' +
                                                '<div class="row form-repeater">' +
                                                    '<div class="col">' +
                                                        '<div class="form-group">' +
                                                            '<input type="text" name="bank-name" class="form-control" data-title="Bank name" placeholder="Bank name">' +
                                                            // '<select name="" class="form-control" data-title="Account type">' +
                                                            //     '<option value="">Account type</option>' +
                                                            //     '<option value="Savings">Savings</option>' +
                                                            //     '<option value="Checking">Checking</option>' +
                                                            //     '<option value="Time Deposit">Time Deposit</option>' +
                                                            // '</select>' +
                                                        '</div>' +
                                                    '</div>' +
                                                    '<div class="col">' +
                                                        '<div class="form-group">' +
                                                            '<input type="text" name="" class="form-control" data-title="Account No." placeholder="Account No.">' +
                                                        '</div>' +
                                                    '</div>' +
                                                '</div>' +
                                            '</div>' +
                                            '<div class="btn-group-xs text-right">' +
                                                '<button type="button" class="btn btn-xs btn-white btn-action" data-action="account-add"><i class="text-success fa fa-plus"></i></button>' +
                                                '<button type="button" class="btn btn-xs btn-white btn-action" data-action="repeater-remove"><i class="text-danger fa fa-minus"></i></button>' +
                                            '</div>' +
                                        '</div>' +
                                        '<div class="col-lg-6 form-repeat-box-parent">' +
                                            '<h3>Credit References</h3>' +
                                            '<div class="form-repeat-box credit-financial-info" data-title="Credit References">' +
                                                '<div class="row form-repeater">' +
                                                    '<div class="col">' +
                                                        '<div class="form-group">' +
                                                            '<input type="text" name="asdf" class="form-control" placeholder="Bank / Financing" data-title="Bank / Financing">' +
                                                        '</div>' +
                                                    '</div>' +
                                                    '<div class="col">' +
                                                        '<div class="form-group">' +
                                                            '<input type="text" name="sdfg" class="form-control" placeholder="Monthly Amortization" data-title="Monthly Amortization">' +
                                                        '</div>' +
                                                    '</div>' +
                                                '</div>' +
                                            '</div>' +
                                            '<div class="btn-group-xs text-right">' +
                                                '<button type="button" class="btn btn-xs btn-white btn-action" data-action="reference-add"><i class="text-success fa fa-plus"></i></button>' +
                                                '<button type="button" class="btn btn-xs btn-white btn-action" data-action="repeater-remove"><i class="text-danger fa fa-minus"></i></button>' +
                                            '</div>' +
                                        '</div>' +


                                    '</div>' +




                                '</div>' +
                            '</div>' +

                            '<div class="panel panel-default">' +
                                '<div class="panel-body">' +
                                    '<strong><h2 class="text-success">TRADE AND OTHER REFERENCES</h2></strong>' +
                                    '<div class="form-repeat-box-parent">' +
                                        '<div class="form-repeat-box trade-reference-info" data-title="Trade and other reference">' +
                                            '<div class="row form-repeater">' +
                                                '<div class="col">' +
                                                    '<div class="form-group">' +
                                                        '<input type="text" name="" class="form-control" placeholder="Customer name / Co-maker" data-title="Customer name / Co-maker">' +
                                                    '</div>' +
                                                '</div>' +
                                                '<div class="col">' +
                                                    '<div class="form-group">' +
                                                        '<input type="text" name="" class="form-control" placeholder="Address" data-title="Address">' +
                                                    '</div>' +
                                                '</div>' +
                                                '<div class="col">' +
                                                    '<div class="form-group">' +
                                                        '<input type="text" name="" class="form-control" placeholder="Contact No." data-title="Contact No.">' +
                                                    '</div>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                        '<div class="btn-group-xs text-right">' +
                                            '<button type="button" class="btn btn-xs btn-white btn-action" data-action="trade-add"><i class="text-success fa fa-plus"></i></button>' +
                                            '<button type="button" class="btn btn-xs btn-white btn-action" data-action="repeater-remove"><i class="text-danger fa fa-minus"></i></button>' +
                                        '</div>' +
                                    '</div>' +

                                '</div>' +
                            '</div>' +

                            '<div class="panel panel-default">' +
                                '<div class="panel-body reference-ids" data-title="Reference ID\'s / Documents">' +
                                    '<strong><h2 class="text-success">REFERENCE ID\'s / DOCUMENTS</h2></strong>' +
                                    '<div class="row">' +
                                        '<div class="col-lg-6 img-box">' +
                                            '<div class="form-group">' +
                                                '<label>Attachment #1 <span class="text-danger">*</span></label>' +
                                                '<input type="file" name="reference_id_a" data-title="Attachment #1" data-base="" class="form-control required image-upload" accept="image/*" required>' +
                                            '</div>' +
                                            '<img class="img-input img-fluid">' +
                                        '</div>' +
                                        '<div class="col-lg-6 img-box">' +
                                            '<div class="form-group">' +
                                                '<label>Attachment #2 <span class="text-danger">*</span></label>' +
                                                '<input type="file" name="reference_id_b" data-title="Attachment #2" data-base="" class="form-control required image-upload" accept="image/*" required>' +
                                            '</div>' +
                                            '<img class="img-input img-fluid">' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="row">' +
                                        '<div class="col-lg-6 img-box">' +
                                            '<div class="form-group">' +
                                                '<label>Attachment #3</label>' +
                                                '<input type="file" name="reference_id_c" data-title="Attachment #3" data-base="" class="form-control image-upload" accept="image/*" required>' +
                                            '</div>' +
                                            '<img class="img-input img-fluid">' +
                                        '</div>' +
                                        '<div class="col-lg-6 img-box">' +
                                            '<div class="form-group">' +
                                                '<label>Attachment #4</label>' +
                                                '<input type="file" name="reference_id_d" data-title="Attachment #4" data-base="" class="form-control image-upload" accept="image/*" required>' +
                                            '</div>' +
                                            '<img class="img-input img-fluid">' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="row">' +
                                        '<div class="col-lg-6 img-box">' +
                                            '<div class="form-group">' +
                                                '<label>Attachment #5</label>' +
                                                '<input type="file" name="reference_id_e" data-title="Attachment #5" data-base="" class="form-control image-upload" accept="image/*" required>' +
                                            '</div>' +
                                            '<img class="img-input img-fluid">' +
                                        '</div>' +
                                        '<div class="col-lg-6 img-box">' +
                                            '<div class="form-group">' +
                                                '<label>Attachment #6</label>' +
                                                '<input type="file" name="reference_id_f" data-title="Attachment #6" data-base="" class="form-control image-upload" accept="image/*" required>' +
                                            '</div>' +
                                            '<img class="img-input img-fluid">' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +



                            '<div class="panel panel-default">' +
                                '<div class="panel-body">' +
                                    '<strong><h2 class="text-success">TERMS</h2></strong>' +
                                    '<div class="row">' +
                                        '<div class="col">' +
                                            '<div class="bg-muted p-4">' +
                                                    loanProductDiscolsure +

                                                // '<strong>Naiintindihan ng humihiram na eto ay market testing sa pakikipag ugnayan ng Agrabah at CARD BDSFI na kung saan:</strong>' +
                                                // '<br>' +
                                                // '<br>' +
                                                // '<p>1. Eto ay pilot testing/market testing na kung saan maaring one time lang ang pag hiram at ang mga susunod na pag hiram ay sa CARD BANK or ibang insitutition na ng CARD MRI pwedeng gawin</p>' +
                                                // '<p>2. Ang hinihiram ay babayaran sa loob ng tatlong (3) buwan na may voluntary contribution na 2.5% ng prinsipal kada buwan, Kaugnay nito kung may pambayad na ang humihiram bago sumapit ang ikatlong buwan, maari nila itong bayaran ng buo or "partial"</p>' +
                                                // '<p>3. Pumapayag at naiintindihan ng humihiram na ang disbursement at collection ay via Konect2 CARD, CARD Sulit Padala or GCASH. Ang ACCOUNT Number ng CARD BDSFI na kung saan maari itong bayaran ay ibibigay sa humhiram matapos "madisburse" and pera."</p>' +
                                                // '<div class="form-group">' +
                                                    '<div class="text-center i-checks"><label><input type="checkbox" class="form-control" id="terms_agree">&nbsp; Naiintindihan</label></div>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +

                        '');


                        checkBxInit();


                        modal.find('.modal-title').text('Loan Application Details');
                        modal.find('#modal-size').removeClass().addClass('modal-dialog modal-lg');
                        modal.modal({backdrop: 'static', keyboard: false});

                        {{--swal({--}}
                        {{--    title: "Are you sure?",--}}
                        {{--    text: "Your loan application will be submitted!",--}}
                        {{--    type: "warning",--}}
                        {{--    showCancelButton: true,--}}
                        {{--    confirmButtonColor: "#DD6B55",--}}
                        {{--    confirmButtonText: "Yes!",--}}
                        {{--    cancelButtonText: "No!",--}}
                        {{--    closeOnConfirm: true,--}}
                        {{--    closeOnCancel: true--}}
                        {{--},--}}
                        {{--function (isConfirm) {--}}
                        {{--    if (isConfirm) {--}}
                        {{--        $.get('{!! route('loan-apply') !!}', {--}}
                        {{--            id: loanProductID--}}
                        {{--        }, function (data) {--}}
                        {{--            console.log('success');--}}
                        {{--            console.log(data);--}}
                        {{--        });--}}
                        {{--    } else {--}}
                        {{--        swal("Cancelled", "Loan application cancelled", "error");--}}
                        {{--    }--}}
                        {{--});--}}

                        break;
                    case 'account-add':
                        var box = $(this).closest('.form-repeat-box-parent').find('.form-repeat-box');
                        box.append('' +
                            '<div class="row form-repeater">' +
                                '<div class="col">' +
                                    '<div class="form-group">' +
                                        '<input type="text" name="bank-name" class="form-control" data-title="Bank name" placeholder="Bank name">' +
                                        // '<select name="" class="form-control" data-title="Account type">' +
                                        //     '<option value="">Account type</option>' +
                                        //     '<option value="Savings">Savings</option>' +
                                        //     '<option value="Checking">Checking</option>' +
                                        //     '<option value="Time Deposit">Time Deposit</option>' +
                                        // '</select>' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col">' +
                                    '<div class="form-group">' +
                                        '<input type="text" name="" class="form-control" placeholder="Account No." data-title="Account No.">' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '');
                        break;
                    case 'reference-add':
                        var box = $(this).closest('.form-repeat-box-parent').find('.form-repeat-box');
                        box.append('' +
                            '<div class="row form-repeater mb-1">' +
                                '<div class="col">' +
                                    '<div class="form-group">' +
                                        '<input type="text" name="asdf" class="form-control" placeholder="Bank / Financing" data-title="Bank / Financing">' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col">' +
                                    '<div class="form-group">' +
                                        '<input type="text" name="sdfg" class="form-control" placeholder="Monthly Amortization" data-title="Monthly Amortization">' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '');
                        break;
                    case 'trade-add':
                        var box = $(this).closest('.form-repeat-box-parent').find('.form-repeat-box');
                        box.append('' +
                            '<div class="row form-repeater">' +
                                '<div class="col">' +
                                    '<div class="form-group">' +
                                        '<input type="text" name="" class="form-control" placeholder="Customer/Co-maker name" data-title="Customer name / Co-maker">' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col">' +
                                    '<div class="form-group">' +
                                        '<input type="text" name="" class="form-control" placeholder="Address" data-title="Address">' +
                                    '</div>' +
                                '</div>' +
                                '<div class="col">' +
                                    '<div class="form-group">' +
                                        '<input type="text" name="" class="form-control" placeholder="Contact No." data-title="Contact No.">' +
                                    '</div>' +
                                '</div>' +
                            '</div>' +
                        '');
                        break;
                    case 'repeater-remove':
                        var repeater = $(this).closest('.form-repeat-box-parent').find('.form-repeat-box').find('.form-repeater');
                        if(repeater.length > 1){
                            repeater.last().remove();
                        }
                        break;
                }
            });

            $(document).on('change', '.image-upload', function(){
                var preview = $(this).closest('.img-box').find('.img-input');
                var input = $(this);
                var file = this.files[0];
                var reader = new FileReader();

                reader.addEventListener("load", function () {
                    preview.attr('src', reader.result);
                    input.data('base', reader.result);
                }, false);

                if (file) {
                    reader.readAsDataURL(file);
                }
            });

            function getList(type, term, amount) {
                console.log('type: ' + type);
                console.log('term: ' + term);
                console.log('amount: ' + numeral(amount).format('0'));
                var list = new Array();
                jQuery.ajaxSetup({async: false});
                $.get('{!! route('loan-product-list-get') !!}', {
                    type: type,
                    term: term,
                    amount: amount
                }, function (data) {
                    // console.log(data);
                    for (var a = 0; a < data.length; a++) {
                        list.push('' +
                            '<tr>' +
                            '<td>' + data[a].name + '</td>' +
                            '<td class="project-title">' +
                            '<a href="#">' + data[a].provider.profile.bank_name + '</a>' +
                            '<br/>' +
                            '<small>' + data[a].type.display_name + '</small>' +
                            '</td>' +
                            '<td>' + data[a].interest_rate + '%</td>' +
                            '<td>' + data[a].duration + ' ' + data[a].timing_name + '</td>' +
                            '<td class="text-right">' + numeral(data[a].amount).format('0,0.00') + '</td>' +
                            '<td class="project-actions">' +
                            '<a href="#" class="btn btn-white btn-sm show_loan" data-name="' + data[a].name + '" data-provider="' + data[a].provider.profile.bank_name + '" data-amount="' + data[a].amount + '" data-type="' + data[a].type.display_name + '" data-duration="' + data[a].duration + '" data-interest_rate="' + data[a].interest_rate + '"><i class="fa fa-search"></i> View </a>' +
                            '<button type="button" class="btn btn-white btn-sm show_application btn-action" data-action="apply-loan" data-id="' + data[a].id + '"><i class="fa fa-check"></i> Apply </button>' +
                            '<div class="d-none" id="disclosure_' + data[a].id + '"> ' + data[a].disclosure_html + '</div>' +
                            '</td>' +
                            '</tr>' +
                            '');
                    }
                });
                $('.loan-product-list').find('tbody').empty().append(list.join(''));
            }

            function checkDisbursement() {
                var status = 0;
                // jQuery.ajaxSetup({async:false});
                $.get('{!! route('check-disbursement') !!}', function(data){
                    console.log(data);
                    if(data){
                        console.log('exist');
                    }else{
                        status += 1;
                        swal({
                            title: "Disbursement account not exist!",
                            text: "Create disbursement account to proceed in loan!",
                            type: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#6a73dd",
                            cancelButtonColor: "#DD6B55",
                            confirmButtonText: "Create!",
                            cancelButtonText: "No thanks!",
                            closeOnConfirm: true,
                            closeOnCancel: true },
                        function (isConfirm) {
                            if (isConfirm) {
                                modal.data('type', 'create-disbursement');
                                modal.find('.modal-title').text('Disbursement Account Information');
                                modal.find('#modal-size').removeClass().addClass('modal-dialog modal-md');
                                modal.find('#modal-save-btn').removeClass('d-none');
                                modal.find('.modal-body').empty().append('' +
                                    '<div class="panel panel-default">' +
                                        '<div class="panel-body">' +
                                            '<div class="row">' +
                                                '<div class="col form-group">' +
                                                    '<label class="i-checks"> <input type="radio" name="account_type" class="disbursement_type" value="GCash" checked> GCash </label>' +
                                                '</div>' +
                                                '<div class="col form-group">' +
                                                    '<label class="i-checks"> <input type="radio" name="account_type" class="disbursement_type" value="Konect2" readonly> Konect2 </label>' +
                                                '</div>' +
                                                '<div class="col form-group">' +
                                                    '<label class="i-checks"> <input type="radio" name="account_type" class="disbursement_type" value="Sulit Padala" readonly> Sulit Padala </label>' +
                                                '</div>' +
                                            '</div>' +
                                            '<div class="row">' +
                                                '<div class="col" id="disbursement_info_box">' +
                                                    '<div class="form-group">' +
                                                        '<label>Account Name</label>' +
                                                        '<input type="text" name="account_name" class="form-control">' +
                                                    '</div>' +
                                                    '<div class="form-group">' +
                                                        '<label>Account Number</label>' +
                                                        '<input type="text" name="account_number" class="form-control">' +
                                                    '</div>' +
                                                '</div>' +
                                            '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '');
                                $('.i-checks').iCheck({
                                    checkboxClass: 'icheckbox_square-green',
                                    radioClass: 'iradio_square-green',
                                });
                                modal.modal({backdrop: 'static', keyboard: false});
                            } else {
                                swal("Cancelled", "Process cancelled", "error");
                            }
                        });
                    }
                });
                return status;
            }

        });
    </script>
@endsection
