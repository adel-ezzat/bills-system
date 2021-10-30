<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{

    // one to many relation
    public function items() {
        return $this->hasMany(BillItem::class);
    }

    // one to one relation
    public function client () {
        return $this->hasOne(Client::class,'id','client_id');
    }

    // get all bills
    public function scopeGetAllBills($query)
    {
        return $query->with(['items' => function ($q) {
            $q->select('*');
        }])->with('client')
            ->withCount('items')
            ->get();
    }

    // get bill by id
    public function scopeGetBillById($query,$id) {
        return $query->with(['items' => function ($q) {
            $q->select('*');
        }])->with('client')
            ->withCount('items')
            ->where('id', $id)
            ->get()->first();
    }
}
