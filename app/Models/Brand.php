<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $guarded = [];
   

    public function images()
    {
        return $this->hasMany(BrandImage::class);
    }
}
