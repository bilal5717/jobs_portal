<?php

namespace App\Http\Controllers\frontend\timesheet;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use App\User;
use App\UserDetail;
use App\Model\Timesheet\Timesheet;
use App\Model\Timesheet\TimesheetDailyHour;
use PDO;
use Hash;
use  App\File;

use Illuminate\Support\Facades\Response;
use ZipArchive;
class TimesheetController extends Controller
{
    //
    public function index($folderId = null, $folderSlug = ""){
        $timesheetDays = array();
        $user = User::find(Auth::user()->id);
    	$userDetail = $user->UserDetail;
    	$lastEndDate = NULL;
    	$submitButton = FALSE;
    	//Timesheet
    	$timesheets = $user->timesheets; 
    	$timesheet = Timesheet::where('status','!=', 'approved')->where('status','!=', 'pending')->where('user_id', Auth::user()->id)->get()->last();
    	$timesheetLast = Timesheet::where('user_id', Auth::user()->id)->where('status','!=', 'new')->orderby('end_date', 'desc')->get()->first();
    	if($timesheet){
    		$timesheetOpened = TRUE;
			$timsheetId = $timesheet->id;
			$timsheetStartDate = $timesheet->start_date;
			$timsheetEndDate = $timesheet->end_date;
			$timesheetHours = $timesheet->timesheet_daily_hours;
			if($timesheetHours){
				$submitButton = TRUE;
			}
			
			//Create loop between start and end date
			$begin = strtotime($timsheetStartDate);
			$end   = strtotime($timsheetEndDate);
			for($i = $begin; $i <= $end; $i = $i+86400){
				$date = date( 'Y-m-d', $i );
			    
			    $record = $this->getDateRecord($date);
			    if($record){
					$timesheetDays[$date] = $record->toArray();
				}else{
					$timesheetDays[$date] = array();
				}
				$timesheetDays[$date]['date'] = $date;
			}
		}else{
			$timesheetOpened = FALSE;
		}
    	if($timesheetLast){
			$lastEndDate = date('Y-m-d', strtotime($timesheetLast->end_date . ' +1 day'));
		}
		//dd($timesheet);
        return view('frontend.timesheet')
        ->with('user', $user)
        ->with('userDetail', $userDetail)
        ->with('timesheet', $timesheet)
        ->with('timesheet_days', $timesheetDays)
        ->with('timesheet_opened', $timesheetOpened)
        ->with('last_timesheet_date', $lastEndDate)
        ->with('submit_button', $submitButton)
        ->with('timesheets', $timesheets);
    }

	public function getDateRecord($date){
		$singleRecord = TimesheetDailyHour::where('user_id', Auth::user()->id)->where('check_in_date', $date)->get()->first();
		return $singleRecord;
	}
	
	public function createNewTimeSheet(Request $request){
		$validator = Validator::make($request->all(), [
            "title"          => "required",
            "start_date"          => "required|unique:timesheets,start_date",
            "end_date"         => "required|unique:timesheets,end_date",
        ]);
        if ($validator->fails()){
        	toastr()->error("Please fill the required fields.");
        }else{
        	$data = array();
        	$data = $request->except('_token');
        	$data['user_id'] = Auth::user()->id;
        	$data['status'] = "new";
        	$data['submit_count'] = 0;
        	$data['submit_date'] = date('Y-m-d H:i:s');
			Timesheet::create($data);
			toastr()->success("Timesheet added successfully.");
		}
		return redirect('/timesheet');
	}
	
	public function editTimeSheet(Request $request){
		$validator = Validator::make($request->all(), [
            "id"          => "required",
            "title"          => "required",
            "start_date"          => "required",
            "end_date"         => "required",
        ]);
        if ($validator->fails()){
        	toastr()->error("Please fill the required fields.");
        }else{
        	$data = array();
        	$data = $request->except('_token');
        	$timesheet = Timesheet::find($request->id);
        	if($timesheet){
				$timesheet->update($data);
				toastr()->success("Timesheet updated successfully.");
			}
		}
		return redirect('/timesheet');
	}
    
    public function saveTimesheet(Request $request){
    	//dd($request);
    	$timesheetID = $request->timesheet_id;
    	$userID = $request->user_id;
    	if($request->data){
    		$timesheetDays = $request->data;
    		foreach($timesheetDays as $date => $record){
    			$dailyHour = TimesheetDailyHour::where('user_id', $userID)->where('check_in_date', $date)->get()->first();
    			$dailyHourData = array();
    			$location = (isset($record['location']))? $record['location'] : NULL;
    			$check_in_time = (isset($record['check_in_time']))? $record['check_in_time'] : NULL;
    			$check_out_time = (isset($record['check_out_time']))? $record['check_out_time'] : NULL;
    			$notes = (isset($record['notes']))? $record['notes'] : NULL;
    			//dd($record['location']);
    			if(!empty($location) || !empty($check_in_time) || !empty($check_out_time) || !empty($notes)){
					$dailyHourData['user_id'] = $userID;
					$dailyHourData['timesheet_id'] = $timesheetID;
					$dailyHourData['location'] = $location;
					$dailyHourData['check_in_date'] = $date;
					$dailyHourData['check_in_time'] = $check_in_time;
					$dailyHourData['check_out_time'] = $check_out_time;
					$dailyHourData['notes'] = $notes;
					if($dailyHour){
						$dailyHour->update($dailyHourData);
					}else{
						TimesheetDailyHour::create($dailyHourData);
					}
				}else{
					if($dailyHour){
						$dailyHour->delete();
					}
				}
				toastr()->success("Timesheet updated successfully.");
			}
		}
		return redirect('/timesheet');
	}
    
    public function submitTimesheet(Request $request){
		$validator = Validator::make($request->all(), [
            "timesheet_id"          => "required",
            "user_id"          => "required",
        ]);
        if ($validator->fails()){
        	toastr()->error("Unable to process timesheet.");
        }else{
        	$timesheet = Timesheet::find($request->timesheet_id);
        	if($timesheet && (Auth::user()->id == $timesheet->user_id)){
	        	$data = array();
	        	$data = $request->except('_token');
	        	$data['user_id'] = Auth::user()->id;
	        	$data['status'] = "pending";
	        	$data['submit_count'] = (int)$timesheet->submit_count + 1;
	        	$data['submit_date'] = date('Y-m-d H:i:s');
				$timesheet->update($data);
				toastr()->success("Timesheet added successfully.");				
			}
		}
		return redirect('/timesheet');
	}
}
