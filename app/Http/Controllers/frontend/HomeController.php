<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\User;
use App\UserDetail;
use App\Document;
use App\Folder;
use PDO;
use Hash;
use  App\File as Userfile;
use  File;

use Illuminate\Support\Facades\Response;
use ZipArchive;
class HomeController extends Controller
{
    //
    public function index($folderId = null, $folderSlug = ""){
        $user = User::find(Auth::user()->id);
    	$userDetail = $user->UserDetail;
    	$stepNo = $user->step;
		$percentage =  ($stepNo / 5) * 100;
		$percentage = (int)$percentage;

        return view('frontend.home')
        ->with('user', $user)
        ->with('userDetail', $userDetail)
        ->with('step', $stepNo)
        ->with('percentage', $percentage);
    }

    public function account($stepId = NULL){
    	$userDetail = array();
    	$userJobDetail = array();
    	$user = User::find(Auth::user()->id);
    	
    	$userDetail = $user->UserDetail;
    	$userJobDetail = $user->UserJobDetail;
    	
    	$Documents = Document::all()->toArray();
    	$userDocument = $user->UserDocument;
    	if($user->image){
    		$savedStep = $user->step + 1;
		}else{
			$savedStep = 1;
		}
    	if($stepId){
    		if($stepId > $savedStep){
				$stepNo = $savedStep;
				toastr()->error("You can not proceed without completing your previuos steps.");
				return redirect("/account/$stepNo")
				->with('userDetail', $userDetail)
				->with('userJobDetail', $userJobDetail)
				->with('documents', $Documents)
		        ->with('user', $user)
		        ->with('step', $stepNo);
			}else{
    			$stepNo = $stepId;
			}
		}else{
			$stepNo = $savedStep;
		}
        return view('frontend.account')
        ->with('user', $user)
        ->with('userDetail', $userDetail)
        ->with('userJobDetail', $userJobDetail)
        ->with('documents', $Documents)
        ->with('userDocument', $userDocument)
        ->with('savedStep', $savedStep)
        ->with('step', $stepNo);
    }

    public function download($fileid){
        $file   = Userfile::find($fileid);
        if($file->folder_id != "0"){
            $folder = Folder::find($file->folder_id);
            $path   = $this->findAncestorFolder("",$folder);
        } else {
            $path   = public_path().'/user_folders/';
        }
        
        $download_file   = $path . $file->file;
        $ext    = preg_replace('/^.*\.([^.]+)$/D', '$1', $file->file);
        $headers = array("Content-Type: application/$ext");
        return Response::download($download_file,  $file->orignal_name, $headers);
    }

    public function multiple(Request $request){
        $zip = new ZipArchive;
        $zip_name = time().".zip";
		$folderName = NULL;
        $res = $zip->open(public_path().'/'.$zip_name, ZipArchive::CREATE);
        if ($res === TRUE) {
        	$path = '';
            foreach($request['files'] as $file){
                $file   = File::find($file);
                if($file->folder_id != "0"){
                    $folder = Folder::find($file->folder_id);
                    $path   = $this->findAncestorFolder("",$folder);
                    if(!$folderName){
						$folderName = $folder->name;
					}
                } else {
                    $path   =  public_path().'/user_folders/';
                }
                // echo $path.$file->file;
                $zip->addFile($path.$file->file,$file->orignal_name);
            }
            if($folderName){
            	@$zip->addFromString('aaa_info.txt', ' H2O Enviromental ' . PHP_EOL . ' Folder name: ' . $folderName . PHP_EOL .' Folder path: ' . $_SERVER['HTTP_REFERER']);
			}
            $zip->close();
        } else {
            echo 'failed, code:' . $res;
        }
        return response()->json(['zip'=>$zip_name]);

    }

    public function downloadzip($zipname){
        $download_file   = public_path()."/$zipname";
        $headers = array("Content-Type: application/zip");
        return Response::download($download_file,  $zipname, $headers)->deleteFileAfterSend(true);
        // unlink($download_file);
    }

