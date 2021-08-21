@component('mail::message')
# {{ $details['title'] }}

<div style="text-align: center">
    {!! $details['body'] !!}
    <h1 style="text-align: center">{{ $details['code'] }}</h1>
    <small>CODE</small><br><br>
{{--    <img src="data:image/png;base64,{{ $details['qrcode'] }}" alt="" width="200">--}}
</div>

@component('mail::button', ['url' => $details['url']])
View Details
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
