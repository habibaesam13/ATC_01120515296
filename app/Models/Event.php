<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable=[
        "name",
        "description",
        "price",
        "category_id",
        "image",
        "date",
        "venue",
    ];
    public function category()
    {
        return $this->belongsTo(Category::class); // An event belongs to a category
    }
}
