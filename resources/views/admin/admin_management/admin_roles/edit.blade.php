@extends('admin.common.index')



@section('content')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Edit Admin Role
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{route('admin.update_role', $role->id)}}" id="form">
                        @csrf
                        @METHOD("POST")
                        <div class="form-group">
                            <label for="name">Role Name:</label>
                            <input type="text" class="form-control" name="name" id="name"  value="{{$role->name}}" required data-parsley-maxlength="10" data-parsley-minlength="4" data-parsley-trigger="change">
                          </div>
                        <div class="form-group">
                          <label for="email">Description:</label>
                          <textarea class="form-control" name="description" id="description" placeholder="Enter role description" required>{{$role->description}}</textarea>
                        </div>
                        
                        <div class="form-group">
                          <label>Permissions:</label>
                          
                          	<ul class="treeview">
                          		@foreach($modules as $module)
                          		<li class="last">
						            <input type="checkbox" name="module_permissions[]" value="{{$module['id']}}" id="permissions_{{$module['id']}}">
						            <label for="permissions_{{$module['id']}}" data-value="{{$module['id']}}"  id="per_label_{{$module['id']}}" data-parent="{{$module['parent_id']}}" class="{{$module['assigned'] == TRUE ? 'custom-checked': 'custom-unchecked'}}">{{$module['name']}} <small style="color: {{($module['type'] == 'Action') ? 'red' : 'green' }};">({{$module['type']}})</small></label>
						            @if($module['sub_modules'])
							            @foreach($module['sub_modules'] as $subModule)
							            <ul>
							                 <li>
							                     <input type="checkbox" name="module_permissions[]" value="{{$subModule['id']}}" data-parent="{{$module['id']}}" class="permissions_sub_{{$module['id']}}" id="permissions_sub_{{$subModule['id']}}" checked />
							                     <label for="permissions_sub_{{$subModule['id']}}" data-value="{{$subModule['id']}}" data-parent="{{$subModule['parent_id']}}" class="{{$subModule['assigned'] == TRUE ? 'custom-checked': 'custom-unchecked'}}" >{{$subModule['name']}} <small style="color: {{($subModule['type'] == 'Action') ? 'red' : 'green' }};">({{$subModule['type']}})</small></label>
							                 </li>
							            </ul>
							            @endforeach
						            @endif
						        </li>
						        @endforeach
						        
						        <input type="hidden" name="permission_ids" id="permission_ids" value="" />
						        
						        <!--
						        	<li class="last">
						            <input type="checkbox" name="short" id="short">
						            <label for="short" class="custom-unchecked">Short Things</label>
							            <ul>
							                 <li>
							                     <input type="checkbox" name="short-1" id="short-1">
							                     <label for="short-1" class="custom-unchecked">Smurfs</label>
							                 </li>
							                 <li>
							                     <input type="checkbox" name="short-2" id="short-2">
							                     <label for="short-2" class="custom-unchecked">Mushrooms</label>
							                 </li>
							                 <li class="last">
							                     <input type="checkbox" name="short-3" id="short-3">
							                     <label for="short-3" class="custom-unchecked">One Sandwich</label>
							                 </li>
							            </ul>
						        	</li>
						        	<li>
						            <input type="checkbox" name="tall" id="tall">
						            <label for="tall" class="custom-unchecked">Tall Things</label>
						            
						            <ul>
						                 <li>
						                     <input type="checkbox" name="tall-1" id="tall-1">
						                     <label for="tall-1" class="custom-unchecked">Buildings</label>
						                 </li>
						                 <li>
						                     <input type="checkbox" name="tall-2" id="tall-2">
						                     <label for="tall-2" class="custom-unchecked">Giants</label>
						                     <ul>
						                         <li>
						                             <input type="checkbox" name="tall-2-1" id="tall-2-1">
						                             <label for="tall-2-1" class="custom-unchecked">Andre</label>
						                         </li>
						                         <li class="last">
						                             <input type="checkbox" name="tall-2-2" id="tall-2-2">
						                             <label for="tall-2-2" class="custom-unchecked">Paul Bunyan</label>
						                         </li>
						                     </ul>
						                 </li>
						                 <li class="last">
						                     <input type="checkbox" name="tall-3" id="tall-3">
						                     <label for="tall-3" class="custom-unchecked">Two sandwiches</label>
						                 </li>
						            </ul>
						        </li>-->
						    </ul>
                          
                        </div>
                        
                        <button type="submit" class="btn btn-primary float-right">Update</button>
                    </form>
                </div>
                
            </div>
        </div>
 
