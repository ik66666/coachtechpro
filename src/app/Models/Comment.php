<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'users_id',
        'comment',
    ];

    public function item(){
        return $this->belongsTo('App\Models\Item');
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
