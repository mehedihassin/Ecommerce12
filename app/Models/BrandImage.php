<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandImage extends Model
{
    protected $guarded = [];
    protected $hidden = ['image'];

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
}
