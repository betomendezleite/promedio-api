<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'person_id',
        'id_payment',
        'status',
        "type",
        "subscription"
    ];

    // Relación con la tabla users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con la tabla persons
    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
