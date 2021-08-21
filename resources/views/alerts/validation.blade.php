
@if (count($errors) > 0)
    @foreach($errors->all() as $error)
        <div class="alert alert-danger">{{ $error }} </div>
    @endforeach
@endif
@if ($message = Session::get('success'))
    <div class="alert alert-success  alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>{{ $message }}</strong>
    </div>
@endif