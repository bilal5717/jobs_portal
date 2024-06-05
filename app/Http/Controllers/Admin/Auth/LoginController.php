<?php
namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Model\Admin\AdminRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Model\Admin\Admin;

class LoginController extends Controller
{  

    use AuthenticatesUsers;
    
    protected $redirectTo = '/app-admin'; //Redirect after authenticate

    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout'); //Notice this middleware
    }
    
     protected function guard() // And now finally this is our custom guard name
    {
        return Auth::guard('admin');
    }
    public function showLoginForm() //Go web.php then you will find this route
    {
        return view('admin.auth.login');
    }
    
    public function login(Request $request) //Go web.php then you will find this route
    {
         $this->validateLogin($request);

        if ($this->attemptLogin($request)) {
        	session(['allowed_routes' => []]);
        	$loggedInRole = Auth::guard('admin')->user()->admin_role_id;
        	$adminId = Auth::guard('admin')->user()->id;
        	if($loggedInRole){
        		if($adminId != 1){
					$permissions = AdminRole::with('adminModules')->find($loggedInRole);
	        		if($permissions && $permissions->adminModules){
	        			$modules = $permissions->adminModules->toArray();
	        			$moduleNames = [];
	        			foreach($modules as $key => $module){
							$moduleNames[] = $module['route_name'];
						}
						session(['allowed_routes' => $moduleNames]);
	        		}
				}
        		
			}
        	
        	return redirect()->route('admin.dashboard');
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
       
    }

	protected function authenticated(Request $request, $user){
        toastr()->success('Admin Loggged in successfully.');  
     	return redirect()->intended('/app-admin/dashboard'); 
    }
    
     public function logout(Request $request)
    {
    	//die("admin logout");
        $this->guard('admin')->logout();

        //$request->session()->invalidate();

        return redirect('/app-admin/login');
    }
    
	/**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        return redirect()->route('admin.login');
    }
    
    /**
     * Where to redirect users after login.
     *
     * @return string
     */
    private function redirectTo()
    {
        return route('admin.dashboard');
    }

}
