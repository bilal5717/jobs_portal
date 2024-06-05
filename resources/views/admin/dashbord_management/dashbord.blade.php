@extends('admin.common.index')
@section('content')
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Dashbord Here
                </div>
                <div class="card-body">
                	<div class="container">
	                    <div class="row">
	                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
	                            <div class="dash-box red-bg">
	                                <div class="dash-content">
	                                    <h3>{{$counts['user_weekly']}}</h3>
	                                    <p>New Users (Last Week)</p>
	                                    <i class="fa fa-users"></i>
	                                </div>
	                                <div class="dash-foot darkredbg">
	                                    <a href="{{url('app-admin/user')}}"> Total Users 
	                                        <i>{{$counts['user']}}</i>
	                                    </a>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
	                            <div class="dash-box red-bg">
	                                <div class="dash-content">
	                                    <h3>{{$counts['company_weekly']}}</h3>
	                                    <p>New Companies (Last Week)</p>
	                                    <i class="fa fa-globe"></i>
	                                </div>
	                                <div class="dash-foot darkredbg">
	                                    <a href="{{url('app-admin/company')}}"> Total Companies 
	                                        <i>{{$counts['company']}}</i>
	                                    </a>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
	                            <div class="dash-box red-bg">
	                                <div class="dash-content">
	                                    <h3>{{$counts['folder_weekly']}}</h3>
	                                    <p>New Folders (Last Week)</p>
	                                    <i class="fa fa-folder-open"></i>
	                                </div>
	                                <div class="dash-foot darkredbg">
	                                    <a href="{{url('app-admin/folders')}}"> Total Folders 
	                                        <i>{{$counts['folder']}}</i>
	                                    </a>
	                                </div>
	                            </div>
	                        </div>
	                        
	                    </div>
	                </div>
                </div>
            </div>
        </div>

	<style>
		.dash-box {text-align: center;position: relative; border-radius: 5px;}
		.red-bg{ background-color: #45a9c7; }
		.dash-content{ padding: 10px; }
		.dash-content p{ color: #fff; }
		.dash-content h3{ text-align: right;color: #fff; }
		.dash-content .fa{ font-size: 70px; position: absolute;top: 5px;left: 5px;color: #000;opacity: 0.1; }
		.dash-foot a{display: flex;justify-content: space-between;align-items: center;padding: 5px;text-transform: uppercase;color: #cdcdcd;}
		.dash-foot a:hover{ color: #fff;text-decoration: none; }
		.darkredbg{background-color: #929e3d;}

	</style>

@endsection
@section('script')
<script>
  /*window.onload = function(){
      
      $(document).ready(function(){
        var multipleSelect =  $('#employee').select2({
          placeholder: "-- Select --"

        });
        

      })
  }*/
  
  
</script>
@endsection
