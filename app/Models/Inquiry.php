<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inquiry extends Model
{
     use HasFactory;

    protected $fillable = [
        'customer_id', 'garage_id', 'service_id',
        'vehicle_type', 'problem_description',
        'distance_km', 'estimated_price', 'status'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
