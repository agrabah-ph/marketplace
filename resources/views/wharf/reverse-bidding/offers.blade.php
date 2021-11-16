
@foreach($offers as $index => $offer)
    <div class="ibox-content offer-box"  data-toggle="collapse"  data-target="#offer_{{$offer->id}}">
        <h2 class="text-center">₱ {{currency_format($offer->total_bid)}}</h2>
        {{--                                            <pre>{{json_encode(json_decode($offer->bids, true), 128)}}</pre>--}}
        <div id="offer_{{$offer->id}}" class="collapse">
            <table class="offer_table table">
                <thead>
                <tr>
                    <th class="small">Item name</th>
                    <th class="small">Quantity</th>
                    <th class="small text-right">Unit Price</th>
                    <th class="small text-right">Cost</th>
                </tr>
                </thead>
                <tbody>
                @foreach(json_decode($offer->bids, true) as $bid)
                    <tr>
                        <td>{{$items[$bid['id']]}}</td>
                        <td>{{$qtys[$bid['id']]}}</td>
                        <td class="text-right">{{number_format_from_comma($bid['price'], 2)}}</td>
                        <td class="text-right">{{number_format_from_comma($bid['cost'], 2)}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <table class="offer_summary">
                <tbody>
                <tr>
                    <td>Gross Total:</td>
                    <td>₱ {{number_format($offer->gross_total)}}</td>
                </tr>
                <tr>
                    <td>Transaction Fee</td>
                    <td>₱ {{number_format($offer->service_fee)}}</td>
                </tr>
                <tr>
                    <td>Value Added Tax</td>
                    <td>₱ {{number_format($offer->vat)}}</td>
                </tr>
                <tr>
                    <td class="font-bold">Total Bid:</td>
                    <td class="font-bold">₱ {{number_format($offer->total_bid)}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endforeach