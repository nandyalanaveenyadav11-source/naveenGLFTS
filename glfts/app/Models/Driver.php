<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    /** @use HasFactory<\Database\Factories\DriverFactory> */
    use HasFactory, \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'name',
        'license_number',
        'certification_level',
        'years_of_experience',
        'is_on_trip',
    ];

    protected $casts = [
        'is_on_trip' => 'boolean',
        'years_of_experience' => 'integer',
    ];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
