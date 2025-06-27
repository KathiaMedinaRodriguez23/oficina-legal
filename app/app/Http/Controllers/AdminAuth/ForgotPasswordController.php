<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        return view('admin.auth.passwords.email');
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('admins');
    }

    public function sendResetLinkEmail(Request $request) {

        $validate = Validator::make($request->all(), [
            'email' => 'required|email|exists:admins,email',
        ], [
            'email.required' => 'Ingrese un correo electrónico.',
            'email.email' => 'Correo electrónico no válido.',
            'email.exists' => 'El correo electrónico no está registrado.',
        ]);

        if ($validate->fails()) {
            return redirect()->back()
                ->withErrors($validate)
                ->withInput()
                ->with('error', $validate->errors()->first());
        }

        try {
            $client = new Client();
            $response = $client->post(env('MS_FORGET_PASSWORD').'/send-url-forgot-password', [
                'json' => [
                    'email' => $request->email,
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                ],
            ]);

            $body = json_decode($response->getBody()->getContents(), true);
            if($response->getStatusCode() != 200) {
                return redirect()->back()
                    ->with('error', 'Error al enviar el enlace de restablecimiento de contraseña: ' . $body['message']);
            }
            return redirect()->back()
                ->with('success', 'Enlace de restablecimiento de contraseña enviado a su correo electrónico.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al enviar el enlace de restablecimiento de contraseña: ' . $e->getMessage());
        }
    }
}
