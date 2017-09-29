<?php
/**
 * Created by PhpStorm.
 * User: rafael
 * Date: 29/08/17
 * Time: 07:42
 */

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

class BillingWizardController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){
        //generando vista del asistente
        return \Illuminate\Support\Facades\View::make('billing_wizard/wizard');
    }

    public function getCustomerByTaxid($taxid){
        $response = new \stdClass();
        $customer = Profile::where('tax_id','=',$taxid)->first();
        if($customer){
            $response->status = "ok";
            $response->data = $customer;
        }
        else{
            $response->status = "not_found";
            $response->message = "NO se encontro el RFC";
        }

        echo json_encode($response);

    }
}
