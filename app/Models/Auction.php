<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Auction extends Model
{
    protected $fillable = [
        'item_id',
        'starting_price',
        'current_price',
        'buyout_price',
        'min_increment',
        'winner_id',
        'is_buyout',
        'start_time',
        'end_time',
        'status',
    ];

    protected $dates = [
        'start_time',
        'end_time',
    ];

    /* =====================
     |  RELATIONSHIPS
     ===================== */

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    public function winner()
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    /* =====================
     |  HELPERS
     ===================== */

    public function isActive()
    {
        return now()->between($this->start_time, $this->end_time)
            && $this->status === 'active';
    }
}