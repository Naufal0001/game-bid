<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles, HasFactory;

    protected $fillable = [
        'username',
        'email',
        'password',
        'provider',
        'provider_id',
        'avatar',
        'game_id',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /* =====================
     |  RELATIONSHIPS
     ===================== */

    // User menjual banyak item
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    // User melakukan banyak bid
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    // User memenangkan auction
    public function wonAuctions()
    {
        return $this->hasMany(Auction::class, 'winner_id');
    }

    // User sebagai buyer di transaksi
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'buyer_id');
    }
}