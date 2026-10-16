<!-- Page Sidebar Start-->
<div class="sidebar-wrapper" data-sidebar-layout="stroke-svg">
    <div>
        <div class="logo-wrapper"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid for-light"
                    src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1791759399/leacent%20webapp.png" alt=""><img class="img-fluid for-dark"
                    src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1791759399/leacent%20webapp.png" alt=""></a>
            <div class="back-btn"><i class="fa-solid fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid">
                </i></div>
        </div>
        <div class="logo-icon-wrapper"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid"
                    src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1791759399/leacent%20webapp.png" alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="{{ route('admin.dashboard') }}"><img class="img-fluid"
                                src="https://res.cloudinary.com/dqi7g7lky/image/upload/v1791759399/leacent%20webapp.png" alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa-solid fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>
                    <li class="pin-title sidebar-main-title">
                        <div>
                            <h6>Pinned</h6>
                        </div>
                    </li>
                    <li class="sidebar-main-title">
                        <div>
                            <h6 class="lan-1">mictomon bespoketailor</h6>
                        </div>
                    </li>
                 
                
  
                    <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a
                            class="sidebar-link sidebar-title" href="javascript:void(0)"><svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-ecommerce') }}"></use>
                            </svg><svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-ecommerce') }}"></use>
                            </svg><span>Mictomon Shop</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.dashboard') }}">My Dashboard</a></li>

                            <li><a href="{{ route('admin.categories.index') }}">Category</a></li>

                           
                            
                            <li><a href="{{ route('admin.orders.index') }}">Order History</a></li>
                            <li><a href="{{ route('admin.books.index') }}">Books</a></li>
                            <li><a href="{{ route('admin.authors.index') }}">Authors</a></li>
                            <li><a href="{{ route('admin.users.index') }}">Users</a></li>
                   
                        </ul>
                    </li>
                    <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a
                            class="sidebar-link sidebar-title link-nav" href="{{ '#' }}"><svg
                                class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-email') }}"></use>
                            </svg><svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-email') }}"></use>
                            </svg><span>Invoice</span></a>
                            <ul class="sidebar-submenu">
                                <li><a href="{{ route('admin.invoice_1') }}">Invoice Lists</a></li>
                            
                               
                            </ul>
                        </li>
                          
                            
                   
                    <li class="sidebar-list"><label class="badge badge-light-success">New</label><i
                            class="fa-solid fa-thumbtack"></i><a class="sidebar-link sidebar-title"
                            href="javascript:void(0)"><svg class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-reports') }}"></use>
                            </svg><svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-reports') }}"></use>
                            </svg><span>Reports</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.reports.sales') }}">Sales</a></li>
                        </ul>
                    </li>
                    <li class="sidebar-list"><i class="fa-solid fa-thumbtack"></i><a
                        class="sidebar-link sidebar-title" href="javascript:void(0)"><svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-chat') }}"></use>
                        </svg><svg class="fill-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#fill-chat') }}"></use>
                        </svg><span>My profile</span></a>
                        <ul class="sidebar-submenu">
                            <li><a href="{{ route('admin.profile') }}">Go to Profile</a></li>

                      
                        </ul>
                </li>
              
               
            
  
                
                 
                            class="sidebar-link sidebar-title link-nav" href="{{ '#' }}"><svg
                                class="stroke-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-subscribe') }}"></use>
                            </svg><svg class="fill-icon">
                                <use href="{{ asset('assets/svg/icon-sprite.svg#fill-subscribe') }}"></use>
                            </svg><span>Subscribed User</span></a></li>
                   

                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
<!-- Page Sidebar Ends-->
