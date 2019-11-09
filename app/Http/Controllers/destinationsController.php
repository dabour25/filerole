<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Validation\Rule;
use App\Currency;
use App\Destinations;
use App\Photo;
use App\Video;
use App\Locations;


class destinationsController extends Controller
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
        // if(permissions('destinations_show') == false){

        //     //set session message
        //     Session::flash('message', __('strings.do_not_have_permission'));
        //     return view('permissions');
        // }
        $input['user_id'] = Auth::user()->id;
        $input['org_id'] = Auth::user()->org_id;
        $currencies=Currency::get();
        $destinations=Destinations::where('org_id',Auth::user()->org_id)->get();
        return view('destinations.index',compact('currencies','destinations'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $input['user_id'] = Auth::user()->id;
        $input['org_id'] = Auth::user()->org_id;

        if ($image = $request->file('image')) {
            //give a name to image and move it to public directory
            $image_name = time() . $image->getClientOriginalName();
            $image->move('images', $image_name);

            //persist data into photos table
            $photo = Photo::create(['file' => $image_name]);
            //save photo_id to user $input
            $input['image'] = $photo->id;
        }
        if ($video = $request->file('video_id')) {
            //give a name to image and move it to public directory
            $video_name = time() . $video->getClientOriginalName();
            $video->move('videos', $video_name);

            //persist data into photos table
            $video1 = Video::create(['file' => $video_name]);
            //save photo_id to user $input
            $input['video_id'] = $video1->id;
        }

        Destinations::create($input);
        //set session message
        Session::flash('created', __('strings.create_message'));
         $previous_url=str_replace(url('/'), '', url()->previous());
      if($previous_url=='/admin/destinations')
      return redirect('/admin/destinations');
      else
      return redirect('/admin/locations');

        //redirect back to functions.index


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(permissions('destinations_edit') == false){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }
        $currencies=Currency::get();
        $destination = Destinations::findOrFail($id);
        $test=  str_replace(url('/'), '', url()->previous());
        if($test=='/admin/destinations')
        $url=1;
        else
        $url=2;
        return view('destinations.edit', compact('destination','currencies','url'));
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
             'price_start' => 'required' , 'name' => 'required' , 'name_en' => 'required',

        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }
        if ($image = $request->file('image')) {
            //give a name to image and move it to public directory
            $image_name = time() . $image->getClientOriginalName();
            $image->move('images', $image_name);

            //persist data into photos table
            $photo = Photo::create(['file' => $image_name]);
            //save photo_id to user $input
            $input['image'] = $photo->id;

        }

        if ($video = $request->file('video_id')) {
            //give a name to image and move it to public directory
            $video_name = time() . $video->getClientOriginalName();
            $video->move('videos', $video_name);

            //persist data into photos table
            $video1 = Video::create(['file' => $video_name]);
            //save photo_id to user $input
            $input['video_id'] = $video1->id;
        }
        //update data into categories type table
        Destinations::findOrFail($id)->update($input);

        //set session message
        Session::flash('updated', __('strings.update_message'));

        //redirect back to functions.index
        if($request->url==1)
        return redirect('/admin/destinations');
        else {
          return redirect('/admin/locations');
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
      if(permissions('destinations_delete') == false){
          //set session message
          Session::flash('message', __('strings.do_not_have_permission'));
          return view('permissions');
      }

        $destination_locations=Locations::where('destination_id',$id)->get();
          $url=str_replace(url('/'), '', url()->previous());
        if(count($destination_locations)!=0){
          Session::flash('deleted', __('strings.message_delete'));

          if($url=='/admin/destinations'){
            return redirect('admin/destinations');
          }
          else{
            return redirect('admin/locations');
          }
        }else{
          Destinations::destroy($id);
          Session::flash('deleted', __('strings.sew_status_3'));
          if($url=='/admin/destinations'){
            return redirect('admin/destinations');
          }
          else{
            return redirect('admin/locations');
          }
          return redirect('admin/locations');
        }


    }



    public function search(Request $request) {
   $serach = $request->input('destination_name');
    if(app()->getLocale() =='ar'){
      $destinations = Destinations::where('name', 'LIKE', '%' . $serach .
'%')->where('org_id',Auth::user()->org_id)->get();

    }else {
      $destinations = Destinations::where('name_en', 'LIKE', '%' . $serach .
'%')->where('org_id',Auth::user()->org_id)->get();

    }
      $currencies=Currency::get();
      $previous_url=str_replace(url('/'), '', url()->previous());
      if($previous_url=='/admin/destinations')
      return view('destinations.index',compact('destinations','currencies'));
      else
     return view('locations.index',compact('destinations','currencies'));

  }

}
