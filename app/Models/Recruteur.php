<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recruteur extends Model
{
    protected $table = 'recruteur';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'company_name',
    ];
}
