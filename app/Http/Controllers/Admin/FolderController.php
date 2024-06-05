<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  App\Folder;
use Illuminate\Support\Str;
use  App\File as SubFile;
use  File;
use App\User;
use PDO;
use App\Company;
use Illuminate\Support\Facades\Mail;
use App\Mail\FileAssignMail;
class FolderController extends Controller	
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
    public function index(Request $request, $parentFolder = '')
    {
        /*if (!empty($request->except('_token'))){
        	dd($includeSubFolders);
		}*/
        $includeSubFolders = ($request->get('sub_folders') && $request->get('sub_folders') == 'on') ? TRUE : FALSE;
        $searched = (!empty($request->except('_token'))) ? TRUE : FALSE;
        $files = array();
        $bredcrumbPath = array();
        $companies = Company::all();
        $parent  = false;
        $redirect_path          = 'app-admin/folder';
        if(!empty($parentFolder)){
            //dd($parentFolder);
            $parent_folder  = Folder::find($parentFolder);
            if(!$parent_folder){
				toastr()->error("Folder does not exist.");
    			return redirect($redirect_path);
			}
            $folders        = Folder::filter($request)->where('id', '<>', $parent_folder->id)
                                    ->where('parent_id', $parent_folder->id)
                                    ->get();
            // dd($folders);   
            $parent = true;                     
			$bredcrumbPath = $this->findAncestorFolderCrumb("breadcrumb", $parent_folder);
			$files = SubFile::where("folder_id",$parent_folder->id)->get();
        } else {
            //$folders = Folder::where('parent_id','0')->get();
            if($includeSubFolders){
				$folders = Folder::filter($request)->get();
			}else{
            	$folders = Folder::filter($request)->with('companies')->where('parent_id','0')->get();
			}
            $files = SubFile::where("folder_id","0")->get();
        }
        
        foreach($folders as $key => $folder){
        	$subFolders = Folder::where('parent_id', $folder->id)->get()->count();
        	$subFiles = SubFile::where('folder_id', $folder->id)->get()->count();
        	$folders[$key]->files_count = $subFiles + $subFolders;
			
		}
        $employees = User::where('type','user')->get();
        return view('admin.folders_management.index')
                ->with('folders',$folders)
                ->with('files',$files)
                ->with('parent',$parent)
                ->with('parentID',$parentFolder)
                ->with('bredcrumbPath',$bredcrumbPath)
                ->with('companies',$companies)
                ->with('searched', $searched);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($parentFolder = '')
    {
        $companies = Company::all();
        $selectedComId = 0;
        if(!empty($parentFolder)){
	        $selectedCompany = Folder::with('companies')->find($parentFolder)->toArray();
	        if($selectedCompany['companies']){
				$selectedComId = $selectedCompany['companies'][0]['id'];
			}
		}
        return view('admin.folders_management.create')
                    ->with('parentID',$parentFolder)
                    ->with('companies',$companies)
                    ->with('selected_company', $selectedComId);
        // ->with('user_id',$id);
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
        ]);
            // dd($request->id);
        $parent_folder          =  $request->parent_id;
        if(!empty($parent_folder)){
            $folder                 =   Folder::find($parent_folder);
            $absolute_path          = $this->findAncestorFolder($folder);
            $parentFolderName       = Folder::find($parent_folder);
            $complete_path          = $absolute_path;
            $redirect_path          = 'app-admin/subfolder/'.$parent_folder.'/view';
        }else{
            $complete_path         = public_path().'/user_folders/';
            $parent_folder          =  '0';
            $redirect_path          = 'app-admin/folder';
        }
        // Create Folder  inside user directory
        if (!File::exists($complete_path.'/'.$request->name)) {
            $create_user_director   = File::makeDirectory($complete_path.'/'.$request->name, $mode = 0777, true, true);
        }  else {
            toastr()->error("Folder already exists.");
            return redirect('app-admin/folder');
        }   
           
        $folderId = Folder::create([
            'name'              => $request->name,
            'slug'              => Str::slug($request->name, '-'),
            'parent_id'         => $parent_folder,
            'user_id'           => $request->user_id,

        ])->id;
        
        if($parent_folder == '0'){
	        $company = Company::findOrFail($request->company_id);
	        if ( !$company->folders->contains($folderId)) {
	            $company->folders()->attach($folderId);
	        }			
		}

        
        toastr()->success("Folder created successfully.");
        return redirect($redirect_path);
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $companies = Company::all();
        $folder = Folder::find($id);
        $selectedComId = NULL;
        $parentFolder = $folder->parent_id;
        if($parentFolder == 0){
			$companyFolderId = $id;
		}else{
			$companyFolderId = $folder->parent_id;
		}
        $selectedCompany = Folder::with('companies')->find($companyFolderId)->toArray();
        if($selectedCompany['companies']){
			$selectedComId = $selectedCompany['companies'][0]['id'];
		}
        return view('admin.folders_management.edit')
        	->with('folder',$folder)
        	->with('companies',$companies)
        	->with('selected_company', $selectedComId);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
    	$redirect_path = "app-admin/folder";
        $validatedData = $request->validate([
            'name'  => 'required|max:255',
        ]);
        $mainFolder   =  $request->folder_id;
        // Find nth sub directory Algo
        if(!empty($mainFolder)){
            $folder                 =   Folder::find($mainFolder);
            
            $absolute_path          =   $this->findAncestorFolder($folder);
            $new_directory_name     =   $absolute_path.$request->name;
            $old_directory_name     =   $absolute_path ; 
            if($folder->parent_id != "0"){
                // Back  to Child Folder
                $one_directory_back     = $folder->parent_id;
                print_r($one_directory_back);
                $redirect_path          = 'app-admin/subfolder/'.$one_directory_back.'/view';
            } else {
                $redirect_path = "app-admin/folder";
            }
            
        	// Replace OLD  DIRECTORY NAME WITH NEW DIRECTORY
	        $explode_path                   = explode("/",$absolute_path); 
	        $secondLastIndex                = count($explode_path) - 2;
	        $explode_path[$secondLastIndex] = $request->name;
	        $new_directory_path_name        = implode("/",$explode_path);
	        // Rename Folder  inside user directory
	        if (! File::exists($new_directory_name)) {
	            @rename($old_directory_name,$new_directory_path_name);
	        }  else {
	            toastr()->error("Folder already exists.");
	            return redirect($redirect_path);
	        } 
	          
		    $folder->name  = $request->name;
		    $folder->slug  = Str::slug($request->name, '-');
		    $folder->save();
			if($folder->parent_id == "0"){
			    $folder->companies()->detach();
			    $folder->companies()->attach($request->company_id);
			}

        } 


	    toastr()->success("Folder updated successfully.");
    	return redirect($redirect_path);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $folder   =   Folder::find($id);
        $this->deleteFoldersTree($folder);
        $absolute_path = $this->findAncestorFolder($folder);
        $this->delete_files($absolute_path);
        Folder::destroy($id);
        $folder->companies()->detach();
        toastr()->success("Folder deleted successfully.");
        return redirect()->back();
    }

	protected function deleteFoldersTree($folder){
		$children = $folder->children()->get();
		foreach($children as $key => $child){
			if($child->children()->exists()){
				$this->deleteFoldersTree($child);
			}
			$child->files()->delete();
			$child->delete();
		}
	}

    public function assignFolder(Request $request){
    	$employees = array();
    	if(isset($request->employees)){
    		$employees = $request->employees;
		}else{
			if(isset($request->company_id)){
    			$companyId = $request->company_id;
				$employees = User::where('type','user')->where('company_id',$companyId)->pluck('id')->toArray();
			}
			
		}
    	if($employees){
	        foreach($employees as $emp){
	            $employee = User::findOrFail($emp);
	            if ( !$employee->folders->contains($request->folder_id)) {
	                $employee->folders()->attach($request->folder_id);
	                $data['name'] = $employee->name;
	                Mail::to($employee->email)->send(new FileAssignMail($data));
	            }
	        }
        	toastr()->success('Folder assigned to employee(s) successfully.');
		}

        return redirect()->back();
    }
    
    function delete_files($target) {
        error_reporting(0);
        if(is_dir($target)){
            $files = glob( $target . '*', GLOB_MARK );
            foreach( $files as $file )
            {
                $this->delete_files( $file );      
            }
            // print_r($target);
            rmdir( $target );
        } elseif(is_file($target)) {
            unlink( $target );  
        }
    }
    public  function findAncestorFolder($folder){
        $i = 0;
        $pid = "";
        $path = array();
        $loop = true;
        // echo "<pre>";
        while($loop){
            
            if($i == 0){
                array_push($path,$folder->name);
                $pid = $folder->parent_id;
            }
            
            if($pid != "0"){
                $folder = Folder::find($pid);
                $pid = $folder->parent_id;
                array_push($path,$folder->name);

            } else  {
                $loop = false;
            }
            if($loop == false) {
                break;
            }
            $i++;
        }
        $sortPath = array_reverse($path);
        $absolute_path = public_path().'/user_folders/';
        foreach($sortPath as $sPath){
            $absolute_path .= $sPath . "/";
        }
        return $absolute_path;
    }

    public function findAncestorFolderCrumb($breadcrumb,$folder){
        
        // $child_direcotry = $folder;
        $i = 0;
        $pid = "0";
        $path = array();
        $loop = true;
        $single = array();
        // echo "<pre>";
        while($loop){
            // Push Current Directory
            if($i == 0){
            	$single = array(
            		"name" => $folder->name,
            		"id" => $folder->id
            	);
                array_push($path, $single);
                $pid = $folder->parent_id;
            }
            // Push Parent Directory if the folder contains the parent directory
            if($pid != "0"){
                $folder = Folder::find($pid);
                //dd($pid);
                $pid = $folder->parent_id;
                $single = array(
            		"name" => $folder->name,
            		"id" => $folder->id
            	);
                array_push($path, $single);

            } else  {
                $loop = false;
            }
            if($loop == false) {
                break;
            }
            $i++;
        }
        $sortPath = array_reverse($path);
        if(!empty($breadcrumb)){
            return $sortPath;
        } else {
            $absolute_path = public_path().'/user_folders/';
        }
        
        foreach($sortPath as $sPath){
            $absolute_path .= $sPath['name'] . "/";
        }
        return $absolute_path;
    }

}
