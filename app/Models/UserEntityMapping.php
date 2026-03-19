<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserEntityMapping extends Model
{
    // نحدد اسم الجدول يدوياً لأنه قد لا يتبع قاعدة الجمع الافتراضية
    protected $table = 'user_entity_mappings';

    protected $fillable = [
        'UserID',
        'EntityID',
        'MappingDate'
    ];

    public $timestamps = false; // إذا لم يكن عندك حقول created_at في هذا الجدول
}
