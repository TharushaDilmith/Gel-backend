<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AwardingBody extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    //course relationship
    public function courses()
    {
        return $this->hasMany('App\Models\Course');
    }
}
