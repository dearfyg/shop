<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    //
    public $table="admin_cart";
    protected $guarded=["updated_at"];
}
