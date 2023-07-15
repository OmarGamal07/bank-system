<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transfer;

class Bank extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'nationalID',
    ];
    function transfer(){
        return $this->hasMany(Transfer::class);
    }
}
