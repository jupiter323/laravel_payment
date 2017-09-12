<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
        $item = $this->route('item');
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
                    'item_category_id' => 'required',
                    'name' => 'required|unique:items',
                    'code' => 'required|unique:items',
                    'taxation_id' => 'required',
                    'discount' => 'required|numeric',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'item_category_id' => 'required',
                    'name' => 'required|unique:items,name,'.$item->id.',id',
                    'code' => 'required|unique:items,code,'.$item->id.',id',
                    'taxation_id' => 'required',
                    'discount' => 'required|numeric'
                ];
            }
            default:break;
        }
    }

    public function attributes(){
        return [
            'item_category_id' => 'item category',
            'taxation_id' => 'taxation'
        ];
    }
}
