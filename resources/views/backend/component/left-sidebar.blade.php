<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li> <a class="waves-effect waves-dark" href="{{route('admin.dashboard.index')}}" aria-expanded="false"><i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{route('admin.profile')}}" aria-expanded="false"><i class="mdi mdi-account-check"></i><span class="hide-menu">Profile</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{route('admin.product')}}" aria-expanded="false"><i class="bi bi-box"></i><span class="hide-menu">Product</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{route("admin.category")}}" aria-expanded="false"><i class="mdi mdi-format-list-bulleted"></i><span class="hide-menu">Product Category</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{route('admin.test')}}" aria-expanded="false"><i class="mdi mdi-emoticon"></i><span class="hide-menu">Icons</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{route('admin.order')}}" aria-expanded="false"><i class="bi bi-cart-check"></i><span class="hide-menu">Order</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="{{route('admin.user')}}" aria-expanded="false"><i class="bi bi-person-fill"></i><span class="hide-menu">User</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="map-google.html" aria-expanded="false"><i class="mdi mdi-earth"></i><span class="hide-menu">Google Map</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="../blank/pages-blank.html" aria-expanded="false"><i class="mdi mdi-book-open-variant"></i><span class="hide-menu">Blank Page</span></a>
                </li>
                <li> <a class="waves-effect waves-dark" href="../404/pages-error-404.html" aria-expanded="false"><i class="mdi mdi-help-circle"></i><span class="hide-menu">Error 404</span></a>
                </li>
            </ul>
        </nav>
    </div>
    <div class="sidebar-footer">
        <!-- item--><a href="" class="link" data-toggle="tooltip" title="Settings"><i class="ti-settings"></i></a>
        <!-- item--><a href="" class="link" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a>
        <!-- item--><a href="{{route("logout")}}" class="link" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a> </div>
</aside>
