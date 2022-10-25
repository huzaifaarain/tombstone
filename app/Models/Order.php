<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $casts = [
        'date_of_birth' => 'datetime:Y-m-d',
        'death_date' => 'datetime:Y-m-d'
    ];

    public function tombstone(){
        return $this->belongsTo(Tombstone::class);
    }

    public function font(){
        return $this->belongsTo(Font::class);
    }

    public function textColor(){
        return $this->belongsTo(TextColor::class);
    }

    public function icon(){
        return $this->belongsTo(Icon::class);
    }
}
