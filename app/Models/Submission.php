<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'message', 'street', 'state', 'zip', 'country'
    ];

    protected function casts()
    {
        return [
            'images' => 'array',
            'files' => 'array',
        ];
    }
}
