<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'ip_address',
        'user_agent',
        'payload',
        'last_activity'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getLastActivity()
    {
        return Carbon::createFromTimeStamp($this->last_activity)->diffForHumans();
    }
}
