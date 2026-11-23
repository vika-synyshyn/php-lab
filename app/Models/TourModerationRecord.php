<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TourModerationRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'moderator_id',
        'decision',
        'reason',
    ];

    public function tour(): BelongsTo
    {
        return $this->belongsTo(Tour::class);
    }

    public function moderator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'moderator_id');
    }
}
