<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Part extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'quantity' => 'integer',
        'active' => 'boolean',
    ];

    public function addedBy()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    protected function unitPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => number_format($value / 100, 2),
            set: fn ($value) => $value * 100,
        );
    }
}
