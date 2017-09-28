<?php
/**
 * Created by PhpStorm.
 * User: rafael
 * Date: 29/08/17
 * Time: 07:42
 */

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\View\View;

class AsistenteFacturacionController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){
        //generando vista del asistente
        return \Illuminate\Support\Facades\View::make('asistente_facturacion/asistente');
    }
}
