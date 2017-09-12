<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class CouponRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $coupon = $this->route('coupon');
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                $rules = [
                    'code' => 'required|unique:coupons,code',
                    'discount' => 'required|numeric|min:1',
                    'valid_from' => 'required|date',
                    'valid_to' => 'required|date|after:valid_from',
                    'maximum_use_count' => 'numeric|min:1'
                ];
                return $rules;
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'code' => 'required|unique:coupons,code,'.$coupon->id,
                    'discount' => 'required|numeric|min:1',
                    'valid_from' => 'required|date',
                    'valid_to' => 'required|date|after:valid_from',
                    'maximum_use_count' => 'numeric|min:1'
                ];
            }
            default:break;
        }
    }
}
