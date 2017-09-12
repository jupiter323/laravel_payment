<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
        $invoice_id = $this->route('id');
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
                    'invoice_number' => 'required|numeric|unique:invoices,invoice_number',
                    'reference_number' => 'sometimes|unique:invoices',
                    'date' => 'required|date',
                    'due_date' => 'required',
                    'due_date_detail' => 'required_if:due_date,due_on_date|date|after:date',                   
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
                    'invoice_number' => 'required|numeric|unique:invoices,invoice_number,'.$invoice_id.',id',
                    'reference_number' => 'sometimes|unique:invoices,reference_number,'.$invoice_id.',id',
                    'date' => 'required|date',
                    'due_date' => 'required',
                    'due_date_detail' => 'required_if:due_date,due_on_date|date|after:date',
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
        'date' => 'invoice date',
        'due_date_detail' => 'specified due date',
        'customer_id' => 'customer',
        'currency_id' => 'currency'
        ];

    }
}
