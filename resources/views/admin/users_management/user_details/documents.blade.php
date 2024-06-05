
<div class="row">
	<div class="col-md-12 mb10">
    	<!--<h4>Job Related Details</h4>-->
    	<h5 style="text-transform: capitalize;">Uploaded documents by user</h5>
    	<hr />
    </div>
	<div class="col-md-12 col-sm-12 col-xs-12">
		@foreach($documents as $document)
        @php
        $userId = $user->id;
        $userDocument = $user->UserDocument;
        $existingDoc = getUserDocument($userId, $document['key'], $userDocument);
        @endphp
        <div class="col-md-12 col-sm-12">
    		<div class="form-group">
			    <div class="form-check">
			      <label class="form-check-label" for="gridCheck{{$loop->index}}">
			        {{$loop->index + 1}} &nbsp;&nbsp;&nbsp; {{$document['name']}} @if($document['is_required'] == 'N') <span>(Optional)</span> @else <sup>*</sup> @endif
			        &nbsp;
			        @if($existingDoc) 
			        	<a href='{{$existingDoc}}' target="_blank" download>Download</a> &nbsp; | &nbsp;
			        	<a href='{{$existingDoc}}' target="_blank">View</a>
			        @endif
			      </label>
			    </div>
			    <input type="file" id="{{$document['key']}}" name="documents[{{$document['key']}}]" class="form-control-file border" style="display: none;">
			</div>
    	</div>
        @endforeach
	</div>
	
	<div class="col-md-12">
		<p><hr /></p>
	</div>
	
</div>