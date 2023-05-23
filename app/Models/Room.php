<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'quantity',
        'price',
        'description',
        'price_text',
    ];

    public function user() : BelongsTo
    {
        return $this->BelongsTo(User::class);
    }

    public function rates() : HasMany
    {
        return $this->hasMany(Rate::class);
    }

    public function avgPoint() 
    {
        $avg = Rate::where('room_id', '=', $this->id)->avg('point') ?? 0;

        return round($avg, 1);
    }

    public function starsRateCount(int $point)
    {
        $count = Rate::where('room_id', '=', $this->id)->where('point', '=', $point)->count();
        $total = Rate::where('room_id', '=', $this->id)->count();
        
        if($total <= 0) {
            return $total;
        }

        return round($count/$total, 2);
    }

    public function images() : HasMany
    {
        return $this->hasMany(Image::class);
    }
}
