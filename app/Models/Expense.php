<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'category_id',
        'status',
        'description',
    ];

    public function getUpdatedAtTimezoneAttribute()
    {
        if ($this->date != null) {
            return (new Carbon( $this->date ))->format('Y-m-d');
        }
    
        return null;
    }

    public function getDay($date)
    {
        $days = array("Lunes","Martes","Miércoles","Jueves","Viernes","Sábado","Domingo");
        return $days[date('N', strtotime($date)) -1 ];
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }
}
