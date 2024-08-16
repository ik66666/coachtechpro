<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'users_id',
        'name',
        'image_url',
        'postcode',
        'address',
        'building',
    ];

    

    public function user(){ 
        return $this->belongsTo('App\Models\User');
    }
}
