<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class QuotationRequest extends FormRequest
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
        $quotation_id = $this->route('id');
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'customer_id' => 'required',
                    'quotation_number' => 'required|numeric|unique:quotations,quotation_number',
                    'reference_number' => 'sometimes|unique:quotations',
                    'date' => 'required|date',
                    'expiry_date' => 'required|after:date',
                    'item_type' => 'required',
                    'currency_id' => 'required',
                    'subtotal_tax_amount' => 'numeric',
                    'subtotal_discount_amount' => 'numeric',
                    'subtotal_shipping_and_handling_amount' => 'numeric',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'customer_id' => 'required',
                    'quotation_number' => 'required|numeric|unique:quotations,quotation_number,'.$quotation_id.',id',
                    'reference_number' => 'sometimes|unique:quotations,reference_number,'.$quotation_id.',id',
                    'date' => 'required|date',
                    'expiry_date' => 'required|after:date',
                    'item_type' => 'required',
                    'currency_id' => 'required'
                ];
            }
            default:break;
        }
    }

    public function attributes()
    {
        return[
        'date' => 'quotation date',
        'customer_id' => 'customer',
        'currency_id' => 'currency'
        ];

    }
}
