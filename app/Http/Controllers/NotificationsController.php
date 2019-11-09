<?php

namespace App\Http\Controllers;

use App\FrontMessages;
use App\FrontMessagesReplay;
use App\User;
use App\UsersMessages;
use Illuminate\Support\Facades\Session;
use App\Events\Notifications as notifyEvent;

use Illuminate\Http\Request;
use Auth;
use DB;
class NotificationsController extends Controller
{

    public function users_index(Request $request){
        $messages = [];
        return view('inbox.users_index', compact('messages'));
    }


    public function users_messages(Request $request, $id){
        $messages = UsersMessages::where(['to_id' =>  $id, 'from_id' => Auth::user()->id])->get();
        UsersMessages::where(['to_id' => Auth::user()->id, 'from_id' => $id])->update([ 'seen' => 1, 'org_id' => Auth::user()->org_id]);
        return view('inbox.users_index', compact('messages', 'id'));
    }
    
    public function customers_new_message(Request $request){

    if(!empty($request->id) && !empty($request['new-message'])) {
        $data = FrontMessages::findOrFail($request->id);
        $content = $request['new-message'];
        $from = DB::table('organizations')->where('id', Auth::user()->org_id)->value('email'); $subject = $data->subject; $email = $data->email;

        \Mail::raw($content, function ($message) use ($from, $subject, $email) {
            $message->from($from);
            $message->to($email)->subject($subject);
        });

        return ['message_id' => null, 'message' => $request['new-message']];
    }else{
        return ['message_id' => null, 'message' => null];
    }
}


    public function users_new_message(Request $request){

        $input =  $request->all();
        if(!empty($request['id']) && !empty( $request['new-message'])) {
            $input['from_id'] = Auth::user()->id;
            $input['to_id'] = $request['id'];
            $input['message'] = $request['new-message'];
            $input['org_id'] = Auth::user()->org_id;

            $m = UsersMessages::create($input);
            $user = DB::table('users')->find($m->from_id);
            event(new notifyEvent($user,$m,'newmsg'));
            return ['message_id' => $m->id, 'message' => $request['new-message']];
        }else{
            return ['message_id' => null, 'message' => null];
        }
    }

    public function users_search(Request $request){
        $users_html = '';
        $users = User::where(['org_id' => Auth::user()->org_id, 'is_active' => 1])->where('name', 'like', $request->keyword.'%')->get();
        if(count($users) > 0) {
            foreach ($users as $value) {
                $image = $value->photo ? asset($value->photo->file) : asset('images/profile-placeholder.png');
                $url = url('admin/inbox/users/message', $value->id);
                $message_count = UsersMessages::where(['to_id' => Auth::user()->id, 'from_id' => $value->id,'seen' => 0])->count();
                $countunseen = $message_count == 0 ? '' : $message_count;
                $last_message = UsersMessages::where(['to_id' => Auth::user()->id, 'from_id' => $value->id])->orderBy('created_at', 'desc')->value('message');
                if($value->id != Auth::user()->id) {
                    $users_html .= "<li class=\"user-list\" data-id=\"$value->id\">
                                <a href=\"$url\" data-load=\"$url\" data-id=\"$value->id\">
                                    <div class=\"user-avatar\">
                                        <img src=\"$image\" alt=\"user avatar\">
                                    </div>
                                    <div class=\"countunseen\">$countunseen</div>
                                    <div class=\"user-name\">$value->name</div>
                                    <div class=\"user-last-message\">$last_message</div>
                                    <div class=\"clear\"></div>
                                </a>
                            </li>";
                }
            }
        }else{
            $users_html = '<p class="empty_state"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>No users found</p>';
        }
        return [ 'status' => 200, 'users' => $users_html];
    }

