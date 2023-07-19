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
        ];
    }
    public function messages()
    {
        return [
            'sender.required' => 'حقل المُرسِل مطلوب.',
            'receiver.required' => 'حقل المُستَلِم مطلوب.',
            'type_id.required' => 'حقل النوع مطلوب.',
            'type_id.exists' => 'النوع المُحدد غير صحيح.',
            'bank_id.required' => 'حقل البنك مطلوب.',
            'bank_id.exists' => 'البنك المُحدد غير صحيح.',
            'mount.required' => 'حقل المبلغ مطلوب.',
            'mount.numeric' => 'يجب أن يكون المبلغ رقمًا.',
            'mount.min' => 'يجب أن يكون المبلغ على الأقل :min.',
            'dateTransfer.date' => 'يجب أن يكون حقل التاريخ صحيحًا.',
            'numberAccount.required' => 'حقل رقم الحساب مطلوب.',
            'numberOperation.required' => 'حقل رقم العملية مطلوب.',
            'numberOperation.string' => 'يجب أن يكون رقم العملية نصًا.',
            'numberOperation.unique' => 'رقم العملية تم استخدامه بالفعل.',
            'name.required' => 'حقل الاسم مطلوب.', // Custom error message for the 'name' field
        ];
    }

}
