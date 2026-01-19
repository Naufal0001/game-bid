<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'item_name',
        'rarity',
        'description',
        'image',
        'is_verified',
        'status',
    ];

    // Item dimiliki user (seller)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Item punya kategori
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // [PERBAIKAN] Mengubah hasOne 'auction' menjadi hasMany 'auctions'
    // Agar kompatibel dengan kode Controller yang mengecek riwayat lelang
    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }
}