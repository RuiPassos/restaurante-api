<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reservation extends Model
{
    protected $fillable = [
        'user_id', 'reserved_at', 'guests', 'notes', 'status'
    ];

    protected $casts = [
        'reserved_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dishes(): BelongsToMany
    {
        // Adicionamos o 'reservation_dish' para corrigir a ficha
        return $this->belongsToMany(Dish::class, 'reservation_dish')->withPivot('quantity');
    }
}
