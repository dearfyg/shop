<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table="Category";
    protected $primaryKey="id";
    protected $guarded=[];

    public function goods()
    {
        return $this->belongsTo(Goods::class);
    }
}
