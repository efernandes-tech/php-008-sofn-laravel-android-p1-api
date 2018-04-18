<?php

namespace SON\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class BillPay extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'name',
        'date_due',
        'value',
        'done',
        'category_id',
    ];

}
