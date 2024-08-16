<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoldItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'users_id',
        'item_id',
    ];

    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'sold_items';

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function item(){
        return $this->belongsTo('App\Models\Item');
    }
}
