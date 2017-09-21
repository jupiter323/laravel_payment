<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
        $account = $this->route('account');
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
                    'name' => 'required|unique:accounts,name',
                    'opening_balance' => 'required|numeric|min:0',
                    'number' => 'required_if:type,bank',
                    'bank_name' => 'required_if:type,bank',
                    'branch_name' => 'required_if:type,bank'
                ];
                return $rules;
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required|unique:accounts,name,'.$account->id,
                    'opening_balance' => 'required|numeric|min:0',
                    'number' => 'required_if:type,bank',
                    'bank_name' => 'required_if:type,bank',
                    'branch_name' => 'required_if:type,bank'
                ];
            }
            default:break;
        }
    }
}
