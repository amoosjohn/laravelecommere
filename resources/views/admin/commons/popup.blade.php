<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin {{Config::get('params.site_name')}} | Dashboard</title>
  <link rel="icon" type="image/png" href="{{ asset('../frontend/images/favicon.png') }}">
  <!-- Tell the browser to be responsive to screen width -->
 
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />        
    <link rel="icon" type="image/png" href="{{asset('front/images/virtualMart.jpg')}}">
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admins/assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admins/assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admins/assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admins/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }} rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
     <link href="{{ asset('admins/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admins/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admins/assets/global/plugins/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admins/assets/global/plugins/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="{{ asset('admins/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ asset('admins/assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ asset('admins/assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{ asset('admins/assets/layouts/layout/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admins/assets/layouts/layout/css/custom.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{ asset('admins/assets/global/plugins/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css') }}">
    <script src="{{ asset('admins/assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('admins/assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('admins/assets/jquery.form.js') }}"></script>
    
   <body class="page-header-fixed page-content-white">
         <div class="page-wrapper">
            <!-- Content Wrapper. Contains page content -->
           <div class="page-container">

                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                  <div class="page-content">
                    <!-- Your Page Content Here -->
                    @yield('content')
                   <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
                </div>  
               </div>    
                <!-- /.content -->
                
           </div>
         
    </body>
    
</html>