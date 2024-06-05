@extends('admin.common.index')



@section('content')

        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Company Management
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
                    <form id="form" method="post" action="{{url('app-admin/company/'.$company->id)}}">
                        @csrf
                        @METHOD("PUT")
                        <div class="form-group">
                            <label for="name">Company Name:</label>
                            <input type="text" class="form-control" name="company_name" id="name"  value="{{$company->company_name}}" required data-parsley-maxlength="30" data-parsley-minlength="4" data-parsley-trigger="change">
                        </div>
                        <div class="form-group">
                            <label for="name">Details:</label>
                            <textarea class="form-control" name="description" id="description"  placeholder="Provide project location or details" required>{{$company->description}}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary float-right">Update</button>
                    </form>
                </div>
                
            </div>
        </div>
    
@endsection
