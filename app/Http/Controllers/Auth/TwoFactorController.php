<?php
namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class TwoFactorController extends Controller
{

    public function verifySecurity(){
        if(!session('two_factor_auth'))
            return redirect('/home');
        
        return view('auth.verify_security');
    }

    public function postVerifySecurity(Request $request){

        $two_factor_auth = $request->input('two_factor_auth');

        if($two_factor_auth == '' || $two_factor_auth != session('two_factor_auth'))
            return response()->json(['message' => trans('messages.invalid_two_factor_auth_code'),'status' => 'error']);

        if($two_factor_auth == session('two_factor_auth')){
            session()->forget('two_factor_auth');
            return response()->json(['status' => 'success','redirect' => '/home']);
        }
    }
}