<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Client extends Model
{
    // one to one inverse
    public function clientBill () {
        return $this->belongsTo(Bill::class,'id','client_id');
    }
}
