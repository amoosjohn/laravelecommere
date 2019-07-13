<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo (isset($pageTitle))?$pageTitle.' | '.Config('params.site_name'):Config('params.site_name'); ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="title" content="<?php echo (isset($title))?$title:''; ?>">
    <meta name="keywords" content="<?php echo (isset($keyword))?$keyword:''; ?>">
    <meta name="description" content="<?php echo (isset($description))?$description:''; ?>">
	<!--iPhone from zooming form issue (maximum-scale=1, user-scalable=0)-->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0"/>
	<link rel="icon" type="image/png" href="{{ asset('front/images/favicon.ico')}}">	
    <!-- Bootstrap --><!--<link href="{{ asset('front/css/bootstrap.min.css') }}" rel="stylesheet">	
	<link rel="stylesheet" href="{{ asset('front/css/stylized.css') }} ">
	<link rel="stylesheet" href="{{ asset('front/css/colorized.css') }}">
	<link rel="stylesheet" href="{{ asset('front/css/animate.css') }}">
	<link rel="stylesheet" href="{{ asset('front/css/swiper.min.css') }}">
	<link rel="stylesheet" href="{{ asset('front/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/extralized/jquery-ui.css')}}">
	<link rel="stylesheet" href="{{ asset('front/css/ionicons.min.css') }}">
	<link rel="stylesheet" href="{{ asset('front/css/zoom.css') }} ">
	<link rel="stylesheet" href="{{ asset('front/style.css') }} ">
	<link rel="stylesheet" href="{{ asset('front/css/home.css') }} ">
	<link rel="stylesheet" href="{{ asset('front/css/responsive.css') }} ">-->
	<link rel="stylesheet" href="{{ asset('front/css/style.min.css') }} ">
	 <link rel="stylesheet" href="{{ asset('front/extralized/jquery-ui.css')}}">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.8/css/fontawesome.css">	
	<!-- jQuery -->
	<!--[if (!IE)|(gt IE 8)]><!-->
	<script src="{{ asset('front/js/jquery-2.2.4.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('front/js/jquery.lazy.min.js') }}"></script>

	<!--<script src="{{ asset('front/js/angular.min.js') }}"></script>
	<script src="{{ asset('front/extralized/jquery-ui.js')}}"></script>  
	<script src="{{ asset('front/extralized/bootstrap-datepicker.js') }}"></script>
	-->
	<script src="{{ asset('front/js/heads.min.js') }}"></script>
	<!--<![endif]-->    
	<!--DatePicker-->
	<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.16.0/moment.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.9/moment-timezone-with-data-2010-2020.min.js"></script> -->
	<!--script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script-->
	<!--[if lte IE 8]>
	  <script src="js/jquery1.9.1.min.js"></script>
	<![endif]-->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="nav-plusminus product-detail-page">
    <div id="body-wrapper">
         @include('front/common/header')
        <main id="page-content">
            @yield('content')
        </main>
        @include('front/common/footer')
    </div><!--body-wrapper-->
        <a href="" class="scrollToTop"><i class="fa fa-angle-up"></i></a>
        <!--
		<script src="{{asset('front/js/bootstrap.min.js')}}"></script>
		<script src="{{asset('front/js/zoom.js')}}"></script>
        <script src="{{asset('front/js/viewportchecker.js')}}"></script>
        <script src="{{asset('front/js/kodeized.js')}}"></script>
        <script src="{{asset('front/js/customized.js')}}"></script>
		<script src="{{asset('front/js/swiper.jquery.min.js')}}"></script>
		<script src="{{asset('front/js/jquery.nicescroll.min.js')}}"></script>
		<script src="{{asset('front/js/jquery.slider.js')}}"></script>
		<script src="{{asset('front/js/jquery.mousewheel.js')}}"></script>
		<script src="{{asset('front/js/touch.js')}}"></script>
		-->
		<script src="{{asset('front/js/footers.min.js')}}"></script>
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script>
		var swiper1 = new Swiper('.s1', {
			pagination: '.swiper-pagination',
			slidesPerView: '4',
			centeredSlides: false,
			paginationClickable: true,
			nextButton: '.swiper-button-next1',
			prevButton: '.swiper-button-prev1',
			spaceBetween: 30,
			autoplay: 2500,
			autoplayDisableOnInteraction: false,
			breakpoints: {
			1024: {	slidesPerView: 3, spaceBetween: 40 },
			768: { slidesPerView: 3, spaceBetween: 30 },
			640: { slidesPerView: 1, spaceBetween: 20 },
			320: { slidesPerView: 1, spaceBetween: 10 }
			}
		});
			var swiper2 = new Swiper('.s2', {
				pagination: '.swiper-pagination',
				slidesPerView: '4',
				centeredSlides: false,
				paginationClickable: true,
				nextButton: '.swiper-button-next2',
				prevButton: '.swiper-button-prev2',
				spaceBetween: 30,
				autoplay: 2500,
				autoplayDisableOnInteraction: false,
				breakpoints: {
				1024: {	slidesPerView: 3, spaceBetween: 40 },
				768: { slidesPerView: 3, spaceBetween: 30 },
				640: { slidesPerView: 1, spaceBetween: 20 },
				320: { slidesPerView: 1, spaceBetween: 10 }
				}
			});
	$( document ).ready(function() { 
    $("input[type=tel],input[name=fax],#acctNo,#rtNo").keypress(function (event) {
    //if the letter is not digit then display error and don't type anything
    var e = event || evt; // for trans-browser compatibility
    var charCode = e.which || e.keyCode;
    if (charCode == 45)
    {
        return true;
    } else if (charCode > 31 && (charCode < 48 || charCode > 57))
    {
        return false;
    } else
    {
        return true;
    }
    });
   $( "input[name=firstName],input[name=lastName],input[name=contactPerson],input[name=designation]" ).keypress(function(e) {
    var key = e.keyCode;
    var yourInput = $(this).val();
    re = /[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi;
    var isSplChar = re.test(yourInput);

    if (key >= 48 && key <= 57) {
        e.preventDefault();
    }
    else if(isSplChar)
    {
            var no_spl_char = yourInput.replace(/[`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '');
            $(this).val(no_spl_char);
            return false;
            e.preventDefault();
    }
    });  
}); 
 $(function() {
        $('.lazy').lazy();
    });
</script>  
     @include('front/common/javascript')
     @include('front.common.cartjs')
<?php
use App\Content;
$content = Content::getPage('google');
if(count($content)>0)
{
    echo $content->body;
}
?>        
    </body>
</html>