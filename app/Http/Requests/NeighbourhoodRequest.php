<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class NeighbourhoodRequest extends FormRequest
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
        $company = $this->route('neighbourhood');
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
                    'name' => 'required|unique:neighbourhood,name',
                    
                ];
                return $rules;
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|unique:neighbourhood,name,'.$neighbourhood->id,
                   
                ];
            }
            default:break;
        }
    }
}
