<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category as categoryModel;
use App\externalReq as external_Req;


class externalTrans extends Model
{
    //

    public function cat()
    {
        return $this->belongsTo('App\Category','cat_id');
    }
    public function req()
    {
        return $this->belongsTo('external_Req','external_req_id');
    }
}
