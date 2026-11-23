<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tour_departure_id',
        'booking_code',
        'group_size',
        'total_amount',
        'status',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function departure(): BelongsTo
    {
        return $this->belongsTo(TourDeparture::class, 'tour_departure_id');
    }

    public function travelers(): HasMany
    {
        return $this->hasMany(Traveler::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
