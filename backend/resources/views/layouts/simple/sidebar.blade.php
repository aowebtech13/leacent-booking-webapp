<!-- Page Sidebar Start-->
<div class="sidebar-wrapper" data-sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid for-light" src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1791759399/leacent%20webapp.png" alt=""><img class="img-fluid for-dark" src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1791759399/leacent%20webapp.png" alt=""></a>
            <div class="back-btn"><i class="fa-solid fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"></i></div>
        </div>
        <div class="logo-icon-wrapper"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid" src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1791759399/leacent%20webapp.png" alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid" src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1791759399/leacent%20webapp.png" alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa-solid fa-angle-right ps-2" aria-hidden="true"></i></div>
                    </li>
                    <li class="pin-title sidebar-main-title"><div><h6>Pinned</h6></div></li>
                    <li class="sidebar-main-title"><div><h6>Leacent Admin</h6></div></li>
                    <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.dashboard') }}"><svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use></svg><svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-home') }}"></use></svg><span>Dashboard</span></a></li>
                    <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a class="sidebar-link sidebar-title link-nav" href="{{ route('admin.profile') }}"><svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use></svg><svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use></svg><span>My Profile</span></a></li>
                    <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)"><svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use></svg><svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use></svg><span>Users</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.users.index') }}">All Users</a></li>
                        </ul>
                    </li>

                    <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)"><svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-ecommerce') }}"></use></svg><svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-ecommerce') }}"></use></svg><span>Orders</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.orders.index') }}">Order History</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)"><svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-bookmark') }}"></use></svg><svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-bookmark') }}"></use></svg><span>Books</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.books.index') }}">All Books</a></li>
                            <li><a href="{{ route('admin.books.create') }}">Create Book</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)"><svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-user') }}"></use></svg><svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-user') }}"></use></svg><span>Authors</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.authors.index') }}">All Authors</a></li>
                            <li><a href="{{ route('admin.authors.create') }}">Create Author</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)"><svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#product-category') }}"></use></svg><svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#product-category') }}"></use></svg><span>Categories</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.categories.index') }}">All Categories</a></li>
                            <li><a href="{{ route('admin.categories.create') }}">Create Category</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a class="sidebar-link sidebar-title" href="javascript:void(0)"><svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#stroke-file') }}"></use></svg><svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#fill-file') }}"></use></svg><span>Invoice</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.invoice_1') }}">Invoice Lists</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a class="sidebar-link sidebar-title link-nav" href="javascript:void(0)" onclick="document.getElementById('logout-form').submit();"><svg class="stroke-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#freepik--Door--inject-63') }}"></use></svg><svg class="fill-icon"><use href="{{ asset('assets/svg/icon-sprite.svg#freepik--Door--inject-63') }}"></use></svg><span>Logout</span></a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none;">@csrf</form>
                    </li>
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
<!-- Page Sidebar Ends-->