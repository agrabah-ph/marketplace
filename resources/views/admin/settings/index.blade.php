@extends('admin.master')

@section('title', 'Settings')

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
{{--                <a href="#" class="btn btn-primary">This is action area</a>--}}
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content">

        <div class="row">
            <div class="col-sm-12">
                <div class="ibox float-e-margins">
                    <div class="ibox-content">
                        <form action="{!! route('settings.store') !!}" method="post" id="form">
                        @csrf
                        <span class="text-muted small float-right"><i class="fa fa-exclamation-triangle"></i> Note:  Deletion can only be done by Developers</span>
                        <br>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Value</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody class="setting_tbody">
                                @forelse($settings as $setting)
                                    <tr>
                                        <td width="30%">{{$setting->display_name}}</td>
                                        <td><input type="text" class="form-control" name="settings[id][{{$setting->id}}]" value="{{$setting->value}}"></td>
                                        <td width="10">
                                            <input type="checkbox" class="js-switch" name="settings[is_active][{{$setting->id}}]" {{$setting->is_active==1?'checked':''}} />
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="empty_row">
                                        <td colspan="99" class="text-center">No Settings Yet</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-primary add_setting">Add Setting</button>
                            <button class="btn btn-success">Save Changes</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal inmodal fade" id="modal" data-type="" tabindex="-1" role="dialog" aria-hidden="true" data-category="" data-variant="" data-bal="">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header" style="padding: 15px;">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
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
    {!! Html::style('css/template/plugins/switchery/switchery.css') !!}
@endsection

@section('scripts')
    {{--    {!! Html::script('') !!}--}}
    <!-- Switchery -->
    {!! Html::script(asset('vendor/datatables/buttons.server-side.js')) !!}
    {!! Html::script('js/template/plugins/switchery/switchery.js') !!}
    <script>

        var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        elems.forEach(function(html) {
            var switchery = new Switchery(html);
        });

        // var elem = document.querySelector('.js-switch');
        // var switchery = new Switchery(elem, { color: '#1AB394' });

        $(document).on('click', '.add_setting', function(){
            var empty_row = $('.empty_row');
            if(empty_row.length)
                empty_row.remove();
            var new_row = '<tr class="">'+
            '    <td width="30%"><input type="text" class="form-control" name="new_entry[name][]" ></td>'+
            '    <td><input type="text" class="form-control" name="new_entry[value][]"></td>'+
            '    <td width="10">'+
            '        <input type="checkbox" class="js-switch new_switches" name="new_entry[is_active][]"/>'+
            '    </td>'+
            '</tr>';
            $('.setting_tbody').append(new_row);

            var elems = Array.prototype.slice.call(document.querySelectorAll('.new_switches'));
            elems.forEach(function(html) {
                var switchery = new Switchery(html);
            });
            $('.new_switches').removeClass('new_switches')
        });

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

        });
    </script>
@endsection
