<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class ItemPriceRequest extends FormRequest
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
        $item_price = $this->route('item_price');
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
                    'item_id' => 'required|unique_with:item_prices,currency_id',
                    'currency_id' => 'required',
                    'unit_price' => 'required|numeric|min:0'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'item_id' => 'required|unique_with:item_prices,currency_id,'.$item_price->id,
                    'currency_id' => 'required',
                    'unit_price' => 'required|numeric|min:0'
                ];
            }
            default:break;
        }
    }

    public function attributes(){
        return [
            'item_id' => 'item',
            'currency_id' => 'currency'
        ];
    }
}
