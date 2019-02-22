<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $table = 'servicios_ccsm';
    protected $primaryKey = 'servicio_ccsmID';

    protected $hidden = [
        'created_at', 'updated_at',
    ];

}