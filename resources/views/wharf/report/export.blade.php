<table>
    <thead>
    <tr>
        <th>Created At</th>
        <th>Expiration</th>
        <th data-sortable="false">Photo</th>
        <th>Name</th>
        <th>Selling Price</th>
        <th>Bought Price</th>
        <th>Winner</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
    @foreach($row as $col)
        <tr>
            <td>{{$col->created_at}}</td>
            <td>{{$col->expiration_time}}</td>
            <td><img class='img-thumbnail bidding_photos' src='{{$col->getFirstMediaPath($type)}}' width="150px"></td>
            <td>{{$col->name}}</td>
            <td>{{$type == 'reverse-bidding'?$col->asking_price:$col->original_price}}</td>
            <td>{{$col->winner?$col->current_bid:'No Bidder'}}</td>
            <td>{{$col->winner?$col->winner->name??$col->winner->email:'No Bidder'}}</td>
            <td>{{$col->status?'Completed':'Active'}}</td>
        </tr>
    @endforeach
    </tbody>
</table>