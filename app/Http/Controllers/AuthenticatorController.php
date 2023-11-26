<?php

namespace App\Http\Controllers;

use App\Models\User;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Http\Request;

class AuthenticatorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function enable2fa()
    {
        $user = auth()->user()->secret_2fa_key;
        if($user == null)
        {
            // Initialize the 2FA class
            $google2fa = app('pragmarx.google2fa');

            //generate new secret
            $secret = $google2fa->generateSecretKey();

            // generate the QR image. This is the image the user will scan with their app: 
            $qrImg = $google2fa->getQRCodeInline(
                $secret,
                config('app.name'),
                auth()->user()->email,
            );
            return view('auth.google.enable_2fa', compact('secret', 'qrImg'));
        }
        else
        {
            return view('auth.google.authenticate_2fa');
        }
    }

    public function storeEnable2fa(Request $request)
    {
        $request->validate([
            'secret_2fa_key' => 'required',
        ]);

        $user = User::find(auth()->user()->id);
        $user->secret_2fa_key = $request->secret_2fa_key;
        $user->update();

        return redirect()->route('home')->with('success', '2FA has been enabled successfully.');
    }


    public function verifySecretKey(Request $request) 
    {
        $user = auth()->user();
        $google2fa = app('pragmarx.google2fa');
        $valid = $google2fa->verifyKey($user->secret_2fa_key, $request->input('one_time_password'));
        if($valid)
        {
            $request->session()->put('2fa:user:id', $user->id);
            return redirect()->route('home');
        }
        else
        {
            return redirect()->back()->with('error', 'Invalid OTP, Please try again.');
        }
    }
}
