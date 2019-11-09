<?php


namespace App\Http\Controllers;


use App\Category;
use App\Photo;
use App\PropertySilder;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;


class HotelRoomsSilderControler extends Controller
{

    public function index($id =0)
    {
      $room = Category::with('photo')->find($id);

      if(!empty($room) && $room->org_id == Auth()->user()->org_id)
      {
         $sliders = PropertySilder::with('photo')->where([['cat_id',$id],['org_id',Auth()->user()->org_id]])->get();

          return view('rooms.slider.index')
              ->with('room',$room)
              ->with('sliders',$sliders);
      }

        Session::flash('danger', __('OoPs..! Not Found Or access denied'));

        return  redirect()->back();
    }

    public function add(Request $request)
    {
        $data = $request->all();

        $room = Category::find($data['id']);

        if(!empty($room) && $room->org_id == Auth()->user()->org_id)
        {
            // valid
            $rules = [
                'id'        => 'required',
                'rank'      => 'nullable|numeric',
                'photo'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            ];

            $valid = Validator::make($request->all(), $rules);
            // check valid
            // 2. return errors
            if ($valid->fails())
                return redirect()->back()->withErrors($valid->errors())->withInput($request->all());


            // slider

            if ($image = $request->file('photo')) {
                //give a name to image and move it to public directory
                $image_name = md5(time()) .'.'. $image->getClientOriginalExtension();
                $image->move('images', $image_name);

                //persist data into photos table
                $photo = Photo::create(['file' => $image_name]);
                //get image_id
                $image_id = $photo->id;

            }

            $slider = new PropertySilder();

            $slider->cat_id  = $data['id'];
            $slider->type  = 'unit';
            $slider->image  = isset($image_id)?$image_id:null;
            $slider->rank  = $data['rank'];
            $slider->org_id  = Auth()->user()->org_id;
            $slider->user_id  = Auth()->user()->id;

            if($slider->save())
            {
                Session::flash('created', __('strings.create_message'));
                return redirect()->back();
            }

            Session::flash('danger', __('OoPs..! we have Same ERRORS Please connected With Supper'));

            return redirect()->back();

        }


        Session::flash('danger', __('OoPs..! we have Same ERRORS Please connected With Supper'));

        return redirect()->back();
    }

    public function delSlider($id =0)
    {
        $slid = PropertySilder::find($id);

        if(!empty($slid) && $slid->org_id == Auth()->user()->org_id)
        {
            if(PropertySilder::where('id',$id)->delete())
            {
                Session::flash('created', __('strings.slider_deleted'));

                return redirect()->back();
            }
            Session::flash('danger', __('OoPs..! Not Found OR access denied'));

            return redirect()->back();
        }

        Session::flash('danger', __('OoPs..! Not Found OR access denied'));

        return redirect()->back();
    }

    public function updated(Request $request)
    {
        $data = $request->all();

        $slid = PropertySilder::find($data['slider_id']);

        if(!empty($slid) && $slid->org_id == Auth()->user()->org_id)
        {
            // valid
            $rules = [
                'slider_id'        => 'required',
                'rank_2'      => 'nullable|numeric',
                'photo'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg',
            ];

            $valid = Validator::make($request->all(), $rules);
            // check valid
            // 2. return errors
            if ($valid->fails())
                return redirect()->back()->withErrors($valid->errors())->withInput($request->all());


            // slider

            if ($image = $request->file('photo')) {
                //give a name to image and move it to public directory
                $image_name = md5(time()) .'.'. $image->getClientOriginalExtension();
                $image->move('images', $image_name);

                //persist data into photos table
                $photo = Photo::create(['file' => $image_name]);
                //get image_id
                $image_id = $photo->id;

            }

            $slid->image  = isset($image_id)?$image_id:$slid->image;
            $slid->rank   = $data['rank_2'];

            if($slid->save())
            {
                Session::flash('created', __('strings.message_success_updated'));
                return redirect()->back();
            }

            Session::flash('danger', __('OoPs..! we have Same ERRORS Please connected With Supper'));

            return redirect()->back();

        }
        Session::flash('danger', __('OoPs..! access denied '));

        return redirect()->back();

    }

}