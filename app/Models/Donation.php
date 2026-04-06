<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $table = 'donations';
    protected $primaryKey = 'DonationID'; 

    protected $fillable = [
        'StatusID',
        'Description',
        'Quantity',
        'Unit',
        'DonatingEntityID',
        'ReceivingEntityID',
        'ExpiryInfo',
        'PickupTimeSuggestion'
    ];

    public function donatingEntity()
    {
        return $this->belongsTo(Entity::class, 'DonatingEntityID', 'EntityID');
    }

    public function receivingEntity()
    {
        return $this->belongsTo(Entity::class, 'ReceivingEntityID', 'EntityID');
    }

    public function status()
    {
        return $this->belongsTo(DonationStatus::class, 'StatusID', 'StatusID');
    }

    public function history()
    {
        return $this->hasMany(DonationHistory::class, 'DonationID', 'DonationID');
    }
}
