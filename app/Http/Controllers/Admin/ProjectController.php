<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Project;
use App\Company;
use App\Model\Timetable\Timetable;
use App\Model\Timetable\TimetableHour;
use App\Model\Timesheet\TimesheetDailyHour;
use Illuminate\Support\Str;
class ProjectController extends Controller
{
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
    	$projects = array();
    	$timetable = Timetable::where('status','=', 'active')->get()->first();
        if(isset($_REQUEST['company_id'])){
			$companyId = $_REQUEST['company_id'];
			$company = Company::find($companyId);
			if($company){
				$projects = $company->projects()->paginate(7);
			}
		}else{
			//$projects = Project::all();
        	$projects = Project::paginate(7);
		}
        
        return view('admin.projects_management.index')->with('projects',$projects)->with('last_timetable',$timetable);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $companies = Company::all();
        return view('admin.projects_management.create')
         ->with('companies',$companies);
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
            'company_id'  => 'required',
            'name'  => 'required|unique:projects|max:255',
            'description'  => 'required',
        ]);
        Project::create([
            'company_id'  => $request->company_id,
            'name'  => $request->name,
            'description'  => $request->description,
            'slug'          => Str::slug($request->name, '-'),

        ]);
        toastr()->success("Created successfully.");
        return redirect('app-admin/project/');
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
        //
        $companies = Company::all();
        $project = Project::find($id);
        return view('admin.projects_management.edit')
                ->with('companies',$companies)
                ->with('project',$project);
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
        $project = Project::find($id);
        $validatedData = $request->validate([
        	'company_id'  => 'required',
            'name'          => "required|unique:projects,name,$id|max:255",
            'description'  => 'required',
        ]);
        $project->company_id = $request->company_id;
        $project->name = $request->name;
        $project->description = $request->description;
        $project->slug = Str::slug($request->name, '-');
        $project->save();
        toastr()->success("Project updated successfully.");
        return redirect('app-admin/project/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) 
    {
        //
        TimetableHour::where('project_id', $id)->delete();
        TimesheetDailyHour::where('project_id', $id)->delete();
        Project::destroy($id);
        toastr()->success("Project deleted successfully.");
        return redirect()->back();
    }
}
