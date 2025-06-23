<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorCardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'delivery_address' => 'required|string|max:255',
            'phone' => 'required|digits_between:10,15',
            'payment_method' => 'required|in:COD,visa',
            // Required if card payment
            'card_name'   => 'required_if:payment_method,card|string|max:100',
            'card_number' => 'required_if:payment_method,card|digits:16',
            'expiry_date' => 'required_if:payment_method,card|date_format:m/y|after:today',
            'ccv'         => 'required_if:payment_method,card|digits:3',

        ];
    }
}
