<div id="get-result-search">
    <div class="table-responsive">
        <table class="table">
            <colgroup>
                <col width="100">
                <col width="300">
                <col width="220">
                <col width="210">
                <col width="210">
                <col width="220">
                <col >
            </colgroup>
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Price ($)</th>
                <th>Quantity</th>
                <th>Quantity Sold</th>
                <th>Rating</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <span id="get_limit" data-url="{{ route('admin.product.limit') }}"> </span>
            @php
                $shows = [ '5', '7', '9'];
                $limit = request()->input('limit', 5);
                $page = request()->input('page', 1);
            @endphp
            @foreach($data as $product)
                <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->quantity}}</td>
                    <td>{{$product->sold_quantity}}</td>
                    <td>
                        @if($product->reviews_avg_rating == 5)
                            <i class="bi bi-star-fill"></i>
                        @elseif($product->reviews_avg_rating == 0 ||$product->reviews_avg_rating == null)
                            <i class="bi bi-star"></i>
                        @else
                            <i class="bi bi-star-half"></i>
                        @endif
                        {{$product->reviews_avg_rating}}({{$product->reviews_count}})
                    </td>
                    <td class="d-flex btn-action">
                        <a href="{{ route('admin.product.edit', $product->id) }}" class="me-3">
                            <button type="submit" class="btn btn-secondary">Update</button>
                        </a>
                        <form id='delete-form-{{ $product->id }}' class="me-3"
                              action="{{ route('admin.product.destroy', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-delete"
                                    data-id="{{ $product->id }}">Delete
                            </button>
                        </form>
                        <a href="{{ route('admin.product.view', $product->id) }}" class="me-3">
                            <button type="submit" class="btn btn-info text-white">See Reviews</button>
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
