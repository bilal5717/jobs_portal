<div class="row">
	<div class="col-md-3 col-md-12-sm-12 col-xs-12" style="padding: 10px;border-right: 2px solid #e6e0e0;">
		<img src="{{getProfileImage($user->id)}}" width="200" style="max-width: 180px;max-height: 180px;">
	</div>
	<div class="col-md-8 col-sm-12 col-xs-12">
		<div class="col-md-6 col-sm-12 user-detail-section2 pull-left">
			@if(isset($user->name))
			<p>
				<div><strong>Name</strong></div>
				<div>{{$user->name}}</div>
			</p>
			@endif
			@if($user->email)
			<p>
				<div><strong>Email Address</strong></div>
				<div>{{$user->email}}</div>
			</p>
			@endif
			<p>
				<div><strong>Address</strong></div>
				@if(isset($userDetail->address))
				<div>{{$userDetail->address}},</div>
				@endif
				@if(isset($userDetail->city) && isset($userDetail->state) && isset($userDetail->zipcode) )
				<div>{{$userDetail->city}}, {{$userDetail->state}}, {{$userDetail->zipcode}}</div>
				@endif
			</p>
		</div>
		<div class="col-md-6 col-sm-12 user-detail-section2 pull-left">
			@if(isset($userDetail->contact))
			<p>
				<div><strong>Contact</strong></div>
				<div>{{$userDetail->contact}}</div>
			</p>
			@endif
			@if($user->created_at)
			<p>
				<div><strong>Registration Date</strong></div>
				<div>{{date('M d, Y', strtotime($user->created_at))}}</div>
			</p>
			@endif
			@if($user->updated_at)
			<p>
				<div><strong>Last updated</strong></div>
				<div>{{date('D: M d, Y', strtotime($user->updated_at))}}</div>
			</p>
			@endif
		</div>

	</div>
	@if(Route::currentRouteName() != 'admin.user.show')
	<div class="col-md-12">
		<p><hr /></p>
		<p><a href="{{route('admin.user.show', ["user" => $user->id])}}"> <i class="fa fa-pencil"></i> View full profile</a></p>		
	</div>
	@endif
	
</div>