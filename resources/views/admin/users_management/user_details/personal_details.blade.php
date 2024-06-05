

	
	@if($userDetail && $userJobDetail)
	<div class="row">
		<div class="col-md-12 mb10">
	    	<h4>Personal Details</h4>
	    	<hr />
	    </div>
		@if(isset($userDetail->birth_date))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Date of Birth:</strong> {{date('D: M d, Y', strtotime($userDetail->birth_date))}}</div>
			</p>
		</div>
		@endif
		
		@if(isset($userDetail->gender))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Gender: </strong> &nbsp; {{$userDetail->gender}}</div>
			</p>
		</div>
		@endif
		
		@if(isset($userDetail->telephone_home))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Telephone (Home): </strong> &nbsp; {{$userDetail->telephone_home}}</div>
			</p>
		</div>
		@endif
		
		@if(isset($userDetail->mobile_number))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Mobile #: </strong> &nbsp; {{$userDetail->mobile_number}}</div>
			</p>
		</div>
		@endif

		@if(isset($userDetail->address))
		<div class="col-md-8 col-sm-12 col-xs-6">
			<p>
				<div><strong>Address: </strong> &nbsp; {{$userDetail->address}}</div>
			</p>
		</div>
		@endif
		
		@if(isset($userDetail->city))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>City: </strong> &nbsp; {{$userDetail->city}}</div>
			</p>
		</div>
		@endif
		@if(isset($userDetail->state))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>State: </strong> &nbsp; {{$userDetail->state}}</div>
			</p>
		</div>
		@endif
		@if(isset($userDetail->zipcode))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Zip Code: </strong> &nbsp; {{$userDetail->zipcode}}</div>
			</p>
		</div>
		@endif
		
		@if(isset($userDetail->permanent_cityzen))
		<div class="col-md-12 col-sm-12 col-xs-6">
			<p>
				<div><strong>Are you a Citizen/Permanent Residentof the Australia? </strong> &nbsp; {{($userDetail->permanent_cityzen == 'Y')? 'Yes': 'No'}}</div>
			</p>
		</div>
		@endif
		@if(isset($userDetail->permanent_cityzen) && isset($userJobDetail->job_type) && $userJobDetail->job_type == 'cleaning' && $userDetail->permanent_cityzen == 'N')
		<div class="col-md-12 col-sm-12 col-xs-6">
			<p>
				<div><strong>If not, mention Visa Status: </strong> &nbsp; {{$userDetail->visa_status}}</div>
			</p>
		</div>
		@endif
		
		@if(isset($userDetail->worked_before))
		<div class="col-md-12 col-sm-12 col-xs-6">
			<p>
				<div><strong>Have you ever worked for Cleaning Services?  </strong> &nbsp; {{($userDetail->worked_before == 'Y')? 'Yes': 'No'}}</div>
			</p>
		</div>
		@endif

		@if(isset($userDetail->worked_before_status) && isset($userJobDetail->job_type) && $userJobDetail->job_type == 'cleaning' && $userDetail->worked_before == 'Y')
		<div class="col-md-12 col-sm-12 col-xs-6">
			<p>
				<div><strong>If yes, Details?  </strong> &nbsp; {{$userDetail->worked_before_status}}</div>
			</p>
		</div>
		@endif

		@if(isset($userJobDetail->job_type) && $userJobDetail->job_type == 'cleaning')
			@if(isset($userDetail->work_anytime))
			<div class="col-md-12 col-sm-12 col-xs-6">
				<p>
					<div><strong>Are you prepared to work anytime? including night shifts and weekends?  </strong> &nbsp; {{($userDetail->work_anytime == 'Y')? 'Yes': 'No'}}</div>
				</p>
			</div>
			@endif

			@if(isset($userDetail->work_anytime_availability) && $userDetail->work_anytime == 'N')
			<div class="col-md-12 col-sm-12 col-xs-6">
				<p>
					<div><strong>If No,whatis youravailability?  </strong> &nbsp; {{$userDetail->work_anytime_availability}}</div>
				</p>
			</div>
			@endif
		@endif
		<div class="col-md-12">
			<p><hr /></p>
		</div>
		
		<!--Recruitment and Payroll Details-->
		
		<div class="col-md-12 mb10">
	    	<h4>Recruitment and Payroll Details</h4>
	    	<hr />
	    </div>

		<!--<div><strong>Tax File Number:</strong> {{date('D: M d, Y', strtotime($userDetail->birth_date))}}</div>-->
	    
	    
	    @if(isset($userDetail->tex_file_number))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Tax File Number:</strong> {{$userDetail->tex_file_number}}</div>
			</p>
		</div>
		@endif
		
	    @if(isset($userDetail->recruitment_bank))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>BANK:</strong> {{$userDetail->recruitment_bank}}</div>
			</p>
		</div>
		@endif
		
	    @if(isset($userDetail->recruitment_branch))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>BRANCH:</strong> {{$userDetail->recruitment_branch}}</div>
			</p>
		</div>
		@endif
		
	    @if(isset($userDetail->recruitment_account_name))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>ACCOUNT NAME:</strong> {{$userDetail->recruitment_account_name}}</div>
			</p>
		</div>
		@endif
		
	    @if(isset($userDetail->recruitment_bsb))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>BSB #:</strong> {{$userDetail->recruitment_bsb}}</div>
			</p>
		</div>
		@endif
		
	    @if(isset($userDetail->rec_account_number))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Account Number:</strong> {{$userDetail->rec_account_number}}</div>
			</p>
		</div>
		@endif
		
		<!--Superannuation Details-->
		
		<div class="col-md-12">
			<p><hr /></p>
		</div>
		<div class="col-md-12 mb10">
	    	<h4>Superannuation Details</h4>
	    	<hr />
	    </div>
	    
	    @if(isset($userDetail->super_name))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Super Name:</strong> {{$userDetail->super_name}}</div>
			</p>
		</div>
		@endif
		
	    @if(isset($userDetail->super_member_id))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Super Member ID:</strong> {{$userDetail->super_member_id}}</div>
			</p>
		</div>
		@endif
		
	    @if(isset($userDetail->super_company_name))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Super Company Name:</strong> {{$userDetail->super_company_name}}</div>
			</p>
		</div>
		@endif
		
	    @if(isset($userDetail->super_abn))
		<div class="col-md-4 col-sm-12 col-xs-6">
			<p>
				<div><strong>Super ABN:</strong> {{$userDetail->super_abn}}</div>
			</p>
		</div>
		@endif
		
		@if(isset($userDetail->super_com_address))
		<div class="col-md-12 col-sm-12 col-xs-12">
			<p>
				<div><strong>Superfund Company Address:</strong> {{$userDetail->super_com_address}}</div>
			</p>
		</div>
		@endif
		
		@if(isset($userDetail->can_contact_supervisor))
		<div class="col-md-12 col-sm-12 col-xs-12">
			<p>
				<div><strong>May we contact your previous supervisor for a reference?: </strong> {{($userDetail->can_contact_supervisor == "Y")? 'Yes': 'No'}}</div>
			</p>
		</div>
		@endif
	</div>
	@else
		<div class="row">
			<div class="col-md-12 mb10">
		    	<h5>Personal details not found.</h5>
		    	<hr />
		    </div>
	    </div>
	@endif
