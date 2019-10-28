<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name', 'parent'
    ];
    
    public function items(){
        return $this->hasMany('App\Category');
    }
}
