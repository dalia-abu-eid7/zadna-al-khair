<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEntityMapping extends Model
{
    protected $table = 'user_entity_mappings';

    protected $fillable = [
        'UserID',
        'EntityID',
        'MappingDate'
    ];

    public $timestamps = false;
}
