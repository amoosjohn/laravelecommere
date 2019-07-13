<!-- BEGIN HEADER -->
<div class="page-header navbar navbar-fixed-top">
<!-- BEGIN HEADER INNER -->
<div class="page-header-inner ">
<!-- BEGIN LOGO -->
<div class="page-logo">
<a href="{{ url('vendor') }}">
    <img src="{{ asset('front/images/small.png') }}" alt="logo" class="logo-default" /> </a>
<div class="menu-toggler sidebar-toggler">
    <span></span>
</div>
</div>
<!-- END LOGO -->
<!-- BEGIN RESPONSIVE MENU TOGGLER -->
<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
<span></span>
</a>
<!-- END RESPONSIVE MENU TOGGLER -->
<!-- BEGIN TOP NAVIGATION MENU -->
<div class="top-menu">
<ul class="nav navbar-nav pull-right">
  
    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
    <li class="dropdown dropdown-user">
        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
            <img alt="" class="img-circle" src="{{ asset('front/images/small.png') }}" />
            <span class="username username-hide-on-mobile"> {{ Auth::user()->firstName }} </span>
            <i class="fa fa-angle-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-default">
            <li>
                <a href="{{ url('/vendor/view-profile') }}">
                    <i class="icon-user"></i> My Profile </a>
            </li>
            <li class="divider"> </li>
            <li>
                <a href="{{ url('/') }}">
                    <i class="icon-lock"></i> Lock Screen </a>
            </li>
            <li>
             <a href="{{ url('vendor/logout') }}">
                 <i class="icon-key"></i> Log Out </a>

            
                    
            </li>
        </ul>
    </li>
    <!-- END USER LOGIN DROPDOWN -->
    <!-- BEGIN QUICK SIDEBAR TOGGLER -->
    <!-- DOC: Apply "dropdown-dark" class after below "dropdown-extended" to change the dropdown styte -->
    <li class="dropdown dropdown-quick-sidebar-toggler">
        <a href="{{ url('vendor/logout') }}" class="dropdown-toggle">
            <i class="icon-logout"></i>
        </a>
    </li>
    <!-- END QUICK SIDEBAR TOGGLER -->
</ul>
</div>
<!-- END TOP NAVIGATION MENU -->
</div>
<!-- END HEADER INNER -->
</div>
<!-- END HEADER -->
 <!-- BEGIN HEADER & CONTENT DIVIDER -->
<div class="clearfix"></div>
<!-- END HEADER & CONTENT DIVIDER -->
<!-- BEGIN CONTAINER -->