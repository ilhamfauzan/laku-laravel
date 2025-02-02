<?php

namespace App\Models;

use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'user_id',
        'service_id',
        'laundry_id',
        'total_price',
        'payment_status',
        'payment_date',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function laundry()
    {
        return $this->belongsTo(Laundry::class);
    }

    public function getFormattedTotalPriceAttribute()
    {
        return 'Rp' . number_format($this->total_price, 0, ',', '.');
    }

    public function getFormattedPaymentDateAttribute()
    {
        return \Carbon\Carbon::parse($this->payment_date)->format('d F Y');
    }

    public function getPaymentStatusLabelAttribute()
    {
        $labels = [
            'pending' => '<span class="badge badge-secondary">Pending</span>',
            'completed' => '<span class="badge badge-success">Completed</span>',
            'failed' => '<span class="badge badge-danger">Failed</span>',
        ];

        return $labels[$this->payment_status];
    }

    public function generateReceipt()
    {
        // Logic to generate receipt
        return "Receipt for Transaction ID: {$this->id}";
    }

    public function toSearchableArray(): array
    {
        return [
            'customer_name' => $this->customer_name,
            'customer_phone_number' => $this->customer_phone_number,
        ];
    }
}
