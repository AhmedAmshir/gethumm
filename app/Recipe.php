<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = ['name', 'description', 'created_at'];

    public $timestamps = false;

    public function ingredients() {
        return $this->belongsToMany('App\Ingredient')
            ->withPivot('amount')
    	    ->withTimestamps();
    }

    public function boxs() {
        return $this->belongsToMany('App\Box');
    }
}
