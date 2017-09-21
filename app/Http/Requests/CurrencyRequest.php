<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
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
        $currency = $this->route('currency');
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
                    'name' => 'required|unique:currencies,name',
                    'symbol' => 'required|unique:currencies,symbol',
                    'position' => 'required',
                    'decimal_place' => 'required|numeric|min:0|max:5'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|unique:currencies,name,'.$currency->id,
                    'symbol' => 'required|unique:currencies,symbol,'.$currency->id,
                    'position' => 'required',
                    'decimal_place' => 'required|numeric|min:0|max:5'
                ];
            }
            default:break;
        }
    }
}
