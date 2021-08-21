@extends('master')

@section('title', 'Product Create')

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
            <div class="title-action">
                <button type="button" class="btn btn-primary btn-action" data-action="store">Store</button>
            </div>
        </div>
    </div>

    <div id="app" class="wrapper wrapper-content">

        <form action="{!! route('purchase-order.store') !!}" method="post" id="form">
            <div class="row">
                <div class="col-sm-5">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Information</h5>
                        </div>
                        <div class="ibox-content">
                            @csrf
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" name="name">
                            </div>
                            <div class="form-group">
                                <label>Expected Delivery Date</label>
                                <input type="text" class="form-control" name="expected_delivery_date">
                            </div>
                            <div class="form-group">
                                <label>Expiration Date</label>
                                <input type="text" class="form-control" name="expiration_date">
                            </div>
                            <div class="form-group">
                                <label>Delivery Address</label>
                                <textarea name="delivery_address" class="form-control no-resize"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Other Requirements</label>
                                <textarea name="other_requirements" class="form-control no-resize"></textarea>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-sm-7">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>Product Orders</h5>
                        </div>
                        <div class="ibox-content">
                            <div class="form-group">
                                <label>Product</label>
                                <input type="text" class="form-control input-sm m-b-xs product_input" placeholder="eg. Rice/Sugar">
                            </div>
                            <div class="form-group">
                                <label>Qty</label>
                                <input type="number" class="form-control input-sm m-b-xs" id="qty" value="1" placeholder="">
                            </div>

                            <div class="form-group">
                                <button type="button" class="btn btn-primary" >Add</button>
                            </div>

                            <table class="footable table table-stripped" data-page-size="8" data-filter=#filter>
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th class="text-right" data-sort-ignore="true"><i class="fa fa-cogs text-success"></i></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="99">--</td>
                                </tr>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <td colspan="3">
                                        <ul class="pagination pull-right"></ul>
                                    </td>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="modal-save-btn">Save changes</button>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('styles')
    {{--{!! Html::style('') !!}--}}
    {{--    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">--}}
    {{--    {!! Html::style('/css/template/plugins/sweetalert/sweetalert.css') !!}--}}
@endsection

@section('scripts')

    {!! Html::script('/js/template/plugins/typehead/bootstrap3-typeahead.js') !!}

    <script>
        $(document).ready(function () {

            $(document).on('click', '.btn-action', function () {

            });

            $.get('{{route('product-list')}}', function(data){
                console.log(data)
                $(".product_input").typeahead({ source:data });
            },'json');

            $(document).on('click', '.btn-action', function () {
                switch ($(this).data('action')) {
                    case 'store':
                        $('#form').submit();
                        break;
                }
            });
        });
    </script>
@endsection
