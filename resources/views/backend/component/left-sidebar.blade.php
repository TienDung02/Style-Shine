<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li> <a class="waves-effect waves-dark" href="{{route('admin.dashboard.index')}}" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{route('admin.product')}}" aria-expanded="false"><i class="bi bi-box"></i><span class="hide-menu">Product</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{route("admin.category")}}" aria-expanded="false"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu">Product Category</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{route('admin.order')}}" aria-expanded="false"><i class="bi bi-cart-check"></i><span class="hide-menu">Order</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{route('admin.user')}}" aria-expanded="false"><i class="bi bi-person-fill"></i><span class="hide-menu">User</span></a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="sidebar-footer d-flex justify-content-end">
        <!-- item--><a href="{{route('admin.password')}}" class="link" data-toggle="tooltip" title="Change Password"><i class="bi bi-key"></i></a>
        <!-- item--><a href="{{route("logout")}}" class="link" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a> </div>
</aside>
