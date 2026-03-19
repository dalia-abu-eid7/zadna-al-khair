<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationStatus extends Model
{
    use HasFactory;
      protected $fillable = ['name'];

    public function donations()
    {
        return $this->hasMany(Donation::class, 'status_id');
    }
}
