@extends('frontend.include.index')

@section('styles')
<style>
	.savedImagePreview{
		border: 3px solid #d7dbdf;
	    padding: 10px;
	    width: 223px;
	}
	.file-default-preview{
		width: 210px;
		height: 210px;
		overflow: hidden;
		border: 2px solid gray;
		padding: 10px;
	}
	.fileinput-upload-button{
		width: 214px;
		margin-top: 5px;
	}
	hr{
		height: 2px;
		background: #2778c1;
	}
</style>
@endsection
@php
if($user->image && file_exists(public_path(). '/user_images/' . $user->id . '/' . $user->image)){
	$imagePath = asset('public/user_images/' . $user->id . '/' . $user->image);
}else{
	$imagePath = asset('public/frontend/assets/images/default.jpg');
}
@endphp
@section('content')
	<div class="container-fluid" id="grad1">
	    <div class="row justify-content-center mt-0">
	        <div class="col-11 col-sm-9 col-md-7 col-lg-12 text-center p-0 mt-3 mb-2">
	            <div class="card px-0 pt-4 pb-0 mt-3 mb-3">
	                <h2><strong>Sign Up Your User Account</strong></h2>
	                <p>Fill all form field to go to next step</p>
	                <div class="row">
	                    <div class="col-md-12 mx-0">
	                    	<!--@if ($errors->any())
				                <div class="alert alert-danger">
				                    <ul>
				                        @foreach ($errors->all() as $error)
				                            <li>{{ $error }}</li>
				                        @endforeach
				                    </ul>
				                </div>
				            @endif-->
				            
				            @php
				            foreach($errors->all() as $error){
								toastr()->error($error);
							}
				            @endphp
	                        <form id="msform" method="post" action="{{url('account')}}" enctype="multipart/form-data">
	                            @csrf()
	                            <!-- progressbar -->
	                            <ul id="progressbar">
	                                <a href="{{url('account/1')}}"><li class="{{($step >= 1 || $step <= $savedStep ? 'active':'')}}" id="account"><strong>Account</strong></li></a>
	                                <a href="{{url('account/2')}}"><li class="{{($step >= 2 || $step <= $savedStep ? 'active':'')}}" id="payment"><strong>Job</strong></li></a>
	                                <a href="{{url('account/3')}}"><li class="{{($step >= 3 || $step <= $savedStep ? 'active':'')}}" id="personal"><strong>Personal</strong></li></a>
	                                <a href="{{url('account/4')}}"><li class="{{($step >= 4 || $step <= $savedStep ? 'active':'')}}" id="confirm"><strong>Awaiting Approval</strong></li></a>
	                            </ul> <!-- fieldsets -->
	                            <input type="hidden" name="user_id" value="{{Auth::user()->id}}"/>
	                            @if($step == 1)
	                            <fieldset>
	                                <div class="form-card">
	                                    <h2 class="fs-title ">Account Information</h2> 
	                                    <div class="row mb10">
	                                    	<div class="col-sm-12 col-md-6">
	                                    		<div class="savedImagePreview">
	                                    			<img id="previewImg" src="{{$imagePath}}" style="width: 200px; height:200px;" alt="profile image" />
	                                    		</div>
	                                    		<button class="btn btn-primary mt10" style="width: 223px;"id="slectNewImage" id="slectNewImage">Upload New Image</button>
	                                    		
	                                    	</div>
	                                    	
                                	        <div class="col-sm-12 col-md-6  imageUploadKrajee" style="display: none;">
									            <input name="image" id="imageField" type="hidden" value="{{$user->image}}" required>
									            <div class="kv-avatar">
									                <div class="file-loading">
									                    <input id="avatar-1" name="avatar" type="file" accept="image/jpg, image/jpeg, image/png, image/bmp" value="" required style="display:none;">
									                </div>
									            </div>
									            <div class="kv-avatar-hint">
									                <small>Select file < 1500 KB</small>
									            </div>
									        </div>
	                                    </div>
	                                    
	                                    <div class="form-group">
						                    <label for="name">Name</label>
						                    <input type="text" class="form-control" name="name" id="name"  value="{{Auth::user()->name}}" required data-parsley-maxlength="10" data-parsley-minlength="4" data-parsley-trigger="change">
						                </div>
						                
	                                    <div class="form-group">
						                  <label for="email">Email address</label>
						                  <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp" value="{{Auth::user()->email}}" required>
						                </div>
	                                </div>
	                                <input type="hidden" name="step" value="1"/>
	                                <a type="button" href="{{url('account/2')}}" class="previous action-button-previous" ><i class='fa fa-arrow-right'></i></a>
	                                <button type="submit" onclick="$('#avatar-1').removeAttr('required');"  class="next action-button">Save</button>
	                            </fieldset>
								@elseif($step == 2)
	                            <fieldset>
	                                <div class="form-card">
	                                    <div class="col-md-12 mb10">
	                                    	<h4>Apply Job</h4>
	                                    	<hr />
	                                    </div>
	                                    
	                                    <div class="radio-group">
						                  	<label for="license_number">Select Job Type.<sup>*</sup></label><br />
											<input class='radio job_type  ' {{isset($userJobDetail->job_type) && $userJobDetail->job_type == 'security' ? 'checked="checked"' : ''}} type="radio"  name="job_type" id="job_type1" value="security" required /> <label for="job_type1">Security</label> &nbsp;&nbsp; 
							                <input class='radio job_type ' {{isset($userJobDetail->job_type) && $userJobDetail->job_type == 'cleaning' ? 'checked="checked"' : ''}} type="radio" name="job_type" id="job_type2" value="cleaning" required /> <label for="job_type2">Cleaning</label> &nbsp;&nbsp; 
							                <input class='radio job_type ' {{isset($userJobDetail->job_type) && $userJobDetail->job_type == 'traffic_controller' ? 'checked="checked"' : ''}} type="radio" name="job_type" id="job_type3"  value="traffic_controller" required /> <label for="job_type3">Traffic Controller</label> 
						                </div>
		                                    <div id="jobFields" style="display: {{isset($userJobDetail->job_type) && ($userJobDetail->job_type == 'security' || $userJobDetail->job_type == 'traffic_controller') ? 'block':'none' }};">
		                                    	<div class="row">
		                                    		<div class="col-md-6 col-sm-12">
					                                    <div class="form-group">
										                  <label for="license_name">License Name:<sup>*</sup></label>
										                  <input type="text" class="form-control" name="license_name" id="license_name" value="{{isset($userJobDetail->license_name) ? $userJobDetail->license_name : Request::get('license_name')}}">
										                </div>
									                </div>
									                
									                <div class="col-md-6 col-sm-12">
					                                    <div class="form-group">
										                  <label for="license_number">License No.<sup>*</sup></label>
										                  <input type="text" class="form-control" name="license_number" id="license_number" value="{{isset($userJobDetail->license_number) ? $userJobDetail->license_number : Request::get('license_number')}}">
										                </div>
									                </div>
									                <div class="col-md-4 col-sm-12">
					                                    <div class="form-group">
										                  <label for="clases">Class(es):<sup>*</sup></label>
										                  <!--<input type="text" class="form-control" name="clases" id="clases" value="{{isset($userJobDetail->clases) ? $userJobDetail->clases : Request::get('clases')}}">-->
										                  
										                  @php
										                  $selected = array();
										                  if($userJobDetail && isset($userJobDetail->clases)){
										                  		$selected = json_decode($userJobDetail->clases); 
														  }
										                  @endphp
										                  <select class="form-control" name="clases[]" id="clases" multiple>
										                  		<option value="1A" <?php echo (in_array("1A", $selected))? "selected":""; ?>>1A</option>
																<option value="1B" <?php echo (in_array("1B", $selected))? "selected":""; ?>>1B</option>
																<option value="1C" <?php echo (in_array("1C", $selected))? "selected":""; ?>>1C</option>
																<option value="1D" <?php echo (in_array("1D", $selected))? "selected":""; ?>>1D</option>
																<option value="1F" <?php echo (in_array("1F", $selected))? "selected":""; ?>>1F</option>
																<option value="2A" <?php echo (in_array("2A", $selected))? "selected":""; ?>>2A</option>
																<option value="2B" <?php echo (in_array("2B", $selected))? "selected":""; ?>>2B</option>
																<option value="2C" <?php echo (in_array("2C", $selected))? "selected":""; ?>>2C</option>
																<option value="2D" <?php echo (in_array("2D", $selected))? "selected":""; ?>>2D</option>
										                  </select>
										                </div>
									                </div>
									                <div class="col-md-4 col-sm-12">
									                	@php
										                  $selectedOption = '';
										                  if(isset($userJobDetail->license_state)){
										                  	$selectedOption = $userJobDetail->license_state;
														  }
										                @endphp
					                                    <div class="form-group">
										                  <label for="license_state">State:<sup>*</sup></label>
										                  <!--<input type="text" class="form-control" name="license_state" id="clases" value="{{isset($userJobDetail->license_state) ? $userJobDetail->license_state : Request::get('license_state')}}">-->
										                  <select class="form-control" name="license_state" id="state">
										                  		<option value="New South Wales" <?php echo ("New South Wales" == $selectedOption)? "selected":""; ?>>New Southwales</option>
										                  		<option value="Victoria" <?php echo ("Victoria" == $selectedOption)? "selected":""; ?>>Victoria</option>
										                  		<option value="Queens Land" <?php echo ("Queens Land" == $selectedOption)? "selected":""; ?>>Queens Land</option>
										                  		<option value="Tasmania" <?php echo ("Tasmania" == $selectedOption)? "selected":""; ?>>Tasmania</option>
										                  		<option value="Western Australia" <?php echo ("Western Australia" == $selectedOption)? "selected":""; ?>>Western Australia</option>
										                  		<option value="Northern Taritary" <?php echo ("Northern Taritary" == $selectedOption)? "selected":""; ?>>Northern Taritary</option>
										                  </select>
										                </div>
									                </div>
									                <div class="col-md-4 col-sm-12">
					                                    <div class="form-group">
										                  <label for="expiry_date">Expiry Date:<sup>*</sup></label>
										                  <input type="date" class="form-control" name="expiry_date" id="clases" value="{{isset($userJobDetail->expiry_date) ? $userJobDetail->expiry_date : Request::get('expiry_date')}}">
										                </div>
									                </div>
		                                    	</div>
		                                    </div>
	                                    	
	                                    
	                                    <!--Security Employment Experience-->
	                                    <div class="row">
	                                    	<div class="col-md-12 mb10 mt10">
	                                    		<h4>Security Employment Experience</h4>
	                                    		<hr />
	                                    	</div>
	                                    	<div class="col-md-6 col-sm-12">
	                                    		<div class="form-group">
								                  	<label for="company_name">Security Company Name:<sup>*</sup></label>
								                  	<input type="text" class="form-control-sm" name="company_name" id="company_name" value="{{isset($userJobDetail->company_name) ? $userJobDetail->company_name : Request::get('company_name')}}" required>
								                </div>	
	                                    	</div>
	                                    	<div class="col-md-6 col-sm-12">
	                                    		<div class="form-group">
								                  	<label for="experience_years">Year of Experience:<sup>*</sup></label>
								                  	<input type="text" class="form-control-sm" name="experience_years" id="experience_years" value="{{isset($userJobDetail->experience_years) ? $userJobDetail->experience_years : Request::get('experience_years')}}" required>
								                </div>	
	                                    	</div>
	                                    	<div class="col-md-6 col-sm-12">
	                                    		<div class="form-group">
								                  	<label for="employee_name">Employer Name:<sup>*</sup></label>
								                  	<input type="text" class="form-control-sm" name="employee_name" id="employee_name" value="{{isset($userJobDetail->employee_name) ? $userJobDetail->employee_name : Request::get('employee_name')}}" required>
								                </div>	
	                                    	</div>
	                                    	<div class="col-md-6 col-sm-12">
	                                    		<div class="form-group">
								                  	<label for="emp_contact_number">Employer Contact Number:<sup>*</sup></label>
								                  	<input type="text" class="form-control-sm" name="emp_contact_number" id="emp_contact_number" value="{{isset($userJobDetail->emp_contact_number) ? $userJobDetail->emp_contact_number : Request::get('emp_contact_number')}}" required>
								                </div>	
	                                    	</div>
	                                    	<div class="col-md-12 col-sm-12">
	                                    		<div class="form-group">
								                  	<label for="availability">Your Availability:<sup>*</sup></label>
								                  	<input type="text" class="form-control-sm" name="availability" id="availability" value="{{isset($userJobDetail->availability) ? $userJobDetail->availability : Request::get('availability')}}" required>
								                </div>	
	                                    	</div>
											<div class="col-md-12 col-sm-12">
	                                    		<div class="form-group">
								                  	<label>Are you prepared to work shift based on a rotational roster, including night shifts and weekends?<sup>*</sup></label><br >
								                  	<div class="form-check form-check-inline">
													  <input class="explain_availability_radio form-check-input" {{isset($userJobDetail->work_shift_prepared) && $userJobDetail->work_shift_prepared == 'Y' ? 'checked="checked"' : ''}} type="radio" name="work_shift_prepared" id="inlineRadio1" value="Y">
													  <label class="form-check-label" for="inlineRadio1">Yes</label>
													</div>
													<div class="form-check form-check-inline">
													  <input class="explain_availability_radio form-check-input" {{isset($userJobDetail->work_shift_prepared) && $userJobDetail->work_shift_prepared == 'N' ? 'checked="checked"' : ''}} type="radio" name="work_shift_prepared" id="inlineRadio2" value="N">
													  <label class="form-check-label" for="inlineRadio2">No</label>
													</div>
								                </div>	
	                                    	</div>
	                                    	<div class="col-md-12 col-sm-12" id="explain_availability" style="display: none;">
	                                    		<div class="form-group">
								                  	<label for="explain_availability">If No, explain your availability:<sup>*</sup></label>
								                  	<input type="text" class="form-control-sm" name="explain_availability" id="explain_availability_input" value="{{isset($userJobDetail->explain_availability) ? $userJobDetail->explain_availability : Request::get('explain_availability')}}" required>
								                </div>	
	                                    	</div>
	                                    </div>
	                                    
	                                    <!--Health Information-->
	                                    <div class="row">
	                                    	<div class="col-md-12 mb10 mt10">
	                                    		<h4>Health Information</h4>
	                                    		<hr />
	                                    	</div>
								            <div class="col-md-12 col-sm-12">Are you suffer from any of the following?</div>
	                                    	<div class="col-md-6 col-sm-12">
	                                    		Disability: &nbsp;&nbsp;
                                				<label class="checkbox-inline"><input type="radio" name="disability" value="Y" {{isset($userJobDetail->disability) && $userJobDetail->disability == 'Y' ? 'checked="checked"' : ''}}> Yes</label>&nbsp;&nbsp;
                                				<label class="checkbox-inline"><input type="radio" name="disability" value="N" {{isset($userJobDetail->disability) && $userJobDetail->disability == 'N' ? 'checked="checked"' : ''}}> No</label>
	                                    	</div>
	                                    	<div class="col-md-6 col-sm-12">
	                                    		Medical Condition: &nbsp;&nbsp;
                                				<label class="checkbox-inline"><input type="radio" name="medical_condition" value="Y"  {{isset($userJobDetail->medical_condition) && $userJobDetail->medical_condition == 'Y' ? 'checked="checked"' : ''}}> Yes</label>&nbsp;&nbsp;
                                				<label class="checkbox-inline"><input type="radio" name="medical_condition" value="N" {{isset($userJobDetail->medical_condition) && $userJobDetail->medical_condition == 'N' ? 'checked="checked"' : ''}}> No</label>
	                                    	</div>
	                                    	<div class="col-md-6 col-sm-12">
	                                    		Mental Disorders: &nbsp;&nbsp;
                                				<label class="checkbox-inline"><input type="radio" name="mental_disorders" value="Y" {{isset($userJobDetail->mental_disorders) && $userJobDetail->mental_disorders == 'Y' ? 'checked="checked"' : ''}}> Yes</label>&nbsp;&nbsp;
                                				<label class="checkbox-inline"><input type="radio" name="mental_disorders" value="N" {{isset($userJobDetail->mental_disorders) && $userJobDetail->mental_disorders == 'N' ? 'checked="checked"' : ''}}> No</label>
	                                    	</div>
	                                    	<div class="col-md-6 col-sm-12">
	                                    		Allergies / Intolerances: &nbsp;&nbsp;
                                				<label class="checkbox-inline"><input type="radio" name="allergies" value="Y" {{isset($userJobDetail->allergies) && $userJobDetail->allergies == 'Y' ? 'checked="checked"' : ''}}> Yes</label>&nbsp;&nbsp;
                                				<label class="checkbox-inline"><input type="radio" name="allergies" value="N" {{isset($userJobDetail->allergies) && $userJobDetail->allergies == 'N' ? 'checked="checked"' : ''}}> No</label>
	                                    	</div>
	                                    	<div class="col-md-6 col-sm-12">
	                                    		Drugs or Alcohol Dependency: &nbsp;&nbsp;
                                				<label class="checkbox-inline"><input type="radio" name="drugs_dependency" value="Y" {{isset($userJobDetail->drugs_dependency) && $userJobDetail->drugs_dependency == 'Y' ? 'checked="checked"' : ''}}> Yes</label>&nbsp;&nbsp;
                                				<label class="checkbox-inline"><input type="radio" name="drugs_dependency" value="N" {{isset($userJobDetail->drugs_dependency) && $userJobDetail->drugs_dependency == 'N' ? 'checked="checked"' : ''}}> No</label>
	                                    	</div>
	                                    	<div class="col-md-6 col-sm-12">
	                                    		Do you smoke?: &nbsp;&nbsp;
                                				<label class="checkbox-inline"><input type="radio" name="smoking" value="Y" {{isset($userJobDetail->smoking) && $userJobDetail->smoking == 'Y' ? 'checked="checked"' : ''}}> Yes</label>&nbsp;&nbsp;
                                				<label class="checkbox-inline"><input type="radio" name="smoking" value="N" {{isset($userJobDetail->smoking) && $userJobDetail->smoking == 'N' ? 'checked="checked"' : ''}}> No</label>
	                                    	</div>
	                                    	<div class="col-md-12 col-sm-12">
	                                    		Are you suffering any medication / Supplements which may affect the performance of your work?: &nbsp;&nbsp;
                                				<label class="checkbox-inline"><input type="radio" name="medication" value="Y" {{isset($userJobDetail->medication) && $userJobDetail->medication == 'Y' ? 'checked="checked"' : ''}}> Yes</label>&nbsp;&nbsp;
                                				<label class="checkbox-inline"><input type="radio" name="medication" value="N" {{isset($userJobDetail->medication) && $userJobDetail->medication == 'N' ? 'checked="checked"' : ''}}> No</label>
	                                    	</div>
	                                    	<div class="col-md-12 col-sm-12">
	                                    		Do you drink alcohol?: &nbsp;&nbsp;
                                				<label class="checkbox-inline"><input type="radio" name="drink_alcohol" value="frequently" {{isset($userJobDetail->drink_alcohol) && $userJobDetail->drink_alcohol == 'frequently' ? 'checked="checked"' : ''}}> Frequently</label>&nbsp;&nbsp;
                                				<label class="checkbox-inline"><input type="radio" name="drink_alcohol" value="occasional" {{isset($userJobDetail->drink_alcohol) && $userJobDetail->drink_alcohol == 'occasional' ? 'checked="checked"' : ''}}> Occasional</label>
                                				<label class="checkbox-inline"><input type="radio" name="drink_alcohol" value="never" {{isset($userJobDetail->drink_alcohol) && $userJobDetail->drink_alcohol == 'never' ? 'checked="checked"' : ''}}> Never</label>
	                                    	</div>
	                                    </div>
	                                    
										<!--Emergency Contact Details-->
										<div class="row">
											<div class="col-md-12 mb10 mt10">
												<h4>Emergency Contact Details</h4>
												<hr />
											</div>
	                                    	<div class="col-md-4 col-sm-12">
	                                    		<div class="form-group">
								                  	<label for="emergency_name">Emergency Name<sup>*</sup></label>
								                  	<input type="text" class="form-control-sm" name="emergency_name" id="emergency_name" value="{{isset($userJobDetail->emergency_name) ? $userJobDetail->emergency_name : Request::get('emergency_name')}}" required>
								                </div>	
	                                    	</div>
	                                    	<div class="col-md-8 col-sm-12">
	                                    		<div class="form-group">
								                  	<label for="emergency_address">Emergency Address<sup>*</sup></label>
								                  	<input type="text" class="form-control-sm" name="emergency_address" id="emergency_address" value="{{isset($userJobDetail->emergency_address) ? $userJobDetail->emergency_address : Request::get('emergency_address')}}" required>
								                </div>	
	                                    	</div>
	                                    	<div class="col-md-6 col-sm-12">
	                                    		<div class="form-group">
								                  	<label for="emergency_relationship">Relationship<sup>*</sup></label>
								                  	<input type="text" class="form-control-sm" name="emergency_relationship" id="emergency_relationship" value="{{isset($userJobDetail->emergency_relationship) ? $userJobDetail->emergency_relationship : Request::get('emergency_relationship')}}" required>
								                </div>	
	                                    	</div>
	                                    	<div class="col-md-6 col-sm-12">
	                                    		<div class="form-group">
								                  	<label for="emergency_number">Contact Number<sup>*</sup></label>
								                  	<input type="text" class="form-control-sm" name="emergency_number" id="emergency_number" value="{{isset($userJobDetail->emergency_number) ? $userJobDetail->emergency_number : Request::get('emergency_number')}}" required>
								                </div>	
	                                    	</div>
	                                    </div>
	                                    
	                                    <!--documents list-->
	                                    <div class="row">
		                                    <div class="col-md-12 mb10 mt10">
		                                    	<h4>Documents Check list:</h4>
		                                    	<hr />
		                                    </div>
		                                    @foreach($documents as $document)
		                                    @php
		                                    $userId = Auth::user()->id;
		                                    $existingDoc = getUserDocument($userId, $document['key'], $userDocument);
		                                    @endphp
		                                    <div class="col-md-12 col-sm-12">
	                                    		<div class="form-group">
												    <div class="form-check">
												      <input data-file-id='{{$document['key']}}'  class="document_check_box form-check-input" {{($document['is_required']== 'Y' && empty($existingDoc))? 'required':''}} type="checkbox" id="gridCheck{{$loop->index}}">
												      <label class="form-check-label" for="gridCheck{{$loop->index}}">
												        {{$document['name']}} @if($document['is_required'] == 'N') <span>(Optional)</span> @else <sup>*</sup> @endif
												        @if($existingDoc) <a href='{{$existingDoc}}' target="_blank" download>Download</a> @endif
												      </label>
												    </div>
												    <input type="file" id="{{$document['key']}}" name="documents[{{$document['key']}}]" class="form-control-file border" style="display: none;">
												</div>
	                                    	</div>
		                                    @endforeach
		                                </div>
	                                    
	                                </div>
	                                
	                                
									<input type="hidden" name="step" value="2"/>
	                                <a type="button" href="{{url('account/1')}}" class="previous action-button-previous" ><i class='fa fa-arrow-left'></i></a>
	                                @if($user->step >= $step)
                                	<a type="button" href="{{url('account/3')}}" class="previous action-button-previous"><i class='fa fa-arrow-right'></i></a>
                                    @else
                                    <a type="button" href="javascript:;" class="previous action-button-previous disabled"><i class='fa fa-arrow-right'></i></a>
                                    @endif
	                                    
	                                <button type="submit"  class="next action-button">Save</button>
	                            </fieldset>
	                            @elseif($step == 3)
	                            <fieldset>
	                                <div class="form-card">
	                                    <div class="row">
		                                    <div class="col-md-12 mb10">
		                                    	<h4>Personal Information</h4>
		                                    	<hr />
		                                    </div>
											<div class="col-md-6 col-sm-12">
	                            				<div class="form-group">
								                  	<label for="birth_date">Date of Birth:<sup>*</sup></label>
								                  	<input type="date" class="form-control-sm" name="birth_date" id="birth_date" value="{{isset($userDetail->birth_date) ? $userDetail->birth_date : Request::get('birth_date')}}" required>
								                </div>	
	                                    	</div>
							                <div class="col-md-6 col-sm-12">
								                <div class="form-group">
								                  <label for="contact">Contact No.<sup>*</sup></label>
								                  <input type="text" class="form-control" name="contact" id="contact" value="{{isset($userDetail->contact) ? $userDetail->contact : Request::get('contact')}}" data-parsley-maxlength="14" data-parsley-minlength="9" required>
								                </div>
							                </div>
							                
							                <div class="col-md-12 col-sm-12">
							                	<div class="form-group">
								                  <label for="address">Address<sup>(Apartment/Unit # + Street Address) *</sup></label>
								                  <input type="text" class="form-control" name="address" id="address" value="{{isset($userDetail->address) ? $userDetail->address : Request::get('address')}}" required>
								                </div>
							                </div>
							                <div class="col-md-6 col-sm-12">
							                	<div class="form-group">
								                  <label for="city">City<sup>*</sup></label>
								                  <input type="text" class="form-control" name="city" id="city" value="{{isset($userDetail->city) ? $userDetail->city : Request::get('city')}}" required>
								                </div>
							                </div>
							                
							                <div class="col-md-3 col-sm-12">
							                	<div class="form-group">
								                  <label for="state">State<sup>*</sup></label>
								                  <input type="text" class="form-control" name="state" id="state" value="{{isset($userDetail->state) ? $userDetail->state : Request::get('state')}}" required>
								                </div>
							                </div>
							                <div class="col-md-3 col-sm-12">
							                	<div class="form-group">
								                  <label for="zipcode">Zipcode<sup>*</sup></label>
								                  <input type="number" class="form-control" name="zipcode" id="zipcode" value="{{isset($userDetail->zipcode) ? $userDetail->zipcode : Request::get('zipcode')}}" required>
								                </div>
							                </div>
							                
							                <div class="col-md-4 col-sm-12">
							                	<div class="form-group">
								                  <label for="zipcode">Telephone (Home)<sup>*</sup></label>
								                  <input type="text" class="form-control" name="telephone_home" id="telephone_home" value="{{isset($userDetail->telephone_home) ? $userDetail->telephone_home : Request::get('telephone_home')}}" required>
								                </div>
							                </div>
							                <div class="col-md-4 col-sm-12">
							                	<div class="form-group">
								                  <label for="mobile_number">Mobile #<sup>*</sup></label>
								                  <input type="text" class="form-control" name="mobile_number" id="mobile_number" value="{{isset($userDetail->mobile_number) ? $userDetail->mobile_number : Request::get('mobile_number')}}" required>
								                </div>
							                </div>
							                <div class="col-md-4 col-sm-12">
							                	<div class="form-group">
								                  <label for="gender">Gender<sup>*</sup></label>
								                  <input type="text" class="form-control" name="gender" id="gender" value="{{isset($userDetail->gender) ? $userDetail->gender : Request::get('gender')}}" required>
								                </div>
							                </div>
							                
							                <div class="col-md-12 col-sm-12">
	                                    		Are you a Citizen/Permanent Residentof the Australia? &nbsp;&nbsp;
                                				<label class="checkbox-inline"><input class="permanent_cityzen_checkbox" type="radio" name="permanent_cityzen" value="Y" {{isset($userDetail->permanent_cityzen) && $userDetail->permanent_cityzen == 'Y' ? 'checked="checked"' : ''}}> Yes</label>&nbsp;&nbsp;
                                				<label class="checkbox-inline"><input class="permanent_cityzen_checkbox" type="radio" name="permanent_cityzen" value="N" {{isset($userDetail->permanent_cityzen) && $userDetail->permanent_cityzen == 'N' ? 'checked="checked"' : ''}}> No</label>
	                                    	</div>
	                                    	
	                                    	@if(isset($userJobDetail->job_type) && ($userJobDetail->job_type == 'cleaning'))
	                                    	<div class="col-md-12 col-sm-12 permanent_cityzen_field" style="display: none;">
							                	<div class="form-group">
								                  <label for="visa_status">If not, mention Visa Status _<sup>*</sup></label>
								                  <input type="text" class="form-control" name="visa_status" id="visa_status" value="{{isset($userDetail->visa_status) ? $userDetail->visa_status : Request::get('visa_status')}}">
								                </div>
							                </div>
							                @endif
	                                    	
	                                    	
	                                    	<!--worked_before_checkbox-->
							                <div class="col-md-12 col-sm-12">
	                                    		Have you ever worked for {{isset($userJobDetail->job_type) && ($userJobDetail->job_type == 'cleaning') ? 'Cleaning Services':'a Security Company' }}? &nbsp;&nbsp;
                                				<label class="checkbox-inline"><input class="worked_before_checkbox" type="radio" name="worked_before" value="Y" {{isset($userDetail->worked_before) && $userDetail->worked_before == 'Y' ? 'checked="checked"' : ''}}> Yes</label>&nbsp;&nbsp;
                                				<label class="checkbox-inline"><input class="worked_before_checkbox" type="radio" name="worked_before" value="N" {{isset($userDetail->worked_before) && $userDetail->worked_before == 'N' ? 'checked="checked"' : ''}}> No</label>
	                                    	</div>
							                
	                                    	<div class="col-md-12 col-sm-12 worked_before_field" style="display: none;">
							                	<div class="form-group">
								                  <label for="visa_status">If yes, Details?<sup>*</sup></label>
								                  <input type="text" class="form-control" name="worked_before_status" id="worked_before_status" value="{{isset($userDetail->worked_before_status) ? $userDetail->worked_before_status : Request::get('worked_before_status')}}">
								                </div>
							                </div>
	                                    	
	                                    	<!---->
                                    		@if(isset($userJobDetail->job_type) && ($userJobDetail->job_type == 'cleaning'))
							                <div class="col-md-12 col-sm-12">
	                                    		Are you prepared to work anytime? including night shifts and weekends? &nbsp;&nbsp;
                                				<label class="checkbox-inline"><input class="work_anytime_checkbox" type="radio" name="work_anytime" value="Y" {{isset($userDetail->work_anytime) && $userDetail->work_anytime == 'Y' ? 'checked="checked"' : ''}}> Yes</label>&nbsp;&nbsp;
                                				<label class="checkbox-inline"><input class="work_anytime_checkbox" type="radio" name="work_anytime" value="N" {{isset($userDetail->work_anytime) && $userDetail->work_anytime == 'N' ? 'checked="checked"' : ''}}> No</label>
	                                    	</div>
							                
	                                    	<div class="col-md-12 col-sm-12 work_anytime_field" style="display: none;">
							                	<div class="form-group">
								                  <label for="work_anytime_availability">If No,whatis youravailability?:<sup>*</sup></label>
								                  <input type="text" class="form-control" name="work_anytime_availability" id="work_anytime_availability" value="{{isset($userDetail->work_anytime_availability) ? $userDetail->work_anytime_availability : Request::get('work_anytime_availability')}}">
								                </div>
							                </div>
							                @endif
	                                    </div>
										
						                <!--Recruitment Details-->
										<div class="row">
	                                    	<div class="col-md-12 mb10 mt10">
	                                    		<h4>Recruitment and Payroll Details</h4>
	                                    		<hr />
	                                    	</div>
	                                    	<div class="col-md-6 col-sm-12"><h5>Payroll Information:</h5></div>
	                                    	<div class="col-md-12 col-sm-12">
                                				<div class="form-group">
								                  	<label for="tex_file_number">Tax File Number:<sup>*</sup></label>
								                  	<input type="text" class="form-control-sm" name="tex_file_number" id="tex_file_number" value="{{isset($userDetail->tex_file_number) ? $userDetail->tex_file_number : Request::get('tex_file_number')}}" required>
								                </div>	
	                                    	</div>
	                                    	<div class="col-md-6 col-sm-12">
                                				<div class="form-group">
								                  	<label for="recruitment_bank">BANK:<sup>*</sup></label>
								                  	<input type="text" class="form-control-sm" name="recruitment_bank" id="recruitment_bank" value="{{isset($userDetail->recruitment_bank) ? $userDetail->recruitment_bank : Request::get('recruitment_bank')}}" required>
								                </div>	
	                                    	</div>
	                                    	<div class="col-md-6 col-sm-12">
                                				<div class="form-group">
								                  	<label for="recruitment_branch">BRANCH:<sup>*</sup></label>
								                  	<input type="text" class="form-control-sm" name="recruitment_branch" id="recruitment_branch" value="{{isset($userDetail->recruitment_branch) ? $userDetail->recruitment_branch : Request::get('recruitment_branch')}}" required>
								                </div>	
	                                    	</div>
	                                    	<div class="col-md-4 col-sm-12">
                                				<div class="form-group">
								                  	<label for="recruitment_account_name">ACCOUNT NAME:<sup>*</sup></label>
								                  	<input type="text" class="form-control-sm" name="recruitment_account_name" id="recruitment_account_name" value="{{isset($userDetail->recruitment_account_name) ? $userDetail->recruitment_account_name : Request::get('recruitment_account_name')}}" required>
								                </div>	
	                                    	</div>
	                                    	<div class="col-md-4 col-sm-12">
                                				<div class="form-group">
								                  	<label for="recruitment_bsb">BSB #:<sup>*</sup></label>
								                  	<input type="text" class="form-control-sm" name="recruitment_bsb" id="recruitment_bsb" value="{{isset($userDetail->recruitment_bsb) ? $userDetail->recruitment_bsb : Request::get('recruitment_bsb')}}" required>
								                </div>	
	                                    	</div>
	                                    	<div class="col-md-4 col-sm-12">
                                				<div class="form-group">
								                  	<label for="recruitment_bsb">Account Number:<sup>*</sup></label>
								                  	<input type="text" class="form-control-sm" name="rec_account_number" id="rec_account_number" value="{{isset($userDetail->rec_account_number) ? $userDetail->rec_account_number : Request::get('rec_account_number')}}" required>
								                </div>	
	                                    	</div>
	                                    </div>
	                                    
	                                    <!--Superannuation Details-->
										<div class="row">
	                                    	<div class="col-md-12 mb10 mt10">
	                                    		<h4>Superannuation Details</h4>
	                                    		<hr />
	                                    	</div>
	                                    	<div class="col-md-6 col-sm-12">
                                				<div class="form-group">
								                  	<label for="super_name">Super Name:<sup>*</sup></label>
								                  	<input type="text" class="form-control-sm" name="super_name" id="super_name" value="{{isset($userDetail->super_name) ? $userDetail->super_name : Request::get('super_name')}}" required>
								                </div>	
	                                    	</div>
	                                    	<div class="col-md-6 col-sm-12">
                                				<div class="form-group">
								                  	<label for="super_member_id">Super Member ID:<sup>*</sup></label>
								                  	<input type="text" class="form-control-sm" name="super_member_id" id="super_member_id" value="{{isset($userDetail->super_member_id) ? $userDetail->super_member_id : Request::get('super_member_id')}}" required>
								                </div>	
	                                    	</div>
	                                    	<div class="col-md-6 col-sm-12">
                                				<div class="form-group">
								                  	<label for="super_company_name">Super Company Name:<sup>*</sup></label>
								                  	<input type="text" class="form-control-sm" name="super_company_name" id="super_company_name" value="{{isset($userDetail->super_company_name) ? $userDetail->super_company_name : Request::get('super_company_name')}}" required>
								                </div>	
	                                    	</div>
	                                    	<div class="col-md-6 col-sm-12">
                                				<div class="form-group">
								                  	<label for="super_abn">Super ABN:<sup>*</sup></label>
								                  	<input type="text" class="form-control-sm" name="super_abn" id="super_abn" value="{{isset($userDetail->super_abn) ? $userDetail->super_abn : Request::get('super_abn')}}" required>
								                </div>	
	                                    	</div>
	                                    	<div class="col-md-12 col-sm-12">
                                				<div class="form-group">
								                  	<label for="super_com_address">Superfund Company Address:<sup>*</sup></label>
								                  	<input type="text" class="form-control-sm" name="super_com_address" id="super_com_address" value="{{isset($userDetail->super_com_address) ? $userDetail->super_com_address : Request::get('super_com_address')}}" required>
								                </div>	
	                                    	</div>
	                                    	<div class="col-md-12 col-sm-12">
	                                    		May we contact your previous supervisor for a reference?: &nbsp;&nbsp;
                                				<label class="checkbox-inline"><input type="radio" name="can_contact_supervisor" value="Y" {{isset($userDetail->can_contact_supervisor) && $userDetail->can_contact_supervisor == 'Y' ? 'checked="checked"' : ''}}> Yes</label>&nbsp;&nbsp;
                                				<label class="checkbox-inline"><input type="radio" name="can_contact_supervisor" value="N" {{isset($userDetail->can_contact_supervisor) && $userDetail->can_contact_supervisor == 'N' ? 'checked="checked"' : ''}}> No</label>
	                                    	</div>
	                                    </div>
	                                    
	                                </div> 
	                                
	                                <input type="hidden" name="step" value="3"/>
	                                <a type="button" href="{{url('account/2')}}" class="previous action-button-previous" ><i class='fa fa-arrow-left'></i></a>
                                    @if($user->step >= $step)
                                	<a type="button" href="{{url('account/4')}}" class="previous action-button-previous"><i class='fa fa-arrow-right'></i></a>
                                    @else
                                    <a type="button" href="javascript:;" class="previous action-button-previous disabled"><i class='fa fa-arrow-right'></i></a>
	                                @endif
	                                <button type="submit"  class="next action-button">Save</button>
	                            </fieldset>
								@elseif($step >= 4)
	                            <fieldset>
	                                <div class="form-card">
	                                    <h2 class="fs-title text-center">Your Request {{($user->user_status == "approved")? "has been approved":"is Successful"}}!</h2> <br><br>
	                                    <div class="row justify-content-center">
	                                        <div class="col-7"> 
	                                        	<p>Hi {{Auth::user()->name}}!</p>
	                                        	@if($user->user_status == "approved")
	                                        		<p><font color="green"><i class='fa fa-check-circle'></i></font> Your request has been approved by the jobs department. Please provide your details and improve your dashboard to proceed.<font color="green"><i class='fa fa-check-circle'></i></font></p>
	                                        	@else
	                                        		<p>Your request is under approval process, please wait and be patient until we review your documents and verify your documents.</p>
	                                        	@endif
	                                        	
	                                    	</div>
	                                    	<div class="col-7 text-center">
	                                            <h5>Thanks</h5>
	                                        </div>
	                                    </div>
	                                    
	                                </div>
                                    <a type="button" href="{{url('account/3')}}" class="previous action-button-previous" ><i class='fa fa-arrow-left'></i></a>
                                    
	                            </fieldset>
								@endif
	                        </form>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
@endsection

@section('script')
<!--https://plugins.krajee.com/file-avatar-upload-demo-->
<script src="{{asset('public/plugins/custom/fileInput/fileInput.min.js')}}"></script>

<script>
	function openFileOption(){
	  document.getElementById("avatar-1").click();
	}
	$(document).ready(function(){
		$('#avatar-1').val('');
		$('#slectNewImage').click(function(){
			$('.imageUploadKrajee').show();
			var $fileField = $("#avatar-1");
			$fileField.fileinput({
			    uploadUrl: "{{url('upload_profile_image')}}/{{$user->id}}",
			    uploadAsync: false,
			    overwriteInitial: false,
			    showPreview: true,
			    uploadExtraData: {
			        user_id: "{{$user->id}}",
			        _token: "{{csrf_token()}}"
			    },
			    showUpload:true,
			    maxImageWidth: 400,
			    maxImageHeight: 400,
			    resizePreference: 'height',
			    resizeImage: true,
			    uploadIcon: '<i class="fa fa-upload"></i> Upload Image',
			    uploadClass: 'btn btn-sm btn-info',
			    showClose: false,
			    showCaption: false,
			    browseLabel: '<span onclick="openFileOption()" style="margin-top:5px; display:block;width:223px;"> Select Profile Image</span>',
			    removeLabel: '',
			    previewFileIcon: '<i class="fa fa-search-plus"></i>',
			    browseIcon: '<i class="fa fa-folder-open"></i>',
			    defaultPreviewContent: '<img src="{{asset('public/frontend/assets/images/default.jpg')}}" alt="Your Avatar" width="200">',
			    layoutTemplates: {main2: '{preview} {browse} {upload}'},
			    allowedFileExtensions: ["jpg", "png", "gif"]
			}).on('filebatchuploadsuccess', function(event, data) {
		        if(data.response.url){
		        	var uploadUrl = data.response.url;
					$('#previewImg').attr('src', uploadUrl);
					$('#avatar-1').val('');
					$('.imageUploadKrajee').hide();
					$('#imageField').val('true');
				}
		    });		
		});
		
		/**
		* Permanent resident, if not then mention
		*/
		if($('.permanent_cityzen_checkbox:checked').val() == 'N'){
			if($('.permanent_cityzen_field')){
				$('.permanent_cityzen_field').show('slow');
				$('.permanent_cityzen_field input').each(function(){
					$(this).attr("required", "true");
				})				
			}
		}else{
			if($('.permanent_cityzen_field')){
				$('.permanent_cityzen_field').hide('slow');
				$('.permanent_cityzen_field input').each(function(){
					$(this).removeAttr("required");
				})
			}
		}
		$('.permanent_cityzen_checkbox').click(function(){
			if($('.permanent_cityzen_field')){
				if($(this).is(':checked') && ($(this)[0].value == 'N')){
					$('.permanent_cityzen_field').show('slow');
					$('.permanent_cityzen_field input').each(function(){
						$(this).attr("required", "true");
					})
				}else{
					$('.permanent_cityzen_field').hide('slow');
					$('.permanent_cityzen_field input').each(function(){
						$(this).removeAttr("required");
					})
				}
			}
		});
		
		/**
		* work_anytime, if not then mention availability
		*/
		if($('.work_anytime_checkbox:checked').val() == 'N'){
			if($('.work_anytime_field')){
				$('.work_anytime_field').show('slow');
				$('.work_anytime_field input').each(function(){
					$(this).attr("required", "true");
				})				
			}
		}else{
			if($('.work_anytime_field')){
				$('.work_anytime_field').hide('slow');
				$('.work_anytime_field input').each(function(){
					$(this).removeAttr("required");
				})
			}
		}
		$('.work_anytime_checkbox').click(function(){
			if($('.work_anytime_field')){
				if($(this).is(':checked') && ($(this)[0].value == 'N')){
					$('.work_anytime_field').show('slow');
					$('.work_anytime_field input').each(function(){
						$(this).attr("required", "true");
					})
				}else{
					$('.work_anytime_field').hide('slow');
					$('.work_anytime_field input').each(function(){
						$(this).removeAttr("required");
					})
				}
			}
		});
		
		/**
		* Worked before fields
		*/
		if($('.worked_before_checkbox:checked').val() == 'Y'){
			$('.worked_before_field').show('slow');
			$('.worked_before_field input').each(function(){
				$(this).attr("required", "true");
			})
		}else{
			$('.worked_before_field').hide('slow');
			$('.worked_before_field input').each(function(){
				$(this).removeAttr("required");
			})
		}
		$('.worked_before_checkbox').click(function(){
			if($(this).is(':checked') && ($(this)[0].value == 'Y')){
				$('.worked_before_field').show('slow');
				$('.worked_before_field input').each(function(){
					$(this).attr("required", "true");
				})
			}else{
				$('.worked_before_field').hide('slow');
				$('.worked_before_field input').each(function(){
					$(this).removeAttr("required");
				})
			}
		});	
		
		/**
		* Job type radio boxes in step 2
		*/
		if($('.job_type:checked').val() == 'security'){
			$('#jobFields').show('slow');
			$('#jobFields input').each(function(){
				$(this).attr("required", "true");
			})
		}else{
			$('#jobFields').hide('slow');
			$('#jobFields input').each(function(){
				$(this).removeAttr("required");
			})
		}
		$('.job_type').click(function(){
			if($(this).is(':checked') && ($(this)[0].value == 'security' || $(this)[0].value == 'traffic_controller')){
				$('#jobFields').show('slow');
				$('#jobFields input').each(function(){
					$(this).attr("required", "true");
				})
			}else{
				$('#jobFields').hide('slow');
				$('#jobFields input').each(function(){
					$(this).removeAttr("required");
				})
			}
		});	
		

		
		/**
		* Explain Availability fields
		*/
		$('.explain_availability_radio').click(function(){
			if($(this).is(':checked') && $(this)[0].value == 'N'){
				$('#explain_availability').show();
				$('#explain_availability_input').attr("required", "true");
			}else{
				$('#explain_availability').hide();
				$('#explain_availability_input').removeAttr("required");
			}
			
		})
		if($('.explain_availability_radio:checked').val() == 'N'){
			$('#explain_availability').show();
			$('#explain_availability_input').attr("required", "true");
		}else{
			$('#explain_availability_input').removeAttr("required");
		};
		
		/**
		* Documents Scripts for fields
		*/
		$('.document_check_box').click(function(){
			var getDocumentId = $(this).attr("data-file-id");
			if($(this).is(':checked')){
				$('#'+getDocumentId).show();
				$('#'+getDocumentId).attr("required", "true");
			}else{
				$('#'+getDocumentId).hide();
				$('#'+getDocumentId).removeAttr("required");
			}
			
		})
		$('.document_check_box').each(function(){
			if($(this).is(':checked')){
				var getDocumentId = $(this).attr("data-file-id");
				$('#'+getDocumentId).show();
				$('#'+getDocumentId).attr("required", "true");
			}
		});
	});
</script>
@endsection