<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class ShipmentRequest extends FormRequest
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
        $shipment_address = $this->route('shipment_address');
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
                    'shipment_address' => 'required|unique:shipment,shipment_address',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'shipment_address' => 'required|unique:shipment,shipment_address,'.$shipment_address->id,
                ];
            }
            default:break;
        }
    }
}
