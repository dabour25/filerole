<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\CustomerHead;

class InvoicesCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoicescheck';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check invoice status';

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
        foreach ($list = CustomerHead::where(['org_id' => \Auth::user()->org_id])->with('transactions')->whereNotNull('cust_id')->get() as $v){
            CustomerHead::where('id', $v->id)->update([ 'invoice_status' => Invoice_status($v->id) ]);
        }
    }
}
