@extends('admin.common.index')

@section('content')

    
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Project Management
                </div>
                <div class="card-body w-50 mx-auto">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="post" action="{{route('admin.project.store')}}" id="form">
                        @csrf
                         <div class="form-group">
                            <label for="companyName">Company Name</label>
                            <select class="form-control" name="company_id">
                                <option value="">Choose Company</option>
                            @foreach($companies as $company)
                                <option value="{{$company->id}}">{{$company->company_name}}</option>
                            @endforeach
                            </select>
                        </div>	
                        <div class="form-group">
                            <label for="name">Project Name:</label>
                            <input type="text" class="form-control" name="name" id="name"  placeholder="Enter name" required data-parsley-maxlength="30" data-parsley-minlength="5" data-parsley-trigger="change">
                        </div>
                        <div class="form-group">
                            <label for="name">Details:</label>
                            <textarea class="form-control" name="description" id="description"  placeholder="Provide project location or details" required></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                    </form>
                </div>
                
            </div>
        </div>

@endsection
