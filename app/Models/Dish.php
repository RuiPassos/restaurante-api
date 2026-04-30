<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Dish extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'available', 'allergens', 'category_id'
    ];
    
    protected $casts = [
        'available' => 'boolean', 
        'price' => 'decimal:2'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function reservations(): BelongsToMany
    {
        // Adicionamos o 'reservation_dish' para corrigir a ficha
        return $this->belongsToMany(Reservation::class, 'reservation_dish')->withPivot('quantity');
    }
}
