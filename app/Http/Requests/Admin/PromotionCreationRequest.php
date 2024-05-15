<?php

namespace App\Http\Requests\Admin;

use App\Http\DataTransferObjects\Admin\PromoCreationRequestDto;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PromotionCreationRequest extends FormRequest
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
            'promo_code' => 'required|string|unique:promotions',
            'type' => 'required|string|in:percentage,value',
            'title' => 'required|string',
            'desc' => 'required|string',
            'reference_value' => 'required|numeric',
            'user_segment' => 'required|string|in:all,specific',
            'expiry_date' => 'required|date|date_format:Y-m-d H:i:s|after:now',
            'max_usage_times' => 'required|numeric',
            'max_usage_times_per_user' => 'required|numeric',
            'users' => 'required|array',
        ];
    }

    public function failedValidation(Validator $validator) : void
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    } 

    public function toDto() : PromoCreationRequestDto
    {
        return new PromoCreationRequestDto([
            'promo_code' => $this->promo_code,
            'type' => $this->type,
            'title' => $this->title ?? null,
            'desc' => $this->desc ?? null,
            'reference_value' => $this->reference_value,
            'user_segment' => $this->user_segment,
            'expiry_date' => $this->expiry_date,
            'max_usage_times' => $this->max_usage_times,
            'max_usage_times_per_user' => $this->max_usage_times_per_user,
            'users' => $this->users,
        ]);
    }
}
