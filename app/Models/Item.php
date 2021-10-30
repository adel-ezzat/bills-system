<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{

    // on to many inverse
    public function bill() {
        return $this->belongsTo(Bill::class);
    }

}
