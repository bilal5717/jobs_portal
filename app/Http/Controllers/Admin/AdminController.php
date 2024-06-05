<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Admin\Admin;
use App\Model\Admin\AdminRole;
use App\Model\Admin\AdminModule;
use App\User;
use App\Company;
use App\Folder;
use App\File;
use Hash;
use Illuminate\Support\Facades\Auth;
class AdminController extends Controller
{
	public function __construct()
    {
    	$this->middleware('admin');
    	//dd("here");
    	/*if(!Auth::guard('admin')->user()){
			return redirect()->intended('/app-admin/login');
		}*/
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guard('admin')->user()){
        	$data = array();
        	$data['company'] = Company::count();
        	$data['folder'] = Folder::count();
        	$data['user'] = User::count();
        	$data['user_weekly'] = User::whereBetween('created_at', [now()->addDays(-7), now()])->count();
        	$data['company_weekly'] = Company::whereBetween('created_at', [now()->addDays(-7), now()])->count();
        	$data['folder_weekly'] = Folder::whereBetween('created_at', [now()->addDays(-7), now()])->count();
            return view('admin.dashbord_management.dashbord')->with(['counts' => $data]);
        } else {
        	$data = array();
        	return view('admin.auth.login')->with(['data' => $data]); 
        }
                
    }
    
    
    
    public function listAdmins(){
        //$adminUsers = Admin::paginate(7);
        $adminUsers = Admin::with('adminRole')->paginate(7);
        return view('admin.admin_management.index')
            ->with('admin_users',$adminUsers);
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
        $roles = AdminRole::all();
        $user       = Admin::find($id);
        return view('admin.admin_management.edit')
                ->with('user',$user)
                ->with('adminRoles', $roles);
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = AdminRole::all();
        //dd($roles);
        return view('admin.admin_management.create')
        	->with('adminRoles', $roles);
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
            'email' => 'required|unique:admins|max:255',
            'admin_role_id'=> 'required',
            'password'=> 'required'
        ]);
        
        dd($validatedData);
        Admin::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'status'          => $request->status,
            'admin_role_id'          => $request->admin_role_id,
            'password'       => Hash::make($request->password),
            'email_verified_at'       => now(),

        ]);
        toastr()->success("User created successfully.");
        return redirect(route('admin.admin_users'));
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        admin::destroy($id);
        //UserDetail::where('user_id', $id)->delete();
        //Delete All documents
        toastr()->success("User deleted successfully.");
        return redirect()->back();
    }
    
    public function appAdmin()
    {
        return redirect()->intended('/app-admin');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_profile(Request $request, $id)
    {
        //
        $validatedData = $request->validate([
            "name"          => "required|max:255",
            "email"         => "required|unique:admins,email,$id|max:255",
        ]);
        $user = Admin::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        if(isset($request->status)){
        	$user->status = $request->status;
		}
        if(isset($request->admin_role_id)){
        	$user->admin_role_id = $request->admin_role_id;
		}
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }
        $user->save();
        toastr()->success("Profile updated successfully.");
        //return $id;
       	return redirect('app-admin/admin_users');
    }
    
    
    /**
	* Roles Management
	*/
    public function adminsRoles(){
        $adminsRoles = AdminRole::paginate(7);
		
        return view('admin.admin_management.admin_roles.index')
            ->with('admin_roles',$adminsRoles);
	}
	public function createRole()
    {
        //dd($roles);
        return view('admin.admin_management.admin_roles.create');
    }
    
    public function addRole(Request $request)
    {
        //
        $validatedData = $request->validate([
            'name'  => 'required|max:255',
            'description' => 'required'
        ]);
        $permission = AdminRole::create([
            'name'           => $request->name,
            'description'          => $request->description

        ]);
        
        if($permission->id){
			toastr()->success("Role created successfully.");
			toastr()->info("Now add role permissions.");
        	return redirect(route('admin.edit_role', $permission->id));
		}
        
        return redirect(route('admin.admin_roles'));
    }
    
    public function editRole($id)
    {
        $role = AdminRole::find($id);
        if(!$role){
			toastr()->error("The selected role does not exist.");
        	return redirect(route('admin.admin_roles'));
		}
        
        /**
		* after Checking assigned Modules
		*/
        $allModules = array();
        $allModules = AdminModule::get()->toArray();
        $selectedModules = array();
        if(isset($role->adminModules)){
        	$selectedModules = $role->adminModules->toArray();
		}
		$processedModules = CompareAndAddElementToArray($allModules, $selectedModules);
		$modulesTree = buildTree($processedModules);//Using Custom Helper
		
        return view('admin.admin_management.admin_roles.edit')
            ->with('role', $role)
            ->with('modules', $modulesTree);
    }
    
    public function updateRole(Request $request, $id)
    {
    	
        $validatedData = $request->validate([
            "name"          => "required|unique:admin_roles,name,$id",
            "description"         => "required",
        ]);
        
        $role = AdminRole::find($id);
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();
        
        if($request->permission_ids){
        	$PerIds = explode(",", $request->permission_ids);
			$role->adminModules()->sync($PerIds);
		}
        
        toastr()->success("Role updated successfully.");
        //return $id;
       	return redirect(route('admin.admin_roles'));
    }
    
    public function deleteRole($id)
    {
        AdminRole::destroy($id);
        //UserDetail::where('user_id', $id)->delete();
        //Delete All documents
        toastr()->success("Role deleted successfully.");
        return redirect()->back();
    }
}
