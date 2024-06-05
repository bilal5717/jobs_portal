<!DOCTYPE html>
<html lang="en">
<!-- begin::Head -->
	<head>
		<!--<base href="../../../../../../">-->
		<meta charset="utf-8" />
		<title>Jobs Portal | Admin Panel</title>
		<meta name="description" content="H2O Admin Panel">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link href='{{asset('public/favicon.ico')}}' rel='shortcut icon' type='image/x-icon' />
		<!--begin::Fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

		<!--end::Fonts -->
		<link rel="stylesheet" href="{{asset('public/css/parsley.css')}}">
		<!--begin::Page Vendors Styles(used by this page) -->

		<!--end::Page Vendors Styles -->

		<!--begin::Global Theme Styles(used by all pages) -->
		<link href="{{asset('public/assets/plugins/global/plugins.bundle.css?v=2.0.0')}}" rel="stylesheet" type="text/css" />
		<link href="{{asset('public/assets/css/style.bundle.css?v=2.0.0')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles -->

		<!--begin::Layout Skins(used by all pages) -->
		<link href="{{asset('public/assets/css/skins/header/base/light.css')}}" rel="stylesheet" type="text/css" />
		<!--<link href="{{asset('public/assets/css/skins/header/base/dark.css')}}" rel="stylesheet" type="text/css" />-->
		<!--<link href="{{asset('public/assets/css/skins/header/menu/light.css')}}" rel="stylesheet" type="text/css" />-->
		<link href="{{asset('public/assets/css/skins/header/menu/dark.css')}}" rel="stylesheet" type="text/css" />
		<!--<link href="{{asset('public/assets/css/skins/brand/light.css')}}" rel="stylesheet" type="text/css" />-->
		<link href="{{asset('public/assets/css/skins/brand/dark.css')}}" rel="stylesheet" type="text/css" />
		<!--<link href="{{asset('public/assets/css/skins/aside/light.css')}}" rel="stylesheet" type="text/css" />-->
		<link href="{{asset('public/assets/css/skins/aside/dark.css')}}" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="{{asset('public/plugins/custom/jquery-ui-1-12/jquery-ui.min.css')}}">
		<link rel="stylesheet" href="{{asset('public/plugins/custom/jquery-ui-timepicker/jquery.ui.timepicker.css')}}">
		<!--end::Layout Skins -->
		<link rel="shortcut icon" href="{{asset('public/media/logos/logo.png')}}" />
		<!--<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />-->
    
		@toastr_css
		<style>
			.select2-container {
				width:465px !important;
			}
			h5,h4,h3, h2, h1{
				color: #2778c1 !important;
			}
		</style>
		@yield('styles')
		<script>
			var KTAppOptions = {
				"colors": {
					"state": {
						"brand": "#5d78ff",
						"dark": "#282a3c",
						"light": "#ffffff",
						"primary": "#5867dd",
						"success": "#34bfa3",
						"info": "#36a3f7",
						"warning": "#ffb822",
						"danger": "#fd3995"
					},
					"base": {
						"label": [
							"#c5cbe3",
							"#a1a8c3",
							"#3d4465",
							"#3e4466"
						],
						"shape": [
							"#f0f3ff",
							"#d9dffa",
							"#afb4d4",
							"#646c9a"
						]
					}
				}
			};
		</script>
	</head>
	<!--kt-aside--minimize-->
<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">
		<!-- begin:: Page -->

		<!-- begin:: Header Mobile -->
		<div id="kt_header_mobile" class="kt-header-mobile  kt-header-mobile--fixed ">
			<div class="kt-header-mobile__logo">
				<a href="{{config('app.wp_url', '/')}}">
					<!--<img alt="Logo" src="../assets/media/logos/logo-dark.png" />-->
					<img alt="Logo" src="{{asset('public/frontend/assets/images/logo.png')}}" style="width: 68px;" />
				</a>
			</div>
			<div class="kt-header-mobile__toolbar">
				<button class="kt-header-mobile__toggler kt-header-mobile__toggler--left" id="kt_aside_mobile_toggler"><span></span></button>
				<button class="kt-header-mobile__toggler" id="kt_header_mobile_toggler"><span></span></button>
				<button class="kt-header-mobile__topbar-toggler" id="kt_header_mobile_topbar_toggler"><i class="flaticon-more"></i></button>
			</div>
		</div>

		<!-- end:: Header Mobile -->
		<div class="kt-grid kt-grid--hor kt-grid--root">
			<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--ver kt-page">
				<!-- begin:: Aside -->
				
				@include('admin.common.aside')
                @include('admin.common.header-menu')
			
			</div>
		</div>
			<!-- begin:: Footer -->
			<div class="kt-footer  kt-grid__item kt-grid kt-grid--desktop kt-grid--ver-desktop" id="kt_footer">
				<div class="kt-container  kt-container--fluid justify-content-center">
					<div class="kt-footer__copyright text-center">
						@2020 
					</div>
					<div class="kt-footer__menu">
						{{--  <a href="http://keenthemes.com/metronic" target="_blank" class="kt-footer__menu-link kt-link">About</a>
						<a href="http://keenthemes.com/metronic" target="_blank" class="kt-footer__menu-link kt-link">Team</a>
						<a href="http://keenthemes.com/metronic" target="_blank" class="kt-footer__menu-link kt-link">Contact</a>  --}}
					</div>
				</div>
			</div>
		<!-- begin::Scrolltop -->
		<div id="kt_scrolltop" class="kt-scrolltop">
			<i class="fa fa-arrow-up"></i>
		</div>
		
		<!--begin::Global Theme Bundle(used by all pages) -->
		<script src="{{asset('public/assets/plugins/global/plugins.bundle.js')}}" type="text/javascript"></script>
		<script src="{{asset('public/assets/js/scripts.bundle.js')}}" type="text/javascript"></script>
		
        <script src="{{asset('public/assets/js/pages/dashboard.js')}}" type="text/javascript"></script>
        <!--<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js" defer></script>-->
        <script src="{{asset('public/js/parsley.min.js')}}"></script>
		<script>
			$('#form').parsley();
			
		</script>
		@yield('script')
		@jquery
		@toastr_js
		@toastr_render
		
		<script src="{{asset('public/plugins/custom/jquery-ui-1-12/jquery-ui.min.js')}}"></script>
    	<script src="{{asset('public/plugins/custom/jquery-ui-timepicker/jquery.ui.timepicker.js')}}"></script>
    	<script src="{{asset('public/js/bootstrap.bundle.min.js')}}"></script>
	</body>
</html>