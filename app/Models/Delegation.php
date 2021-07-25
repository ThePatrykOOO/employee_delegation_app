<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Delegation
 * @package App\Models
 * @property $id,
 * @property $employee_id,
 * @property $start,
 * @property $end,
 * @property $amount_due,
 * @property $country,
 * @property $currency,
 */
class Delegation extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'start',
        'end',
        'amount_due',
        'country',
    ];
}
