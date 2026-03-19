<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    use HasFactory;
protected $primaryKey = 'EntityID'; // أخبري لاراڤيل باسم المفتاح الأساسي عندك
    protected $fillable = ['EntityName', 'EntityType', 'LicenseNumber', 'Address', 'ContactPerson', 'ContactEmail', 'Status'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_entity_mappings');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
