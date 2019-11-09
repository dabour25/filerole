<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Customers;
use App\Followup;
use App\FollowupMessage;
use App\FollowupSessions;

class FollowupSendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'followup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send schedule mail';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        foreach (Followup::where(['org_id' => \Auth::user()->org_id])->get() as $value){
            if(FollowupSessions::where('followup_id', $value->id)->exists()){
                foreach (FollowupSessions::where(['followup_id' => $value->id, 'session_status' => 1])->get() as $v2){
                    $date = explode(' ' , $v2->session_dt);

                    if(date('Y-m-d', strtotime('-1 day', strtotime($date[0]))) == date('Y-m-d')) {
                        $customer = Customers::where('id', $value->cust_id)->first();
                        $from = DB::table('organizations')->where('id', Auth::user()->org_id)->value('email');
                        $subject = "تفاصيل الحجز";
                        $email = $customer->email;
                        $content = " $date[0]نود ان نذكركم بان موعد الحجز يوم   ";

                        try{
                            \Mail::send('vendor.emails.followup', ['email' => $customer->email, 'content' => $content], function ($message) use ($from, $subject, $email) {
                                $message->from($from);
                                $message->to($email)->subject($subject);
                            });
                            FollowupMessage::create([ 'followup_id' => $value->id, 'msg_dt' => date('Y-m-d'), 'msg_media' => 'mail', 'msg_status' => 1, 'msg_content' => $content, 'org_id' => $value->org_id]);
                        }catch (\Exception $ex){
                            FollowupMessage::create([ 'followup_id' => $value->id, 'msg_dt' => date('Y-m-d'), 'msg_media' => 'mail', 'msg_status' => 0, 'msg_content' => $content, 'org_id' => $value->org_id]);
                        }
                    }
                }
            }
        }



    }
}
