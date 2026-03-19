<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationHistory extends Model
{
    use HasFactory;
protected $table = 'donation_history';
     protected $fillable = ['donation_id', 'status_id', 'changed_by', 'note'];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function status()
    {
        return $this->belongsTo(DonationStatus::class, 'status_id');
    }
}
