	  <div class="top-bar">
	      <div class="container p-0">
	          <div class="row align-items-center no-gutters">
	              <div class=" col-md-2">
	                  <div class="logo">
	                      <a href="{{url('/')}}"><img width="130px" src="{{asset('public/frontend/assets/images/logo.png')}}" /></a>
	                  </div>
	              </div>
	              <div class="col-md-10">
	                  <div class="wrap">
	                    <div class="socialicons">
	                      <a href="#" target="_blank" ><i class="fa fa-facebook-f"></i></a>
	                      <a href="#" target="_blank"><i class="fa fa-twitter"></i></a>
	                      <a href="#"><i class="fa fa-linkedin"></i></a>
	                      <a href="#"><i class="fa fa-youtube"></i></a>
	                    </div>
	                    <nav class="main-menu-nav">
	                      <div class="body-overlay"></div>
	                      <div class="menu-toggler"></div>
	                      <div class="main-menu-div">
	                          <div class="menu-header">
	                              <a href="#" class="home-icon"><svg class="icons"><use xlink:href="#homeicon"></use></svg></a>
	                              <span class="close-icon"><svg class="icons"><use xlink:href="#crossbtn"></use></svg></span>
	                          </div>
	                          <ul>
	                          	<?php 
	                      	  		$APIUrl = $wpUrl . 'wp-json/wp/v2/menus/1';
	                      	  		$menus = @json_decode(file_get_contents($APIUrl), TRUE);
	                      	  		if($menus){
		                      	  		foreach($menus as $key => $menu){
											if(isset(Auth::user()->name) && $menu['id'] != '115'){
												$subClass = '';
												if(count($menu['childs']) > 0){
													$subClass = "sub-menu";
												}
												echo "<li class='$subClass' id='". $menu['id'] ."'><a href='". $menu['url'] ."'>". $menu['title'] ."</a>";
												if($menu['childs']){
													echo "<ul>";
													foreach($menu['childs'] as $key2 => $menu2){
														echo "<li><a href='". $menu2['url'] ."'>". $menu2['title'] ."</a></li>";
													}
													echo "</ul>";
												}
												echo "</li>";							
											}
										}
									}
	                          	  ?>
	                              <li><a href="{{url('/')}}">HOME</a></li>
	                              <li><a href="{{url('/')}}">ABOUT US</a></li>
	                              <li><a href="{{url('/')}}">SERVICES</a></li>
	                              <li><a href="{{url('/')}}">CONTACT US</a></li>
	                              <li><a href="javascript:;"> {{ Auth::user()->name }} <i class="fa fa-caret-down" aria-hidden="true"></i></a>
	                                <ul>
	                                  <li><a href="javascript:;" data-toggle="modal" data-target="#editProfile">Profile</a></li>
	                                  <li><a href="{{url('/account')}}">My Account</a></li>
	                                  <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout </a></li>
	                                   <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
	                                        @csrf
	                                    </form>
	                                </ul>
	                              </li>
	                          </ul>
	                      </div>
	                    </nav>
	                  </div>
	              </div>
	          </div>
	      </div>
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
	            
	            <form method="post" action="{{url('update_profile/'.Auth::user()->id)}}" id="form">
	                @csrf
	                <div class="form-group">
	                    <label for="name">Name</label>
	                    <input type="text" class="form-control" name="name" id="name"  value="{{Auth::user()->name}}" required data-parsley-maxlength="10" data-parsley-minlength="4" data-parsley-trigger="change">
	                  </div>
	                <div class="form-group">
	                  <label for="email">Email address</label>
	                  <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" value="{{Auth::user()->email}}" required>
	                </div>
	                
	                <div class="form-group">
	                  <label for="password">Password</label>
	                  <input type="password" class="form-control" name="password" id="password" placeholder="Password" data-parsley-maxlength="16" data-parsley-minlength="8" data-parsley-trigger="change">
	                </div>
	                
	                <button type="submit" class="btn btn-primary float-right">Update</button>
	            </form>
	        </div>
		  	</div>
		</div>
	</div>

