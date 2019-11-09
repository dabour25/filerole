<?php

namespace App\Http\Controllers;

use App\EmpAttendance;
use App\Http\Requests\YearlyVacationsRequest;
use App\Http\Requests\YearlyVacationsUpdateRequest;
use App\WeeklyVacations;
use App\YearlyVacations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Auth;
use Illuminate\Validation\Rule;

class YearlyVacationsController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Admin Packages Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing booking package views to
    | admin, to show all packages, provide ability to edit and delete
    | specific package.
    |
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(permissions('yearly_vacations_view') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }

        $weekly = WeeklyVacations::where('org_id', Auth::user()->org_id)->paginate(20);
        $yearly = YearlyVacations::where('org_id', Auth::user()->org_id)->paginate(20);

        return view('weekly_vacations.index', compact('weekly', 'yearly'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(permissions('yearly_vacations_add') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        return view('weekly_vacations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $date = $request->date;
        $v = \Validator::make($request->all(), [
            'active' => 'required',
            'date' => [
                'required',
                Rule::unique('year_vacation')->where(function ($query) use($date) {
                    return $query->where(['date' => $date ,'org_id' => Auth::user()->org_id]);
                }),
            ],
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }
        $input['org_id'] = Auth::user()->org_id;
        $input['user_id'] = Auth::user()->id;
        $input['year'] = date('Y', strtotime($request->date));
        $vacation = YearlyVacations::create($input);

        if (EmpAttendance::where(['org_id' => Auth::user()->org_id, 'date' => $request->date ])->exists()){
            foreach (EmpAttendance::where(['org_id' => Auth::user()->org_id, 'date' => $request->date ])->get() as $value){
                EmpAttendance::where(['id' => $value->id])->update(['yvac_id' => $vacation->id, 'attend_type' => 2]);
            }
        }

        //set session message
        Session::flash('created', __('strings.message_success') );

        //redirect back to weekly_vacations.index
        return redirect('admin/yearly_vacations');
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
        if(permissions('yearly_vacations_edit') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }

        $vacation = YearlyVacations::findOrFail($id);
        return view('weekly_vacations.edit', compact('vacation'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(YearlyVacationsUpdateRequest $request, $id)
    {
        $input = $request->all();

        $input['org_id'] = Auth::user()->org_id;
        $input['user_id'] = Auth::user()->id;
        $input['year'] = date('Y', strtotime($request->date));

        //update data into yearly_vacations table
        YearlyVacations::findOrFail($id)->update($input);

        //set session message and redirect back weekly_vacations.index
        Session::flash('updated', __('strings.message_success_updated') );
        return redirect('/admin/yearly_vacations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find specific yearly_vacations
        $vacation = WeeklyVacations::findOrFail($id);

        //delete yearly_vacations
        YearlyVacations::destroy($vacation->id);

        //set session message and redirect back to weekly_vacations.index
        Session::flash('deleted', __('strings.yearly_vacations_msg_3'));
        return redirect('/admin/yearly_vacations');

    }
}
