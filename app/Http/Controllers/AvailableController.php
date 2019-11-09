<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\CaptinAvailable;
use App\WeeklyVacations;
use Auth;
use Illuminate\Validation\Rule;


class AvailableController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Admin Users Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing users views to
    | admin, to show all users, provide ability to edit and delete
    | specific user.
    |
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(permissions('available_view') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }

        $times = CaptinAvailable::where('org_id', Auth::user()->org_id)->paginate(20);
        return view('available.index', compact( 'times'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(permissions('available_add') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }

        $users = User::where(['org_id' => Auth::user()->org_id, 'is_active' => 1])->paginate(20);
        $vacations = WeeklyVacations::where(['org_id' => Auth::user()->org_id, 'active' => 1])->get();

        return view('available.create', compact('users', 'vacations'));
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
        $day = $request->day; $time = $request->time; $id = $request->captin_id;

        $messages = [
            'time.unique' => __('strings.available_msg_1') ,
        ];

        $v = \Validator::make($request->all(), [
            'captin_id' => 'required|not_in:0', 'day' => 'required' ,
            'time' => [
                'required',
                Rule::unique('captin_available')->where(function ($query) use($day, $time, $id) {
                    return $query->where(['captin_id' => $id ,'day' => $day, 'time' => $time, 'active' => 1]);
                }),
            ],
        ],
            $messages
        );

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }

        $input['user_id'] = Auth::user()->id;
        $input['org_id'] = Auth::user()->org_id;

        CaptinAvailable::create($input);


        //set session message
        Session::flash('created', __('strings.message_success'));


        //redirect back to functions.index
        return back()->withInput();
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
        if(permissions('available_edit') == 0){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        $users = User::where(['org_id' => Auth::user()->org_id, 'is_active' => 1])->paginate(20);
        $vacations = WeeklyVacations::where(['org_id'=> Auth::user()->org_id, 'active' => 1])->get();
        $available = CaptinAvailable::findOrFail($id);
        return view('available.edit', compact('available', 'users', 'vacations'));
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
        $input = $request->all();
        $day = $request->day; $time = $request->time; $id = $request->captin_id;

        $messages = [
            'time.unique' => __('strings.available_msg_1') ,
        ];

        $v = \Validator::make($request->all(), [
            'captin_id' => 'required|not_in:0', 'day' => 'required' ,
            'time' => [
                'required',
                Rule::unique('captin_available')->where(function ($query) use($day, $time, $id) {
                    return $query->where(['captin_id' => $id ,'day' => $day, 'time' => $time, 'active' => 1]);
                }),
            ],
        ],
            $messages
        );

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }

        $input['user_id'] = Auth::user()->id;
        $input['org_id'] = Auth::user()->org_id;

        //update data into categories table
        CaptinAvailable::findOrFail($id)->update($input);

        //set session message
        Session::flash('updated', __('strings.message_success_updated'));

        //redirect back to available.index
        return redirect('/admin/available');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        //delete available
        CaptinAvailable::destroy($id);

        //set session message and redirect back to available.index
        Session::flash('deleted', __('strings.available_msg_4'));

        return redirect('admin/available');

    }

    public function Active($id, $value)
    {
        $value = $value == 'true' ? 1 : 0;
        $available  = CaptinAvailable::where('id', $id)->first();
        $count = CaptinAvailable::where(['captin_id' => $available->captin_id, 'time' => $available->time, 'day' => $available->day, 'active' => 1, 'org_id' => Auth::user()->org_id])->count();
        if($count == 0){
            $available  = CaptinAvailable::where('id', $id)->update(['active' => $value]);
            //set session message and redirect back to available.index
            Session::flash('created', __('strings.available_msg_5') );
        }else{
            if($count == 0){
                Session::flash('created', __('strings.available_msg_5') );
            }elseif ($value == 0 && $count == 1){
                Session::flash('created', __('strings.available_msg_5') );
            }else{
                Session::flash('created', __('strings.available_msg_1') );
            }
            $available  = CaptinAvailable::where('id', $id)->update([ 'active' => 0]);
        }

        return redirect('admin/available');
    }
}
