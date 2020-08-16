<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GithubUser extends Model
{
    protected $table="github_user";
    protected $primaryKey="g_id";
    protected $guarded=[];
    public $timestamps = false;
}
