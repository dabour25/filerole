<?php

namespace App\Http\Controllers;

use App\BookingTime;
use App\Http\Requests\SettingsRequest;
use App\Http\Requests\TaxSettingsRequest;
use App\Http\Requests\BankingSettingsRequest;
use App\InvoiceTemplate;
use App\Photo;
use App\Role;
use App\Tax;
use App\Banking;
use App\Settings;
use App\InternalItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Auth;
use App\org;
use App\InvoiceSetup;
use App\PaymentSetup;
use App\ActivityLabelSetup;

class AdminSettingsController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Admin Settings Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing settings view to
    | admin, to show all settings, provide ability to change
    | specific settings.
    |
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*if(permissions('settings') == false){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }*/

        $taxs = Tax::where('org_id', Auth::user()->org_id)->paginate(20);
        $banks = Banking::where('org_id', Auth::user()->org_id)->paginate(20);
        $org = org::where('id', Auth::user()->org_id)->first();
        $activity_labels=ActivityLabelSetup::where('activity_id',$org->activity_id)->whereIn('type',['item_service','services','items'])->orderBy('id','desc')->get();
    
        $basket_available=ActivityLabelSetup::where('activity_id',$org->activity_id)->where('type','basket')->get();
        
        if(count($basket_available)==0){
            
            $basket=0;
        }
        else{
            $basket=1;
        }
        return view('settings.index', compact( 'taxs', 'banks', 'org','activity_labels','basket'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SettingsRequest $request, $id)
    {
        $input = $request->all();
        if(isset($request->internal_item)){

                if(InternalItem::where('org_id', Auth::user()->org_id)->exists()){
                    InternalItem::where('org_id', Auth::user()->org_id)->update(['appear' => $request->internal_item]);
                }else{
                    InternalItem::insert(['appear' => $request->internal_item, 'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->id]);
                }
        }else {


            //update data into settings table
            Settings::findOrFail($id)->update($input);



            //check if cover image is selected
            if ($cover = $request->file('cover')) {
                //remove previous promo image
                unlink(public_path() . '/images/promo.jpg');

                //upload new promo image
                $cover->move('images', 'promo.jpg');
            }

            //check if logo-light is selected
            if ($logo_light = $request->file('business_logo_light')) {
                //remove previous promo image
                unlink(public_path() . '/images/logo-light.png');

                //upload new promo image
                $logo_light->move('images', 'logo-light.png');
            }

            //check if logo-light is selected
            if ($logo_dark = $request->file('business_logo_dark')) {
                //remove previous promo image
                unlink(public_path() . '/images/logo-dark.png');

                //upload new promo image
                $logo_dark->move('images', 'logo-dark.png');
            }
        }

        //set session message and redirect back admin.settings
        Session::flash('settings_saved', __('strings.message_success'));
        return redirect('/admin/settings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function settings_view()
    {
        /*if(permissions('settings') == false){
            //set session message
            Session::flash('message', __('strings.do_not_have_permission'));
            return view('permissions');
        }*/

        $settings = Settings::find(1);
        $taxs = Tax::where('org_id', Auth::user()->org_id)->paginate(20);
        $banks = Banking::where('org_id', Auth::user()->org_id)->paginate(20);
        $org = org::where('id', Auth::user()->org_id)->first();
        return view('settings.index', compact('settings', 'taxs', 'banks', 'org'));
    }

    public function GetTax($id)
    {
        return Tax::findOrFail($id);
    }

    public function Tax(Request $request){

        $input = $request->all();

        $v = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'tax_type' => 'required|not_in:0',
            'active' => 'required',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors())->withInput();
        }
        if(isset($request->id) && $request->id !== ""){

            if(isset($request->tax_type) && $request->tax_type == 1){
                $input['percent'] = null;

            }elseif (isset($request->tax_type) && $request->tax_type == 2){
                $input['value'] = null;

            }

            //update data into tax table
             Tax::findOrFail($request->id)->update($input);

            //set session message
            Session::flash('created', __('strings.settings_msg_2'));
        }else{
            $input['org_id'] = Auth::user()->org_id;
            $input['user_id'] = Auth::user()->id;
            Tax::create($input);

            //set session message
            Session::flash('created', __('strings.settings_msg_3'));

        }
        //redirect back to settings.index
        return redirect('admin/settings/tax');

    }


    public function Banking(BankingSettingsRequest $request){

        $input = $request->all();

        if(isset($request->id) && $request->id !== ""){

            if(isset($request->bank_type) && $request->bank_type == 1){
                $input['account'] = null;
            }
            $input['name'] = $request->b_name;
            $input['name_en'] = $request->b_name_en;
            $input['description'] = $request->b_description;

            $input['type'] = $request->bank_type;

            //update data into banking table
            Banking::findOrFail($request->id)->update($input);

            //set session message
            Session::flash('created', __('strings.settings_msg_4'));
        }else{

            if(isset($request->bank_type) && $request->bank_type == 1){
                $input['account'] = null;
            }
            $input['name'] = $request->b_name;
            $input['name_en'] = $request->b_name_en;
            $input['description'] = $request->b_description;
            $input['type'] = $request->bank_type;
            $input['org_id'] = Auth::user()->org_id;
            $input['user_id'] = Auth::user()->id;
            Banking::create($input);

            //set session message
            Session::flash('created', __('strings.settings_msg_5') );

        }
        //redirect back to settings.index
        return redirect('admin/settings/banking');

    }

    public function GetBanking($id)
    {
        return Banking::findOrFail($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function Bankdestroy($id)
    {
        //delete role
        Banking::destroy($id);

        //set session message and redirect back to settings.index
        Session::flash('deleted', __('strings.settings_msg_6') );
        return redirect('admin/settings/banking');
    }

    public function DefaultBanking($id, $value)
    {

        if(Banking::where(['id' => $id, 'active' => 0])->exists()){

        }else{
            $value = $value == 'true' ? 1 : 0;
            foreach (Banking::where(['active' => 1,'org_id' => Auth::user()->org_id])->get() as $v){
                Banking::where(['id' => $v->id, 'active' => 1])->update(['default' => 0]);
            }
            Banking::where(['id' => $id, 'active' => 1])->update(['default' => $value]);

            //set session message and redirect back to settings.index
            Session::flash('created', __('strings.settings_msg_7') );
        }
        return redirect('admin/settings/banking');
    }



    public function Display(Request $request)
    {
        //return $request->all();

        //Settings::where('key', 'country')->update(['value' => $request->country, 'user_id' => Auth::user()->id]);
        //Settings::where('key', 'current')->update(['value' => $request->country, 'user_id' => Auth::user()->id]);

        Settings::where(['key' => 'current_symbol', 'org_id' => Auth::user()->org_id])->update(['value' => $request->current_symbol, 'user_id' => Auth::user()->id]);
        Settings::where(['key' => 'date' , 'org_id' => Auth::user()->org_id])->update(['value' => $request->date, 'user_id' => Auth::user()->id]);
        Settings::where(['key' => 'decimal_place' , 'org_id' => Auth::user()->org_id])->update(['value' => $request->decimal_place, 'user_id' => Auth::user()->id]);
        Settings::where(['key' => 'language' , 'org_id' => Auth::user()->org_id])->update(['value' => $request->language, 'user_id' => Auth::user()->id]);
        Settings::where(['key' => 'fonts' , 'org_id' => Auth::user()->org_id])->update(['value' => $request->fonts, 'user_id' => Auth::user()->id]);
        Settings::where(['key' => 'navbar' , 'org_id' => Auth::user()->org_id])->update(['value' => $request->navbar, 'user_id' => Auth::user()->id]);

        $helplinks = $request->helplinks == 'on' ? 'on' : null;
        if(Settings::where(['key' => 'helplinks' , 'org_id' => Auth::user()->org_id])->doesntExist()){
          Settings::create(['key' => 'helplinks', 'value' => $helplinks, 'user_id' => Auth::user()->id, 'org_id' => Auth::user()->org_id]);
        }else{
          Settings::where(['key' => 'helplinks', 'org_id' => Auth::user()->org_id])->update(['value' => $helplinks, 'user_id' => Auth::user()->id]);
        }
        
        if(Settings::where(['key' => 'sold_item_type' , 'org_id' => Auth::user()->org_id])->doesntExist()) {
            Settings::create(['key' => 'sold_item_type', 'value' => $request->sold_item_type, 'user_id' => Auth::user()->id, 'org_id' => Auth::user()->org_id]);
        }else{
            Settings::where(['key' => 'sold_item_type', 'org_id' => Auth::user()->org_id])->update(['value' => $request->sold_item_type, 'user_id' => Auth::user()->id]);
        }
        if(Settings::where(['key' => 'basket' , 'org_id' => Auth::user()->org_id])->doesntExist()) {
            Settings::create(['key' => 'basket', 'value' => $request->basket, 'user_id' => Auth::user()->id, 'org_id' => Auth::user()->org_id]);
        }else{
            Settings::where(['key' => 'basket', 'org_id' => Auth::user()->org_id])->update(['value' => $request->basket, 'user_id' => Auth::user()->id]);
        }
        
        if(Settings::where(['key' => 'menu' , 'org_id' => Auth::user()->org_id])->doesntExist()) {
            Settings::create(['key' => 'menu', 'value' => $request->menu, 'user_id' => Auth::user()->id, 'org_id' => Auth::user()->org_id]);
        }else{
            Settings::where(['key' => 'menu', 'org_id' => Auth::user()->org_id])->update(['value' => $request->menu, 'user_id' => Auth::user()->id]);
        }
        
        
        if(Settings::where(['key' => 'loading' , 'org_id' => Auth::user()->org_id])->doesntExist()) {
            Settings::create(['key' => 'loading', 'value' => $request->loading, 'user_id' => Auth::user()->id, 'org_id' => Auth::user()->org_id]);
        }else{
            Settings::where(['key' => 'loading', 'org_id' => Auth::user()->org_id])->update(['value' => $request->loading, 'user_id' => Auth::user()->id]);
        }
        

        if(Settings::where(['key' => 'session' , 'org_id' => Auth::user()->org_id])->doesntExist()) {
            Settings::create(['key' => 'session', 'value' => $request->session, 'user_id' => Auth::user()->id, 'org_id' => Auth::user()->org_id]);
            Settings::create(['key' => 'session_time', 'value' => $request->session_time, 'user_id' => Auth::user()->id, 'org_id' => Auth::user()->org_id]);
        }else{
            Settings::where(['key' => 'session', 'org_id' => Auth::user()->org_id])->update(['value' => $request->session, 'user_id' => Auth::user()->id]);
            Settings::where(['key' => 'session_time', 'org_id' => Auth::user()->org_id])->update(['value' => $request->session_time, 'user_id' => Auth::user()->id]);

        }

        //set session message and redirect back to settings.index
        Session::flash('created', __('strings.settings_msg_8'));
        return redirect('admin/settings');
    }

    public function create_template(Request $request){

        return view('settings.invoice_template');

    }

    public function customize_template(Request $request){
        $data = \Validator::make($request->all(), [
           'name'=>'required',

       ]);
       if ($data->fails()) {

           return redirect()->back()->withErrors($data->errors())->withInput();
       }
       
        //check if an image is selected
        if($image = $request->image_blob)
        {
            $blob = $request->image_blob;
            $blob = substr($blob, strlen("data:image/jpeg;base64,"));
            $blob = base64_decode($blob);
            $imageName = Auth::user()->org_id.'-'.$request->name.'-preview.jpg';
            file_put_contents(realpath('invoice_template')."/". $imageName, $blob);
        }else{
            $imageName = null;
        }
        if(InvoiceTemplate::where(['name' => $request->name, 'org_id' => Auth::user()->org_id])->doesntExist()){
            $data = InvoiceTemplate::create([ 'name' => $request->name, 'value' => json_encode($request->template),  'preview' => $imageName,'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->user_id]);
            return redirect('admin/settings/customize_template/'. $data->id);
        }else{
            return back();
        }
    }


    public function customize_update(Request $request){
        $data = \Validator::make($request->all(), [
           'name'=>'required',

       ]);
       if ($data->fails()) {

           return redirect()->back()->withErrors($data->errors())->withInput();
       }
       
        //check if an image is selected
        if($image = $request->image_blob)
        {
            $blob = $request->image_blob;
            $blob = substr($blob, strlen("data:image/jpeg;base64,"));
            $blob = base64_decode($blob);
            $imageName = Auth::user()->org_id.'-'.$request->name.'-preview.jpg';
            file_put_contents(realpath('invoice_template')."/". $imageName, $blob);
        }else{
            $imageName = null;
        }
        InvoiceTemplate::where('id', $request->template_id)->update([ 'name' => $request->name, 'value' => json_encode($request->template), 'preview' => $imageName, 'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->user_id]);
        return redirect('admin/settings/invoiceset');
        //return redirect('admin/settings/customize_template/'. $request->name);

    }
    public function customize(Request $request, $template_id){
        foreach ($data = InvoiceTemplate::where('id', $template_id)->get() as $value){
            $value->value = json_decode($value->value, true);
        }
        $data =  $data[0];
        return view('settings.invoice_template', compact('name', 'data'));

    }

    public function select_template($name){
        Settings::where('key', 'invoice_template')->update(['value' => $name, 'user_id' => Auth::user()->id, 'org_id' => Auth::user()->org_id]);
        return redirect('admin/settings/customize_template/'. $name);
    }


    public function invoice_template(Request $request){

        $content = $request->template;
        $name = $request->name;
        $background_color = $content['background_color'];
        $footer_txt_color = $content['footer_txt_color'];
        $footer_bg_color = $content['footer_bg_color'];
        $primary_color = $content['primary_color'];
        $margin = $content['margin'];
        $logo_size = $content['logo_size'];
        $invoice_font = $content['invoice_font'];
        $invoice_default_size = $content['invoice_default_size'];
        $invoice_default_layout = $content['invoice_default_layout'];
        //$header_model = $content['header_model'];
        $footer_text = $content['footer_text'];
        $header_bg_color = $content['header_bg_color'];
        $table_line_th_height = $content['table_line_th_height'].'px';
        $table_line_td_height = $content['table_line_td_height'].'px';
        $signature_txt = $content['signature_txt'];
        $font_size = $content['font_size'];
        $header_txt_color = $content['header_txt_color'];
        $table_line_th_color = $content['table_line_th_color'];
        $table_line_th_bg = $content['table_line_th_bg'];


        $logo_monocolor = $content['logo_monocolor'] == 1 ? 'checked="checked"' : '';
        $logo_greyscale = $content['logo_greyscale'] == 1 ? 'checked="checked"' : '';
        $show_footer = $content['show_footer'] == 1 ? 'checked="checked"' : '';
        $show_header = $content['show_header'] == 1 ? 'checked="checked"' : '';
        $show_signature = $content['show_signature'] == 1 ? 'checked="checked"' : '';

        $organization = org::where('id', Auth::user()->org_id)->first();
        $organization_logo = !empty($organization->image_id) ? asset(Photo::where('id', $organization->image_id)->value('file')) : asset('trust.png');
        $organization_name = $organization->name;
        $organization_email = $organization->email;
        $organization_phone = $organization->phone;
        $organization_address = $organization->address;


        if($content['show_header'] == 1){
            $header = "<div class=\"invoice_header etat_header\">
                        <div class=\"row\">
                            <div class=\"col-xs-4 invoice-logo\">
                                <img src=\"$organization_logo\" alt=\"$organization_name\" height=\"120\" width=\"150\" style =\"vertical-align:middle;max-width: 50%;\" >
                            </div >
                            <div class=\"col-xs-8 invoice-header-info\">
                                <h4> $organization_name</h4>
                                <p> $organization_address 
                                    <br>
                                    <strong> Phone: </strong> $organization_phone 
                                    </br>
                                    <strong> Email: </strong> $organization_email
                                </p>
                            </div>
                        </div>
                        <hr>
                        <div class=\"clearfix\" ></div>
                    </div>";
        }else{
            $header = "";
        }

        if($content['show_footer'] == 1){
            $footer = "<footer class=\"invoice_footer\">
                            <hr>
                            <p>$footer_text</p>
                        </footer>";
        }else{
            $footer = "<footer class=\"invoice_footer\">
                            <hr>
                            <p>$footer_text</p>
                        </footer>";
        }

        if($content['show_signature']    == 1){
            $signature = "<div class=\"etat_footer\">
                            <div class=\"row\">
                                <div class=\"col-xs-4 col-xs-offset-8\"><p>&nbsp;</p>
                                    <p style=\"border-bottom: 1px solid #666;\">&nbsp;</p>
                                    <p class=\"text-md-center\">$signature_txt</p>
                                </div>
                            </div>
                            <p>&nbsp;</p>
                            <div style=\"clear: both;\"></div>
                        </div>";
        }else{
            $signature = "";
        }
        $url = url('/');

        $data = "<div class=\"invoice_preview\">
                        <div id=\"css_script\">
                            <style type=\"text/css\" id=\"pageInit\">
                                @page {
                                    size: 21cm 29.7cm
                                }
                            </style>
                            
                            <link href=\"$url/assets_invoice/css/print.css\" rel=\"stylesheet\">
                            
                            <style type=\"text/css\">
                                #wrap_invoice.page {
                                    font-family: $invoice_font;
                                    background-color: $background_color;
                                    padding: $margin;
                                    z-index: 1;
                                }

                                #wrap_invoice h3 {
                                    color: $primary_color;
                                }

                                #wrap_invoice h4 {
                                    color: $primary_color;
                                }

                                .invoice_header .invoice-logo img {
                                    height: $logo_size !important;
                                    width: auto !important;
                                    max-width: $logo_size;
                                }

                                #wrap_invoice,
                                #wrap_invoice p,
                                #wrap_invoice .text-color,
                                #wrap_invoice .inv.col b,
                                #wrap_invoice .table_invoice {
                                    font-size: $font_size;
                                    color: $footer_txt_color;
                                }

                                #wrap_invoice .table_invoice thead th {
                                    background: $table_line_th_bg;
                                    color: $table_line_th_color;
                                    line-height: $table_line_th_height;
                                    height: $table_line_th_height;
                                }

                                #wrap_invoice .table_invoice td {
                                    line-height: $table_line_td_height;
                                    height: $table_line_td_height;
                                }

                                #wrap_invoice .page-title {
                                    color: $primary_color;
                                    text-align: center;
                                }

                                #wrap_invoice .invoice_header {
                                    background: $header_bg_color;
                                    color: #000000 !important;
                                    margin: -0.5cm -0.5cm 0 -0.5cm;
                                    padding: 0.5cm 0.5cm 0 0.5cm;
                                }

                                #wrap_invoice .invoice_header * {
                                    color: $header_txt_color !important;
                                    margin: 0;
                                }

                                #wrap_invoice .invoice_footer,
                                #wrap_invoice .invoice_footer p,
                                #wrap_invoice .invoice_footer .pagging {
                                    background: $footer_bg_color;
                                    color: $footer_txt_color;
                                }
                            </style>
                        </div>
                        <div class=\"wrapper\" style=\"width: 1101px; height: 851px; overflow: hidden;\">
                            <div id=\"wrap_invoice\" class=\"page $invoice_default_size $invoice_default_layout\"
                                 style=\"transform: scale(1); transform-origin: 0px 0px 0px;\">
                                
                                $header
                                
                                <center><h3 class=\"page-title\">Invoice</h3></center>
                                <div class=\"etat_content\">
                                    <div class=\"row text-md-center\">
                                        <div class=\"col-sm-3\">
                                            <h3 class=\"inv col\"><b>Invoice N°</b><br>0010</h3>
                                        </div>
                                        <div class=\"col-sm-3\">
                                            <h3 class=\"inv col\"><b>Reference</b><br>INV-170010</h3>
                                        </div>
                                        <div class=\"col-sm-3\">
                                            <h3 class=\"inv col\"><b>Date</b><br>09/07/2017</h3>
                                        </div>
                                        <div class=\"col-sm-3\">
                                            <h3 class=\"inv col\"><b>Due Date</b><br>31/07/2017</h3>
                                        </div>
                                    </div>
                                    <hr>
                                    <br>
                                    <div class=\"row inv\">
                                        <div class=\"col-sm-12\">
                                            <h4>Bill to</h4>
                                        </div>
                                        <div class=\"col-sm-6\">
                                            <h3 class=\"inv\"> customer name</h3>
                                            <b>Address:</b> customer address,<br>
                                        </div>
                                        <div class=\"col-sm-6\">
                                            <b>Phone:</b> +20123456789<br><b>Email:</b> customer@gmail.com
                                        </div>
                                        <div style=\"clear: both;\"></div>
                                    </div>
                                    <br>
                                    <h3 class=\"inv\">invoice items</h3>
                                    <table class=\"table_invoice table_invoice-condensed table_invoice-bordered table_invoice-striped\"
                                           style=\"margin-bottom: 5px;\">
                                        <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>Description (Code)</th>
                                            <th>Quantity</th>
                                            <th>Unit price</th>
                                            <th>Total</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class=\"text-md-center\">1</td>
                                            <td class=\"text-md-left\">Sony vaio (Pc Portable)</td>
                                            <td class=\"text-md-center\">2.00</td>
                                            <td class=\"text-md-center\">500,00 $</td>
                                            <td class=\"text-md-center\">1 000,00 $</td>
                                        </tr>
                                        <tr>
                                            <td class=\"text-md-center\">2</td>
                                            <td class=\"text-md-left\">Wireless Alfa + Decoder</td>
                                            <td class=\"text-md-center\">1.00</td>
                                            <td class=\"text-md-center\">320,00 $</td>
                                            <td class=\"text-md-center\">320,00 $</td>
                                        </tr>
                                        <tr>
                                            <td class=\"text-md-center\">3</td>
                                            <td class=\"text-md-left\">Flash disk</td>
                                            <td class=\"text-md-center\">5.00</td>
                                            <td class=\"text-md-center\">1,20 $</td>
                                            <td class=\"text-md-center\">6,00 $</td>
                                        </tr>
                                        <tr>
                                            <td class=\"text-md-center\">4</td>
                                            <td class=\"text-md-left\">SkyWifi</td>
                                            <td class=\"text-md-center\">1.00</td>
                                            <td class=\"text-md-center\">35,00 $</td>
                                            <td class=\"text-md-center\">35,00 $</td>
                                        </tr>
                                        <tr>
                                            <td class=\"text-md-center\">5</td>
                                            <td class=\"text-md-left\">Aduino</td>
                                            <td class=\"text-md-center\">10.00</td>
                                            <td class=\"text-md-center\">5,00 $</td>
                                            <td class=\"text-md-center\">50,00 $</td>
                                        </tr>
                                        <tr>
                                            <td colspan=\"4\" class=\"text-md-right font-weight-bold\">Subtotal</td>
                                            <td class=\"text-md-right font-weight-bold\">1 411,00 $</td>
                                        </tr>
                                        <tr>
                                            <td colspan=\"4\" class=\"text-md-right font-weight-bold\">Global tax</td>
                                            <td class=\"text-md-right font-weight-bold\">(17%) 239,87 $</td>
                                        </tr>
                                        <tr>
                                            <td colspan=\"4\" class=\"text-md-right font-weight-bold\">Total</td>
                                            <td class=\"text-md-right font-weight-bold\">1 650,87 $</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class=\"col-sm-12\">
                                        <p></p>
                                        <p>Note: this is preview invoice</p>
                                    </div>
                                </div>
                                <div style=\"clear: both;\"></div>
                                $signature
                               
                                $footer
                                
                                <div style=\"clear: both;\"></div>
                            </div>
                        </div>
                        <script type=\"text/javascript\">
                            function setPrinterConfig() {
                                resolution = $('#resolution').val() != undefined ? $('#resolution').val() : \"A4\";
                                rotate = $('#rotate').val() != undefined ? $('#rotate').val() : \"portrait\";

                                $('.page').removeClass('A4 A5 Letter Legal');
                                $('.page').addClass(resolution);
                                $('.page').removeClass('portrait landscape');
                                $('.page').addClass(rotate);

                                w = \"21cm\";
                                h = \"29.7cm\";
                                
                                if (resolution == \"A4\") {
                                    w = \"21cm\";
                                    h = \"29.7cm\";
                                } else if (resolution == \"A5\") {
                                    w = \"14.8cm\";
                                    h = \"21cm\";
                                } else if (resolution == \"Letter\") {
                                    w = \"21.6cm\";
                                    h = \"27.9cm\";
                                } else if (resolution == \"Legal\") {
                                    w = \"21.6cm\";
                                    h = \"35.6cm\";
                                }
                                
                                if (rotate == \"landscape\") {
                                    $('#pageInit').html(\"@page{size: \" + h + \" \" + w + \"}\");
                                } else {
                                    $('#pageInit').html(\"@page{size: \" + w + \" \" + h + \"}\");
                                }
                                scaleTemplate();
                            };

                            function getPageHeight() {
                                resolution = $('#resolution').val() != undefined ? $('#resolution').val() : \"A4\";
                                rotate = $('#rotate').val() != undefined ? $('#rotate').val() : \"portrait\";

                                w = 21;
                                h = 29.7;
                                if (resolution == \"A4\") {
                                    w = 21;
                                    h = 29.7;
                                } else if (resolution == \"A5\") {
                                    w = 14.8;
                                    h = 21;
                                } else if (resolution == \"Letter\") {
                                    w = 21.6;
                                    h = 27.9;
                                } else if (resolution == \"Legal\") {
                                    w = 21.6;
                                    h = 35.6;
                                }
                                if (rotate == \"landscape\") {
                                    return w;
                                } else {
                                    return h;
                                }
                            };

                            function getPageWidth() {
                                resolution = $('#resolution').val() != undefined ? $('#resolution').val() : \"A4\";
                                rotate = $('#rotate').val() != undefined ? $('#rotate').val() : \"portrait\";

                                w = 21;
                                h = 29.7;
                                if (resolution == \"A4\") {
                                    w = 21;
                                    h = 29.7;
                                } else if (resolution == \"A5\") {
                                    w = 14.8;
                                    h = 21;
                                } else if (resolution == \"Letter\") {
                                    w = 21.6;
                                    h = 27.9;
                                } else if (resolution == \"Legal\") {
                                    w = 21.6;
                                    h = 35.6;
                                }
                                if (rotate == \"landscape\") {
                                    return h;
                                } else {
                                    return w;
                                }
                            };

                            function scaleTemplate() {
                                $.each($('[id=wrap_invoice]'), function (i, wrap_invoice) {
                                    var scale = 1;
                                    if ($(wrap_invoice).parent().is(\".wrapper\")) {
                                        $(wrap_invoice).unwrap();
                                    }
                                    var parent = $(wrap_invoice).parent();
                                    var padding = $(parent).outerWidth() - $(parent).width();
                                    var outer_height = $(parent).height();
                                    var inner_height = $(wrap_invoice).outerHeight();
                                    var outer_width = $(parent).width();
                                    var inner_width = $(wrap_invoice).outerWidth();
                                    if (outer_width < inner_width) {
                                        if (padding == 0) {
                                            scale = parseFloat(outer_width / (inner_width + 20));
                                            padding = 20;
                                        } else {
                                            scale = parseFloat(outer_width / inner_width);
                                            padding = 0;
                                        }
                                        var x = padding / 2;
                                        var origin = x.toFixed(2) + \"px 0px 0px\";
                                        $(wrap_invoice).css({
                                            '-webkit-transform': 'scale(' + (scale.toFixed(2)) + ')',
                                            '-webkit-transform-origin': origin
                                        });
                                        var wrapper = $(\"<div class='wrapper'></div>\");
                                        $(wrapper).css({
                                            'width': inner_width * scale,
                                            'height': inner_height * scale,
                                            \"overflow\": \"hidden\"
                                        });
                                        $(wrap_invoice).wrap(wrapper);
                                    } else {
                                        $(wrap_invoice).css({'-webkit-transform': '', '-webkit-transform-origin': \"\"});
                                    }
                                });
                            };

                            document.table_border = false;
                            document.table_strip = false;
                            document.table_border = true;
                            document.table_strip = true;

                            $(document).ready(function () {
                                $('#wrap_invoice table').removeClass();
                                $('#wrap_invoice table').addClass('table_invoice table_invoice-condensed');

                                $('#wrap_invoice table').addClass('table_invoice-bordered');

                                $('#wrap_invoice table').addClass('table_invoice-striped');


                                setPrinterConfig();
                                $('body').on('keyup', function (ev) {
                                    if (ev.keyCode == 27) {
                                        $('#close_page').click();
                                    }
                                });

                                $('#close_page').click(function () {
                                    window.close();
                                    window.parent.window.close();
                                    return false;
                                });
                            });
                            setTimeout(function () {
                                $(window).trigger(\"resize\");
                            }, 100);
                        </script>
                    </div>
                    <div id=\"loading_preview\" style=\"display: none;\">
                        <div class=\"black_background\"></div>
                        <div class=\"loader_img\"></div>
                    </div>";

        return view('settings.printing_template', compact('data', 'name', 'logo_monocolor', 'logo_greyscale','show_footer','show_header','show_signature'));
    }

    public function backup(){

    }
    public function invoice_setup(Request $request){
        /*$v = \Validator::make($request->all(), [
            'type' => 'required|not_in:0',
            'type_value' => 'required',
        ]);

        if ($v->fails()) {
            return redirect('admin/settings/invoiceset')->withErrors($v->errors())->withInput();
        }*/
        //return $request->all();
        
        foreach($request->ids as $key => $value){
            if(InvoiceSetup::where(['type' => $value, 'org_id' => Auth::user()->org_id])->exists()){
                InvoiceSetup::where('type', $value)->update([ 'value' => $request->type_value[$key], 'description' => $request->type_description[$key], 'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->id  ]);
            }else{
                InvoiceSetup::create([  'type' => $value, 'value' => $request->type_value[$key], 'description' => $request->type_description[$key], 'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->id]);
            }
        }
        
        //set session message
        Session::flash('created', __('strings.customers__msg_1') );

        return redirect('admin/settings/invoiceset');
    }

    public function invoice_setup_value(Request $request, $id){
        return InvoiceSetup::where(['type' => $id, 'org_id' => Auth::user()->org_id])->first();
    }
    
    
    public function delete_template(Request $request, $template_id){
        InvoiceTemplate::where(['id' => $template_id, 'org_id' => Auth::user()->org_id])->delete();
        return redirect('admin/settings/invoiceset');
    }
    
    public function payment_setting(Request $request){

    // update cash
    if(PaymentSetup::where(['gateway' => 'cash' , 'org_id' => Auth::user()->org_id])->doesntExist()){
      PaymentSetup::create(['gateway' => 'cash', 'active' => $request->cash_active, 'user_id' => Auth::user()->id, 'org_id' => Auth::user()->org_id]);
    }else{
      PaymentSetup::where(['gateway' => 'cash', 'org_id' => Auth::user()->org_id])->update(['active' =>$request->cash_active, 'user_id' => Auth::user()->id]);
    }

    //update PayPal

    if(PaymentSetup::where(['gateway' => 'paypal' , 'org_id' => Auth::user()->org_id])->doesntExist()){
      PaymentSetup::create(['gateway' => 'paypal','acc_name'=>$request->paypal_user_name,'acc_password'=>$request->paypal_password,'acc_signature'=>$request->paypal_signature,'active' => $request->paypal_active, 'user_id' => Auth::user()->id, 'org_id' => Auth::user()->org_id]);
    }else{
      PaymentSetup::where(['gateway' => 'paypal', 'org_id' => Auth::user()->org_id])->update(['acc_name'=>$request->paypal_user_name,'acc_password'=>$request->paypal_password,'acc_signature'=>$request->paypal_signature,'active' =>$request->paypal_active, 'user_id' => Auth::user()->id]);
    }


   // update stripe
   if(PaymentSetup::where(['gateway' => 'stripe' , 'org_id' => Auth::user()->org_id])->doesntExist()){
     if($request->authorize_active==1 && $request->stripe_active==1){
      PaymentSetup::create(['gateway' => 'stripe','acc_name'=>$request->stripe_user_name,'acc_password'=>$request->stripe_password,'active' => 0, 'user_id' => Auth::user()->id, 'org_id' => Auth::user()->org_id]);
     }else{
       PaymentSetup::create(['gateway' => 'stripe','acc_name'=>$request->stripe_user_name,'acc_password'=>$request->stripe_password,'active' => $request->stripe_active, 'user_id' => Auth::user()->id, 'org_id' => Auth::user()->org_id]);
     }

   }else{
       if($request->authorize_active==1 && $request->stripe_active==1 ){
           PaymentSetup::where(['gateway' => 'stripe', 'org_id' => Auth::user()->org_id])->update(['acc_name'=>$request->stripe_user_name,'acc_password'=>$request->stripe_password,'active' =>0, 'user_id' => Auth::user()->id]);
     }else{
       PaymentSetup::where(['gateway' => 'stripe', 'org_id' => Auth::user()->org_id])->update(['acc_name'=>$request->stripe_user_name,'acc_password'=>$request->stripe_password,'active' =>$request->stripe_active, 'user_id' => Auth::user()->id]);
     }
     
   }
   //update authorize
   if(PaymentSetup::where(['gateway' => 'authorize' , 'org_id' => Auth::user()->org_id])->doesntExist()){
   
        PaymentSetup::create(['gateway' => 'authorize','acc_name'=>$request->authorize_user_name,'acc_password'=>$request->authorize_transaction_key,'acc_signature'=>$request->authorize_login_id,'active' => $request->authorize_active, 'user_id' => Auth::user()->id, 'org_id' => Auth::user()->org_id]);
}
   else{
      
           PaymentSetup::where(['gateway' => 'authorize', 'org_id' => Auth::user()->org_id])->update(['acc_name'=>$request->stripe_user_name,'acc_password'=>$request->authorize_transaction_key,'acc_signature'=>$request->authorize_login_id,'active' =>$request->authorize_active, 'user_id' => Auth::user()->id]);
   }

   //update google
   if(PaymentSetup::where(['gateway' => 'google' , 'org_id' => Auth::user()->org_id])->doesntExist()){
     PaymentSetup::create(['gateway' => 'google','acc_name'=>$request->google_user_name,'acc_password'=>$request->google_password,'active' => $request->google_active, 'user_id' => Auth::user()->id, 'org_id' => Auth::user()->org_id]);
   }else{
     PaymentSetup::where(['gateway' => 'google', 'org_id' => Auth::user()->org_id])->update(['acc_name'=>$request->stripe_user_name,'acc_password'=>$request->stripe_password,'active' =>$request->google_active, 'user_id' => Auth::user()->id]);
   }

   //update default

   PaymentSetup::where(['gateway' => $request->default, 'org_id' => Auth::user()->org_id])->update(['default'=>1,'user_id' => Auth::user()->id]);

   return back();
}

}
