<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryItem extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'category_id',
    ];

    /**
     * モデルに関連付けるテーブル
     *
     * @var string
     */
    protected $table = 'category_items';

    public function category(){
        return $this->belongsTo('App\Models\Category');
    }
    public function item(){
        return $this->belongsTo('App\Models\Item');
    }
}
