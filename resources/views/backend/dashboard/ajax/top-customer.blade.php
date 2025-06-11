<table class="table">
    <thead>
    <tr>
        <th>#</th>
        <th>Full Name</th>
        <th>Quantity Purchased</th>
        <th>Last Purchase Date</th>
    </tr>
    </thead>
    <tbody>
    @php $count = 1 @endphp
    @foreach($topCustomers as $topCustomer)
        <tr>
            <td>{{$count}}</td>
            <td>{{$topCustomer->cus_name}}</td>
            <td>{{$topCustomer->total_quantity}}</td>
            <td>{{ \Carbon\Carbon::parse($topCustomer->last_purchase_date)->format('d-m-Y') }}</td>
            @php $count++ @endphp
        </tr>
    @endforeach
    </tbody>
</table>
