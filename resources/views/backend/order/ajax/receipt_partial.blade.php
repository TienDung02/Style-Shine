<style>
    body {
        font-family: DejaVu Sans, sans-serif;
        font-size: 12px;
    }

    h3, h4, h6 {
        margin: 0;
        color: #455a64;
    }

    .section {
        margin-bottom: 20px;
    }

    .row {
        width: 100%;
        overflow: hidden;
        margin-bottom: 10px;
    }

    .col {
        float: left;
        width: 48%;
        margin-right: 4%;
    }

    .col:last-child {
        margin-right: 0;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th, td {
        border: 1px solid #000;
        padding: 6px;
        text-align: center;
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
    }

    .total {
        float: right;
        width: 40%;
    }

    .clearfix::after {
        content: "";
        display: table;
        clear: both;
    }
</style>

<div class="review-container">
    <h3>Order Receipt</h3>

    <div class="section clearfix">
        <div class="col">
            <h6>Customer Name: {{$order->CUS_NAME}}</h6>
        </div>
        <div class="col">
            <h6>Seller: Style & Shine</h6>
        </div>
    </div>
    <div class="section clearfix">
        <div class="col" style="width: 100%; margin-top: 5px;">
            <h6>Shipping Address: {{$order->ADDRESS}}</h6>
        </div>
    </div>

    <div class="section clearfix">
        <div class="col">
            <h6>Order ID: {{$order->id}}</h6>
        </div>
        <div class="col">
            <h6>Order Date: {{$order->created_at}}</h6>
        </div>
    </div>
    <div class="section clearfix">
        <div class="col" style="width: 100%; margin-top: 5px;">
            <h6>Payment Method: {{$order->payment_method}}</h6>
        </div>
    </div>

    <div class="section">
        <h4>Order Details</h4>
        <table>
            <thead>
            <tr>
                <th>No.</th>
                <th>Product Name</th>
                <th>Price (VND)</th>
                <th>Quantity</th>
            </tr>
            </thead>
            <tbody>
            @php $count = 1; @endphp
            @foreach($data as $detail)
                <tr>
                    <td>{{$count}}</td>
                    <td>{{$detail->product->NAME_PRODUCT}}</td>
                    <td>{{number_format($detail->product->PRICE, 0, '', '.')}}</td>
                    <td>{{$detail->quantity}}</td>
                </tr>
                @php $count++; @endphp
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="section total">
        <div class="total-row">
            <h6 style="margin-right: 100px">Subtotal {{$data->sum('quantity')}} item(s): {{number_format($order->total_price, 0, '', '.')}} VND</h6>
            <h6 style="margin-right: 100px">Shipping: 30.000 VND</h6>
            <h6 style="margin-right: 100px">Total Payment: {{number_format($order->total_price + 30000, 0, '', '.')}} VND</h6>
        </div>
    </div>
</div>
