<?php

namespace App\Http\Controllers\Admin\Timesheet;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Model\Timesheet\Timesheet;
use App\Model\Timesheet\TimesheetDailyHour;
use App\Model\Timesheet\TimesheetComment;
use App\User;
use App\UserDetail;
use Hash;
class TimesheetController extends Controller
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
    public function index($status = NULL)
    {
        //
        if($status){
        	$timesheets =  Timesheet::where('status', $status)->where('status', '!=', 'new')->paginate(7);
		}else{
			$timesheets =  Timesheet::where('status', '!=', 'new')->paginate(7);
		}
        //dd($timesheets);
        return view('admin.timesheets.index')
            ->with('timesheets',$timesheets);
            
    }
    
    /**
	* Change timesheet status
	* 
	* @return
	*/
	public function changeStatus(Request $request){
		$validator = Validator::make($request->all(), [
            "timesheet_id"          => "required",
            "status"         => "required",
        ]);
        if ($validator->fails()){
        	 toastr()->error("Invalid status parameters.");
        }
        $timesheet = Timesheet::find($request->timesheet_id);
        if($timesheet){
			$data = array();
			$data['status'] = $request->status;
			$timesheet->update($data);
			toastr()->success("Timesheet ".$request->status." successfully.");
		}
		if(!empty(request()->headers->get('referer'))){
			return redirect(request()->headers->get('referer'));
		}else{
			return redirect(route('admin.timesheets'));
		}
	}
    
    public function openTimesheet($id = NULL){
    	$timesheet = Timesheet::find($id);
    	if($timesheet){
        	$user = User::find($timesheet->user_id);
        	if($user){
        		$isEmpty = FALSE;
    			$timesheetDays = array();
				$timsheetId = $timesheet->id;
				$timsheetStartDate = $timesheet->start_date;
				$timsheetEndDate = $timesheet->end_date;
				$timesheetHours = $timesheet->timesheet_daily_hours;
				$userDetail = $user->UserDetail;
				$timesheets = $user->timesheets->where('id', '!=', $timsheetId)->where('status', '!=', 'new'); 
				if($timesheetHours){
					$isEmpty = TRUE;
				}
				
				//Create loop between start and end date
				$begin = strtotime($timsheetStartDate);
				$end   = strtotime($timsheetEndDate);
				for($i = $begin; $i <= $end; $i = $i+86400){
					$date = date( 'Y-m-d', $i );
				    
				    $record = $this->getDateRecord($date, $timesheet->user_id);
				    if($record){
						$timesheetDays[$date] = $record->toArray();
					}else{
						$timesheetDays[$date] = array();
					}
					$timesheetDays[$date]['date'] = $date;
				}
				return view('admin.timesheets.timesheet-detail')
		        ->with('user', $user)
		        ->with('userDetail', $userDetail)
		        ->with('timesheet', $timesheet)
		        ->with('timesheet_empty', $isEmpty)
		        ->with('timesheet_days', $timesheetDays)
		        ->with('timesheets', $timesheets);				
			}
			toastr()->error("Timesheet user does not exist.");
		}
		toastr()->error("Timesheet does not exist.");
		return redirect(route('admin.timesheets'));
		
	}

	public function getDateRecord($date, $userId){
		$singleRecord = TimesheetDailyHour::where('user_id', $userId)->where('check_in_date', $date)->get()->first();
		return $singleRecord;
	}

	public function saveTimesheetAdmin(Request $request){
		$validator = Validator::make($request->all(), [
            "timesheet_id"          => "required",
            "user_id"         => "required",
        ]);
        if ($validator->fails()){
        	 toastr()->error("Invalid status parameters.");
        }
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
			}
		}
		toastr()->success("Timesheet hours updated successfully.");
		return redirect(route('admin.open_timesheet').'/'.$timesheetID);
		
	}

	public function saveTimesheetAction(Request $request){
		$validator = Validator::make($request->all(), [
            "admin_id"          => "required",
            "timesheet_id"          => "required",
            "user_id"          => "required",
            "status"         => "required",
            "comments"         => "required",
        ]);
        if ($validator->fails()){
        	toastr()->error("Please provide all the params.");
        }
        $timesheetID = $request->timesheet_id;
    	$userID = $request->user_id;
        $timesheet = Timesheet::find($timesheetID);
		if($request->status && $timesheet){
			$data = array();
        	$data['status'] = $request->status;
			$timesheet->update($data);
		}
		if($request->comments){
			$commentdata = array(
				"timesheet_id" => $timesheetID,
				"comment" => $request->comments,
				"admin_id" => $request->admin_id,
			);
			TimesheetComment::create($commentdata);
		}
		toastr()->success("Timesheet hours updated successfully.");
		return redirect(route('admin.open_timesheet').'/'.$timesheetID);
	}
	
	
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Timesheet::destroy($id);
        TimesheetDailyHour::where('timesheet_id', $id)->delete();
        TimesheetComment::where('timesheet_id', $id)->delete();
        toastr()->success("Timesheet deleted successfully.");
        return redirect()->back();
    }

    public function fetchEmployee($id){
        $employees = User::where('type','user')->where('company_id',$id)->get();
        return response()->json(['employees'=>$employees]);
    }
}
