<?php

/**
* Return sum of times in format array("02:05", "11:00", "0:00")
* @param undefined $times
* 
* @return
*/

function sumArrayOfTimes($times = array()){
  		$all_seconds=0;
	foreach ($times as $time) {
        //list($hour, $minute, $second) = explode(':', $time);
        list($hour, $minute) = explode(':', $time);
        $all_seconds += (int)$hour * 3600;
        $all_seconds += (int)$minute * 60;
        //$all_seconds += $second;
    }
   $total_minutes = floor($all_seconds/60);
   $seconds = $all_seconds % 60;
   $hours = floor($total_minutes / 60); 
   $minutes = $total_minutes % 60;

    // returns the time already formatted
    return $hours.':'.$minutes;
}

function getProfileImage($userId = NULL){
	$ImageUrl = asset('public/frontend/assets/images/default.jpg');
	if($userId){
		$user = \App\User::find($userId);
        if($user){
        	$destination = public_path(). '/user_images/'.$userId.'/';
        	if(\File::exists($destination . $user->image) && !empty($user->image)){
        		$ImageUrl = asset('public/user_images/' . $user->id . '/' . $user->image);
			}
        }
	}
	return $ImageUrl;
}

function getadminName($adminId = NULL){
	$adminName = 'Admin';
	$admin = \App\Model\Admin\Admin::find($adminId);
	if($admin){
		$adminName = $admin->name;
	}
	return $adminName;
}

/**
* Description: get single document of a user by the user id and name and resourse
* @param Int/String $userId
* @param String $documentColumn : image field name or database colum name
* @param Object $documentsResource
* 
* @return String DocumentUrl
*/
function getUserDocument($userId, $documentColumn, $documentsResource = NULL){
	$documentUrl = NULL;
	if(!$documentsResource){
		$documentsResource = \App\UserDocument::where('user_id', $userId)->get()->first();
	}
	if($documentsResource){
		if(isset($documentsResource->$documentColumn) && !empty($documentsResource->$documentColumn)){
			$documentPath = '/user_images/'.$userId.'/documents/' . $documentsResource->$documentColumn;
			$rootPath = public_path(). $documentPath;
			if(file_exists($rootPath)){
				$documentUrl = asset('public' . $documentPath);
			}
		}
	}
	return $documentUrl;
}

/**
* get all uploaded documents of a user by the user id
* @param Int/String $userId
* @return
*/
function getUserAllDocuments($userId){
	$documentUrls = array();
	$userDocuments = \App\UserDocument::where('user_id', $userId)->get()->first();
	//dd($userDocuments);
	if($userDocuments){
		$allDocs = $userDocuments->makeHidden(['id', 'user_id', 'created_at', 'updated_at'])->toArray();
		foreach($allDocs as $key => $userDocumentName){
			if(!empty($userDocumentName)){
				$documentPath = '/user_images/'.$userId.'/documents/' . $userDocumentName;
				$rootPath = public_path(). $documentPath;
				if(file_exists($rootPath)){
					$documentUrls[$userDocumentName] = asset('public' . $documentPath);
				}
			}
		}
		
	}
	return $documentUrls;
}

/**
* Get company name by id
*/
function getCompanyData($companyId, $column = ''){
	$CompanyData = array();
	$company = \App\Company::where('id', $companyId)->get()->first();
	if($company){
		$CompanyData = $company->toArray();
		if(!empty($column) && isset($company->$column)){
			return $company->$column;
		}
	}
	$CompanyData;
}


/**
* Credentials
*
* Usage per month: 2500 
* 
* Authorization Header: Basic cUN3SFhCTFJDYTVEQTVJdkQ1cEp6VWFzRE5weG5wSDM6WHFHNGt3V0JCNzdwMldKSw==
* API Key:qCwHXBLRCa5DA5IvD5pJzUasDNpxnpH3
* API Secret:XqG4kwWBB77p2WJK
* 
* @return
*/

function getAccessTokenSecurity(){
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://api.onegov.nsw.gov.au/oauth/client_credential/accesstoken?grant_type=client_credentials",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
	    "authorization: Basic cUN3SFhCTFJDYTVEQTVJdkQ1cEp6VWFzRE5weG5wSDM6WHFHNGt3V0JCNzdwMldKSw==",
	    "content-type: application/json"
	  ),
	  CURLOPT_SSL_VERIFYPEER => FALSE
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err){
	  	return $err;
	} else {
	  return $response;
	}
}

function securityLicenseCheck($licenseNumber){
	$token = NULL;
	$accessData = getAccessTokenSecurity();
	$accessData = json_decode($accessData);
	
	if(isset($accessData->access_token)){
		$token = $accessData->access_token;
	}
	
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://api.onegov.nsw.gov.au/securityregister/v1/verify?licenceNumber=$licenseNumber",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_HTTPHEADER => array(
	  	"apikey: qCwHXBLRCa5DA5IvD5pJzUasDNpxnpH3",
	    "authorization: Bearer $token",
	    "content-type: application/json"
	  ),
	  CURLOPT_SSL_VERIFYPEER => FALSE
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	  return FALSE;
	} else {
	  return json_decode($response);
	}
}


/**
 * Dev. Babar
 * Description: Compare two arrays and check if an element of first exist in second 
 * -then put some extra component to that specific element Example available : true / false
 * @arrayData main array data
 * @arrayDataSub sub array or sum element assigned from main array
 * @elementName specific element name to add in arrayData
 * Add an element to all sub groups of an array.
 */
function CompareAndAddElementToArray(array $arrayData, array $arrayDataSub, $checkElement = 'id', $elementName = 'assigned', $existValue = TRUE, $notExistValue = FALSE) {
    $compareResults = array();

    foreach ($arrayData as $element) {
        //Check if element exist in sub array
        $elementExist = FALSE;
        foreach($arrayDataSub as $subArray){
            if($subArray[$checkElement] == $element[$checkElement]){
                $elementExist = TRUE;
                break;
            }
        }
        //If element exist in sub array than assign exist value to new 
        if($elementExist == TRUE){
            $element[$elementName] = $existValue;
            $compareResults[] = $element;                   
        }else{
            $element[$elementName] = $notExistValue;
            $compareResults[] = $element; 
        }
    }

    return $compareResults;
}

/**
 * Create Tree View Using Parent Ids
 * This Function has been used to create sub modules for admin permissions and generate side menus
 * @return \Illuminate\Http\JsonResponse
 */
function buildTree(array $elements, $parentId = 0) {
    $branch = array();

    foreach ($elements as $element) {
        if ($element['parent_id'] == $parentId) {
            $children = buildTree($elements, $element['id']);
            if ($children) {
                $element['sub_modules'] = $children;
            }
            $branch[] = $element;
        }
    }
    return $branch;
}

/**
* Description: Check permission of a route name
* @param String $routeName - name of route assigned by permission manager
* 
* @return
*/
function is_allowed($routeName){
	if(Auth::guard('admin')->user()->id == 1){
		return TRUE;
	}
	$allowedRoutes = session('allowed_routes', []);
	if(in_array($routeName, $allowedRoutes)){
		return TRUE;
	}else{
		return FALSE;
	}
}

