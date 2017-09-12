<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
        $branch = $this->route('branch');
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
                    'branch_name' => 'required|unique:branch,branch_name',
                    'email' => 'required|email'
                ];
                return $rules;
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'branch_name' => 'required|unique:branch,branch_name,'.$branch->id,
                    'email' => 'required|email'
                ];
            }
            default:break;
        }
    }
}
