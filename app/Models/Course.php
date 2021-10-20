<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_name', 'course_image', 'course_url',
    ];

    //resoursetype relationship
    public function resoursetypes()
    {
        return $this->belongsTo('App\Models\Resoursetype');
    }

    //awardingbody relationship
    public function awardingbodies()
    {
        return $this->belongsTo('App\Models\Awardingbody');
    }

}
