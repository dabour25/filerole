<?php

namespace App\Http\Controllers;

use App\BookingDetails;
use App\Category;
use App\CategoryDetails;
use App\CategoryNum;
use App\ClosingDateList;
use App\FacilityList;
use App\Photo;
use App\PriceList;
use App\PropertySilder;
use App\Tax;
use App\Transactions;
use Illuminate\Http\Request;
use App\Property;
use App\Destinations;
use App\Locations;
use Auth;
use Illuminate\Support\Facades\DB;
use function GuzzleHttp\Promise\all;
use Validator;
use Carbon\Carbon;
use Session;
use App\Policy_types;
use App\property_policy;
use Illuminate\Validation\Rule;


class HotelRoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {

       if(permissions('room_view') == false){
            //set session message
            Session::flash('message',__('strings.do_not_have_permission'));
            return view('permissions');
        }


        $hotels =  $propertys= DB::table('property')
            ->join('locations','locations.id','=','property.location_id')
            ->join('destinations','destinations.id','=','locations.destination_id')
            ->select('property.*','destinations.name as destination_name_ar','destinations.name_en as destination_name_en')
            ->where('property.org_id','=',Auth()->user()->org_id)
            ->orderBy('property.updated_at','DESC')
            ->get();

        $countOfRooms = Category::where('org_id',Auth()->user()->org_id)->count();

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

        // get Tax_step
        $taxs = Tax::where('org_id',Auth()->user()->org_id)->where('active',1)->get();


