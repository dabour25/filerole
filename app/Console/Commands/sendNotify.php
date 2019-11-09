<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notification as notifyModel;
use App\Events\Notifications as notifyEvent;
use DB;

class sendNotify extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notifiy:offer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
       $offer =  DB::table('offers')->whereDate('date_to', date("Y-m-d"))->get();
       foreach ($offer as $key ) {
         $cat =  DB::table('categories')->find($key->cat_id);
         $Notify = new notifyModel();
         $Notify->org_id = $key->org_id;
         $Notify->content = "لقد تم انتهاء عرض $cat->name";
         $Notify->content_en = "the offer $cat->name_en   has been  ended ";
         $Notify->content_type = "offer";
         $Notify->save();
         event(new notifyEvent($key->org_id,$Notify,'offer'));
       }
        }


}
