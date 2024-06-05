<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Company;
use App\Model\Timetable\Timetable;
use Illuminate\Support\Str;
class CompanyController extends Controller
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
        //
        $timetable = Timetable::where('status','=', 'active')->get()->first();
        //$companies = Company::all();
        $companies = Company::paginate(7);
        return view('admin.companies_management.index')->with('companies',$companies)->with('last_timetable',$timetable);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.companies_management.create');
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
            'company_name'  => 'required|max:255',
            'description'  => 'required',
        ]);
        Company::create([
            'company_name'  => $request->company_name,
            'description'  => $request->description,
            'slug'          => Str::slug($request->company_name, '-'),

        ]);
        toastr()->success("Created successfully.");
        return redirect('app-admin/company/');
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
        $company = Company::find($id);
        return view('admin.companies_management.edit')
                ->with('company',$company);
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
        $company = Company::find($id);
        $validatedData = $request->validate([
            'company_name'          => 'required|max:255',
            'description'  => 'required',
        ]);
        $company->company_name = $request->company_name;
        $company->description = $request->description;
        $company->slug = Str::slug($request->company_name, '-');
        $company->save();
        toastr()->success("Company updated successfully.");
        return redirect('app-admin/company/');
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
        Company::destroy($id);
        toastr()->success("Company deleted successfully.");
        return redirect()->back();
    }
}
