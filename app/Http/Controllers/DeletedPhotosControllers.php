<?php


namespace App\Http\Controllers;


use App\Customers;
use App\Destinations;
use App\org;
use App\User;
use Session;

class DeletedPhotosControllers extends Controller
{
    // del photos -> destinations
    public function delDestPhoto($id =0)
    {
        // check->destinations && access

        $des = Destinations::find($id);

        if(!empty($des) && $des->org_id == Auth()->user()->org_id)
        {
            $des->image =null;
            if($des->save())
            {

                Session::flash('deleted', __('strings.delete_message') );
                return redirect()->back();
            }

            Session::flash('danger', __('OoPs..! we have Same ERRORS Please connected With Supper'));

            return redirect()->back();

        }


        Session::flash('danger', __('OoPs..! Not Found Or access denied'));

        return redirect()->back();
    }

    // del photos -> users

    public function delUserPhoto($id =0)
    {
        $user = User::find($id);
        if (!empty($user) && $user->org_id == Auth()->user()->org_id) {
            $user->photo_id = null;
            if ($user->save()) {

                Session::flash('deleted', __('strings.delete_message'));
                return redirect()->back();
            }

            Session::flash('danger', __('OoPs..! we have Same ERRORS Please connected With Supper'));

            return redirect()->back();
        }
    }

    // del Photos -> Customer

    public function delCustomerPhoto($id =0)
    {
        $customer = Customers::find($id);
        if (!empty($customer) && $customer->org_id == Auth()->user()->org_id) {
            $customer->photo_id = null;
            if ($customer->save()) {

                Session::flash('deleted', __('strings.delete_message'));
                return redirect()->back();
            }

            Session::flash('danger', __('OoPs..! we have Same ERRORS Please connected With Supper'));

            return redirect()->back();
        }

        Session::flash('danger', __('OoPs..! we have Same ERRORS Please connected With Supper'));

        return redirect()->back();

    }


    // del Photos -> Org -> image_id

    public function delOrgImageID($id = 0)
    {

         $org = org::find($id);

        if(!empty($org) && $org->id == Auth()->user()->org_id)
        {
            $org->image_id  = null;

            if($org->save())
            {
                Session::flash('deleted', __('strings.delete_message'));
                return redirect()->back();
            }

            Session::flash('danger', __('OoPs..! we have Same ERRORS Please connected With Supper'));

            return redirect()->back();
        }

        Session::flash('danger', __('OoPs..! we have Same ERRORS Please connected With Supper'));

        return redirect()->back();
    }

    // del Photos -> Org -> front_image

    public function delOrgFrontImage($id = 0)
    {
        $org = org::find($id);

        if(!empty($org) && $org->id == Auth()->user()->org_id)
        {
            $org->front_image  = null;

            if($org->save())
            {
                Session::flash('deleted', __('strings.delete_message'));
                return redirect()->back();
            }

            Session::flash('danger', __('OoPs..! we have Same ERRORS Please connected With Supper'));

            return redirect()->back();
        }

        Session::flash('danger', __('OoPs..! we have Same ERRORS Please connected With Supper'));

        return redirect()->back();
    }

    // del Photos -> org -> location_map

    public function delOrgMap($id = 0)
    {
        $org = org::find($id);

        if(!empty($org) && $org->id == Auth()->user()->org_id)
        {
            $org->location_map  = null;

            if($org->save())
            {
                Session::flash('deleted', __('strings.delete_message'));
                return redirect()->back();
            }

            Session::flash('danger', __('OoPs..! we have Same ERRORS Please connected With Supper'));

            return redirect()->back();
        }

        Session::flash('danger', __('OoPs..! we have Same ERRORS Please connected With Supper'));

        return redirect()->back();
    }



}