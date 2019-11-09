<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Photo;
use App\org_news;
use Auth;
use Illuminate\Support\Facades\Session;


class newController extends Controller
{
    public function shownews()
    {
      if (permissions('show_news') == 0 ) {

            //set session message

            Session::flash('message', __('strings.do_not_have_permission'));

            return view('permissions');

        }
        $news = org_news::where('org_id', Auth::user()->org_id)->orderBy('news_date', 'desc')->get();

        return view('news.new', compact('news'));

    }

    public function edit(org_news $new)
    {
      if (permissions('edit_news') == 0 ) {

            //set session message

            Session::flash('message', __('strings.do_not_have_permission'));

            return view('permissions');

        }
        return view('news.edit', compact('new'));

    }

    public function update(Request $request, $news)
    {

        $v = \Validator::make($request->all(), [
            'news_title' => 'required|min:5',
            'news_title_en' => 'required|min:5',
            'news_desc' => 'required|min:5',
            'news_date' => 'required|date'

        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        }


        $iii = $request->all();

        if ($image = $request->file('image_id')) {
            //give a name to image and move it to public directory
            $image_name = time() . $image->getClientOriginalName();
            $image->move('images', $image_name);

            //persist data into photos table
            $photo = Photo::create(['file' => $image_name]);
            //save photo_id to user $input
            $iii['image_id'] = $photo->id;

        }
		$org_news = org_news::findOrFail($news);


		if( app()->getLocale() == 'ar'){
		$iii['news_desc'] = $request->news_desc;
		}else{

		$iii['news_desc_en'] = $request->news_desc;
		$iii['news_desc'] = $org_news->news_desc;


		}
		org_news::findOrFail($news)->update($iii);

        return redirect('admin/news');


    }

    public function delete(org_news $new)
    {
        $new->delete();
        return back();


    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'news_title' => 'required|min:5',
            'news_title_en' => 'required|min:5',
            'news_desc' => 'required|min:5',
            'news_date' => 'required|date',
            'image_id' => 'required|mimes:jpeg,png'
        ]);

        $iii = $request->all();
        $new = new org_news;

        if ($image = $request->file('image_id')) {
            //give a name to image and move it to public directory
            $image_name = time() . $image->getClientOriginalName();
            $image->move('images', $image_name);

            //persist data into photos table
            $photo = Photo::create(['file' => $image_name]);
            //save photo_id to user $input
            $iii['image_id'] = $photo->id;
            $new->image_id = $photo->id;
        }
        $new->news_title = $request->news_title;
        $new->news_title_en = $request->news_title_en;
		app()->getLocale() == 'ar' ?  $new->news_desc = $request->news_desc :  $new->news_desc_en = $request->news_desc;

        $new->news_date = $request->news_date;
        $new->active = $request->active;
        $new->org_id = Auth::user()->org_id;
        $new->save();
        return redirect('admin/news');

    }

    public function openstore()
    {
      if (permissions('add_news') == 0 ) {

            //set session message

            Session::flash('message', __('strings.do_not_have_permission'));

            return view('permissions');

        }
        return view('news.add');

    }


}
