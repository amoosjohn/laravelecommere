<div class="page-sidebar-wrapper">
    <!-- BEGIN SIDEBAR -->
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
   
        <ul class="page-sidebar-menu  page-header-fixed sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 20px">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <li class="sidebar-toggler-wrapper hide">
                <div class="sidebar-toggler">
                    <span></span>
                </div>
            </li>
            <!-- END SIDEBAR TOGGLER BUTTON -->
            <li class="heading">
                <h3 class="uppercase">Main Navigation</h3>
            </li>
            <li class="nav-item ">
                <a href="{{ url('admin/dashboard') }}" class="nav-link">
                    <i class="fa fa-dashboard"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            @if(Auth::user()->role_id!=2)
            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-user-secret"></i>
                    <span class="title">Admin Users</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{ url('admin/users') }}" class="nav-link ">
                            <span class="title">List Users</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{ url('admin/users/create') }}" class="nav-link ">
                            <span class="title">Add User</span>
                        </a>
                    </li>
                   
                </ul>
            </li>
            @endif
            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-user-plus"></i>
                    <span class="title">Vendors</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{ url('admin/vendors') }}" class="nav-link ">
                            <span class="title">List  of Vendors</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{ url('admin/vendor/create') }}" class="nav-link ">
                            <span class="title">Add Vendor</span>
                        </a>
                    </li>
                   
                </ul>
            </li>
            <li class="nav-item ">
                <a href="{{ url('admin/customers') }}" class="nav-link">
                    <i class="icon-users"></i>
                    <span class="title">Customers</span>
                </a>
            </li> 
            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-home"></i>
                    <span class="title">Home Page</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{ url('admin/slider') }}" class="nav-link ">
                            <span class="title">Slider</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{ url('admin/sections') }}" class="nav-link ">
                            <span class="title">Sections</span>
                        </a>
                    </li>
                    
                </ul>
            </li>
            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-layers"></i>
                    <span class="title">Content</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{ url('admin/content?type=page') }}" class="nav-link ">
                            <span class="title">Pages</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{ url('admin/content?type=email') }}" class="nav-link ">
                            <span class="title">Emails</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{ url('admin/content?type=social') }}" class="nav-link ">
                            <span class="title">Social</span>
                        </a>
                    </li>
<!--                    <li class="nav-item  ">
                        <a href="{{ url('admin/content/create') }}" class="nav-link ">
                            <span class="title">Add Content</span>
                        </a>
                    </li>-->

                </ul>
            </li>
            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-tag"></i>
                    <span class="title">Categories</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{ url('admin/categories') }}" class="nav-link ">
                            <span class="title">List Categories</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{ url('admin/categories/create') }}" class="nav-link ">
                            <span class="title">Add Category</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{ url('admin/commission') }}" class="nav-link ">
                            <span class="title">Commission Fee</span>
                        </a>
                    </li>
                   
                </ul>
            </li>
            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-social-dribbble"></i>
                    <span class="title">Brands</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{ url('admin/brands') }}" class="nav-link ">
                            <span class="title">List Brands</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{ url('admin/brands/create') }}" class="nav-link ">
                            <span class="title">Add Brand</span>
                        </a>
                    </li>
                   
                </ul>
            </li>
            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-pencil"></i>
                    <span class="title">Colours</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{ url('admin/colours') }}" class="nav-link ">
                            <span class="title">List Colours</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{ url('admin/colours/create') }}" class="nav-link ">
                            <span class="title">Add Colour</span>
                        </a>
                    </li>
                   
                </ul>
            </li>
           <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-arrows"></i>
                    <span class="title">Size</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{ url('admin/size') }}" class="nav-link ">
                            <span class="title">List Size</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{ url('admin/size/create') }}" class="nav-link ">
                            <span class="title">Add Size</span>
                        </a>
                    </li>
                   
                </ul>
            </li>
            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-graph"></i>
                    <span class="title">Products</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{ url('admin/products') }}" class="nav-link ">
                            <span class="title">List Products</span>
                        </a>
                    </li>
                   
                </ul>
            </li>
            <li class="nav-item ">
                <a href="{{ url('admin/orders') }}" class="nav-link">
                    <i class="icon-basket"></i>
                    <span class="title">Orders</span>
                </a>
            </li> 
            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-tags"></i>
                    <span class="title">Discount Coupons</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{ url('admin/coupons') }}" class="nav-link ">
                            <span class="title">List Coupons</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{ url('admin/coupons/create') }}" class="nav-link ">
                            <span class="title">Add Coupon</span>
                        </a>
                    </li>
                   
                </ul>
            </li>
            <li class="nav-item ">
                <a href="{{ url('admin/reviews') }}" class="nav-link">
                    <i class="icon-star"></i>
                    <span class="title">Reviews</span>
                </a>
            </li>
            <li class="nav-item ">
                <a href="{{ url('admin/newsletter') }}" class="nav-link">
                    <i class="fa fa-envelope"></i>
                    <span class="title">Newsletter</span>
                </a>
            </li>
            <li class="nav-item ">
                <a href="{{ url('admin/complaint') }}" class="nav-link">
                    <i class="fa fa-paper-plane"></i>
                    <span class="title">Complaint</span>
                </a>
            </li>
            <li class="nav-item ">
                <a href="{{ url('admin/content/google') }}" class="nav-link">
                    <i class="fa fa-google"></i>
                    <span class="title">Google Analytics</span>
                </a>
            </li>
             <li class="nav-item ">
                <a href="{{ url('admin/content/shipping-rates') }}" class="nav-link">
                    <i class="fa fa-ship"></i>
                    <span class="title">Shipping Rates</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="fa fa-tags"></i>
                    <span class="title">Payments</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{ url('admin/payments') }}" class="nav-link ">
                            <span class="title">List Payments</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{ url('admin/payments/create') }}" class="nav-link ">
                            <span class="title">Add Payment</span>
                        </a>
                    </li>
                   
                </ul>
            </li>
            <li class="nav-item ">
                <a href="{{ url('admin/report') }}" class="nav-link">
                    <i class="fa fa-pie-chart"></i>
                    <span class="title">Report</span>
                </a>
            </li>
        </ul>
           
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->