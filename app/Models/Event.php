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
        "number_of_tickets",
        "date",
        "venue",
    ];
    public function category()
    {
        return $this->belongsTo(Category::class); 
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    
    public function users()
    {
        return $this->hasManyThrough(User::class, Ticket::class, 'event_id', 'id', 'id', 'user_id');
    }
    


}
