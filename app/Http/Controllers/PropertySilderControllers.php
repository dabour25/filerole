<?php


namespace App\Http\Controllers;


use App\Photo;
use App\Property;
use App\PropertySilder;
use Illuminate\Http\Request;
use Session;
use Validator;

class PropertySilderControllers extends Controller
{
    // index

    public function index($id = 0)
    {
        // get Property By ID
       $property = Property::with('myphoto')->find($id);

        if(!empty($property) && $property->org_id == Auth()->user()->org_id)
        {
            // get Slider
            $mysliders = PropertySilder::with('photo')->where([ ['property_id',$property->id ] ,['org_id',Auth()->user()->org_id] ])->get();
            // view

            return view('property.slider.index')
                ->with('property',$property)
                ->with('mysliders',$mysliders);
        }

        Session::flash('danger', __('OoPs..! Not Found OR access denied'));

        return redirect('/admin/property');

    }

     // add
    /***
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function addView($id = 0)
    {
        $property = Property::find($id);

        if(!empty($property) && $property->org_id == Auth()->user()->org_id)
        {
            return view('property.slider.add')->with('property',$property);
        }

        Session::flash('danger', __('OoPs..! Not Found OR access denied'));

        return redirect('/admin/property');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function addProcess(Request $request)
    {

        $property = Property::find($request->get('property'));

        if(!empty($property) && $property->org_id == Auth()->user()->org_id)
        {
            // vlid
            $rules = [
                'rank' => 'nullable|integer',
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

            // insert

            $slider = new PropertySilder();

            $slider->property_id = $property->id;
            $slider->type = 'property';
            $slider->rank = $request->get('rank');
            $slider->image = $image_id;
            $slider->org_id = Auth()->user()->org_id;
            $slider->user_id = Auth()->user()->id;

            if($slider->save())
            {
                Session::flash('created', __('strings.create_message'));

                return redirect('admin/property/slider/'.$property->id);
            }

            Session::flash('danger', __('OoPs..! We Have Same Errors Please Try Later'));

            return redirect('admin/property/slider/'.$property->id);

        }

        Session::flash('danger', __('OoPs..! Not Found OR access denied'));

        return redirect('/admin/property');
    }


    // updated

    public function updatedView($id = 0)
    {
        // get slider check access
        $slider = PropertySilder::with('photo')->find($id);

        if(!empty($slider) && $slider->org_id == Auth()->user()->org_id )
        {
            $property = Property::find($slider->property_id);

            return view('property.slider.updated')
                ->with('property',$property)
                ->with('slider',$slider);
        }

        Session::flash('danger', __('OoPs..! Not Found OR access denied'));

        return redirect()->back();
    }

    public function updatedProcess(Request $request)
    {
        //check if found and access
        $slider = PropertySilder::find($request->get('id'));

        if(!empty($slider) && $slider->org_id == Auth()->user()->org_id )
        {
            $rules = [
                'rank' => 'nullable|integer',
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

            // updated

            $slider->type = 'property';
            $slider->rank = $request->get('rank');
            $slider->image = isset($image_id)?$image_id:$slider->image;

            if($slider->save())
            {
                Session::flash('created', __('strings.create_message'));

                return redirect('admin/property/slider/'.$slider->property_id);
            }

            Session::flash('danger', __('OoPs..! We Have Same Errors Please Try Later'));

            return redirect('admin/property/slider/'.$slider->property_id);


        }

        Session::flash('danger', __('OoPs..! Not Found OR access denied'));

        return redirect()->back();

    }

    public function del($id = 0)
    {
        $slider = PropertySilder::find($id);
        if(!empty($slider) && $slider->org_id == Auth()->user()->org_id)
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


}