<?php
/**
 * Created by PhpStorm.
 * User: rafael
 * Date: 29/08/17
 * Time: 07:42
 */

namespace App\Http\Controllers;

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

    public function process(){

        $profileId = $_GET['profileid'];
        $profile = Profile::find($profileId);
        $date = new \DateTime();
        $data['profile'] = $profile;
        $notification = new \stdClass();
        $notification->subject = "Nueva Factura";
        $notification->message = "Enviamos su nueva factura";
        $data['notification'] = $notification;
        $fileContent = view('txt_templates.base32', $data);


        $xsaDomain = env("XSA_DOMAIN");
        $xsaRfc = env("XSA_RFC");
        $xsaKey = env("XSA_KEY");

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
