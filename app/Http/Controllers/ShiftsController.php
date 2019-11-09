<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Shift;
use App\ShiftDay;
use App\UserShift;
use Auth;
use Session;


class ShiftsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
          if (permissions('shift_view') == 0 ) {
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        $shifts=Shift::where('org_id',Auth::user()->org_id)->get();
        return view('shifts.index',compact('shifts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('shifts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $input=$request->all();
        $error=0;
      $data = \Validator::make($request->all(), [
          'name' => 'required',
          'name_en' => 'required',
          'data'=>'required',

      ]);
      if ($data->fails()) {
          return redirect()->back()->withErrors($data->errors())->withInput();

      }
      foreach($input['data']['ShiftDay'] as $key){
        if($key['weekday']!=0){


        if(period_id($key['from_time'])>period_id($key['to_time'])){
            Session::flash('shiftday'.$key['weekday'], __('strings.time_to must be bigger than time one'));
          $error=1;
        }
        }

      }
      if($error==1){

        return redirect()->back()->withInput();
      }


      $shift=new Shift();
      $shift->name=$input['name'];
      $shift->name_en=$input['name_en'];
      $shift->org_id=Auth::user()->org_id;
      $shift->active=$input['active'];
      $shift->user_id=Auth::user()->id;
      $shift->save();
      foreach($input['data']['ShiftDay'] as $key){
        if($key['weekday']!=0){
          $shiftDay=new ShiftDay();
          $shiftDay->shift_id=$shift->id;
          $shiftDay->shift_day=$key['weekday'];
          $shiftDay->time_from=period_id($key['from_time']);
          $shiftDay->time_to=period_id($key['to_time']);
          $shiftDay->org_id=Auth::user()->org_id;
          $shiftDay->user_id=Auth::user()->id;
          $shiftDay->save();
          }
      }
      Session::flash('shift_created', __('strings.shift_created'));
      return redirect('admin/shift');
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
      $shiftDays=[];
        $shift=Shift::where('org_id',Auth::user()->org_id)->where('id',$id)->first();
        $shiftDays[0]=ShiftDay::where('org_id',Auth::user()->org_id)->where('shift_id',$shift->id)->where('shift_day',2)->first();
        $shiftDays[1]=ShiftDay::where('org_id',Auth::user()->org_id)->where('shift_id',$shift->id)->where('shift_day',3)->first();
        $shiftDays[2]=ShiftDay::where('org_id',Auth::user()->org_id)->where('shift_id',$shift->id)->where('shift_day',4)->first();
        $shiftDays[3]=ShiftDay::where('org_id',Auth::user()->org_id)->where('shift_id',$shift->id)->where('shift_day',5)->first();
        $shiftDays[4]=ShiftDay::where('org_id',Auth::user()->org_id)->where('shift_id',$shift->id)->where('shift_day',6)->first();
        $shiftDays[5]=ShiftDay::where('org_id',Auth::user()->org_id)->where('shift_id',$shift->id)->where('shift_day',7)->first();
        $shiftDays[6]=ShiftDay::where('org_id',Auth::user()->org_id)->where('shift_id',$shift->id)->where('shift_day',1)->first();

        return view('shifts.edit',compact('shift','shiftDays'));
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

              $input=$request->all();
              $error=0;
            $data = \Validator::make($request->all(), [
                'name' => 'required',
                'name_en' => 'required',
                'data'=>'required',

            ]);
            if ($data->fails()) {
                return redirect()->back()->withErrors($data->errors())->withInput();

            }
            foreach($input['data']['ShiftDay'] as $key){
              if($key['weekday']!=0){


              if(period_id($key['from_time'])>period_id($key['to_time'])){
                  Session::flash('shiftday'.$key['weekday'], __('strings.time_to must be bigger than time one'));
                $error=1;
              }
              }

            }
            if($error==1){

              return redirect()->back()->withInput();
            }


            $shift=Shift::where('org_id',Auth::user()->org_id)->where('id',$id)->first();
            $shift->name=$input['name'];
            $shift->name_en=$input['name_en'];
            $shift->org_id=Auth::user()->org_id;
            $shift->active=$input['active'];
            $shift->user_id=Auth::user()->id;
            $shift->save();
            $shiftDay=ShiftDay::where('org_id',Auth::user()->org_id)->where('shift_id',$shift->id)->delete();
            foreach($input['data']['ShiftDay'] as $key){
              if($key['weekday']!=0){

                $shiftDay=new ShiftDay();
                $shiftDay->shift_id=$shift->id;
                $shiftDay->shift_day=$key['weekday'];
                $shiftDay->time_from=period_id($key['from_time']);
                $shiftDay->time_to=period_id($key['to_time']);
                $shiftDay->org_id=Auth::user()->org_id;
                $shiftDay->user_id=Auth::user()->id;
                $shiftDay->save();

                }
            }
            Session::flash('shift_created', __('strings.shift_updated'));
            return redirect('admin/shift');
    }
        public function captin_days($captin_id){
      $days=[];
      $captin_shifts=UserShift::where('captin_id',$captin_id)->where('org_id',Auth::user()->org_id)->pluck('shift_id');


      $shift_days=ShiftDay::where('org_id',Auth::user()->org_id)->whereIn('shift_id',$captin_shifts)->pluck('shift_day');
      
      foreach($shift_days as $shift_day){
        $days[]=getDayName($shift_day);
      }
      return $days;

    }
    
      public function DefaultShift($id){

           shift::where('id','!=',$id)->update(['default'=>0]);
           Shift::where('id', $id)->update(['active'=>1,'default' => 1]);

           //set session message and redirect back to settings.index
           Session::flash('created', __('strings.default_status_changed') );

       return redirect('admin/shift');
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
    }
}
