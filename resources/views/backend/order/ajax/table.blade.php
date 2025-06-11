<div id="get-result-search">
    <div class="table-responsive">
        <table class="table">
            <colgroup>
                <col width="100">
                <col>
                <col>
                <col>
                <col width="220">
            </colgroup>
            <thead>
            <tr>
                <th>#</th>
                <th>Customer Name</th>
                <th>Payment Method</th>
                <th>Price ($)</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <span id="get_limit" data-url="{{ route('admin.order.limit') }}"> </span>
            @php
                $shows = [ '5', '7', '9'];
                $limit = request()->input('limit', 5);
                $page = request()->input('page', 1);
            @endphp
            @foreach($data as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->username}}</td>
                    <td>{{$order->payment_method}}</td>
                    <td>{{$order->total_price}}</td>
                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y') }}</td>
                    <td class="d-flex btn-action">
                        <a href="{{ route('admin.order.view', $order->id) }}" class="me-3">
                            <button type="submit" class="btn btn-info text-white">View Detail</button>
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="card-bottom">
        <div class="paginate" id="pagination-links">
            {{$data->withQueryString()->appends($_GET)->links('.backend.component.paginate')}}
        </div>

        <form action="" method="post">
            @csrf
            <div class="border-start">
                <p>Show</p>
                <select name="limit-category" id="show-limit">
                    @foreach($shows as $show)
                        <option {{$show==$limit?'selected':''}} value="{{$show}}">{{$show}}</option>
                    @endforeach
                </select>
                <p>item</p>
            </div>
        </form>
    </div>
</div>
