<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'NotificationID';
    public $timestamps = true;

    protected $fillable = [
        'UserID',
        'SourceTable',
        'SourceID',
        'Type',
        'Message',
        'IsRead'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'UserID');
    }
}
