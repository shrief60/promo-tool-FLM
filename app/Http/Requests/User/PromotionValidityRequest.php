<?php

namespace App\Http\Requests\User;

use App\Http\DataTransferObjects\User\OrderDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PromotionValidityRequest extends FormRequest
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
            'promo_code' => 'required|string',
            'price' => 'required|numeric',
        ];
    }

    public function failedValidation(Validator $validator) : void
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    } 

    public function toDto() : OrderDto
    {
        return new OrderDto([
            'promo_code' => $this->promo_code,
            'price' => $this->price,
            'user_id' => $this->user_id,
        ]);
    }
}
