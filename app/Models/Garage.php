<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Garage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'contact_number', 'address',
        'opening_time', 'closing_time', 'is_24_7'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class,'garage_services')
            ->withPivot('base_price', 'per_km_charge', 'is_available')
            ->withTimestamps();
    }

    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

    public function scopeNearby($query, $latitude, $longitude, $radius = 10)
    {
        return $query->whereRaw("
            ST_Distance_Sphere(
                POINT(?, ?),
                POINT(ST_X(location), ST_Y(location))
            ) <= ? * 1000
        ", [$longitude, $latitude, $radius]);
    }
}

