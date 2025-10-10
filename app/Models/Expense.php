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

    public function getCreatedAtTimezoneAttribute()
    {
        if ($this->created_at != null) {
            return (new Carbon( $this->created_at ))->format('Y-m-d');
        }
    
        return null;
    }

    public function getUpdatedAtTimezoneAttribute()
    {
        return $this->updated_at;
        if ($this->updated_at != null) {
            return (new Carbon( $this->updated_at ))->format('Y-m-d');
        }
    
        return null;
    }

    public function updatedAt()
    {
        return $this->updated_date;
        if ($this->updated_date != null) {
            return (new Carbon( $this->updated_date ))->format('Y-m-d');
        }
    
        return null;
    }

    public function getDay($date)
    {
        $days = ["Lunes","Martes","Miércoles","Jueves","Viernes","Sábado","Domingo"];
        return $days[date('N', strtotime($date)) - 1 ];
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id', 'id');
    }
}
