<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\File;
use App\Folder;
use App\User;
use App\Company;
//use App\Jobs\SendEmailAssignFileJob;
use Carbon\Carbon;
use App\Mail\FileAssignMail;
use Illuminate\Support\Facades\Mail;
class FileController extends Controller
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
    public function index($folder_id)
    {
        $bredcrumbPath = array();
        if($folder_id == "root"){
            $files = File::where("folder_id","0")->get();
        } else {
            $files = File::where("folder_id",$folder_id)->get();
	        $parent_folder  = Folder::find($folder_id);
	        $bredcrumbPath = $this->findAncestorFolderCrumb("breadcrumb", $parent_folder);
        }
        $employees = User::where('type','user')->get();
        $companies = Company::all();
        return view('admin.files_management.index')
                    ->with('files',$files)
                    ->with('folder_id',$folder_id)
                    ->with('employees',$employees)
                    ->with('bredcrumbPath', $bredcrumbPath)
                    ->with('companies',$companies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($folder_id)
    {
        //
        $bredcrumbPath = array();
        if($folder_id){
	        $parent_folder  = Folder::find($folder_id);
	        if($parent_folder){
		    	$bredcrumbPath = $this->findAncestorFolderCrumb("breadcrumb", $parent_folder);
			}
		}

        return view('admin.files_management.create')
        		->with('folder_id',$folder_id)
        		->with('bredcrumbPath', $bredcrumbPath);
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
            //'file'  => 'required|max:10000|mimes:doc,docx,jpeg,pdf,png',
            'file'  => 'required|mimes:doc,docx,pdf,xls,xlsx,csv,png,jpg,jpeg,gif,webp',
            'folder_id'  => 'required',
        ]);
        $folder = Folder::find($request->folder_id);
        if($request->folder_id == "root"){
            $absolute_path = public_path(). '/user_folders/';
            $folder_id     = '0';
        } else {
            $absolute_path = $this->findAncestorFolder($folder);
            $folder_id     = $request->folder_id;
        }
        
        //dd($request->has('file'));
        if($request->has('file')){
            $file = $request->file('file');
            $orignalName = $file->getClientOriginalName();
            $mimeType = $file->getClientMimeType();
            $time = microtime('.') * 10000; 
            $filename = $time.'.'.strtolower( $file->getClientOriginalExtension() );
            $destination = $absolute_path;
            $file->move($destination, $filename);
            
            //Save to database
            $fileId = File::create([
	            'file' => $filename,
	            'orignal_name' => $orignalName,
	            'mime_type' => $mimeType,
	            'folder_id' => $folder_id
	        ])->id;
	        
	        if(is_numeric($folder_id) && (int)$folder_id > 0 && $fileId){
	        	$company = $this->getFolderCompany($folder_id);
		        if(isset($company['id'])){
	    			$companyId = $company['id'];
					$employees = User::where('type','user')->where('company_id',$companyId)->get();
			    	if($employees){
				        foreach($employees as $employee){
			                $data['name'] = $employee->name;
			                Mail::to($employee->email)->send(new FileAssignMail($data));
				        }
			        }
		        }

			}

	        
	        //Show notification
        	toastr()->success("File uploaded successfully in [".$folder->name."] folder.");
        }
		return response()->json([
		    'status' => true,
		    'message' => 'File uploaded successfully.',
		]);
        //return redirect('app-admin/subfolder/'.$request->folder_id.'/view');
        //return redirect('app-admin/folder/'.$request->folder_id.'/file/upload');
    }

	public function getFolderCompany($folderId){
		//ini_set('xdebug.max_nesting_level', -1);
		$folders = Folder::where('id', $folderId)->first();
		$companyData = array();
		if($folders->parent_id == 0){
			$topFolderId = $folders->id;
			$company = Folder::with('companies')->find($topFolderId)->companies;
			$companyArr = $company->toArray();
			if(isset($companyArr[0])){
				$companyData = $companyArr[0];
			}
		}else{
			$companyData = $this->getFolderCompany($folders->parent_id);
		}
		return $companyData;
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
    public function edit($fodlerID,$fileID)
    {
        //
        $file = File::find($fileID);
        return view('admin.files_management.edit')->with('file',$file)->with('folder_id',$fodlerID);
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
        //
        $validatedData = $request->validate([
            'file'  => 'required|max:10000|mimes:doc,docx,jpeg,pdf,png',
        ]);
        $folder = Folder::find($request->folder_id);
        if($request->folder_id == "root"){
            $absolute_path = public_path(). '/user_folders/';
        } else {
            $absolute_path = $this->findAncestorFolder($folder);
        }
        if($request->has('file')){
            $file = $request->file('file');
            $orignalName = $file->getClientOriginalName();
            $mimeType = $file->getClientMimeType();
            $time = microtime('.') * 10000; 
            $filename = $time.'.'.strtolower( $file->getClientOriginalExtension() );
            $destination = $absolute_path;
            $file->move($destination, $filename);
            
	        $file = File::find($request->file_id);
	        // Delete Old  file
	        $path = $absolute_path.'/'.$file->file;
	        unlink($path);
	        // Save new  file in DB
	        $file->file = $filename;
	        $file->orignal_name = $orignalName;
	        $file->mime_type = $mimeType;
	        $file->save();
	        toastr()->success("File updated successfully.");
        }
        return redirect('app-admin/subfolder/'.$request->folder_id.'/view');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($folderID,$fileID)
    {
        
        $folder         = Folder::find($folderID);
        $file           = File::find($fileID);
        if($folderID == "root"){
            $absolute_path = public_path(). '/user_folders/';
        } else {
            $absolute_path  = $this->findAncestorFolder($folder);
        }
        


        $path = $absolute_path.'/'.$file->file;
        // Delete File 
        @unlink($path);
        File::destroy($fileID);
        toastr()->success("File deleted successfully.");
        return redirect()->back();
    }


    public function assignFile(Request $request){
        $data = array();
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
	            if ( !$employee->files->contains($request->file_id)){
	                 //dispatch(new SendEmailAssignFileJob());
	                 /*$data['name'] = $employee->name;
	                 Mail::to($employee->email)->send(new FileAssignMail($data));*/
	                 
	                $data['name'] = $employee->name;
	                Mail::to($employee->email)->send(new FileAssignMail($data));
	                $employee->files()->attach($request->file_id);
	            }
	           
	            
	        }
        }
        toastr()->success('Employee assigned successfully.');
        return redirect()->back();
    }


    public function findAncestorFolder($folder){
        
        // $child_direcotry = $folder;
        $i = 0;
        $pid = "";
        $path = array();
        $loop = true;
        // echo "<pre>";
        while($loop){
            // Push Current Directory
            if($i == 0){
                array_push($path,$folder->name);
                $pid = $folder->parent_id;
            }
            // Push Parent Directory if the folder contains the parent directory
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
        $pid = "";
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
