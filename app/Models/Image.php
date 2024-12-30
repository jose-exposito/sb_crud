<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['url', 'item_id'];
    
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}