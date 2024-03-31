<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'persons';
    protected $fillable = [
        'name',
        'lastname',
        'sex',
        'birthday',
        'address',
        'city',
        'country',
        'email',
        'phone',
        'avatar',
    ];
}
