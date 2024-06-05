
@if(!$userJobDetail)
	<div class="row">
		<div class="col-md-12 mb10">
	    	<h5>Not applied for a job.</h5>
	    	<hr />
	    </div>
    </div>
    
@else

	<div class="row">
		@if(isset($userJobDetail->job_type))
		<div class="col-md-12 mb10">
	    	<!--<h4>Job Related Details</h4>-->
	    	<h5 style="text-transform: capitalize;">Applied For {{str_replace('_', ' ', $userJobDetail->job_type)}}</h5>
	    	<hr />
	    </div>
		@endif
		
		@if($userJobDetail->job_type != 'cleaning')
			@if(isset($userJobDetail->license_name))
			<div class="col-md-4 col-sm-12 col-xs-6">
				<p>
					<div><strong>License Name:</strong> {{$userJobDetail->license_name}}</div>
				</p>
			</div>
			@endif
			
			@if(isset($userJobDetail->clases))
			<div class="col-md-4 col-sm-12 col-xs-6">
				<p>
					<div><strong>Class(es): </strong> &nbsp; {{$userJobDetail->clases}}</div>
				</p>
			</div>
			@endif
			
			@if(isset($userJobDetail->license_state))
			<div class="col-md-4 col-sm-12 col-xs-6">
				<p>
					<div><strong>State: </strong> &nbsp; {{$userJobDetail->license_state}}</div>
				</p>
			</div>
			@endif
			
			@if(isset($userJobDetail->expiry_date))
			<div class="col-md-4 col-sm-12 col-xs-6">
				<p>
					<div><strong>Expiry Date: </strong> &nbsp; {{date('D: M d, Y', strtotime($userJobDetail->expiry_date))}}</div>
				</p>
			</div>
			@endif
			
			<div class="col-md-12">
				<p><hr /></p>
			</div>
		@endif

		<!--Recruitment and Payroll Details-->
		<div class="col-md-12 mb10">
	    	<h4>Security Employment Experience</h4>
	    	<hr />
	    </div>

		@if(isset($userJobDetail->company_name))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Security Company Name: </strong> &nbsp; {{$userJobDetail->company_name}}</div>
			</p>
		</div>
		@endif
		
		@if(isset($userJobDetail->experience_years))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Year of Experience: </strong> &nbsp; {{$userJobDetail->experience_years}}</div>
			</p>
		</div>
		@endif
		
		@if(isset($userJobDetail->employee_name))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Employer Name: </strong> &nbsp; {{$userJobDetail->employee_name}}</div>
			</p>
		</div>
		@endif
		
		@if(isset($userJobDetail->emp_contact_number))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Employer Contact Number: </strong> &nbsp; {{$userJobDetail->emp_contact_number}}</div>
			</p>
		</div>
		@endif
		
		@if(isset($userJobDetail->availability))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Your Availability: </strong> &nbsp; {{$userJobDetail->availability}}</div>
			</p>
		</div>
		@endif
		
		@if(isset($userJobDetail->work_shift_prepared))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Are you prepared to work shift based on a rotational roster, including night shifts and weekends?: </strong> &nbsp; {{($userJobDetail->work_shift_prepared == 'Y')? 'Yes': 'No'}}</div>
			</p>
		</div>
		@endif
		
		@if(isset($userJobDetail->explain_availability))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>If No, explain your availability: </strong> &nbsp; {{$userJobDetail->explain_availability}}</div>
			</p>
		</div>
		@endif
		
		
		
		<!--Recruitment and Payroll Details-->
		<div class="col-md-12">
			<p><hr /></p>
		</div>

		<div class="col-md-12 mb10">
	    	<h4>Security Employment Experience</h4>
	    	<h6>Are you suffer from any of the following?</h6>
	    	<hr />
	    </div>
	    
	    @if(isset($userJobDetail->disability))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Disability: </strong> &nbsp; {{($userJobDetail->disability == 'Y')? 'Yes': 'No'}}</div>
			</p>
		</div>
		@endif
		
	    @if(isset($userJobDetail->medical_condition))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Medical Condition: </strong> &nbsp; {{($userJobDetail->medical_condition == 'Y')? 'Yes': 'No'}}</div>
			</p>
		</div>
		@endif
		
	    @if(isset($userJobDetail->mental_disorders))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Mental Disorders: </strong> &nbsp; {{($userJobDetail->mental_disorders == 'Y')? 'Yes': 'No'}}</div>
			</p>
		</div>
		@endif
		
	    @if(isset($userJobDetail->allergies))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Allergies / Intolerances: </strong> &nbsp; {{($userJobDetail->allergies == 'Y')? 'Yes': 'No'}}</div>
			</p>
		</div>
		@endif
		
	    @if(isset($userJobDetail->drugs_dependency))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Drugs or Alcohol Dependency: </strong> &nbsp; {{($userJobDetail->drugs_dependency == 'Y')? 'Yes': 'No'}}</div>
			</p>
		</div>
		@endif
		
	    @if(isset($userJobDetail->smoking))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Do you smoke?: </strong> &nbsp; {{($userJobDetail->smoking == 'Y')? 'Yes': 'No'}}</div>
			</p>
		</div>
		@endif
		
	    @if(isset($userJobDetail->medication))
		<div class="col-md-12 col-sm-12 col-xs-12">
			<p>
				<div><strong>Are you suffering any medication / Supplements which may affect the performance of your work?: </strong> &nbsp; {{($userJobDetail->medication == 'Y')? 'Yes': 'No'}}</div>
			</p>
		</div>
		@endif
		
	    @if(isset($userJobDetail->drink_alcohol))
		<div class="col-md-12 col-sm-12 col-xs-12">
			<p>
				<div><strong>Do you drink alcohol?: </strong> &nbsp; {{($userJobDetail->drink_alcohol == 'Y')? 'Yes': 'No'}}</div>
			</p>
		</div>
		@endif
		
		
		<div class="col-md-12">
			<p><hr /></p>
		</div>

		<div class="col-md-12 mb10">
	    	<h4>Emergency Contact Details</h4>
	    	<hr />
	    </div>
	    
	    @if(isset($userJobDetail->emergency_name))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Emergency Name: </strong> &nbsp; {{$userJobDetail->emergency_name}}</div>
			</p>
		</div>
		@endif
		
	    @if(isset($userJobDetail->emergency_address))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Emergency Address: </strong> &nbsp; {{$userJobDetail->emergency_address}}</div>
			</p>
		</div>
		@endif
		
	    @if(isset($userJobDetail->emergency_relationship))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Relationship: </strong> &nbsp; {{$userJobDetail->emergency_relationship}}</div>
			</p>
		</div>
		@endif
		
	    @if(isset($userJobDetail->emergency_number))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Contact Number: </strong> &nbsp; {{$userJobDetail->emergency_number}}</div>
			</p>
		</div>
		@endif
		
	</div>

@endif