<?php
namespace App\Http\Controllers;

use App\Charts\KPI;
use DB;
use Auth;
use App\Followup;
use App\FollowupMessage;
use App\FollowupPhotos;
use App\FollowupSessions;
use App\Customers;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Countries;


class FollowupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (permissions('followup_view') == 0) {
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }

        //return $request->all();
        $followup_list = Followup::where(['org_id' => Auth::user()->org_id]);
        $services_list = Category::join('categories_type', function ($join) {
            $join->on('categories_type.id', '=', 'categories.category_type_id')->where(['categories_type.type' => 2, 'categories.org_id' => Auth::user()->org_id]);
        })->select('categories.*')->where(['categories.org_id' => Auth::user()->org_id])->get();

        if(!empty($request->status) && $request->status !== 0){
            $followup_list = $followup_list->where(['status' => $request->status]);
        }
        if(!empty($request->customers) && $request->customers !== 0){
            $followup_list = $followup_list->where(['cust_id' => $request->customers]);
        }
        if(!empty($request->phones) && $request->phones !== 0){
            $followup_list = $followup_list->where(['cust_id' => $request->phones]);
        }
        if(!empty($request->request_date)){
            $followup_list = $followup_list->where(['request_dt' => $request->request_date]);
        }
        if(!empty($request->service_type) && $request->service_type !== 0){
            $followup_list = $followup_list->where(['cat_id' => $request->service_type]);
        }
        $followup_list = $followup_list->paginate(20);

        return view('followup.index', compact('followup_list', 'services_list'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (permissions('followup_add') == 0) {
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        
         $countries = Countries::all();
        $services_list = Category::join('categories_type', function ($join) {
           $join->on('categories_type.id', '=', 'categories.category_type_id')->where(['categories_type.type' => 2, 'categories.org_id' => Auth::user()->org_id]);
        })->select('categories.*')->where(['categories.org_id' => Auth::user()->org_id])->get();

        $customers_list = Customers::where(['active' => 1,'org_id' => Auth::user()->org_id])->get();
        return view('followup.create', compact('services_list', 'customers_list','countries'));
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

        $v = \Validator::make($request->all(), [
            'customers' => 'required|not_in:0',
            'service_type' => 'required|not_in:0',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }

        $input['cust_id'] = $request->customers;
        $input['cat_id'] = $request->service_type;
        $input['secr_text'] = $request->description;
        $input['health_status'] = $request->health_status;
        $input['status'] = $request->status;
        $input['request_dt'] = $request->request_date;
        $input['user_id'] = Auth::user()->id;
        $input['org_id'] = Auth::user()->org_id;
        $insert = Followup::create($input);

        if(!empty($request->types) && $request->types !== [null]){
            foreach ($request->types as $key => $value){
                if($value != 0) {
                    //check if an image is selected
                    if ($image = $request->file('files')[$key]) {
                        //give a name to image and move it to public directory
                        $image_name = trim(time().$image->getClientOriginalName());
                        $image->move('images', $image_name);

                        //persist data into photos table
                        FollowupPhotos::create(['followup_id' => $insert->id, 'fimage' => $image_name, 'image_type' => $value, 'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->id]);

                    }
                }

            }
        }

        //set session message
        Session::flash('created', __('strings.message_success'));

        //redirect back
        return redirect('/admin/followup');
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
        if(\Request::is('admin/followup/*/confirm')){
            if (permissions('followup_confirm') == 0) {
                //set session message
                Session::flash('message', __('strings.do_not_have_permission'));
                return view('permissions');
            }
        }
        if(\Request::is('admin/followup/*/edit')){
            if (permissions('followup_edit') == 0) {
                //set session message
                Session::flash('message', __('strings.do_not_have_permission'));
                return view('permissions');
            }
        }

        $followup = Followup::findOrFail($id);
        $services_list = Category::join('categories_type', function ($join) {
            $join->on('categories_type.id', '=', 'categories.category_type_id')->where(['categories_type.type' => 2, 'categories.org_id' => Auth::user()->org_id]);
        })->select('categories.*')->where(['categories.org_id' => Auth::user()->org_id])->get();

        $customers_list = Customers::where(['active' => 1,'org_id' => Auth::user()->org_id])->get();
        $customer = Customers::where('id', $followup->cust_id)->first();

        return view('followup.edit', compact('followup','customer', 'services_list', 'customers_list'));
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

        $v = \Validator::make($request->all(), [
            'customers' => 'required|not_in:0',
            'service_type' => 'required|not_in:0',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }

        $input['cust_id'] = $request->customers;
        $input['cat_id'] = $request->service_type;
        $input['secr_text'] = $request->description;
        $input['health_status'] = $request->health_status;
        if(!empty($request->admin_description)){
            $input['admin_text'] = $request->admin_description;
        }
        
        $input['status'] = $request->request_status;
        $input['request_dt'] = $request->request_date;
        if(!empty($request->deposit)){
            $input['deposit'] = $request->deposit;
        }
        if(!empty($request->deposit_inv_code)){
            $input['deposit_inv_code'] = $request->deposit_inv_code;
        }
        $input['user_id'] = Auth::user()->id;
        $input['org_id'] = Auth::user()->org_id;

        if(!empty($request->types) && $request->types !== [null]){
            foreach ($request->types as $key => $value){
                if($value != 0) {
                    //check if an image is selected
                    if ($image = $request->file('files')[$key]) {
                        //give a name to image and move it to public directory
                        $image_name = trim(time().$image->getClientOriginalName());
                        $image->move('images', $image_name);
                        if($request->image_ids[$key] != 0){
                            FollowupPhotos::where('id' , $request->image_ids[$key])->update(['fimage' => $image_name, 'image_type' => $value, 'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->id]);
                        }else {
                            FollowupPhotos::create(['followup_id' => $id, 'fimage' => $image_name, 'image_type' => $value, 'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->id]);
                        }
                    }
                }
            }
        }
        if(!empty($request->ids) && $request->ids !== [null]){
            foreach ($request->ids as $key => $ids) {
                if($ids != 0) {
                    $input['status'] = 's';
                    FollowupSessions::where('id', $ids)->update(['followup_id' => $id, 'serial' => $request->serial[$key], 'session_dt' => date('Y-m-d', strtotime($request->date[$key])), 'session_pay' => $request->amount[$key], 'session_inv_code' => $request->invoice_no[$key], 'serial' => $request->serial[$key], 'session_status' => $request->status[$key], 'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->id]);
                }
            }
        }

        if(!empty($request->date) && $request->date !== [null]){
            foreach ($request->date as $key => $value) {
                if($value != null && $request->ids[$key] == 0) {
                    $input['status'] = 's';
                    FollowupSessions::create(['followup_id' => $id, 'serial' => $request->serial[$key], 'session_dt' => date('Y-m-d', strtotime($value)), 'session_pay' => $request->amount[$key], 'session_inv_code' => $request->invoice_no[$key], 'serial' => $request->serial[$key], 'session_status' => $request->status[$key], 'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->id]);
                }
            }
        }

        //update data
        Followup::findOrFail($id)->update($input);

        //set session message and redirect back
        Session::flash('updated', __('strings.message_success_updated'));

        return back();
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteImage($id){

        $image = FollowupPhotos::findOrFail($id);
        if($image->fimage){
            //unlink image
            unlink(public_path().$image->fimage);

            //delete from photo table
            FollowupPhotos::destroy($id);
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function DeleteSession($id){

        FollowupSessions::destroy($id);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function customer($id) {
        return Customers::findOrFail($id);
    }

    public function Reports(Request $request, $type){
        if($type == 'status') {
            $status = [__('strings.followup_status_1'), __('strings.followup_status_2'), __('strings.followup_status_3'), __('strings.followup_status_4'), __('strings.followup_status_5')];

            foreach ($status as $key => $value) {
                $labels[] = $value;
                if ($key == 0) {
                    if(empty($request->date_from) && empty($request->date_to)){
                        $score[] = Followup::where(['status' => 'q', 'org_id' => Auth::user()->org_id])->whereBetween('request_dt', [date('Y-m-d'), date('Y-m-d')])->count();
                    }else{
                        $score[] = Followup::where(['status' => 'q', 'org_id' => Auth::user()->org_id])->whereBetween('request_dt', [$request->date_from, $request->date_to])->count();
                    }
                }
                if ($key == 1) {
                    if(empty($request->date_from) && empty($request->date_to)) {
                        $score[] = Followup::where(['status' => 'a', 'org_id' => Auth::user()->org_id])->whereBetween('request_dt', [date('Y-m-d'), date('Y-m-d')])->count();
                    }else{
                        $score[] = Followup::where(['status' => 'a', 'org_id' => Auth::user()->org_id])->whereBetween('request_dt', [$request->date_from, $request->date_to])->count();
                    }
                }
                if ($key == 2) {
                    if(empty($request->date_from) && empty($request->date_to)) {
                        $score[] = Followup::where(['status' => 's', 'org_id' => Auth::user()->org_id])->whereBetween('request_dt', [date('Y-m-d'), date('Y-m-d')])->count();
                    }else{
                        $score[] = Followup::where(['status' => 's', 'org_id' => Auth::user()->org_id])->whereBetween('request_dt', [$request->date_from, $request->date_to])->count();
                    }
                }
                if ($key == 3) {
                    if(empty($request->date_from) && empty($request->date_to)) {
                        $score[] = Followup::where(['status' => 'r', 'org_id' => Auth::user()->org_id])->whereBetween('request_dt', [date('Y-m-d'), date('Y-m-d')])->count();
                    }else{
                        $score[] = Followup::where(['status' => 'r', 'org_id' => Auth::user()->org_id])->whereBetween('request_dt', [$request->date_from, $request->date_to])->count();
                    }
                }
                if ($key == 4) {
                    if(empty($request->date_from) && empty($request->date_to)) {
                        $score[] = Followup::where(['status' => 'f', 'org_id' => Auth::user()->org_id])->whereBetween('request_dt', [date('Y-m-d'), date('Y-m-d')])->count();
                    }else{
                        $score[] = Followup::where(['status' => 'f', 'org_id' => Auth::user()->org_id])->whereBetween('request_dt', [$request->date_from, $request->date_to])->count();
                    }
                }
            }

            if (!empty($labels) && !empty($score)) {
                $chart = new KPI();
                $chart->labels($labels);
                $chart->dataset(app()->getLocale() == 'ar' ? ' العدد' : 'Count', 'bar', $score)->color('#007bff');
            }
            return view('followup.reports', compact('type', 'chart', 'status'));
        }

        if($type == 'details'){
            $followup_list = Followup::where(['org_id' => Auth::user()->org_id]);

            if(!empty($request->status) && $request->status !== 0){
                $followup_list = $followup_list->where(['status' => $request->status]);
            }
            if(!empty($request->customers) && $request->customers !== 0){
                $followup_list = $followup_list->where(['cust_id' => $request->customers]);
            }
            if(!empty($request->date_from) || !empty($request->date_to)){
                $followup_list = $followup_list->whereBetween('request_dt', [$request->date_from, $request->date_to]);
            }
            $followup_list = $followup_list->get();

            return view('followup.reports', compact('followup_list'));
        }

        if($type == 'messages'){
            $followup_list = FollowupMessage::where(['org_id' => Auth::user()->org_id]);

            if(!empty($request->status) && $request->status !== 0){
                $followup_list = $followup_list->where(['msg_media' => $request->status]);
            }
            if(!empty($request->date_from) || !empty($request->date_to)){
                $followup_list = $followup_list->whereBetween('msg_dt', [$request->date_from, $request->date_to]);
            }
            $followup_list = $followup_list->get();

            return view('followup.reports', compact('followup_list'));
        }

        return \App::abort(404);
    }

}
