<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
class StoreTransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'sender' => 'required|string|max:255',
            'receiver' => 'required|string|max:255',
            'type_id' => 'required|exists:types,id',
            'bank_id' => 'required|exists:banks,id',
            'mount' => 'required|numeric|min:0',
            'dateTransfer' => 'nullable|date',
            'numberAccount' => 'required|string|max:255',
            'numberOperation' => 'required|string|unique:transfers,numberOperation',
        ];
    }
    public  function  failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        return redirect()->route('transfers.createtransfer')
            ->withInput()
            ->withErrors($errors);
    }
}
