<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id', 'feed_id', 'game_fowl_id', 'quantity'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }

    public function gameFowl()
    {
        return $this->belongsTo(GameFowl::class);
    }
}
