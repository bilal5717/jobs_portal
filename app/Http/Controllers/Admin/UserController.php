<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\User;
use App\Company;
use App\UserDetail;
use App\UserDocument;
use App\UserJobDetail;
use App\Document;
use App\Model\Timetable\Timetable;
use App\Model\Timetable\TimetableHour;
use App\Model\Timesheet\Timesheet;
use App\Model\Timesheet\TimesheetDailyHour;
use Hash;
class UserController extends Controller
{
	/**
	* Apply Sconstructor method for middleware
	*/
	public function __construct()
    {
    	$this->middleware('admin');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $timetable = Timetable::where('status','=', 'active')->get()->first();
        $searched = (!empty($request->except('_token'))) ? TRUE : FALSE;
        $companies = Company::all();
        if($searched){
        	$users =	User::filter($request)->paginate(7);
		}else{
        	$users =  User::where('type','user')->paginate(7);
		}
		
        return view('admin.users_management.index')
        	->with('searched', $searched)
            ->with('users',$users)
            ->with('last_timetable',$timetable);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function jobRequests()
    {
        //
        $users =  User::where('user_status','pending')->paginate(7);
        //dd($users);
        return view('admin.users_management.job_apply')
            ->with('users',$users);
                
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function jobRequestAction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "user_id"          => "required",
            "job_action"         => "required",
        ]);
        if ($validator->fails()){
        	 toastr()->error("Parameters are missing.");
        }
        $action = $request->job_action;
        $user_id = $request->user_id;
        $User = User::find($user_id);
        if($User){
	        $data = array();
	        if($action == 'accept'){
				$data['user_status'] = "approved";
				$data['step'] = 3;
				toastr()->success("Employee accepted successfully.");
			}	
			if($action == 'reject'){
				$data['user_status'] = "rejected";
				toastr()->success("Employee rejected successfully.");
			}
			$User->update($data);		
		}
        $users =  User::where('user_status','pending')->paginate(7);
        return redirect('app-admin/user/applies')
            ->with('users',$users);
                
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.users_management.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'name'  => 'required|max:255',
            'email' => 'required|unique:users|max:255',
            'password'=> 'required'
        ]);
        User::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'password'       => Hash::make($request->password),
            'email_verified_at'       => now(),

        ]);
        toastr()->success("User created successfully.");
        return redirect('app-admin/user/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user       = User::find($id);
        
        $userDetail = array();
        $userJobDetail = array();
        
        if($user){
        	if($user->UserDetail){
	        	$userDetail = $user->UserDetail;
			}
			if($user->UserJobDetail){
	        	$userJobDetail = $user->UserJobDetail;
			}
			
	    	$timesheets = $user->timesheets->where('status', '!=', 'new');
	    	$Documents = Document::all()->toArray();
	        return view('admin.users_management.view_user')
                ->with('user',$user)
                ->with('userDetail', $userDetail)
                ->with('userJobDetail', $userJobDetail)
                ->with('documents', $Documents)
                ->with('timesheets', $timesheets);
		}else{
			return redirect(route('admin.user'));
		}
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $user       = User::find($id);
        return view('admin.users_management.edit')
                ->with('user',$user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $user = User::find($id);
        $validatedData = $request->validate([
            "name"          => "required|max:255",
            "email"         => "required|unique:users,email,$id|max:255",
        ]);
        $user->name = $request->name;
        $user->email = $request->email;
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }
        $user->save();
        toastr()->success("User updated successfully.");
        return redirect('app-admin/user/');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {
        $validatedData = $request->validate([
            "user_id"          => "required",
            "user_status"         => "required",
        ]);
        $user = User::find($request->user_id);
        if($user){
	        $user->user_status = $request->user_status;
	        $user->save();
	        toastr()->success("User ".$request->user_status." successfully.");			
		}

        return redirect(route('admin.user.index'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::destroy($id);
        UserDetail::where('user_id', $id)->delete();
        UserDocument::where('user_id', $id)->delete();
        UserJobDetail::where('user_id', $id)->delete();
        Timesheet::where('user_id', $id)->delete();
        TimetableHour::where('user_id', $id)->delete();
        //Delete All documents
    	$destination = public_path(). '/user_images/'.$id.'/';
    	if(\File::exists($destination)){
    		\File::deleteDirectory($destination);
		}
        toastr()->success("User deleted successfully.");
        return redirect()->back();
    }

    public function fetchEmployee($id){
        $employees = User::where('type','user')->where('company_id',$id)->get();
        return response()->json(['employees'=>$employees]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchUsers(Request $request)
    {
        $searched = (!empty($request->except('_token'))) ? TRUE : FALSE;
        $filters = $request->except('_token');
        if($searched){
        	$users =	User::filter($request)->get();
		}else{
        	$users =  User::where('type','user')->where('type','user')->get();
		}
		foreach($users as $key => $user){
			$users[$key]['profile_image'] = getProfileImage($user['id']);
		}
		
        return $users;
    }


}
