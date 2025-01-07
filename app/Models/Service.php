<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_name',
        'service_price',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getFormattedServicePriceAttribute()
    {
        return 'Rp' . number_format($this->service_price, 0, ',', '.');
    }

}
