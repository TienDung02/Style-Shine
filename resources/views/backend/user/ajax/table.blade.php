<div id="get-result-search">
    <div class="table-responsive">
        <table class="table">
            <colgroup>
                <col width="80">
                <col width="280">
                <col width="300">
                <col>
                <col width="300">
            </colgroup>
            <thead>
            <tr>
                <th>#</th>
                <th>Username</th>
                <th>Full Name</th>
                <th>Email</th>
                <th><a style="color: #757575" href="">Number of products purchased</a></th>
            </tr>
            </thead>
            <tbody>
            <span id="get_limit" data-url="{{ route('admin.user.limit') }}"> </span>
            @php
                $shows = [ '5', '7', '9'];
                $limit = request()->input('limit', 5);
                $page = request()->input('page', 1);
            @endphp
            @foreach($data as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->cus_name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->total_quantity}}</td>
                    <td class="d-flex btn-action">
                        <a href="{{ route('admin.user.view', $user->id) }}" class="me-3">
                            <button type="submit" class="btn btn-info text-white">View</button>
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
