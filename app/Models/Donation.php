<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;
    protected $table = 'donations';
    protected $primaryKey = 'DonationID';

    protected $fillable =
     ["StatusID",   'Description', 'Quantity', 'Unit', 'ExpiryInfo',
      'DonatingEntityID'  , 'PickupTimeSuggestion'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }

    public function status()
    {
        return $this->belongsTo(DonationStatus::class, 'status_id');
    }

    public function history()
    {
        return $this->hasMany(DonationHistory::class);
    }
}
