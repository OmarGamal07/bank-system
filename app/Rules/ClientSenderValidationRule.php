<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Client;
class ClientSenderValidationRule implements Rule
{
    public function passes($attribute, $value)
    {
        try {
            $client = Client::find($value);
            // $user = User::find($manager->user->id);
            return $client && $client->role === 'sender';
        } catch (\Exception $e) {
            return false;
        }
    }

    public function message()
    {
        return 'The selected client must have a role of "sender".';
    }
}