        return view('rooms.index', compact('hotels', 'categories', 'amentities','countOfRooms','taxs'));
    }

    public function search(Request $request)
    {
        $id = $request->get('hotel');
        if ($id != 0) {

            $hotels= DB::table('property')
                ->join('locations','locations.id','=','property.location_id')
                ->join('destinations','destinations.id','=','locations.destination_id')
                ->select('property.*','destinations.name as destination_name_ar','destinations.name_en as destination_name_en')
                ->where('property.id',$id)
                ->where('property.org_id','=',Auth()->user()->org_id)
                ->get();
        }else{
            $hotels = DB::table('property')
                ->join('locations','locations.id','=','property.location_id')
                ->join('destinations','destinations.id','=','locations.destination_id')
                ->select('property.*','destinations.name as destination_name_ar','destinations.name_en as destination_name_en')
                ->where('property.org_id','=',Auth()->user()->org_id)
                ->orderBy('property.updated_at','DESC')
                ->get();
        }


        $countOfRooms = Category::where('org_id',Auth()->user()->org_id)->count();

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


        return view('rooms.index', compact('hotels', 'id','categories', 'amentities','countOfRooms','taxs'));
    }

    public function  add(Request $request)
    {
        if(permissions('add_new_room') == false){
            //set session message
            Session::flash('message',__('strings.do_not_have_permission'));
            return view('permissions');
        }
        $data = $request->all();

         // valid
        $countClose = count($data['from']);

        if ($image = $request->file('photo')) {
            //give a name to image and move it to public directory
            $image_name = md5(time()) .'.'. $image->getClientOriginalExtension();
            $image->move('images', $image_name);

            //persist data into photos table
            $photo = Photo::create(['file' => $image_name]);
            //get image_id
            $image_id = $photo->id;

        }

        // 1. add categoryis

        $category = new Category();

        $category->category_type_id   = $data['cate_id'];
        $category->property_id        = $data['property_id'];
        $category->name               = $data['name'];
        $category->name_en            = $data['name_en'];
        $category->photo_id           = isset($image_id)?$image_id:null;
        $category->cancel_policy      = $data['cancel_policy'];
        $category->cancel_days        = isset($data['cancel_days'])?$data['cancel_days']:0;
        $category->cancel_charge      = isset($data['cancel_charge'])?$data['cancel_charge']:0;
        $category->active             =1;
        $category->org_id             = Auth()->user()->org_id;
        $category->user_id            = Auth()->user()->id;
        if($category->save())
        {

            //tax & prices
            if($data['tax'] == null)
            {
                $newPrices = new PriceList();

                $newPrices->cat_id = $category->id;
                $newPrices->date =  date('Y-m-d');
                $newPrices->price =  $data['price'];
                $newPrices->tax_value = 0;
                $newPrices->tax =  null;
                $newPrices->final_price = $data['price'];
                $newPrices->active =  1;
                $newPrices->org_id = Auth()->user()->org_id;
                $newPrices->user_id = Auth()->user()->id;
                $newPrices->save();
            } else {
                $gettax = Tax::find($data['tax']);
                if(!empty($gettax) && $gettax->org_id == Auth()->user()->org_id)
                {
                    // check used value or percent
                    if($gettax->percent !=null)
                    {
                        $taxValue = $data['price'] * $gettax->percent / 100;
                        $taxUsed = $gettax->percent;
                        $taxTota = $data['price'] +$taxValue;
                    }
                    else{
                        $taxValue = $data['price'] + $gettax->value;
                        $taxUsed = $gettax->value;
                        $taxTota = $taxValue;
                    }
                    // add in price_list { }
                    $newPrices = new PriceList();

                    $newPrices->cat_id = $category->id;
                    $newPrices->date =  date('Y-m-d');
                    $newPrices->price =  $data['price'];
                    $newPrices->tax_value =  $taxUsed;
                    $newPrices->tax =  $data['tax'];
                    $newPrices->final_price =  $taxTota;
                    $newPrices->active =  1;
                    $newPrices->org_id = Auth()->user()->org_id;
                    $newPrices->user_id = Auth()->user()->id;

                    $newPrices->save();
                }
            }



            // add facility_list
          if(!empty($data['amentities']))
            {


                foreach ($data['amentities'] as $amentity) {

                    $ameti[] = [
                        'cat_id' => $amentity,
                        'category_id'=>$category->id,
                        'active' => 1,
                        'org_id' => Auth()->user()->org_id,
                        'user_id' => Auth()->user()->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];

                }

                FacilityList::insert($ameti);
            }

            // add close_day
            // Data Request from[ 0,1,2] , to[0,1,2] , reason[0,1,2]
            // close date [from[0],to[0],reason[0]],[ from[1],to[1],reason[1]]..
           if(!empty($data['from']))
            {
                for ($i=0;$i < $countClose;$i ++)
                {
                    $closeDay[$i]['cat_id']= $category->id;
                    $closeDay[$i]['date_from']=$data['from'][$i];
                    $closeDay[$i]['date_to']=$data['to'][$i];
                    $closeDay[$i]['reason']=$data['reason'][$i];
                    $closeDay[$i]['org_id']=Auth()->user()->org_id;
                    $closeDay[$i]['user_id']=Auth()->user()->id;
                    $closeDay[$i]['created_at']=Carbon::now();
                    $closeDay[$i]['updated_at']=Carbon::now();

                    if($closeDay[$i]['date_from'] !=null &&$closeDay[$i]['date_to'] !=null)
                    {
                        $from = $closeDay[$i]['date_from'];
                        $to = $closeDay[$i]['date_to'];
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
                            });})->where('org_id',Auth()->user()->org_id)->where('cat_id',$category->id)->first();

                        if(empty($cloth))
                        {
                            ClosingDateList::insert($closeDay[$i]);
                        }


                    }

                }


            }
            // 2. add category_num
            if($data['category_num'] != null)
            {

                for ($catenum = 0;$catenum < $data['category_num'];$catenum ++)
                {
                    $num = new CategoryNum();

                    $num->cat_id =$category->id;
                    $num->cat_num =$catenum +1;
                    $num->org_id             = Auth()->user()->org_id;
                    $num->user_id            = Auth()->user()->id;

                    if($num->save())
                    {
                        if (!empty($data['amentities']))
                        {
                            foreach ($data['amentities'] as $amentity) {

                                $numamentities[] = [
                                    'cat_id' => $amentity,
                                    'category_num_id' => $num->id,
                                    'active' => 1,
                                    'org_id' => Auth()->user()->org_id,
                                    'user_id' => Auth()->user()->id,
                                    'created_at' => Carbon::now(),
                                    'updated_at' => Carbon::now()
                                ];

                            }
                            FacilityList::insert($numamentities);
                            $numamentities = [];
                        }

                        if(!empty($data['from']))
                        {
                            $numclose = [];
                            for ($i=0;$i < $countClose;$i ++)
                            {
                                $numclose[$i]['category_num_id']= $num->id;
                                $numclose[$i]['date_from']=$data['from'][$i];
                                $numclose[$i]['date_to']=$data['to'][$i];
                                $numclose[$i]['reason']=$data['reason'][$i];
                                $numclose[$i]['org_id']=Auth()->user()->org_id;
                                $numclose[$i]['user_id']=Auth()->user()->id;
                                $numclose[$i]['created_at']=Carbon::now();
                                $numclose[$i]['updated_at']=Carbon::now();

                                if($numclose[$i]['date_from'] !=null &&$numclose[$i]['date_to'] !=null)
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
                                        });})->where('org_id',Auth()->user()->org_id)->where('category_num_id',$num->id)->first();

                                    if(empty($cloth))
                                    {
                                        ClosingDateList::insert($numclose[$i]);
                                    }

                                }

                            }

                        }
                    }// save sum
                }

            }// if found categoriy num

            Session::flash('created', __('strings.create_message'));
            return redirect()->back();
        } // if save cateogry


        Session::flash('danger', __('OoPs..! we have Same ERRORS Please connected With Supper'));

        return redirect()->back();

    }

    public function getCateigors($id = 0)
    {
        $hotel = Property::find($id);

        $cateigorys = [];
        if(!empty($hotel)&& $hotel->org_id == Auth()->user()->org_id)
        {
            $cateigorys = Category::with('type','photo')->where([
                ['property_id',$id],
                ['org_id',Auth()->user()->org_id],
                ['active',1]
            ])->orderBy('updated_at', 'desc')->get();

            return response()->json($cateigorys);
        }

        Session::flash('danger', __('OoPs..! Not Found Or access denied'));

        return  response()->json($cateigorys);




    }

    public function updatedView($id =0)
    {

         if(permissions('updated_room') == false){
            //set session message
            Session::flash('message',__('strings.do_not_have_permission'));
            return view('permissions');
        }


        $room = Category::with('photo')->find($id);


        if(!empty($room) && $room->org_id == Auth()->user()->org_id)
        {
            // get cate_type

            $categoriesType = DB::table('categories_type')
                ->select('categories_type.*')
                ->where([
                    ['categories_type.type', 7],
                    ['categories_type.org_id', Auth()->user()->org_id],
                    ['categories_type.active', 1]
                ])->get();

            // get close

            $closeDays = ClosingDateList::where([['cat_id',$id],['org_id', Auth()->user()->org_id]])->get();

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
           $amentitiesData=FacilityList::where('category_id',$id)->pluck('cat_id')->toArray();


            // get countCate um

            $countCateNum = CategoryNum::where([['cat_id',$id],['org_id', Auth()->user()->org_id]])->count();

            // get hotel

            $hotels = Property::where('org_id',Auth()->user()->org_id)->get();
            $policys=Policy_types::where('org_id',Auth()->user()->org_id)->get();



          $policy_types=property_policy::join('policy_type','policy_type_id','=','policy_type.id')
            ->where('property_policy.org_id',Auth()->user()->org_id)
            ->where('cat_id',$id)
            ->select('property_policy.*', 'name','type')
            ->orderBy('id','desc')
            ->get();
            return view('rooms/updated')
                ->with('hotels',$hotels)
                ->with('countCateNum',$countCateNum)
                ->with('amentitiesData',$amentitiesData)
                ->with('amentities',$amentities)
                ->with('closeDays',$closeDays)
                ->with('room',$room)
                ->with('categoriesType',$categoriesType)
                ->with('policys', $policys)
                ->with('policy_types',$policy_types);
        }


        Session::flash('danger', __('OoPs..! Not Found Or access denied'));

        return  redirect()->back();

    }

    public function updatedProcess(Request $request)
    {

        // check
        $data = $request->all();
        $category =Category::find($data['id']);

        // check
        if(!empty($category) && $category->org_id == Auth()->user()->org_id)
        {

            $countClose = count($data['from']);
            //* valid
            $rules = [
                'id'       => 'required',
                'name'     => 'required|max:255',
                'name_en'  => 'nullable|max:255',
                'from[]'   => 'nullable|date',
                'to[]'     => 'nullable|date',
                'photo'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            ];

            $valid = Validator::make($request->all(), $rules);
            // check valid
            // 2. return errors
            if ($valid->fails())
               return redirect()->back()->withErrors($valid->errors())->withInput($request->all());

            //* insert

            // iamge

            if ($image = $request->file('photo')) {
                //give a name to image and move it to public directory
                $image_name = md5(time()) .'.'. $image->getClientOriginalExtension();
                $image->move('images', $image_name);

                //persist data into photos table
                $photo = Photo::create(['file' => $image_name]);
                //get image_id
                $image_id = $photo->id;

            }

            $category->category_type_id   = $data['cate_id'];
            $category->property_id        = $data['property_id'];
            $category->name               = $data['name'];
            $category->name_en            = $data['name_en'];
            $category->photo_id           = isset($image_id)?$image_id:$category->photo_id;
            $category->cancel_policy      = $data['cancel_policy'];
            if($data['cancel_policy'] == 'before check in')
            {
                $category->cancel_days        = isset($data['cancel_days'])?$data['cancel_days']:null;
                $category->cancel_charge      = isset($data['cancel_charge'])?$data['cancel_charge']:null;
            } else{
                $category->cancel_days        = null;
                $category->cancel_charge      = null;
            }

            if($category->save()) {
                // 1- amints

                // deleled old
                $oldAmeits =FacilityList::where('category_id',$data['id'])->pluck('cat_id')->toArray();
                $del = FacilityList::whereIn('id', $oldAmeits)->delete();
                // insert new
                // add facility_list
                if(!empty($data['amentities']))
                {


                    foreach ($data['amentities'] as $amentity) {

                        $ameti[] = [
                            'cat_id' => $amentity,
                            'category_id'=>$data['id'],
                            'active' => 1,
                            'org_id' => Auth()->user()->org_id,
                            'user_id' => Auth()->user()->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now()
                        ];

                    }

                    FacilityList::insert($ameti);
                }

                // 2 - cloth date

                // add close_day
                // Data Request from[ 0,1,2] , to[0,1,2] , reason[0,1,2]
                // close date [from[0],to[0],reason[0]],[ from[1],to[1],reason[1]]..
                if(!empty($data['from']))
                {
                    for ($i=0;$i < $countClose;$i ++)
                    {
                        $closeDay[$i]['cat_id']= $data['id'];
                        $closeDay[$i]['date_from']=$data['from'][$i];
                        $closeDay[$i]['date_to']=$data['to'][$i];
                        $closeDay[$i]['reason']=$data['reason'][$i];
                        $closeDay[$i]['org_id']=Auth()->user()->org_id;
                        $closeDay[$i]['user_id']=Auth()->user()->id;
                        $closeDay[$i]['created_at']=Carbon::now();
                        $closeDay[$i]['updated_at']=Carbon::now();

                        if($closeDay[$i]['date_from'] !=null &&$closeDay[$i]['date_to'] !=null)
                        {
                            $from = $closeDay[$i]['date_from'];
                            $to = $closeDay[$i]['date_to'];
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
                                });})->where('org_id',Auth()->user()->org_id)->where('cat_id',$data['id'])->first();

                            if(empty($cloth))
                            {
                                ClosingDateList::insert($closeDay[$i]);
                            }
                        }

                    }
                }

                //3 check category_num

                if($data['category_num'] != null)
                {
                    $countCateNum = CategoryNum::where([['cat_id',$data['id']],['org_id', Auth()->user()->org_id]])->count();


                    for ($catenum = 0;$catenum < $data['category_num'];$catenum ++)
                    {
                        $countCateNum +=1 ;
                        $num = new CategoryNum();

                        $num->cat_id =$data['id'];
                        $num->cat_num =$countCateNum;
                        $num->org_id             = Auth()->user()->org_id;
                        $num->user_id            = Auth()->user()->id;

                        if($num->save())
                        {
                            if (!empty($data['amentities']))
                            {
                                foreach ($data['amentities'] as $amentity) {

                                    $numamentities[] = [
                                        'cat_id' => $amentity,
                                        'category_num_id' => $num->id,
                                        'active' => 1,
                                        'org_id' => Auth()->user()->org_id,
                                        'user_id' => Auth()->user()->id,
                                        'created_at' => Carbon::now(),
                                        'updated_at' => Carbon::now()
                                    ];

                                }
                                FacilityList::insert($numamentities);
                                $numamentities = [];
                            }

                            if(!empty($data['from']))
                            {
                                $numclose = [];
                                for ($i=0;$i < $countClose;$i ++)
                                {
                                    $numclose[$i]['category_num_id']= $num->id;
                                    $numclose[$i]['date_from']=$data['from'][$i];
                                    $numclose[$i]['date_to']=$data['to'][$i];
                                    $numclose[$i]['reason']=$data['reason'][$i];
                                    $numclose[$i]['org_id']=Auth()->user()->org_id;
                                    $numclose[$i]['user_id']=Auth()->user()->id;
                                    $numclose[$i]['created_at']=Carbon::now();
                                    $numclose[$i]['updated_at']=Carbon::now();

                                    if($numclose[$i]['date_from'] !=null &&$numclose[$i]['date_to'] !=null)
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
                                            });})->where('org_id',Auth()->user()->org_id)->where('category_num_id',$num->id)->first();

                                        if(empty($cloth))
                                        {
                                            ClosingDateList::insert($numclose[$i]);
                                        }
                                    }

                                }

                            }
                        }// save sum
                    }

                }// if found categoriy num

                Session::flash('created', __('strings.create_message'));
                return redirect()->back();

            } // if-> save


        }

        Session::flash('danger', __('OoPs..! Not Found Or access denied'));

        return  'redirect()->back()';


    }


    // del photo

    public function delPhoto($id = 0)
    {
        $category =Category::find($id);

        if(!empty($category) && $category->org_id == Auth()->user()->org_id)
        {
            $category->photo_id = null;

            if($category->save())
            {
                Session::flash('deleted', __('strings.delete_message') );
                  return redirect()->back();
            }

            Session::flash('danger', __('OoPs..! We Have Some Errors Please Try leter'));

               return  'redirect()->back()';
        }


        Session::flash('danger', __('OoPs..! Not Found Or access denied'));

        return  'redirect()->back()';

    }

     //created Prices
    public function createPrices($id = 0)
    {
        $room = Category::find($id);

        if(!empty($room) && $room->org_id == Auth()->user()->org_id) {

            $kids = DB::table('categories_detail')
                ->join('categories','categories.id','=','categories_detail.catsub_id')
                ->join('categories_type','categories_type.id','=','categories.category_type_id')
                ->select('categories_detail.*','categories.id','categories.name as room_ar','categories.name_en')
                ->where([
                    ['categories_detail.cat_id',$id],
                    ['categories_detail.org_id',Auth()->user()->org_id],
                    ['categories_type.type',9]
                ])->get();

            $additionals = DB::table('categories_detail')
                ->join('categories','categories.id','=','categories_detail.catsub_id')
                ->join('categories_type','categories_type.id','=','categories.category_type_id')
                ->select('categories_detail.*','categories.id','categories.name as room_ar','categories.name_en')
                ->where([
                    ['categories_detail.cat_id',$id],
                    ['categories_detail.org_id',Auth()->user()->org_id],
                    ['categories_type.type',8]
                ])->get();

            $mytypes = Category::join('categories_type', function ($join) {
                $join->on('categories_type.id', '=', 'categories.category_type_id')->where(['categories_type.type' => 9, 'categories.org_id' => Auth::user()->org_id]);
            })->select('categories.*')->where(['categories.org_id' => Auth::user()->org_id])->get();
            $types = Category::join('categories_type', function ($join) {
                $join->on('categories_type.id', '=', 'categories.category_type_id')->where(['categories_type.type' => 8, 'categories.org_id' => Auth::user()->org_id]);
            })->select('categories.*')->where(['categories.org_id' => Auth::user()->org_id])->get();


            return view('rooms.addprices')
                ->with('room',$room)
                ->with('mytypes',$mytypes)
                ->with('kids',$kids)
                ->with('additionals',$additionals)
                ->with('types',$types);

        }

        Session::flash('danger', __('OoPs..! Not Found Or access denied'));

        return  redirect()->back();
    }

    public function createdPricesProcess(Request $request)
    {
        //check
        $data = $request->all();
        $room = Category::find($data['room']);

        if(!empty($room) && $room->org_id == Auth()->user()->org_id) {
            // valid Rule::unique('users')->where(function($query) {
          /*  => Rule::unique('categories_detail')->where(function ($query)use($request){
                return $query->where('categories_detail.org_id',Auth()->user()->org_id)
                    ->where('categories_detail.cat_id',$request->get('room'))
                    ->where('categories_detail.catsub_id',$request->get('catsub_id'));
            }),
            //                  $query->where('role_id', '<>', 999);catsub_id
            //    })*/
            $rules = [
                'room'            => 'required',
                 'catsub_id.*'    =>  'unique:categories_detail,catsub_id,NULL,id,cat_id,'.$request->get('room'),
                'price.*'         => 'nullable|numeric',
            ];

            $valid = Validator::make($request->all(), $rules);
            // check valid
            // 2. return errors
            if ($valid->fails())
            {
                Session::flash('danger', __('OoPs..! لقد ادخلت هذا النوع من قبل'));

                return redirect()->back()->withErrors($valid->errors())->withInput($request->all());

            }



            //insert data {age_from , age_to , price ,ids )

            if(!empty($data['price']))
            {
                $age_pri = count($data['price']);
                for($i=0 ; $i < $age_pri ;$i++)
                {
                    $pricesAdd[$i]['cat_id'] = $data['room'];
                    $pricesAdd[$i]['catsub_id'] = $data['catsub_id'][$i];
                    $pricesAdd[$i]['price'] = $data['price'][$i];
                    $pricesAdd[$i]['org_id']=Auth()->user()->org_id;
                    $pricesAdd[$i]['user_id']=Auth()->user()->id;
                    $pricesAdd[$i]['created_at']=Carbon::now();
                    $pricesAdd[$i]['updated_at']=Carbon::now();

                    if($pricesAdd[$i]['catsub_id']!=null &&$pricesAdd[$i]['price']!=null)
                        CategoryDetails::insert($pricesAdd[$i]);

                }

                Session::flash('created', __('strings.create_message'));
                return redirect()->back();
            }

            Session::flash('danger', __('OoPs..! Not Found Or access denied'));

            return  redirect()->back();



        }

        Session::flash('danger', __('OoPs..! Not Found Or access denied'));

        return  redirect()->back();


    }
    // del prices

    public function delPries($id =0)
    {
        $del = CategoryDetails::find($id);

        if(!empty($del) && $del->org_id == Auth()->user()->org_id)
        {
            if(CategoryDetails::where('id',$id)->delete())
            {
                Session::flash('created', __('strings.delete_message'));

                return redirect()->back();
            }
            Session::flash('danger', __('OoPs..! Not Found OR access denied'));

            return redirect()->back();
        }

        Session::flash('danger', __('OoPs..! Not Found OR access denied'));

        return redirect()->back();

    }

    public function deletedClothDay($id =0)
    {
        $day = ClosingDateList::find($id);
        if(!empty($day) && $day->org_id == Auth()->user()->org_id)
        {
           if( ClosingDateList::where('id',$id)->delete())
           {
               Session::flash('created', __('strings.delete_message_days'));
               return redirect()->back();
           }

            ession::flash('danger', __('OoPs..! Wrong have same errors please try again'));

            return  redirect()->back();

        }

        Session::flash('danger', __('OoPs..! Not Found Or access denied'));

        return  redirect()->back();
    }

    public function delroom($id =0)
    {
        if(permissions('deleted_room') == false){
            //set session message
            Session::flash('message',__('strings.do_not_have_permission'));
            return view('permissions');
        }
        $room = Category::find($id);
        // check access
        if(!empty($room) && $room->org_id == Auth()->user()->org_id)
        {
            // not in category_num
            $pro_slider = PropertySilder::where('cat_id',$id)->get();

            if(count($pro_slider) !=0)
            {
                Session::flash('danger', __('OoPs..! لا يمكن حذفه هذه الغرفه لرتباطها ببعض الصور'));

                return  redirect()->back();
            }

            $category_num = CategoryNum::where('cat_id',$id)->get();
            if(count($category_num)!=0)
            {
                Session::flash('danger', __('OoPs..! لا يمكن الحذف بسبب وجود غرف تحت هذه الغرفه'));

                return  redirect()->back();
            }

            // check not in poroperty_slider




            // not in categories_detail

            $categories_detail = CategoryDetails::where('cat_id',$id)->get();

            if(count($categories_detail) !=0)
            {
                Session::flash('danger', __('OoPs..! لا يمكن الحذف لرتباط الغرفه بالاسعار اضافيه و اسعار اطفال'));

                return  redirect()->back();
            }

            // closing dates

            $closeing = ClosingDateList::where('cat_id',$id)->get();

            if(count($closeing) !=0)
            {
                Session::flash('danger', __('OoPs..! لا يمكن حذف هذا الغرفه لارتباطها بمواعيد اغلاق'));

                return  redirect()->back();
            }

            $facility = FacilityList::where('property_id',$id)->get();


            if(count($facility)!=0)
            {
                Session::flash('danger', __('خطأ .. ! لا يمكن حذف هذه الغرفه لحتوائها علي ملحقات'));

                return  redirect()->back();
            }


            $trans = Transactions::where('cat_id',$id)->get();

            if(count($trans)!=0)
            {
                Session::flash('danger', __('خطأ .. ! لا يمكن الحذف'));

                return  redirect()->back();
            }


            $booking = BookingDetails::where('cat_id',$id)->get();

            if(count($booking)!=0)
            {
                Session::flash('danger', __(' خطأ .. !لا يمكن حذف غرفه محجوزه'));

                return  redirect()->back();
            }




            if( Category::where('id',$id)->delete())
            {

                Session::flash('created', __('strings.delete_message_days'));
                return redirect()->back();
            }

            ession::flash('danger', __('OoPs..! Wrong have same errors please try again'));

            return  redirect()->back();

        }

        Session::flash('danger', __('OoPs..! Not Found Or access denied'));

        return  redirect()->back();
        // no have access
    }
    function add_main_policy(Request $request){
    //  dd($request->all());

      $new_policy= new Policy_types;
      $new_policy->name=$request->name;
      $new_policy->name_en=$request->name_en;
      $new_policy->org_id=Auth()->user()->org_id;
      $new_policy->type=$request->type_add;
      if($request->checkin_card)
      $new_policy->checkin_card=$request->checkin_card;
      else
      $new_policy->checkin_card='n';
      $new_policy->save();
      if($request->type_add==1) $mytab=2;
       elseif($request->type_add==2) $mytab=3;
      return redirect()->back()
      ->with(['mytab' =>$mytab])
      ->with(['policy_id' =>$new_policy->id])
      ->withInput(['tab'=>$request->pre_tab]);

    }

        function add_policy(Request $request){

           $room = Category::find($request->cat_id);
           if($request->type==1) $mytab=2;
          elseif($request->type==2) $mytab=3;
            $v = \Validator::make($request->all(), [
                'details' => 'required|min:5',
                'policy_type_id' => 'required',

            ]);

            if ($v->fails()) {
                return redirect()->back()->withInput(['tab'=>$request->tab])->withErrors($v->errors());
            }
             $old_details=property_policy::where(['policy_type_id'=>$request->policy_type_id, 'org_id'=>Auth()->user()->org_id,'cat_id'=>$request->cat_id])->first();
             $values = array_except($request->all(), ['_token','type','tab']);

            if($old_details){
           property_policy::where('id',$old_details->id)->update($values);
         }else{
           $policy_details= new property_policy;
           $policy_details->details =$request->details;
           $policy_details->details_en =$request->details_en;
           $policy_details->policy_type_id=$request->policy_type_id;
           $policy_details->org_id=Auth()->user()->org_id;
           $policy_details->cat_id=$request->cat_id;
           $policy_details->save();
         }

              $policys=Policy_types::where('org_id',Auth()->user()->org_id)->get();
              $policy_types=property_policy::join('policy_type','policy_type_id','=','policy_type.id')
              ->where('property_policy.org_id',Auth()->user()->org_id)
              ->where('cat_id',$request->cat_id)
              ->select('property_policy.*', 'name','type')
              ->get();

               return redirect()->back()
                ->withInput(['tab'=>$request->tab])
                ->with(['mytab' =>$mytab])
               ->with('policys',$policys)
               ->with('room,',$room)
               ->with('policy_types',$policy_types);





        }

        function policy_type($id,$room_id){
        $policy_detail=property_policy::join('policy_type','policy_type_id','=','policy_type.id')
        ->where(['property_policy.org_id'=>Auth()->user()->org_id,'cat_id'=>$room_id,'policy_type_id'=>$id])
        ->select('property_policy.*', 'name','type')
        ->first();
        return $policy_detail;
        }

        function delete_policy_details($id,$type,$tab){
          if($type==1) $mytab=2;
           else $mytab=3;

          $hotel_id=property_policy::where('id',$id)->value('property_id');
          property_policy::destroy($id);
          Session::flash('deleted', __('strings.sew_status_3'));
          $policys=Policy_types::where('org_id',Auth()->user()->org_id)->get();
          //Policy_types::findOrFail($property->id)->update($input);


          $policy_types=property_policy::join('policy_type','policy_type_id','=','policy_type.id')
          ->where('property_policy.org_id',Auth()->user()->org_id)
          ->where('property_id',$hotel_id)
          ->select('property_policy.*', 'name','type')
          ->orderBy('id','desc')
          ->get();

          return redirect()->back()
           ->withInput(['tab'=>$tab])
           ->with(['mytab' =>$mytab])
           ->with('policys',$policys)
           ->with('policy_types',$policy_types);
        }
        function update_policy_type(Request $request){
            $values = array_except($request->all(), ['_token','type','tab']);
            $id=$request->id;
             $request->tab;
           if($request->tab =='tab-2')
           {
           $mytab=2;
           }else{
            $mytab=3;
           }
            $policy_type=property_policy::where('id',$id)->first();
            $policys=Policy_types::where('org_id',Auth()->user()->org_id)->get();
            property_policy::where('id',$id)->update($values);
            $policy_types=property_policy::join('policy_type','policy_type_id','=','policy_type.id')
            ->where('property_policy.org_id',Auth()->user()->org_id)
            ->where('property_id',$policy_type->property_id)
            ->select('property_policy.*', 'name','type')
            ->get();
              return redirect()->back()
              ->with(['mytab' =>$mytab])
              ->withInput(['tab'=>$request->tab]);


        }

}
