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
        return true;
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
            'phone_number' => 'required|digits_between:10,15',
            'payment_method' => 'required|in:COD,visa',
            // Required if visa payment
            'holder_name'   => 'required_if:payment_method,visa|string|max:100',
            'card_number' => 'required_if:payment_method,visa|digits:16',
            'expiry_date' => 'required_if:payment_method,visa|date_format:m/y|after:today',
            'ccv'         => 'required_if:payment_method,visa|digits:3',
        ];
    }
    public function messages(): array
{
    return [

        
        'delivery_address.required' => 'The delivery address is required.',
        'delivery_address.string'   => 'The delivery address must be a valid Address.',

        'phone_number.required'            => 'The phone number is required.',
        'phone_number.digits_between'      => 'The phone number must be between 10 and 15 digits.',

        'payment_method.required'   => 'The payment method is required.',
        'payment_method.in'         => 'The selected payment method must be either COD or Visa.',

        'holder_name.required_if'     => 'The cardholder name is required when using Visa.',
        'holder_name.max'             => 'The cardholder name may not be greater than 100 characters.',

        'card_number.required_if'   => 'The card number is required when using Visa.',
        'card_number.digits'        => 'The card number must be exactly 16 digits.',

        'expiry_date.required_if'   => 'The expiry date is required when using Visa.',
        'expiry_date.date_format'   => 'The expiry date must be in the format MM/YY.',
        'expiry_date.after'         => 'The expiry date must be a future date.',

        'ccv.required_if'           => 'The CCV is required when using Visa.',
        'ccv.digits'                => 'The CCV must be exactly 3 digits.',
    ];
}

}
