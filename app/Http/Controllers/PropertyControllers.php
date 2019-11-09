<?php


namespace App\Http\Controllers;

use Auth;
use App\CategoriesType;
use App\Category;
use App\Currency;
use App\FacilityList;
use App\Locations;
use App\Photo;
use App\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Carbon\Carbon;
use Session;
use App\Policy_types;
use App\property_policy;
use App\propertyPaymethod;
use App\Destinations;

class PropertyControllers extends Controller
{
    public function index()
    {
        $org_id = Auth()->user()->org_id;

          $propertys= DB::table('property')
           ->join('photos','photos.id','=','property.image')
            ->join('locations','locations.id','=','property.location_id')
            ->join('destinations','destinations.id','=','locations.destination_id')
            ->select('property.*','photos.file','destinations.name as destination_name_ar','destinations.name_en as destination_name_en')
            ->where('property.org_id','=',$org_id)
            ->orderBy('property.updated_at','DESC')
            ->get();

        $serachpropertys = $propertys;


        return view('property.index')->with('propertys', $propertys)->with('serachpropertys',$serachpropertys);
    }

    public function addviwe()
    {
        // 1. get Categories
              if(permissions('add_property') == false){

            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        $categories = DB::table('categories_type')
            ->join('categories', 'categories.category_type_id', '=', 'categories_type.id')
            ->select('categories.*')
            ->whereIn('categories_type.type', [5, 6])
            ->where([
                ['categories.active', 1],
                ['categories.org_id', Auth()->user()->org_id],
                ['categories_type.org_id', Auth()->user()->org_id],
                ['categories_type.active', 1]
            ])->get();

        //2. get Location

        $locations = Locations::where([
            ['org_id', Auth()->user()->org_id],
            ['active', 1],
        ])->get();


        // 3. get currencies

        $currencies = Currency::get();
      $destinations=Destinations::where('org_id',Auth::user()->org_id)->where('active',1)->get();

        return view('property.add')
            ->with('locations', $locations)
            ->with('currencies', $currencies)
            ->with('destinations', $destinations)
            ->with('categories', $categories);
    }


    // Process add

    public function addProcess(Request $request)
    {

        $data = $request->all();
        // 1. valid
        //- rule
        $rules = [
            'prop_type' => 'required|string',
            'location_id' => 'required',
            'name' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'alias' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:25',
            'email' => 'nullable|email|max:255',
            'active' => 'required|integer',
            'infrontpage' => 'required|integer',
            'stars' => 'required|integer',
            'location_id' => 'required',
            'property_site' => 'nullable|active_url',
            'image' => 'required|image|mimes:jpeg,bmp,png,jpg',

        ];

        $valid = Validator::make($request->all(), $rules);
        // check valid
        // 2. return errors
        if ($valid->fails())
            return redirect()->back()->withErrors($valid->errors())->withInput($request->all());


        // iamge
        if ($image = $request->file('image')) {
            //give a name to image and move it to public directory
            $image_name = md5(time()) . $image->getClientOriginalExtension();
            $image->move('images', $image_name);

            //persist data into photos table
            $photo = Photo::create(['file' => $image_name]);
            //get image_id
            $image_id = $photo->id;

        }


        // 3. insert
        $propert = new Property();
        $propert->prop_type = $data['prop_type'];
        $propert->name = $data['name'];
        $propert->name_en = $data['name_en'];
        $propert->active = $data['active'];
        $propert->image = $image_id;
        $propert->alias = $data['alias'];
        $propert->description = $data['description'];
        $propert->description_en = $data['description_en'];
        $propert->slider_desc = $data['slider_desc'];
        $propert->slider_desc_en = $data['slider_desc_en'];
        $propert->location_id = $data['location_id'];
        $propert->latitude = $data['latitude'];
        $propert->longitude = $data['longitude'];
        $propert->currency = $data['currency_id'];
        $propert->address = $data['address'];
        $propert->telephone = $data['phone'];
        $propert->email = $data['email'];
        $propert->property_site = $data['property_site'];
        $propert->infrontpage = $data['infrontpage'];
        $propert->service_fees = $data['service_fees'];
        $propert->stars = $data['stars'];
        $propert->org_id = Auth()->user()->org_id;
        $propert->user_id = Auth()->user()->id;


        if ($propert->save()) {

            $ameti = [];
            foreach ($data['amentities'] as $amentity) {

                $ameti[] = [
                    'cat_id' => $amentity,
                    'property_id' => $propert->id,
                    'active' => 1,
                    'org_id' => Auth()->user()->org_id,
                    'user_id' => Auth()->user()->id,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];

            }
            $array_paymethod=['cash','paypal','stripe','authorize','google'];
            for($i=0; $i<count($array_paymethod); $i++){
              $hotel_paymethod=new propertyPaymethod;
              $hotel_paymethod->gateway=$array_paymethod[$i];
              $hotel_paymethod->property_id=$propert->id;
              $hotel_paymethod->org_id= Auth()->user()->org_id;
              if($array_paymethod[$i]=='cash'){
                $hotel_paymethod->active=1;
                $hotel_paymethod->default=1;
              }else{
                $hotel_paymethod->active=0;
                $hotel_paymethod->default=0;
              }
              $hotel_paymethod->save();
            }


            FacilityList::insert($ameti);

            Session::flash('created', __('strings.create_message'));

            return redirect('/admin/property');
        }


        Session::flash('danger', __('OoPs..! we have Same ERRORS Please connected With Supper'));

        return redirect('/admin/property');

    }

    public function updatedView($id = 0)
    {
    //     if(permissions('edit_property') == false){

    //       //set session message
    //       Session::flash('message', __('strings.do_not_have_permission'));
    //       return view('permissions');
    //   }
        //1. getProperty by ID
          $property = Property::find($id);
        // check if found and org_id
        if(!empty($property) && $property->org_id == Auth()->user()->org_id)
        {
            // 2. get All Categires
              $categories = DB::table('categories_type')
                ->join('categories', 'categories.category_type_id', '=', 'categories_type.id')
                ->select('categories.*')
                ->whereIn('categories_type.type', [5, 6])
                ->where([
                    ['categories.active', 1],
                    ['categories.org_id', Auth()->user()->org_id],
                    ['categories_type.org_id', Auth()->user()->org_id],
                    ['categories_type.active', 1]
                ])->get();

            //3. get Location

            $locations = Locations::where([
                ['org_id', Auth()->user()->org_id],
                ['active', 1],
            ])->get();


            // 4. get currencies

            $currencies = Currency::get();
            $policys=Policy_types::where('org_id',Auth()->user()->org_id)->get();

            $policy_types=property_policy::join('policy_type','policy_type_id','=','policy_type.id')
            ->where('property_policy.org_id',Auth()->user()->org_id)
            ->where('property_id',$id)
            ->select('property_policy.*', 'name','type')
            ->get();

            $amentitiesData=FacilityList::where('property_id',$id)->pluck('cat_id')->toArray();
            $myiamge = Photo::find($property->image);
            // 6. view :)
            foreach ($policy_types as  $value) {
           if($value->type==1){
                $mytab='2';
           }else{
              $mytab='3';
           }
            }
            return view('property.updated')
                ->with('property',$property)
                ->with('myiamge',$myiamge)
                ->with('amentitiesData',$amentitiesData)
                ->with('locations', $locations)
                ->with('currencies', $currencies)
                ->with('categories', $categories)
                ->with('policys', $policys)
                ->with('mytab', $mytab)
                ->with('policy_types',$policy_types);
        }


        Session::flash('danger', __('OoPs..! Not Found OR access denied'));

        return redirect('/admin/property');



    }
    
    public function PhotoDel($id = 0 )
    {
         //1. getProperty by ID
          $property = Property::find($id);
        // check if found and org_id
        if(!empty($property) && $property->org_id == Auth()->user()->org_id)
        {
             $property->image = null;
             
             if($property->save())
             {
                 Session::flash('deleted', __('strings.delete_message') );
                  return redirect()->back(); 
             }
             
              Session::flash('danger', __('OoPs..! we have Same ERRORS Please connected With Supper'));

           return redirect()->back();
          
        }
        
         // access dien or Not Found 
         Session::flash('danger', __('OoPs..! Not Found OR access deniedr'));

        return redirect()->back();
        
    }

    public function updatedProcess(Request $request)
    {


        $data = $request->all();
        $propert = Property::find($data['id']);
        // check if found and org_id
        if(!empty($propert) && $propert->org_id = Auth()->user()->org_id) {

            $data = $request->all();

            // 1. valid
            //- rule
            $rules = [
                'prop_type' => 'required|string',
                'name' => 'required|string|max:255',
                'name_en' => 'nullable|string|max:255',
                'alias' => 'nullable|string|max:255',
                'address' => 'nullable|string|max:25',
                'email' => 'nullable|email|max:255',
                'active' => 'required|integer',
                'stars' => 'required|integer',
                'infrontpage' => 'required|integer',
                'property_site' => 'nullable|active_url',
                'image' => 'nullable|image|mimes:jpeg,bmp,png,jpg',

            ];

            $valid = Validator::make($request->all(), $rules);
            // check valid
            // 2. return errors
            if ($valid->fails())
                return redirect()->back()->withErrors($valid->errors())->withInput($request->all());


            // iamge
            if ($image = $request->file('image')) {
                //give a name to image and move it to public directory
                $image_name = md5(time()) . $image->getClientOriginalExtension();
                $image->move('images', $image_name);

                //persist data into photos table
                $photo = Photo::create(['file' => $image_name]);
                //get image_id
                $image_id = $photo->id;

            }


            $propert->prop_type = $data['prop_type'];
            $propert->name = $data['name'];
            $propert->name_en = $data['name_en'];
            $propert->active = $data['active'];
            $propert->image = isset($image_id)?$image_id:$propert->image;
            $propert->alias = $data['alias'];
            $propert->description = $data['description'];
            $propert->description_en = $data['description_en'];
            $propert->slider_desc = $data['slider_desc'];
            $propert->slider_desc_en = $data['slider_desc_en'];
            $propert->location_id = $data['location_id'];
            $propert->latitude = $data['latitude'];
            $propert->longitude = $data['longitude'];
            $propert->currency = $data['currency_id'];
            $propert->address = $data['address'];
            $propert->telephone = $data['phone'];
            $propert->email = $data['email'];
            $propert->property_site = $data['property_site'];
            $propert->infrontpage = $data['infrontpage'];
            $propert->service_fees = $data['service_fees'];
            $propert->stars = $data['stars'];

            if ($propert->save()) {

                $oldAmeits = FacilityList::where('property_id',$data['id'])->pluck('id')->toArray();
                $del = FacilityList::whereIn('id', $oldAmeits)->delete();

                $ameti = [];
                foreach ($data['amentities'] as $amentity) {

                    $ameti[] = [
                        'cat_id' => $amentity,
                        'property_id' => $propert->id,
                        'active' => 1,
                        'org_id' => Auth()->user()->org_id,
                        'user_id' => Auth()->user()->id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now()
                    ];

                }


                FacilityList::insert($ameti);

                Session::flash('created', __('strings.create_message'));

                return redirect('/admin/property');
            }


            Session::flash('danger', __('OoPs..! we have Same ERRORS Please connected With Supper'));

            return redirect('/admin/property');


        }


        Session::flash('danger', __('OoPs..! Not Found OR access denied'));

        return redirect('/admin/property');



    }


    public function search(Request $request)
    {

        $org_id = Auth()->user()->org_id;
        $serach = $request->get('property_name');

        $serachpropertys= DB::table('property')
            ->join('photos','photos.id','=','property.image')
            ->join('locations','locations.id','=','property.location_id')
            ->join('destinations','destinations.id','=','locations.destination_id')
            ->select('property.*','photos.file','destinations.name as destination_name_ar','destinations.name_en as destination_name_en')
            ->where('property.org_id','=',$org_id)
            ->orderBy('property.updated_at','DESC')
            ->get();

            $propertys= DB::table('property')
                ->join('photos','photos.id','=','property.image')
                ->join('locations','locations.id','=','property.location_id')
                ->join('destinations','destinations.id','=','locations.destination_id')
                ->select('property.*','photos.file','destinations.name as destination_name_ar','destinations.name_en as destination_name_en')
                ->where([
                    ['property.org_id','=',$org_id],
                    ['property.name', 'LIKE', '%' . $serach . '%']])
                ->orderBy('property.updated_at','DESC')
                ->get();


            return view('property.index')->with('propertys', $propertys)->with('serachpropertys',$serachpropertys);


    }
function add_main_policy(Request $request){
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
       $property = Property::find($request->property_id);
       if($request->type==1) $mytab=2;
      elseif($request->type==2) $mytab=3;
        $v = \Validator::make($request->all(), [
            'details' => 'required|min:5',
            'policy_type_id' => 'required',

        ]);

        if ($v->fails()) {
            return redirect()->back()->withInput(['tab'=>$request->tab])->withErrors($v->errors());
        }
         $old_details=property_policy::where(['policy_type_id'=>$request->policy_type_id, 'org_id'=>Auth()->user()->org_id,'property_id'=>$request->property_id])->first();
         $values = array_except($request->all(), ['_token','type','tab']);

        if($old_details){
       property_policy::where('id',$old_details->id)->update($values);
     }else{
       $policy_details= new property_policy;
       $policy_details->details =$request->details;
       $policy_details->details_en =$request->details_en;
       $policy_details->policy_type_id=$request->policy_type_id;
       $policy_details->org_id=Auth()->user()->org_id;
       $policy_details->property_id=$request->property_id;
       $policy_details->save();
     }

          $policys=Policy_types::where('org_id',Auth()->user()->org_id)->get();
          $policy_types=property_policy::join('policy_type','policy_type_id','=','policy_type.id')
          ->where('property_policy.org_id',Auth()->user()->org_id)
          ->where('property_id',$request->property_id)
          ->select('property_policy.*', 'name','type')
          ->get();

           return redirect()->back()
            ->withInput(['tab'=>$request->tab])
            ->with(['mytab' =>$mytab])
           ->with('policys',$policys)
           ->with('property',$property)
           ->with('policy_types',$policy_types);





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

   function policy_type($id,$hotel_id){
  $policy_detail=property_policy::join('policy_type','policy_type_id','=','policy_type.id')
  ->where(['property_policy.org_id'=>Auth()->user()->org_id,'property_id'=>$hotel_id,'policy_type_id'=>$id])
  ->select('property_policy.*', 'name','type')
  ->first();
return $policy_detail;
}

}
