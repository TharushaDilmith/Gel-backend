<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceType extends Model
{
    use HasFactory;

    protected $fillable = [
        'resource_body_name',
    ];
    //course relationship
    public function courses()
    {
        return $this->hasMany('App\Models\Course');
    }

}
