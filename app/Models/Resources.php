<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resources extends Model
{
    use HasFactory;

    protected $fillable = [
        'resource_name', 'resource_image', 'resource_url',
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

    //course relationship
    public function courses()
    {
        return $this->belongsTo('App\Models\Course');
    }
}
