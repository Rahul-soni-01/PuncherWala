<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GarageService extends Model
{
    use HasFactory;

    protected $table = 'garage_services';

    protected $fillable = [
        'garage_id',
        'service_id',
        'base_price',
        'per_km_charge',
        'is_available'
    ];

    public function garage()
    {
        return $this->belongsTo(Garage::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function calculatePrice($distance = 0)
    {
        $price = $this->base_price;
        
        if ($this->per_km_charge && $distance > 0) {
            $price += $distance * $this->per_km_charge;
        }

        return $price;
    }
}