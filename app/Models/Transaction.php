<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'auction_id',
        'buyer_id',
        'total_price',
        'delivery_status',
        'transaction_date',
        'status',
    ];

    protected $dates = [
        'transaction_date',
    ];

    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}