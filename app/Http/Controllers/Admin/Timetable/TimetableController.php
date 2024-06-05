<?php

namespace App\Http\Controllers\Admin\Timetable;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Model\Timetable\Timetable;
use App\Model\Timetable\TimetableHour;
use App\User;
use App\Project;
use App\UserDetail;
use Hash;
class TimetableController extends Controller
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
    public function index()
    {
        //
      
        $timetables =  Timetable::paginate(7);
        //dd($timetables);
        return view('admin.timetables.index')
            ->with('timetables',$timetables);
            
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$timetable = Timetable::where('status','=', 'active')->get()->first();
    	$record = array();
    	//$begin = strtotime(date("M d, Y"));
    	//$begin = strtotime('monday this week');
    	if(isset($timetable->start_date) && !empty($timetable->start_date)){
    		$begin = strtotime("next monday", strtotime($timetable->start_date));
    	}else{
    		$begin = strtotime('next monday');
		}
    	
    	$end = strtotime("+6 day", $begin);
    	$projects = Project::where("is_active", "Y")->get();
    	$users = User::where("user_status", "approved")->limit(5)->get();
		$timetableDays = array();
		
		//Define dates start and end
		
		for($i = $begin; $i <= $end; $i = $i+86400){
			$date = date( 'Y-m-d', $i );
			$timetableDays[$date] = array();
			$timetableDays[$date]['date'] = $date;
		}
		return view('admin.timetables.timetable-create')
        ->with('timetable', $timetable)
        ->with('start_date', date("Y-m-d", $begin))
        ->with('end_date', $end)
        ->with('timetable_days', $timetableDays)
        ->with('projects', $projects)
        ->with('users', $users);
        
		//toastr()->error("Timetable does not exist.");
		//return redirect(route('admin.timetables'));
        //
        //return view('admin.timetables.timetable-create');
    }

    /**
	* Change timetable status
	* 
	* @return
	*/
	public function changeStatus(Request $request){
		$validator = Validator::make($request->all(), [
            "timetable_id"          => "required",
            "status"         => "required",
        ]);
        if ($validator->fails()){
        	 toastr()->error("Invalid status parameters.");
        }
        $timetable = Timetable::find($request->timetable_id);
        if($timetable){
			$data = array();
			$data['status'] = $request->status;
			$timetable->update($data);
			toastr()->success("Timetable ".$request->status." successfully.");
		}
		if(!empty(request()->headers->get('referer'))){
			return redirect(request()->headers->get('referer'));
		}else{
			return redirect(route('admin.timetables'));
		}
	}
    
    public function openTimetable($id = NULL){
    	// Sort timetable by company
    	$projectIDs = array();
    	$sortUserId = NULL;
    	if(isset($_REQUEST['company_id'])){
			$companyId = $_REQUEST['company_id'];
			$projectIDs = Project::where("is_active", "Y")->where("company_id", $companyId)->pluck('id');
		}
		
		// Sort by a specific Project
		if(isset($_REQUEST['project_id'])){
			$projectIDs = Project::where("is_active", "Y")->where("id", $_REQUEST['project_id'])->pluck('id');
		}
		
		// Sort timetable by a selected user
		if(isset($_REQUEST['user_id'])){
			$sortUserId = $_REQUEST['user_id'];
		}
		
		if($projectIDs){
			$projects = Project::where("is_active", "Y")->whereIn("id", $projectIDs)->get();
		}else{
			$projects = Project::where("is_active", "Y")->get();
		}
    	
    	$timetable = Timetable::find($id);
    	/*if(isset($_GET['test'])){
			dd($dayName);
		}*/    	
    	
    	if(!$timetable){
    		toastr()->error("Timetable not found.");
			return redirect(route('admin.timetables'));
		}
    	$record = array();
    	
    	//Next monday from the saved date
		$begin = strtotime('next monday');
		if(isset($timetable->start_date) && !empty($timetable->start_date)){
			$tableStartingDate = $timetable->start_date;
			$dayName = date('D', strtotime($tableStartingDate));
			if(strtolower($dayName) != "mon"){
				$begin = strtotime("next monday", strtotime($tableStartingDate));
			}else{
				$begin = strtotime($tableStartingDate);
			}			
		}else{
			$tableStartingDate = date( 'Y-m-d', $begin);
		}
    	$end = strtotime("+6 day", $begin);
    	
    	$users = User::where("user_status", "approved")->limit(5)->get();
		$timetableDays = array();
		
		for($i = $begin; $i <= $end; $i = $i+86400){
			$date = date( 'Y-m-d', $i );
		    $dayName = date('D', strtotime($date));
		    if($projectIDs || $sortUserId){
		    	if($sortUserId){
					$existingRecords = $this->getDateRecordByUser($id, $dayName, $sortUserId);
				}else{
					$existingRecords = $this->getDateRecordByProjectIds($id, $dayName, $projectIDs);
				}
			}else{
		    	$existingRecords = $this->getDateRecord($id, $dayName);
			}
		    if(count($existingRecords) > 0){
		    	foreach($existingRecords as $key => $record){
		    		$record = $record->toArray();
		    		if(isset($record['user_id'])){
						$userData = User::find($record['user_id']);
						if(!$userData){
							$tableHourId = $record['id'];
							TimetableHour::where('id', $tableHourId)->delete();
							toastr()->error("User not exist against this id [".$record['user_id']."]. Record deleted.");
							$userData = array();
						}else{
							$userData = $userData->toArray();
						}
					}else{
						$userData = array();
					}
		    		
		    		$record['date'] = $date;
		    		$record['user'] = $userData;
					$timetableDays[$date.'_'.$key] = $record;
				}
			}else{
				$timetableDays[$date] = array();
				$timetableDays[$date]['date'] = $date;
			}
		}
		//dd($timetableDays);
		return view('admin.timetables.timetable-edit')
        ->with('timetable', $timetable)
        ->with('table_begin_date', $tableStartingDate)
        ->with('start_date', date("Y-d-m", $begin))
        ->with('end_date', $end)
        ->with('timetable_days', $timetableDays)
        ->with('projects', $projects)
        ->with('users', $users);
	}

	public function getDateRecord($timetableId, $dayName){
		$records = array();
		$records = TimetableHour::where('day_name', $dayName)->where('timetable_id', $timetableId)->get();
		return $records;
	}
	
	/**
	* Get timetable hours by project id
	* @param  $timetableId
	* @param  $dayName
	* @param  $projectId
	* 
	* @return
	*/
	public function getDateRecordByProjectIds($timetableId, $dayName, $projectIds = array()){
		$records = array();
		$records = TimetableHour::where('day_name', $dayName)->whereIn('project_id', $projectIds)->where('timetable_id', $timetableId)->get();
		return $records;
	}
	
	/**
	* Get timetable hours by a specific user
	* @param $timetableId
	* @param $dayName
	* @param $user_id
	* @return
	*/
	public function getDateRecordByUser($timetableId, $dayName, $user_id){
		$records = array();
		$records = TimetableHour::where('day_name', $dayName)->where('user_id', $user_id)->where('timetable_id', $timetableId)->get();
		return $records;
	}

	public function saveNewTimetableAdmin(Request $request){
		$validator = Validator::make($request->all(), [
            "timetable_title"          => "required",
        	"start_date"         => "required",
        ]);
        
        
        $timeTableUpdate = FALSE;
        $timetable_id = NULL;
        if(isset($request->timetable_id) && !empty($request->timetable_id)){
			$timeTableUpdate = TRUE;
			$timetable_id = $request->timetable_id;
		}
        
        if ($validator->fails()){
        	 toastr()->error("Invalid status parameters.");
        	 if(isset($request->timetable_id)){
			 	return redirect(route('admin.open_timetable', $request->timetable_id));
			 }else{
        	 	return redirect(url('app-admin/timetable/create'));
			 }
        }
        
        //Check if the next monday is reserved or not : unique check
        
   		$tableStartingDate = $request->start_date;
		$dayName = date('D', strtotime($tableStartingDate));
		if(strtolower($dayName) != "mon"){
			$nextMonday = strtotime("next monday", strtotime($tableStartingDate));
		}else{
			$nextMonday = strtotime($tableStartingDate);
		}
        
        $dateFromNM = date('Y-m-d', $nextMonday);
        $recordsWithDate = Timetable::where('start_date', $dateFromNM)->where('status', 'active')->where('id', '!=', $timetable_id)->get()->first();
        if($recordsWithDate){
			toastr()->error("First/selected Monday within the selected date is already reserved. Please select another starting date in future.");
        	if(isset($request->timetable_id)){
			 	return redirect(route('admin.open_timetable', $request->timetable_id));
			 }else{
        	 	return redirect(url('app-admin/timetable/create'));
			 }
		}
		
        $timeTableData = array(
        	"title"          => $request->timetable_title,
        	"start_date"          => $dateFromNM,
        );
        
        # Update timetable record
		if($timeTableUpdate){
			$timetableID = $request->timetable_id;
			$timeTable = Timetable::find($timetableID);
			$timeTable->update($timeTableData);
		}else{
			$timetable = Timetable::create($timeTableData);
			$timetableID = $timetable->id;
		}
    	
    	# Delete the requested IDs
    	if(isset($request->deleted_ids) && is_array($request->deleted_ids) && count($request->deleted_ids) > 0){
    		TimetableHour::destroy($request->deleted_ids);
		}
		
		# Save timetable hours data
    	if($request->data){
	    	if($timetableID){
	    		$timetableDays = $request->data;
	    		foreach($timetableDays as $date => $record){
	    			$dayName = date('D', strtotime($date));
	    			for($i = 0; $i < count($record['check_in_date']) ; $i++){
						
		    			$dailyHourData = array();
		    			$userID = (isset($record['user_id'][$i]))? $record['user_id'][$i] : NULL;
		    			$project_id = (isset($record['project_id'][$i]))? $record['project_id'][$i] : NULL;
		    			$check_in_time = (isset($record['check_in_time'][$i]))? $record['check_in_time'][$i] : NULL;
		    			$check_out_time = (isset($record['check_out_time'][$i]))? $record['check_out_time'][$i] : NULL;
		    			$notes = (isset($record['notes'][$i]))? $record['notes'][$i] : NULL;
		    			$dailyHour = TimetableHour::where('timetable_id', $timetableID)->where('user_id', $userID)->where('day_name', $dayName)->get()->first();
		    			//
		    			if(!empty($project_id) && (!empty($userID) || !empty($check_in_time) || !empty($check_out_time) || !empty($notes))){
							$dailyHourData['user_id'] = $userID;
							$dailyHourData['timetable_id'] = $timetableID;
							$dailyHourData['project_id'] = $project_id;
							$dailyHourData['check_in_date'] = $date;
							$dailyHourData['day_name'] = $dayName;
							$dailyHourData['check_in_time'] = $check_in_time;
							$dailyHourData['check_out_time'] = $check_out_time;
							$dailyHourData['notes'] = $notes;
							if($dailyHour){
								$dailyHour->update($dailyHourData);
							}else{
								TimetableHour::create($dailyHourData);
							}
						}else{
							if($dailyHour){
								$dailyHour->delete();
							}
						}
					}
				}
			}else{
				
			}
		}
		toastr()->success("Timetable hours updated successfully.");
		return redirect(route('admin.open_timetable', $timetableID));
		
	}



	public function saveTimetableAction(Request $request){
		$validator = Validator::make($request->all(), [
            "admin_id"          => "required",
            "timetable_id"          => "required",
            "user_id"          => "required",
            "status"         => "required",
        ]);
        if ($validator->fails()){
        	toastr()->error("Please provide all the params.");
        }
        $timetableID = $request->timetable_id;
    	$userID = $request->user_id;
        $timetable = Timetable::find($timetableID);
		if($request->status && $timetable){
			$data = array();
        	$data['status'] = $request->status;
			$timetable->update($data);
		}
		toastr()->success("Timetable hours updated successfully.");
		return redirect(route('admin.open_timetable').'/'.$timetableID);
	}
	
	
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Timetable::destroy($id);
        TimetableHour::where('timetable_id', $id)->delete();
        toastr()->success("Timetable deleted successfully.");
        return redirect()->back();
    }

    public function fetchEmployee($id){
        $employees = User::where('type','user')->where('company_id',$id)->get();
        return response()->json(['employees'=>$employees]);
    }
    
    //If duplicate return true
    public function checkDuplicateUser($user_id, $date){
        $employees = TimetableHour::where('user_id', $user_id)->where('check_in_date', $date)->get()->first();
        if($employees){
			return 'true';
		}else{
			return 'false';
		}
    }
}
