<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Laundry extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'customer_phone_number',
        'laundry_weight',
        'laundry_date',
        'user_id',
        'status',
        'service_id',
        'total_price',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getFormattedLaundryDateAttribute()
    {
        return $this->laundry_date->format('d F Y');
    }

    public function getFormattedLaundryWeightAttribute()
    {
        return $this->laundry_weight . ' kg';
    }

    public function getFormattedTotalPriceAttribute()
    {
        return 'Rp' . number_format($this->total_price, 0, ',', '.');
    }

}
