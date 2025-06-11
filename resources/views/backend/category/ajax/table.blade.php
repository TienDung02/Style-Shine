<div id="get-result-search">
    <div class="table-responsive">
        <table class="table">
            {{--                                        {{dd($data)}}--}}

            <colgroup>
                <col width="150">
                <col width="800">
                <col>
                <col width="300">
            </colgroup>
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Products</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <span id="get_limit" data-url="{{ route('admin.category.limit') }}"> </span>
            <span id="store_category" data-url="{{ route('admin.category.store') }}"> </span>
            @php
                $shows = [ '5', '7', '9'];
                $limit = request()->input('limit', 5);
                $page = request()->input('page', 1);
            @endphp


            @foreach($data as $category)
                <tr>
                    <td>{{$category->ID}}</td>
                    <td>{{$category->NAME}}</td>
                    <td>{{$category->products->count() ?? 0}}</td>
                    <td class="d-flex btn-action">
                        <a  class="me-3">
                            {{--                                                            <button type="submit" class="btn btn-secondary">Update</button>--}}
                            <span id="update_category" data-url="{{ route('admin.category.update', $category->ID) }}"> </span>
                            <button
                                class="btn btn-secondary btn-edit"
                                data-id="{{ $category->ID }}"
                                data-name="{{ $category->NAME }}"
                                data-bs-toggle="modal"
                                data-url="{{ route('admin.category.update', $category->ID) }}"
                                data-bs-target="#categoryModal" >
                                Update
                            </button>
                        </a>

                        <form id='delete-form-{{ $category->ID }}'
                              action="{{ route('admin.category.destroy', $category->ID) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-delete"
                                    data-id="{{ $category->ID }}">Delete
                            </button>
                        </form>
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
