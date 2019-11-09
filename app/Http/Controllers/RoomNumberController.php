<?php


namespace App\Http\Controllers;


use App\BookingDetails;
use App\Category;
use App\CategoryNum;
use App\ClosingDateList;
use App\FacilityList;
use App\Property;
use App\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Session;
use Carbon\Carbon;

class RoomNumberController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *  index ( view -> rooms.num.index )
     *  ' Back with -> cateigory-> [table] + add_Cateigory[ $hotels ,$amentities ,$categories]
     */
    public function index()
    {
        if(permissions('room_num_view') == false){
            //set session message
            Session::flash('message',__('strings.do_not_have_permission'));
            return view('permissions');
        }

        // get category-> type = 7

        $category = DB::table('categories')
            ->join('categories_type', 'categories_type.id', '=', 'categories.category_type_id')
            ->join('property', 'property.id', '=', 'categories.property_id')
            ->select('categories.*', 'categories_type.name as type_name_ar', 'categories_type.name_en as type_name_en', 'property.name as pro_name', 'property.name_en as pro_name_en')
            ->where([
                ['categories_type.type', 7],
                ['categories_type.org_id', Auth()->user()->org_id],
                ['categories.org_id', Auth()->user()->org_id],
            ])->orderBy('categories.updated_at', 'DESC')
            ->get();

        // to add
        $hotels = Property::where('org_id', Auth()->user()->org_id)->get();
        // amentities
        $amentities = DB::table('categories_type')
            ->join('categories', 'categories.category_type_id', '=', 'categories_type.id')
            ->select('categories.*')
            ->whereIn('categories_type.type', [5, 6])
            ->where([
                ['categories.active', 1],
                ['categories.org_id', Auth()->user()->org_id],
                ['categories_type.org_id', Auth()->user()->org_id],
                ['categories_type.active', 1]
            ])->get();

        // categories

        $categories = DB::table('categories_type')
            ->select('categories_type.*')
            ->where([
                ['categories_type.type', 7],
                ['categories_type.org_id', Auth()->user()->org_id],
                ['categories_type.active', 1]
            ])->get();

        $taxs = Tax::where('org_id',Auth()->user()->org_id)->where('active',1)->get();


        return view('rooms.num.index')
            ->with('categories', $categories)
            ->with('hotels', $hotels)
            ->with('amentities', $amentities)
            ->with('id', 0)
            ->with('taxs', $taxs)
            ->with('category', $category);
    }

    public function getCategoryNum($id = 0)
    {
        $cate = Category::find($id);
        $category_num = [];
        if (!empty($cate) && $cate->org_id = Auth()->user()->org_id) {
            $category_num = CategoryNum::where('cat_id', $id)->where('org_id', Auth()->user()->org_id)
                ->orderBy('cat_num', 'ASC')->get();

            return response()->json($category_num);
        }
        return response()->json($category_num);

    }

    public function search(Request $request)
    {
        if(permissions('room_num_view') == false){
            //set session message
            Session::flash('message',__('strings.do_not_have_permission'));
            return view('permissions');
        }

        $id = $request->room;
        if ($id == 0) {
            return redirect('admin/rooms/number');
        }

        $category = DB::table('categories')
            ->join('categories_type', 'categories_type.id', '=', 'categories.category_type_id')
            ->join('property', 'property.id', '=', 'categories.property_id')
            ->select('categories.*', 'categories_type.name as type_name_ar', 'categories_type.name_en as type_name_en', 'property.name as pro_name', 'property.name_en as pro_name_en')
            ->where([
                ['categories_type.type', 7],
                ['categories_type.org_id', Auth()->user()->org_id],
                ['categories.org_id', Auth()->user()->org_id],
                ['categories.id', $id],
            ])->get();

        if (count($category) > 0) {
            // to add
            $hotels = Property::where('org_id', Auth()->user()->org_id)->get();
            // amentities
            $amentities = DB::table('categories_type')
                ->join('categories', 'categories.category_type_id', '=', 'categories_type.id')
                ->select('categories.*')
                ->whereIn('categories_type.type', [5, 6])
                ->where([
                    ['categories.active', 1],
                    ['categories.org_id', Auth()->user()->org_id],
                    ['categories_type.org_id', Auth()->user()->org_id],
                    ['categories_type.active', 1]
                ])->get();

            // categories

            $categories = DB::table('categories_type')
                ->select('categories_type.*')
                ->where([
                    ['categories_type.type', 7],
                    ['categories_type.org_id', Auth()->user()->org_id],
                    ['categories_type.active', 1]
                ])->get();

            $taxs = Tax::where('org_id',Auth()->user()->org_id)->where('active',1)->get();


            return view('rooms.num.index')
                ->with('categories', $categories)
                ->with('hotels', $hotels)
                ->with('amentities', $amentities)
                ->with('category', $category)
                ->with('taxs', $taxs)
                ->with('id', $id);
        }

        return redirect('admin/rooms/number');


    }
   public function addNewCatNum(Request $request)
    {
        if(permissions('room_num_add') == false){
            //set session message
            Session::flash('message',__('strings.do_not_have_permission'));
            return view('permissions');
        }

        // valid
        $rules = [
            'id_rooms' => 'required|integer',
            'cat_num' => 'required|max:50',
            'floor_num' => 'required|max:4',
            'building' => 'nullable|max:40',
            'from*'   =>'nullable|date',
            'to*'   =>'nullable|date',
        ];

        $valid = Validator::make($request->all(), $rules);
        // check valid
        // 2. return errors
        if ($valid->fails())
            return redirect()->back()->withErrors($valid->errors())->withInput($request->all());


        $data = $request->all();
        $room = Category::find($data['id_rooms']);
        // check access room ?
        if (!empty($room) && $room->org_id == Auth()->user()->org_id) {
            // insert
            $room_num = new CategoryNum();
            $room_num->cat_id = $data['id_rooms'];
            $room_num->cat_num = $data['cat_num'];
            $room_num->building = $data['building'];
            $room_num->floor_num = $data['floor_num'];
            $room_num->org_id = Auth()->user()->org_id;
            $room_num->user_id = Auth()->user()->id;

            if ($room_num->save()) {
                if (!empty($data['amentities'])) {


                    foreach ($data['amentities'] as $amentity) {

                        $ameti[] = [
                            'cat_id' => $amentity,
                            'category_num_id' => $room_num->id,
                            'active' => 1,
                            'org_id' => Auth()->user()->org_id,
                            'user_id' => Auth()->user()->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ];

                    }

                    FacilityList::insert($ameti);
                }

                $countClose = count($data['from']);
                if (!empty($data['from'])) {
                    $numclose = [];
                    for ($i = 0; $i < $countClose; $i++) {
                        $numclose[$i]['category_num_id'] = $room_num->id;
                        $numclose[$i]['date_from'] = $data['from'][$i];
                        $numclose[$i]['date_to'] = $data['to'][$i];
                        $numclose[$i]['reason'] = $data['reason'][$i];
                        $numclose[$i]['org_id'] = Auth()->user()->org_id;
                        $numclose[$i]['user_id'] = Auth()->user()->id;
                        $numclose[$i]['created_at'] = Carbon::now();
                        $numclose[$i]['updated_at'] = Carbon::now();

                        if ($numclose[$i]['date_from'] != null && $numclose[$i]['date_to'] != null)
                        {
                            $from = $numclose[$i]['date_from'];
                            $to = $numclose[$i]['date_to'];
                            $cloth = ClosingDateList::where(function ($query) use
                            ($from,$to) {
                                $query->where(function ($query) use
                                ($from, $to) {
                                    $query->where('date_from', '<=',
                                        $from)->where('date_to', '>=', $from);
                                })->orWhere(function ($query) use ($from,$to) {
                                    $query->where('date_from',
                                        '<=',$to)->where('date_to', '>=', $to);
                                })->orWhere(function ($query) use ($from,$to) {
                                    $query->where('date_from','>=',$from )->where('date_to',
                                        '<=',$to);
                                });})->where('org_id',Auth()->user()->org_id)->where('category_num_id',$room_num->id)->first();

                            if(empty($cloth))
                            {
                                ClosingDateList::insert($numclose[$i]);
                            }
                        }

                    }

                }



                Session::flash('created', __('strings.create_message'));
                return redirect()->back();

            }
            Session::flash('danger', __('OoPs..! Have Same Errors try again'));

            return redirect()->back();

        }
        // : No Access
        Session::flash('danger', __('OoPs..! Not Found Or access denied'));

        return redirect()->back();


    }

    
    /**
     * updated Category_num view
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     *
     */

    public function updatedView($id = 0)
    {
        if(permissions('room_num_updated') == false){
            //set session message
            Session::flash('message',__('strings.do_not_have_permission'));
            return view('permissions');
        }

        //  $catNum = CategoryNum::find($id);

        $catNum = DB::table('category_num')
            ->join('categories', 'categories.id', '=', 'category_num.cat_id')
            ->join('categories_type', 'categories_type.id', '=', 'categories.category_type_id')
            ->join('property', 'property.id', '=', 'categories.property_id')
            ->select('category_num.*', 'categories.name as categor_name', 'categories.name_en as categor_name_en ', 'categories_type.name as type_name_ar', 'categories_type.name_en as type_name_en', 'property.name as pro_name', 'property.name_en as pro_name_en')
            ->where('category_num.id', $id)
            ->first();

        // check Category num -> found && have access
        if (!empty($catNum) && $catNum->org_id == Auth()->user()->org_id) {
            // get close -day
            $closeDays = ClosingDateList::where('category_num_id', $id)
                ->orderBy('updated_at', 'desc')->get();

            // amentis
            // get amints
            $amentities = DB::table('categories_type')
                ->join('categories', 'categories.category_type_id', '=', 'categories_type.id')
                ->select('categories.*')
                ->whereIn('categories_type.type', [5, 6])
                ->where([
                    ['categories.active', 1],
                    ['categories.org_id', Auth()->user()->org_id],
                    ['categories_type.org_id', Auth()->user()->org_id],
                    ['categories_type.active', 1]
                ])->get();

            // my amentities
            $amentitiesData = FacilityList::where('category_num_id', $id)->pluck('cat_id')->toArray();

            // view

            return view('rooms.num.updated')
                ->with('amentitiesData', $amentitiesData)
                ->with('amentities', $amentities)
                ->with('closeDays', $closeDays)
                ->with('catNum', $catNum);
        }

        Session::flash('danger', __('OoPs..! Not Found Or access denied'));

        return redirect()->back();

    }

    /**
     *  updated process
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     */
 
    public function updatedProcess(Request $request)
    {

        $rules = [
            'id' => 'required|integer',
            'cat_num' => 'required|max:50',
            'floor_num' => 'required|max:4',
            'building' => 'nullable|max:40',
            'from*' => 'nullable|date',
            'to*' => 'nullable|date',
        ];

        $valid = Validator::make($request->all(), $rules);
        // check valid
        // 2. return errors
        if ($valid->fails())
            return redirect()->back()->withErrors($valid->errors())->withInput($request->all());

        //check
        $data = $request->all();
        $catNum = CategoryNum::find($data['id']);
        if (!empty($catNum) && $catNum->org_id == Auth()->user()->org_id) {
            $catNum->cat_num = $data['cat_num'];
            $catNum->building = $data['building'];
            $catNum->floor_num = $data['floor_num'];

            if ($catNum->save()) {
                // add amints
                $oldAmeits = FacilityList::where('category_num_id', $data['id'])->pluck('id')->toArray();
                $del = FacilityList::whereIn('id', $oldAmeits)->delete();
                // insert new
                // add facility_list
                if (!empty($data['amentities'])) {


                    foreach ($data['amentities'] as $amentity) {

                        $ameti[] = [
                            'cat_id' => $amentity,
                            'category_num_id' => $data['id'],
                            'active' => 1,
                            'org_id' => Auth()->user()->org_id,
                            'user_id' => Auth()->user()->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ];

                    }

                    FacilityList::insert($ameti);
                }

                $countClose = count($data['from']);
                if (!empty($data['from'])) {
                    $numclose = [];
                    for ($i = 0; $i < $countClose; $i++) {
                        $numclose[$i]['category_num_id'] = $data['id'];
                        $numclose[$i]['date_from'] = $data['from'][$i];
                        $numclose[$i]['date_to'] = $data['to'][$i];
                        $numclose[$i]['reason'] = $data['reason'][$i];
                        $numclose[$i]['org_id'] = Auth()->user()->org_id;
                        $numclose[$i]['user_id'] = Auth()->user()->id;
                        $numclose[$i]['created_at'] = Carbon::now();
                        $numclose[$i]['updated_at'] = Carbon::now();

                        if ($numclose[$i]['date_from'] != null && $numclose[$i]['date_to'] != null)
                        {
                            $from = $numclose[$i]['date_from'];
                            $to = $numclose[$i]['date_to'];
                            $cloth = ClosingDateList::where(function ($query) use
                            ($from,$to) {
                                $query->where(function ($query) use
                                ($from, $to) {
                                    $query->where('date_from', '<=',
                                        $from)->where('date_to', '>=', $from);
                                })->orWhere(function ($query) use ($from,$to) {
                                    $query->where('date_from',
                                        '<=',$to)->where('date_to', '>=', $to);
                                })->orWhere(function ($query) use ($from,$to) {
                                    $query->where('date_from','>=',$from )->where('date_to',
                                        '<=',$to);
                                });})->where('org_id',Auth()->user()->org_id)->where('category_num_id',$data['id'])->first();

                            if(empty($cloth))
                            {
                                ClosingDateList::insert($numclose[$i]);
                            }
                        }

                    }

                }


                Session::flash('created', __('strings.message_success'));
                return redirect()->back();

            }
            Session::flash('danger', __('OoPs..! Have Same Errors try again'));

            return redirect()->back();


        }

        Session::flash('danger', __('OoPs..! Not Found Or access denied'));

        return redirect()->back();

    }
    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     *  del Ctho date
     */

    public function delCloth($id = 0)
    {
        $cloth = ClosingDateList::find($id);

        // check

        if (!empty($cloth) && $cloth->org_id == Auth()->user()->org_id) {
            if (ClosingDateList::where('id', $id)->delete()) {

                Session::flash('created', __('strings.delete_message_days'));
                return redirect()->back();
            }

            ession::flash('danger', __('OoPs..! Wrong have same errors please try again'));

            return redirect()->back();
        }

        Session::flash('danger', __('OoPs..! Not Found Or access denied'));

        return redirect()->back();
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     *  deleted category num  if have access && not in {{ cloth , Facility , booking }}
     */

    public function delCatNum($id = 0)
    {
        if(permissions('room_num_del') == false){
            //set session message
            Session::flash('message',__('strings.do_not_have_permission'));
            return view('permissions');
        }


        $catNum = CategoryNum::find($id);


        if(count(!$catNum)!=0 && $catNum->org_id == Auth()->user()->org_id)
        {
            $Cloth = ClosingDateList::where('category_num_id',$id)->count();
            if($Cloth !=0)
            {
                Session::flash('danger', __('لا يمكن الحذف لموجود ايام اغلاق'));

                return redirect()->back();
            }

            $amits = FacilityList::where('category_num_id',$id)->count();

            if($amits!=0)
            {
                Session::flash('danger', __('لا يمكن الحذف لوجود وسائل راحه'));

                return redirect()->back();
            }

            $booking = BookingDetails::where('category_num_id',$id)->count();

            if($booking != 0)
            {
                Session::flash('danger', __('هذا الغرفه تم حجزه لذلك لا يمكن الحذف'));

                return redirect()->back();
            }


            if(CategoryNum::where('id',$id)->delete())
            {
                Session::flash('created', __('strings.delete_message'));
                return redirect()->back();
            }

            ession::flash('danger', __('OoPs..! Wrong have same errors please try again'));

            return redirect()->back();


        }

        Session::flash('danger', __('OoPs..! Not Found Or access denied'));

        return redirect()->back();
    }
}