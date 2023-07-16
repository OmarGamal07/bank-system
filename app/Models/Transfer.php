<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\Type;
use App\Models\Bank;

class Transfer extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'type_id',
        'bank_id',
        'mount',
        'dateTransfer',
        'numberAccount',
        'numberOperation',
    ];
    function sender()
    {
        return $this->belongsTo(Client::class, 'sender_id', 'id')->select('id', 'name');
    }
    function receiver()
    {
        return $this->belongsTo(Client::class, 'receiver_id', 'id')->select('id', 'name');
    }
    function type()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id')->select('id', 'name');
    }
    function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id')->select('id', 'name','nationalID');
    }
}