@endsection
@section('styles')
<style>
	
	* { margin: 0; padding: 0; }

	#page-wrap {
	  margin: auto 0;
	}

	.treeview {
	  margin: 10px 0 0 20px;
	}

	ul { 
	  list-style: none;
	}

	.treeview li {
	  padding: 2px 0 2px 16px;
	}

	.treeview > li:first-child > label {
	  /* style for the root element - IE8 supports :first-child
	  but not :last-child ..... */
	  
	}

	.treeview li.last {
	  background-position: 0 -1766px;
	}

	.treeview li > input {
	  height: 16px;
	  width: 16px;
	  /* hide the inputs but keep them in the layout with events (use opacity) */
	  opacity: 0;
	  filter: alpha(opacity=0); /* internet explorer */ 
	  -ms-filter:"progid:DXImageTransform.Microsoft.Alpha(opacity=0)"; /*IE8*/
	}

	.treeview li > label {
	  background: url(<?php echo @asset('public/assets/images/gr_custom-inputs.png'); ?>) 0 -1px no-repeat;
	  /* move left to cover the original checkbox area */
	  margin-left: -20px;
	  /* pad the text to make room for image */
	  padding-left: 20px;
	}

	/* Unchecked styles */

	.treeview .custom-unchecked {
	  background-position: 0 -1px;
	}
	.treeview .custom-unchecked:hover {
	  background-position: 0 -21px;
	}

	/* Checked styles */

	.treeview .custom-checked { 
	  background-position: 0 -81px;
	}
	.treeview .custom-checked:hover { 
	  background-position: 0 -101px; 
	}

	/* Indeterminate styles */

	.treeview .custom-indeterminate { 
	  background-position: 0 -141px; 
	}
	.treeview .custom-indeterminate:hover { 
	  background-position: 0 -121px; 
	}
</style>
@endsection

@section('script')
<script>
$(function() {

  $('input[type="checkbox"]').change(checkboxChanged);

  	function checkboxChanged(){
    	var $this = $(this),
        checked = $this.prop("checked"),
        container = $this.parent(),
        siblings = container.siblings();
		
		var allchildChecked = false;
		var parentId = $this.attr('data-parent');
		if(parentId){
			var classN = ".permissions_sub_"+parentId + ":checked";
			allchildChecked = $(classN).length > 0;
			console.log("allchildUnchecked: ", allchildChecked);
		}
	    container.find('input[type="checkbox"]')
	    .prop({
	        indeterminate: false,
	        checked: checked
	    })
	    .siblings('label')
	    .removeClass('custom-checked custom-unchecked custom-indeterminate')
	    .addClass(checked ? 'custom-checked' : 'custom-unchecked');
   		getCheckedIDs();
   		
   		//This line makes trouble with parents
   		//checkSiblings(container, checked, allchildChecked);
  }

  function checkSiblings($el, checked, allchildChecked) {
    var parent = $el.parent().parent(),
        all = true,
        indeterminate = false;

    $el.siblings().each(function() {
      return all = ($(this).children('input[type="checkbox"]').prop("checked") === checked);
    });
	
    if (all && checked) {
      parent.children('input[type="checkbox"]')
      .prop({
          indeterminate: false,
          checked: checked
      })
      .siblings('label')
      .removeClass('custom-checked custom-unchecked custom-indeterminate')
      .addClass(checked ? 'custom-checked' : 'custom-unchecked');

      checkSiblings(parent, checked);
    }else if (all && !checked) {
      indeterminate = parent.find('input[type="checkbox"]:checked').length > 0;
		
      parent.children('input[type="checkbox"]')
      /*.prop("checked", checked)*/
      .prop("indeterminate", indeterminate)
      .siblings('label')
      .removeClass('custom-checked custom-unchecked custom-indeterminate')
      .addClass(indeterminate ? 'custom-indeterminate' : (checked ? 'custom-checked' : 'custom-unchecked'));

		if(!allchildChecked){
			parent.children('input[type="checkbox"]')
	      	.prop("checked", checked);
		}

      checkSiblings(parent, checked);
    }else {
      $el.parents("li").children('input[type="checkbox"]')
      .prop({
          indeterminate: true,
          checked: false
      })
      .siblings('label')
      .removeClass('custom-checked custom-unchecked custom-indeterminate')
      .addClass('custom-indeterminate');
    }
  }

	function getCheckedIDs(){
		var AllChecked = $('.custom-checked');
		var allIDs = [];
		$.each(AllChecked, function(key, element){
		    var selectedValue = $(this).attr("data-value");
		    var parentValue = $(this).attr("data-parent");
		    
		    //Check Parent
		    if(parentValue > 0){
		        var parentId = "#per_label_" + parentValue;
		        if($(parentId).hasClass('custom-checked')){
		            allIDs.push(selectedValue);
		        }
		    }else{
		        allIDs.push(selectedValue);
		    }
		})
		$('#permission_ids').val(allIDs);
	}
});
</script>
@endsection