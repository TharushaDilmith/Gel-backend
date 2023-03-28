<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'course_name',
        'brand',
        'course_type',
        'resource_type',
        'course_link',
        'validity',
        'awarding_body',
    ];


    //course relationship
    public function resources()
    {
        return $this->hasMany('App\Models\Resources');
    }

    //course relationship with awarding body
    public function awarding_body()
    {
        return $this->belongsTo('App\Models\AwardingBody');
    }

    //course relationship with brand
    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }
}
