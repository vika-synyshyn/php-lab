<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TourCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function tours(): HasMany
    {
        return $this->hasMany(Tour::class, 'category_id');
    }
}
