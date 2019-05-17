<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderEventModel extends Model
{
    public $table = 'order_events';

    protected $casts = [
        'data' => 'array',
    ];

    protected $guarded = [];
}
