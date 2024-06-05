<?php
	//if(isset($_GET['test'])){
		//dd(Auth::guard('admin')->user()->user_role);
	//}
 ?>

<div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor kt-wrapper" style="padding-top: 50px;" id="kt_wrapper">
    <div id="kt_header" class="kt-header kt-grid__item  kt-header--fixed ">
        <button class="kt-header-menu-wrapper-close" id="kt_header_menu_mobile_close_btn"><i class="la la-close"></i></button>
            <div class="kt-header-menu-wrapper" id="kt_header_menu_wrapper">
        </div>
        
		<!-- begin:: Header Topbar -->
		<div class="kt-header__topbar">
		<!--begin: User Bar -->
			<div class="kt-header__topbar-item kt-header__topbar-item--user">
				<div class="kt-header__topbar-wrapper" data-toggle="dropdown" data-offset="0px,0px" onclick="jQuery('#head-menu').toggle();">
					<div class="kt-header__topbar-user">
						<span class="kt-header__topbar-welcome kt-hidden-mobile">Hi,</span>
						<span class="kt-header__topbar-username kt-hidden-mobile" style="text-transform: capitalize;">{{Auth::guard('admin')->user()->name}}</span>
						{{--  <img class="kt-hidden" alt="Pic" src="assets/media/users/300_25.jpg" />  --}}
						<span class="kt-badge kt-badge--username kt-badge--unified-success kt-badge--lg kt-badge--rounded kt-badge--bold"  style="text-transform: capitalize;letter-spacing: -2px;">
							@php
								$nameParts = explode(" ", Auth::guard('admin')->user()->name);
							@endphp
							@foreach($nameParts as $part)
								{{@substr($part, 0, 1)}}
							@endforeach
						</span>
					</div>
				</div>
				<div id="head-menu" class="dropdown dropdown-menu dropdown-menu-fit dropdown-menu-right dropdown-menu-anim dropdown-menu-top-unround dropdown-menu-xl">
							
					<div class="kt-notification">
						<ul class="kt-nav kt-margin-t-10 kt-margin-b-10">
							    <li class="kt-nav__item kt-nav__item--active">
							        <a href="javascript:;" data-toggle="modal" data-target="#editProfile" class="kt-nav__link">
							            <span class="kt-nav__link-icon"><i class="flaticon2-gear"></i></span>
							            <span class="kt-nav__link-text">Settings</span>
							        </a>
							    </li>
							    <li class="kt-nav__item">
							        <a href="{{ route('admin.logout') }}"  class="kt-nav__link">
							            <span class="kt-nav__link-icon"><i class="flaticon-logout"></i></span>
							            <span class="kt-nav__link-text">Logout</span>
							        </a>
							        
							    </li>
							</ul>
						<!--
						<div class="kt-notification__custom kt-space-between">
							
							<a  href="" class="btn btn-label btn-label-brand btn-block btn-bold">Admin Profile</a>
							<a  href="{{ route('logout') }}"
							onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-label btn-label-brand btn-block btn-bold">Sign Out</a>
							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
								@csrf
							</form>
							
						</div>
						-->
					</div>
				</div>
			</div>
		</div>
		<!-- end:: Header Topbar -->

	</div>
	

<!--Edit Profile Popup-->
	<div class="modal fade" id="editProfile" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	    <div class="modal-dialog">
	      <div class="modal-content">
	        <div class="modal-header">
	          <h5 class="modal-title" id="staticBackdropLabel">Profile Settings</h5>
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span>
	          </button>
	        </div>
	        <div class="modal-body">
				@if ($errors->any())
	                <div class="alert alert-danger">
	                    <ul>
	                        @foreach ($errors->all() as $error)
	                            <li>{{ $error }}</li>
	                        @endforeach
	                    </ul>
	                </div>
	            @endif
	            
	            <form method="post" action="{{url('app-admin/update_profile/'.Auth::guard('admin')->user()->id)}}" id="form">
	                @csrf
	                <div class="form-group">
	                    <label for="name">Name</label>
	                    <input type="text" class="form-control" name="name" id="name"  value="{{Auth::guard('admin')->user()->name}}" required data-parsley-maxlength="10" data-parsley-minlength="4" data-parsley-trigger="change">
	                  </div>
	                <div class="form-group">
	                  <label for="email">Email address</label>
	                  <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" value="{{Auth::guard('admin')->user()->email}}" required>
	                </div>
	                
	                <div class="form-group">
	                  <label for="password">Password</label>
	                  <input type="password" class="form-control" name="password" id="password" placeholder="Password" data-parsley-maxlength="16" data-parsley-minlength="8" data-parsley-trigger="change">
	                </div>
	                
	                <button type="submit" class="btn btn-primary float-right">Update</button>
	            </form>
	        </div>
	        {{-- <div class="modal-footer">--}}
	            
	            {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
	          {{-- <button type="button" class="btn btn-primary">Understood</button> --}}
	        {{-- </div>  --}}
		  	</div>
		</div>
	</div>


	<!-- end:: Header -->
	<div class="kt-content  kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" id="kt_content">
		<!-- begin:: Content -->
		<div class="kt-container  kt-container--fluid  kt-grid__item kt-grid__item--fluid">
			<div class="row">
			
				@yield('content')

			</div>
		</div>
		<!-- end:: Content -->
	</div>


</div>