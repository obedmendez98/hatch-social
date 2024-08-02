<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\OAuth;
use Stripe\Price;
use Stripe\Checkout\Session;
use App\Models\User;
use Auth;
use Log;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Jenssegers\Agent\Agent;

class StripeConnectController extends Controller
{
    public function redirectToStripe()
    {
        $url = OAuth::authorizeUrl([
            'response_type' => 'code',
            'scope' => 'read_write',
            'client_id' => env('STRIPE_CLIENT_ID'),
        ]);

        return redirect($url);
    }

    public function handleStripeCallback(Request $request)
    {
        // Create an instance of the Agent library
        $agent = new Agent();

        // Check if there is an error in the request
        if ($request->has('error')) {
            // Check if the user is on a mobile device
            if ($agent->isMobile()) {
                // Redirect to a custom URL scheme for mobile devices
                $redirectUrl = 'hatchsocial://login';
            } else {
                // Redirect to a specific page within your website for computers
                $redirectUrl = url('/connect/error?error=access_denied');
            }

            // Redirect to the appropriate URL based on the device type
            return redirect()->to($redirectUrl);
        }

        $user = User::where('email', "cnavarro0321@gmail.com")->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
      
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $response = OAuth::token([
            'grant_type' => 'authorization_code',
            'code' => $request->code,
        ]);

        $stripeUserId = $response->stripe_user_id;

        //Guardar el ID de Stripe en el perfil del usuario
        //$user = Auth::user();
        $user->stripe_id = $stripeUserId;
        $user->save();

        // Check if the user is on a mobile device
        if ($agent->isMobile()) {
            // Redirect to a custom URL scheme for mobile devices
            $redirectUrl = 'hatchsocial://login';
            // Redirect to the appropriate URL based on the device type
            return redirect()->to($redirectUrl);
        } 
        return redirect()->route('login')->with('success', 'Cuenta de Stripe conectada exitosamente.');
    }

    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $user = User::where('email', "cnavarro0321@gmail.com")->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        
        // Verifica que el usuario tenga una cuenta de Stripe conectada
        if (!$user->stripe_id) {
            return response()->json(['error' => 'El usuario no tiene una cuenta de Stripe conectada'], 400);
        }

        try {

            // El ID del precio configurado en el dashboard de Stripe
            $priceId = "price_1PesyKDc3TWlc8ChkUJiCOKY";

            // Definir el porcentaje de la tarifa de aplicación (por ejemplo, 10%)
            $applicationFeePercentage = 10;
            //$amount = 1000; // 10 dólares en centavos
            // Obtener los detalles del precio desde Stripe
            $priceData = Price::retrieve($priceId);
            $amount = $priceData->unit_amount;
            $applicationFeeAmount = ($amount * $applicationFeePercentage) / 100;

            // Calcular la tarifa de aplicación en centavos
            $applicationFeeAmount = ($amount * $applicationFeePercentage) / 100;

            // Crear la sesión de Checkout
            $session = Session::create([
                'line_items' => [[
                    'price' => "price_1PesyKDc3TWlc8ChkUJiCOKY", // Usar el price_id del producto
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => route('auth.success'),
                'cancel_url' => route('auth.cancel'),
                'payment_intent_data' => [
                    'application_fee_amount' => $applicationFeeAmount, // Tarifa de aplicación calculada
                    'transfer_data' => [
                        'destination' => $user->stripe_id,
                    ],
                ],
            ]);
            return redirect($session->url);
            //return response()->json(['id' => $session->id]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function disconnectAccount(Request $request)
    {
        try {
            Log::info('Cliente de Stripe creado para el usuario: 1 ');
            Stripe::setApiKey(env('STRIPE_SECRET'));

            //$user = Auth::user();

            //if (!$user->stripe_account_id) {
                //return redirect()->back()->with('error', 'No hay cuenta de Stripe vinculada.');
            //}
            Log::info('Cliente de Stripe creado para el usuario: 2 ');
            // Revocar el token OAuth
            $response = OAuth::deauthorize([
                'client_id' => env('STRIPE_CLIENT_ID'),
                //'stripe_user_id' => $user->stripe_account_id,
                'stripe_user_id' => "acct_1PLb2jLyCrckxh2j",
            ]);
            Log::info('Cliente de Stripe creado para el usuario: 3 ');
            // Remover el ID de la cuenta de Stripe del perfil del usuario
            //$user->stripe_account_id = null;
            //$user->save();

            return redirect()->route('login')->with('success', 'Cuenta de Stripe desvinculada exitosamente.');
        } catch (\Exception $e) {
            Log::error('Error al desvincular la cuenta de Stripe: ' . $e->getMessage());
            return redirect()->back()->with('error', 'No se pudo desvincular la cuenta de Stripe.');
        }
    }
}
