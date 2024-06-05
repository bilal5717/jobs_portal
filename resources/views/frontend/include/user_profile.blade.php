<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12 user_details">
		<div class="row">
			<div class="col-md-2 col-md-12-sm-12 col-xs-12">
				<img src="{{getProfileImage($user->id)}}" >
			</div>
			<div class="col-md-10 col-md-12-sm-12 col-xs-12">
				<div class="col-md-12 col-sm-12 user-detail-section2 pull-left">
					@if(isset($user->name))
					<p><small>Name</small></p>
					<span>{{$user->name}}</span>
					@endif
					@if($user->email)
					<p><small>Email Address</small></p>
					<span>{{$user->email}}</span>
					@endif
					<p><small>Address</small></p>
					@if(isset($userDetail->address))
					<span>{{$userDetail->address}},</span>
					@endif
					@if(isset($userDetail->city) && isset($userDetail->state) && isset($userDetail->zipcode) )
					<span>{{$userDetail->city}}, {{$userDetail->state}}, {{$userDetail->zipcode}}</span>
					@endif
					@if(isset($userDetail->contact))
					<p><small>Contact</small></p>
					<span>{{$userDetail->contact}}</span>
					@endif
					<p><hr /></p>
					<p><a href="{{url('account/1')}}"> <i class="fa fa-pencil"></i> Edit Profile Info</a></p>
				</div>                           
			</div>
		</div>
	</div>
	
</div>