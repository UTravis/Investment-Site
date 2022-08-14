<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Funds extends Model
{
    use HasFactory;

    //Reverse one to one relationship with User Model
    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
