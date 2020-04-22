<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $fillable = ['fullname', 'address', 'mobile', 'delivery_date', 'created_at'];

    public $timestamps = false;

    public function recipes() {
        return $this->belongsToMany('App\Recipe')
            ->withTimestamps();;
    }
}
