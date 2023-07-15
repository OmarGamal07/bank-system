<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transfer;

class Client extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'role'
    ];
    function transfer(){
        return $this->hasMany(Transfer::class);
    }
}
