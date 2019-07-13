<?php 
use App\Permissions;
$user_id = Auth::user()->id;
?>
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
                <h3 class="uppercase">Main Navigation </h3>
            </li>
            <li class="nav-item">
                <a href="{{ url('vendor') }}" class="nav-link">
                    <i class="fa fa-dashboard"></i>
                    <span class="title">Dashboard</span>
                </a>
            </li>
            @if(Auth::user()->role_id==3)
            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-tag"></i>
                    <span class="title">My Profile</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{url('vendor/view-profile/')}}" class="nav-link ">
                            <span class="title">View Profile</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{ url('vendor/info_edit',Auth::user()->id) }}" class="nav-link ">
                            <span class="title">Update Profile</span>
                        </a>
                    </li>
                   
                </ul>
            </li>
<!--            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-social-dribbble"></i>
                    <span class="title">Contact Persons</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{url('vendor/all-contacts')}}" class="nav-link ">
                            <span class="title">List of Contacts</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="#" class="nav-link ">
                            <span class="title">Add Contact</span>
                        </a>
                    </li>
                   
                </ul>
            </li>-->
            
            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-users"></i>
                    <span class="title">Users</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{url('vendor/users')}}" class="nav-link ">
                            <span class="title">List  of Users </span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{url('vendor/users/create')}}" class="nav-link ">
                            <span class="title">Add User</span>
                        </a>
                    </li>
                   
                </ul>
            </li>
            @endif
            <?php
            $permission = Permissions::getPermission($user_id,'commission');
            ?>
            @if(Auth::user()->role_id==3 || $permission>0)
            <li class="nav-item ">
                <a href="{{ url('vendor/commission') }}" class="nav-link">
                    <i class="icon-tag"></i>
                    <span class="title">Commission Fees</span>
                </a>
            </li> 
            @endif
            @if(Auth::user()->role_id==4)
            <?php
            $permission = Permissions::getPermission($user_id,'product');
            $permission2 = Permissions::getPermission($user_id,'product_list');
            $permission3 = Permissions::getPermission($user_id,'product_create');
            $permission4 = Permissions::getPermission($user_id,'product_import');
            ?>
            @if($permission>0)
            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-graph"></i>
                    <span class="title">Products</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    @if($permission2>0)
                    <li class="nav-item  ">
                        <a href="{{ url('vendor/products') }}" class="nav-link ">
                            <span class="title">List Products</span>
                        </a>
                    </li>
                    @endif
                    @if($permission3>0)
                    <li class="nav-item  ">
                        <a href="{{ url('vendor/products/create') }}" class="nav-link ">
                            <span class="title">Add Product</span>
                        </a>
                    </li>
                    @endif
                    @if($permission4>0)
                    <li class="nav-item  ">
                        <a href="{{ url('vendor/product/import') }}" class="nav-link ">
                            <span class="title">Import Products</span>
                        </a>
                    </li>
                    @endif
                   
                   
                </ul>
            </li>
            @endif
            @else
            <li class="nav-item">
                <a href="javascript:;" class="nav-link nav-toggle">
                    <i class="icon-graph"></i>
                    <span class="title">Products</span>
                    <span class="arrow"></span>
                </a>
                <ul class="sub-menu">
                    <li class="nav-item  ">
                        <a href="{{ url('vendor/products') }}" class="nav-link ">
                            <span class="title">List Products</span>
                        </a>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{ url('vendor/products/create') }}" class="nav-link ">
                            <span class="title">Add Product</span>
                        </a>
                    </li>
                     <li class="nav-item  ">
                        <a href="{{ url('vendor/product/import') }}" class="nav-link ">
                            <span class="title">Import Products</span>
                        </a>
                    </li>
                   
                </ul>
            </li>
            @endif
<!--            <li class="nav-item ">
                <a href="{{ url('vendor/reviews') }}" class="nav-link">
                    <i class="icon-star"></i>
                    <span class="title">Reviews</span>
                </a>
            </li>-->
            <?php
            $permission = Permissions::getPermission($user_id,'orders');
            ?>
            @if(Auth::user()->role_id==3 || $permission>0)
            <li class="nav-item ">
                <a href="{{ url('vendor/orders') }}" class="nav-link">
                    <i class="icon-basket"></i>
                    <span class="title">Orders</span>
                </a>
            </li>
            @endif
            
            <?php
            $permission = Permissions::getPermission($user_id,'report');
            ?>
            @if(Auth::user()->role_id==3 || $permission>0)
            <li class="nav-item ">
                <a href="{{ url('vendor/report') }}" class="nav-link">
                    <i class="fa fa-pie-chart"></i>
                    <span class="title">Report</span>
                </a>
            </li>
            @endif
        </ul>
           
        <!-- END SIDEBAR MENU -->
    </div>
    <!-- END SIDEBAR -->
</div>
<!-- END SIDEBAR -->
