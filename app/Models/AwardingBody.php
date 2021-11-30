<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AwardingBody extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'awarding_body_name',
    ];

    //course relationship
    public function courses()
    {
        return $this->hasMany('App\Models\Resources');
    }
}