    public function fetch_messages(Request $request){
         $users_html = ''; $message_html = '';
         $users = User::where(['org_id' => Auth::user()->org_id, 'is_active' => 1])->get();
         if(count($users) > 0) {
             foreach ($users as $value) {
                 $image = $value->photo ? asset($value->photo->file) : asset('images/profile-placeholder.png');
                 $url = url('admin/inbox/users/message', $value->id);
                 $message_count = UsersMessages::where(['to_id' => Auth::user()->id, 'from_id' => $value->id,'seen' => 0])->count();
                 $countunseen = $message_count == 0 ? '' : $message_count;
                 $last_message = UsersMessages::where(['to_id' => Auth::user()->id, 'from_id' => $value->id])->orderBy('created_at', 'desc')->value('message');
                 if($value->id != Auth::user()->id) {
                     $users_html .= "<li class=\"user-list\" data-id=\"$value->id\">
                                 <a href=\"$url\" data-load=\"$url\" data-id=\"$value->id\">
                                     <div class=\"user-avatar\">
                                         <img src=\"$image\" alt=\"user avatar\">
                                     </div>
                                     <div class=\"countunseen\">$countunseen</div>
                                     <div class=\"user-name\">$value->name</div>
                                     <div class=\"user-last-message\">$last_message</div>
                                     <div class=\"clear\"></div>
                                 </a>
                             </li>";
                 }
             }
             foreach (UsersMessages::where(['from_id' => $request->id, 'to_id' => Auth::user()->id])->Orwhere(['from_id' => Auth::user()->id, 'to_id' => $request->id])->get() as $m){
                 $use = User::findOrFail($request->id);
                 $image2 = $use->photo ? asset($use->photo->file) : asset('images/profile-placeholder.png');
                
                 if($m->to_id == $request->id && $m->from_id == Auth::user()->id) {
                     $message_html .= "<div class=\"message to-user pull-right\" data-id=\"$m->id\">
                                     <div class=\"user-message\">$m->message</div>
                                     <div class=\"clear\"></div>
                                 </div>
                                 <div class=\"clear\"></div>";
                 }
                 if($m->to_id == Auth::user()->id && $m->from_id == $request->id) {
                     $message_html .= "<div class=\"message to-user incming_msg pull-left\" data-id=\"$m->id\">
                                                 <div class=\"user-avatar\">
                                                     <img src=\"$image2\" alt=\"user message\">
                                                 </div>
                                                 <div class=\"user-message\">$m->message</div>
                                                 <div class=\"clear\"></div>
                                             </div>
                                             <div class=\"clear\"></div>";
                 }
             }
    
         }
         return [ 'status' => 200, 'users' => $users_html, 'message' => $message_html];
    }

    public function customers_index(Request $request){
        return view('inbox.customers_index', compact('messages'));
    }

    public function customers_new_messages(Request $request){
        $data = FrontMessages::findOrFail($request['id']);
        $content = $request['new-message'];
        FrontMessagesReplay::create(['parent_id' =>  $request->id,'message' => $request['new-message'],'org_id' => Auth::user()->org_id, 'user_id' => Auth::user()->id]);

        $from = DB::table('organizations')->where('id', Auth::user()->org_id)->value('email'); $subject = $data->subject; $email = $data->email;
        \Mail::raw($content, function ($message) use ($from, $subject, $email) {
            $message->from($from);
            $message->to($email)->subject($subject);
        });
        //set session message
        Session::flash('created', __('strings.customers_message'));
        //redirect back to functions.index
        return back();
    }

    public function customers_search(Request $request){
        $customers_html = '';
        $customers = FrontMessages::where('name', 'like', $request->keyword.'%')->get();
        if(count($customers) > 0) {
            foreach ($customers as $value) {
                $url = url('admin/inbox/customers/message', $value->id);
                $countunseen = $value->open == 1 ? '' : 1;
                $customers_html .= "<li class=\"user-list\" data-id=\"$value->id\">
                            <a href=\"$url\" data-load=\"$url\" data-id=\"$value->id\">
                                <div class=\"countunseen\">$countunseen</div>
                                <div class=\"user-name\">$value->name - $value->email</div>
                                <div class=\"user-last-message\">$value->subject</div>
                                <div class=\"clear\"></div>
                            </a>
                        </li>";

            }
        }else{
            $customers_html = '<p class="empty_state"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>No users found</p>';
        }
        return [ 'status' => 200, 'users' => $customers_html];

    }

    public function customers_messages(Request $request, $id){
        $messages = FrontMessages::where(['id' =>  $id])->get();
        FrontMessages::where(['id' => $id])->update([ 'open' => 1]);
        return view('inbox.customers_index', compact('messages', 'id'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function customer_reply(Request $request, $id)
    {
        $data = FrontMessages::findOrFail($id);

        FrontMessages::where('id', $id)->update(['open' => 1]);
        $content = $request->message;
        $from = DB::table('organizations')->where('id', Auth::user()->org_id)->value('email'); $subject = $data->subject; $email = $data->email;
        \Mail::raw($content, function ($message) use ($from, $subject, $email) {
            $message->from($from);
            $message->to($email)->subject($subject);
        });
        //redirect back to dashboard
        return back();

    }

    public function UsersMessage(Request $request, $id){

        foreach ($messages = UsersMessages::where(['to_id' =>  $id, 'from_id' => Auth::user()->id])->get() as $value){
            $user = User::findOrFail($id);
            $value->name = app()->getLocale() == 'ar' ? $user->name : $user->name_en;
        }
        foreach ($reply = UsersMessages::where(['from_id' => $id, 'to_id' => Auth::user()->id])->get() as $value){
            $user2 = User::findOrFail(Auth::user()->id);
            $value->name = app()->getLocale() == 'ar' ? $user2->name : $user2->name_en;
        }

        return [ 'messages' => $messages, 'reply' => $reply];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function AddUsersMessage(Request $request){
        $input =  $request->all();

        if(!empty($request->message)){
            $input['from_id'] = Auth::user()->id;
            $input['to_id'] = $request->user_id;
            $input['message'] = $request->message;
            $input['org_id'] = Auth::user()->org_id;
    
            UsersMessages::create($input);
        }
        return [ 'status' => 200, 'message' => true];
    }


}
