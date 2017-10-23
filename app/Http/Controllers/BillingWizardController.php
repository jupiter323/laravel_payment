<?php
/**
 * Created by PhpStorm.
 * User: rafael
 * Date: 29/08/17
 * Time: 07:42
 */

namespace App\Http\Controllers;

use App\Company;
use App\Profile;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

class BillingWizardController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index($company_alias){

        //Geting company by alias
        $company = Company::where('alias','=',$company_alias)->first();

        if(!$company){
            $data['title'] = '404';
            $data['name'] = 'Page not found';
            return response()->view('errors.404',$data,404);
        }

        //loading assistant view
        $data['company'] = $company;
        return \Illuminate\Support\Facades\View::make('billing_wizard/wizard',$company);
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

    public function process(){

        $profileId = $_GET['profileid'];
        $companyId = $_GET['company_id'];
        $company = Company::find($companyId);
        $profile = Profile::find($profileId);
        $date = new \DateTime();
        $data['profile'] = $profile;
        $notification = new \stdClass();
        $notification->subject = "Nueva Factura";
        $notification->message = "Enviamos su nueva factura";
        $data['notification'] = $notification;
        $fileContent = view('txt_templates.base32', $data);

        //Setting xsa params by company
        $xsaDomain = $company->xsa_domain;
        $xsaRfc = $company->xsa_rfc;
        $xsaKey = $company->xsa_key;

       $soapWrapper = new SoapWrapper();
        $soapWrapper->add('XSA', function ($service) use ($xsaDomain) {
            $service
                ->wsdl("https://{$xsaDomain}/xsamanager/services/FileReceiverService?wsdl")
                ->trace(true);
        });

        // Without classmap
        $response = $soapWrapper->call('XSA.guardarDocumento', [
            [
                'in0' => $xsaKey."-".$xsaRfc, //key parameter
                'in1' => "DEMO PRUEBA", //empresaOsucursal  parameter
                'in2' => "base32", //tipoDocumento  parameter
                'in3' => "{$profile->tax_id}_base32_".$date->getTimestamp().".txt", //nombreDocumento  parameter
                'in4' => $fileContent //contenidoDocumento parameter
            ]
        ]);

        var_dump($response);

    }

    public function update(){
        if(isset($_GET['id']) &&  $_GET['id'] ){ // El perfil existe
            $profile = Profile::find($_GET['id']);
        }
        else{
            $profile = new Profile();
            unset($_GET['id']);
        }

        foreach($_GET as $field => $value){
            $profile->$field = $value;
        }

        $profile->save();

        $response['data'] = $profile;
        return json_encode($response);
    }
}