    public function findAncestorFolder($breadcrumb,$folder){
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
            "email"         => "required|unique:users,email,$id|max:255",
            //'company_id'  => 'required',
        ]);
        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->company_id = $request->company_id;
        if(!empty($request->password)){
            $user->password = Hash::make($request->password);
        }
        $user->save();
        toastr()->success("Profile updated successfully.");
        //return $id;
       	return redirect('/');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_profile_wizard(Request $request)
    {
        $id = $request->user_id;
        if($id != Auth::user()->id || !isset(Auth::user()->id)){
			return;
		}
		$User = User::find($id);
		$savedStep = $User->step;
		$userStatus = $User->user_status;
		$UserDetail = $User->UserDetail();// Get instances
		$userDetails = $User->UserDetail;//Get attributes
		$UserJobDetailInstance = $User->UserJobDetail();// Get instances
		$UserJobDetail = $User->UserJobDetail;// Get instances
		
        $stepNo = $request->step;
        if($stepNo == 1){
	        $validator = Validator::make($request->all(), [
	        	"image"          => "required",
	            "name"          => "required|max:255",
	            "email"         => "required|unique:users,email,$id|max:255",
	        ]);
		}elseif($stepNo == 2){
			if(isset($UserJobDetail->id)){
				$uniqueCheck = "unique:user_job_details,license_number," . $UserJobDetail->id;
			}else{
				$uniqueCheck = "unique:user_job_details,license_number";
			}
			if(isset($request->job_type) && !empty($request->job_type)){
				$validator = Validator::make($request->all(), [
		            "license_name"          => "required",
		            "license_number"          => "required|$uniqueCheck|max:255",
		        ]);
			}else{
				$validator = Validator::make($request->all(), [
		            "job_type"          => "required",
		        ]);
			}
		}elseif($stepNo == 3){
			
			$validator = Validator::make($request->all(), [
	            "contact"         => "required",
	            'address'  => 'required',
	            "city"          => "required",
	            "state"          => "required",
	            "zipcode"          => "required",
	        ]);
		}
		
        if ($validator->fails()){
        	$messages = $validator->errors();
        	if($messages->messages()){
	        	foreach($messages->messages() as $key => $value){
					$msg = $value[0];
					toastr()->error($msg);
				}
			}
            return redirect('/account/'.$stepNo);
        }
        
		if($savedStep < $stepNo){
			$User->step = $stepNo; 
		}		
		
		if($stepNo == 1){
			$User->name = $request->name;
        	$User->email = $request->email;
		}elseif($stepNo == 2){
			// "000103918"
			/**
			* Check License expiry 
			*/
			$licenseError = NULL;
			$licenseNumber = $request->license_number;
		    $licenseDetails = securityLicenseCheck($licenseNumber);
		    if($licenseDetails){
				$licenseData = $licenseDetails[0];
				if(isset($licenseData->status) && $licenseData->status == "Current"){
					//OK
				}else{
					$licenseError = "Your provided security has been expired, you can not proceed with expired license.";
				}
			}else{
				$licenseError = "Your provided security license is not valid.";
			}
			if($licenseError){
	        	toastr()->error($licenseError);
            	return redirect('/account/'.$stepNo);
			}
			
			$arraData = $request->except(['_token', 'step', 'documents']);
			
			if(isset($arraData['clases'])){
				$arraData['clases'] = json_encode($arraData['clases']);
			}
			//dd($arraData);
			/*
			** Save user job details & data
			*/
			if($UserJobDetail){
				$UserJobDetailInstance->update($arraData);
			}else{
				$UserJobDetailInstance->create($arraData);
			}
			
			/*
			** Save user selected documents and delete old ones
			*/
			$UserDocumentInstance = $User->UserDocument();// Get instances
			$UserDocuments = $User->UserDocument;//Get attributes
			$allDocs = $request->documents;
			if($allDocs){
				$docNames = array();
				foreach($allDocs as $docName => $docFile){
					if($request->hasFile("documents.$docName")){
			            
			            $destination = public_path(). '/user_images/'.$id.'/documents/';
						$file = $docFile;
			            $filename = $docName.'.'.strtolower( $file->getClientOriginalExtension() );
			            if (!File::exists($destination)) {
				            File::makeDirectory($destination, $mode = 0777, true, true);
				        }else{
							if(isset($UserDocuments->$docName) && !empty($UserDocuments->$docName)){
								$oldFile = $destination . $UserDocuments->$docName;
								if(file_exists($oldFile)){
									unlink($oldFile);
								}
							}
						}
			            //First perform delete
			            $file->move($destination, $filename);
			            $docNames[$docName] = $filename;
					}
				}
				if($docNames){
					if($UserDocuments){
			    		$UserDocumentInstance->update($docNames);
					}else{
			    		$UserDocumentInstance->create($docNames);
					}
				}
			}
		}else{
			if($userStatus == 'new' && $stepNo == 3){
				$User->user_status = "pending";
			}
			$userDetailData = $request->except(['_token', 'step']);
			if(isset($userDetails->id)){
				//dd($userDetailData);
				UserDetail::find($userDetails->id)->update($userDetailData);
			}else{
				$UserDetail->create($userDetailData);
			}
		}
		$User->save();
        toastr()->success("Profile updated successfully.");

       	$stepNo = $request->step + 1;
        return redirect('account/'.$stepNo);
        /*return view('frontend.account/')
	        ->with('user', $User)
	        ->with('step', $stepNo)
	        ->with('userDetail', $userDetails)
	        ->with('userJobDetail', $UserJobDetail);*/
    }
    
    public function uploadProfileImage(Request $request){
		$validatedData = $request->validate([
            'avatar'  => 'required|max:2000|mimes:jpeg,png',
            'user_id'  => 'required',
        ]);
        $userId = $request->user_id;
        $user = User::find($userId);
        if($request->has('avatar') && $user){
        	$oldImageName = $user->image;
            $file = $request->file('avatar');
            $time = microtime('.') * 10000;
            $filename = $time.'.'.strtolower( $file->getClientOriginalExtension() );
            $destination = public_path(). '/user_images/'.$userId.'/';
            if (!File::exists($destination)) {
	            File::makeDirectory($destination, $mode = 0777, true, true);
	        }
            $file->move($destination, $filename);
            $user->update(array('image' => $filename));
            if(File::exists($destination . $oldImageName) && !empty($oldImageName)){
				//dd($destination . $oldImageName);
				unlink($destination . $oldImageName);
			}
	        //Show notification
        	toastr()->success("Profile image uploaded successfully.");
        	$response = array(
			    'status' => true,
			    'message' => 'Profile image uploaded successfully.',
			    'url' => asset('public/user_images/' . $user->id . '/' . $filename)
			);
        }else{
			$response = array(
			    'status' => false,
			    'message' => 'Unable to upload profile image.',
			    'url' => asset('public/frontend/assets/images/default.jpg')
			);
		}
		return response()->json($response);
	}
    
}
