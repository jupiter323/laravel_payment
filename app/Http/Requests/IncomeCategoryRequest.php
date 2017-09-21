<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class IncomeCategoryRequest extends FormRequest
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
        $income_category = $this->route('income_category');
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
                    'name' => 'required|unique:income_categories,name'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|unique:income_categories,name,'.$income_category->id
                ];
            }
            default:break;
        }
    }
}
