<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'description',
        'image_url',
        'users_id',
        'category_item_id',
        'condition_id',
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function category_item(){
        return $this->belongsTo('App\Models\CategoryItem');
    }
    public function condition(){
        return $this->belongsTo('App\Models\Condition');
    }
    public function category(){
        return $this->belongsTo('App\Models\Category');
    }
}
