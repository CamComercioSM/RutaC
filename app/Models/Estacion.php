<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estacion extends Model
{
    protected $table = 'estaciones';
    protected $primaryKey = 'estacionID';

    protected $hidden = [
        'created_at', 'updated_at',
    ];

}