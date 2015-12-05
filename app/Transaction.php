<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }
    
    public function getDates()
{
    /* substitute your list of fields you want to be auto-converted to timestamps here: */
    return array('created_at', 'updated_at', 'deleted_at', 'prod_update');
}
}
