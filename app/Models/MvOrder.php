<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MvOrder extends Model
{
    public $table = 'mv_orders';

    // We set the values of timestamps in App\Jobs\UpdateMvOrder
    public $timestamps = false;
}
