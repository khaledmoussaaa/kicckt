<?php

namespace App\Models;

use App\Casts\DateTimeCasting;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class BaseModel extends Model implements HasMedia
{
    use HasFactory, Notifiable, InteractsWithMedia;
    /**
     * The default attributes that should be cast.
     * These will be merged with the model-specific casts.
     *
     * @var array<string, string>
     */
    protected $defaultCasts = [
        'created_at' => DateTimeCasting::class,
        'updated_at' => DateTimeCasting::class,
    ];

    /**
     * Get the merged casts array from default and model-specific casts.
     *
     * @return array
     */
    public function getCasts()
    {
        return array_merge($this->defaultCasts, $this->casts);
    }
}
