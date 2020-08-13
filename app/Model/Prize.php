<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Prize extends Model
{
    protected $table="prize";
    protected $primaryKey="id";
    public $timestamps = false;
}
