<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserPasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\org;
use DB;
use App\Photo;

class orgController extends Controller
{

    public function updata(Request $request, $id)
    {

        $iii = request()->except(['_token']);

        if ($image = $request->file('image_id')) {
            //give a name to image and move it to public directory
            $image_name = time() . $image->getClientOriginalName();
            $image->move('images', $image_name);

            //persist data into photos table
            $photo = Photo::create(['file' => $image_name]);
            //save photo_id to user $input
            $iii['image_id'] = $photo->id;
        }
        if ($image1 = $request->file('front_image')) {
            //give a name to image and move it to public directory
            $image_name1 = time() . $image1->getClientOriginalName();
            $image1->move('images', $image_name1);

            //persist data into photos table
            $photo = Photo::create(['file' => $image_name1]);
            //save photo_id to user $input
            $iii['front_image'] = $photo->id;
        }
        if ($image2 = $request->file('location_map')) {
            //give a name to image and move it to public directory
            $image_map = time() . $image2->getClientOriginalName();
            $image2->move('images', $image_map);

            //persist data into photos table
            $photo = Photo::create(['file' => $image_map]);
            //save photo_id to user $input
            $iii['location_map'] = $photo->id;
        }
        $iii['user_id'] = Auth::user()->id;
		$iii['currency']= $request->currency;

		$org = org::findOrFail($id);
		if(app()->getLocale() == 'ar'){
		$iii['description'] = $request->description;
		 $iii['about_us'] = $request->about_us;
		}else{
		$iii['aboutus_en'] = $request->about_us;
		$iii['description_en'] = $request->description;
		$iii['description'] = $org->description;
		$iii['about_us'] = $org->about_us;
		}

		$v = \Validator::make($request->all(),[
            'attendance_start_day' => 'required|numeric|between:1,30'

        ]);

		 if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }

        org::where('id', $id)->update($iii);

        return redirect('admin/settings/setcomp');

    }

    public function GetOrgs()
    {
        $orgs = DB::table('organizations')->where('id', Auth::user()->org_id)->paginate(20);
        return view('orgs.orgview', compact('orgs'));
    }


    public function edit($id)
    {
     
        $org = org::findOrFail($id);

        return view('orgs.org', compact('org'));
    }


}
