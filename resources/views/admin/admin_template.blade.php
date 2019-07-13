<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
    <head>
        <meta charset="utf-8">
        <title>{{Config::get('params.site_name')}}</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
        <link href="{{ asset('admins/assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admins/assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admins/assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admins/assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admins/assets/global/plugins/fancybox/source/jquery.fancybox.css') }}" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{ asset('admins/assets/global/plugins/morris/morris.css') }}" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{ asset('admins/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{ asset('admins/assets/global/plugins/icheck/skins/all.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{ asset('admins/assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{ asset('admins/assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="{{ asset('admins/assets/layouts/layout/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('admins/assets/layouts/layout/css/themes/darkblue.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
        <link href="{{ asset('admins/assets/layouts/layout/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{ asset('front/css/admin-style.css') }}" />

        <link rel="stylesheet" href="{{ asset('admins/assets/global/plugins/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css') }}">
        <script src="{{ asset('admins/assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>    
        <script src="{{ asset('admins/assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
        
        <style>
            form.delete {
                display: inline-block;
            }
            .form-inline {
                display: inline-block;
            }
        </style>
    </head>
    <body class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">
         <div class="page-wrapper">


            <!-- Header -->
            @include('admin/commons/header')
           <!-- BEGIN CONTAINER -->
            <div class="page-container">
            <!-- Sidebar -->
            
            @include('admin/commons/sidebar')
            <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">
            <!-- Content Wrapper. Contains page content -->
            
            
               
                    <!-- Your Page Content Here -->
                    @yield('content')
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->
               </div>    
                <!-- /.content -->
                
           </div>
            <!-- /.content-wrapper -->
            <!-- Footer -->
            @include('admin/commons/footer')
        </div>     
        <div class="quick-nav-overlay"></div>
        <!-- BEGIN CORE PLUGINS -->

        <script src="{{ asset('admins/assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admins/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admins/assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admins/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        	
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{ asset('admins/assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admins/assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admins/assets/global/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admins/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admins/assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admins/assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admins/assets/global/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admins/assets/global/plugins/fancybox/source/jquery.fancybox.pack.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admins/assets/global/plugins/plupload/js/plupload.full.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admins/assets/global/plugins/counterup/jquery.waypoints.min.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{ asset('admins/assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admins/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
        
  
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{ asset('admins/assets/pages/scripts/ecommerce-products-edit.min.js') }}" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{ asset('admins/assets/global/plugins/ckeditor/ckeditor.js') }}" type="text/javascript"></script>
<!--        <script src="{{ asset('admins/assets/global/plugins/ckeditor/samples/js/sample.js') }}" type="text/javascript"></script>-->
        <script src="{{ asset('admins/assets/layouts/layout/scripts/layout.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admins/assets/layouts/layout/scripts/demo.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admins/assets/layouts/global/scripts/quick-sidebar.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admins/assets/layouts/global/scripts/quick-nav.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('admins/assets/pages/scripts/form-icheck.min.js') }}" type="text/javascript"></script>
         <script src="{{ asset('admins/assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
        
         <script>
             $(document).ready(function()
             {
                 $('#clickmewow').click(function()
                 {
                     $('#radio1003').attr('checked', 'checked');
                 });
             })
      
    $(document).ready(function () {
                 var url = window.location;
                 $('.sidebar-menu a[href="' + url + '"]').parents('li').addClass('active open');
                 $('.sidebar-menu a[href="' + url + '"]').parent().addClass('open');

                 $('.sidebar-menu a[href="' + url + '"]').closest('.nav-item').addClass('active');

                 $('.sidebar-menu a[href="' + url + '"]').closest('.sub-menu').css("display", "block");



                 $('.sidebar-menu a').filter(function () {
                     return this.href === url;
                 }).parent().addClass('active');


             });        
     $('#confirm-delete').on('show.bs.modal', function (e) {
         $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
     });
     $('#confirm-status').on('show.bs.modal', function (e) {
         $(this).find('.btn-status').attr('href', $(e.relatedTarget).data('href'));
     });
     function readURL(input) {
         if (input.files && input.files[0]) {
             var reader = new FileReader();
            
             reader.onload = function (e) {
                 $('#imagePreview').attr('src', e.target.result);
             }
            
             reader.readAsDataURL(input.files[0]);
         }
     }
    
     $("body").on("change","#logo",function(){
         readURL(this);
     });

     $(".delete").on("submit", function(){
         $("#confirm-delete").modal("show");
         return false;
     });
     $("#btn-ok").on("click", function(){
        document.getElementById("delete").submit();
        return false;
     });
     $('table[data-form="deleteForm"]').on('click', '.form-delete', function(e){
     e.preventDefault();
     var $form=$(this);
     $('#confirm').modal({ backdrop: 'static', keyboard: false })
         .on('click', '#delete-btn', function(){
             $form.submit();
         });
 });
    

 $(document).ready(function(){
    $('a[data-toggle="tab"]').click(function (e) {
     e.preventDefault();
     $(this).tab('show');
 });

 $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
     var id = $(e.target).attr("href");
     localStorage.setItem('selectedTab', id)
 });

 var selectedTab = localStorage.getItem('selectedTab');
 if (selectedTab != null) {
     $('a[data-toggle="tab"][href="' + selectedTab + '"]').tab('show');
 }
 });

    CKEDITOR.replace( 'editor', {
     filebrowserBrowseUrl : '<?php echo url('') ?>/uploads/kcfinder/browse.php?opener=ckeditor&type=files',
     filebrowserImageBrowseUrl : '<?php echo url('') ?>/uploads/kcfinder/browse.php?opener=ckeditor&type=images',
     filebrowserFlashBrowseUrl : '<?php echo url('') ?>/uploads/kcfinder/browse.php?opener=ckeditor&type=flash',
     filebrowserUploadUrl : '<?php echo url('') ?>/uploads/kcfinder/upload.php?opener=ckeditor&type=files',
     filebrowserImageUploadUrl :'<?php echo url('') ?>/uploads/kcfinder/upload.php?opener=ckeditor&type=images',
     filebrowserFlashUploadUrl : '<?php echo url('') ?>/uploads/kcfinder/upload.php?opener=ckeditor&type=flash'
    } );
         </script>
  
    </body>
</html>
