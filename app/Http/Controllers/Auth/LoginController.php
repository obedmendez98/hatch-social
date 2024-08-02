<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\OAuth;
use App\Models\User;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Validator;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function admin(Request $request)
    {
        try{
            Log::info('Cliente de Stripe creado para el usuario: 1');

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 400);
            }

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            Stripe::setApiKey(env('STRIPE_SECRET'));

            if (!$user->customer_id) {
                try {
                    $customer = Customer::create([
                        'email' => $user->email,
                        'name' => $user->name,
                    ]);

                    $user->customer_id = $customer->id;
                    $user->save();
                } catch (\Exception $e) {
                    return response()->json(['error' => 'No se pudo crear el cliente de Stripe: ' . $e->getMessage()], 500);
                }
            }

            return response()->json(['message' => 'Stripe customer ID updated successfully', 'stripe_customer_id' => $user->customer_id], 200);

            /*$validator = Validator::make($request->all(),[
                'email' => 'required|email|exists:users',
                'password'=>'required'
            ]);
            Log::info('Cliente de Stripe creado para el usuario:2');

            if($validator->fails())
            {
                Log::info('Cliente de Stripe creado para el usuario:3 ');
                return redirect()->back()->with(['error'=>$validator->errors()->first()]);
            }
            Log::info('Cliente de Stripe creado para el usuario:4 ');

            if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])) {
                $user = Auth::user();
                Log::info('Cliente de Stripe creado para el usuario: ' . $user->id);

                // Configurar Stripe
                Stripe::setApiKey(env('STRIPE_SECRET'));

                // Verificar si el usuario ya tiene un cliente de Stripe
                if (!$user->stripe_customer_id) {
                    try {
                        
                        $customer = Customer::create([
                            'email' => $user->email,
                            'name' => $user->name,
                        ]);

                        $user->stripe_customer_id = $customer->id;
                        $user->save();
                    } catch (\Exception $e) {

                        return redirect()->back()->with('error', 'No se pudo crear el cliente de Stripe: ' . $e->getMessage());
                    }
                }


                if($user->role == 'admin'){

                    return redirect()->route('dashboard');
                } else {
                    
                }
            }else{
                return back()->with(['error'=>'Invalid Credentials']);
            } */
        }catch(\Exception $e){
            return redirect()->back()->with(['error'=>$e->getMessage()]);
        }
    }

    public function redirectToStripe()
    {
        $url = OAuth::authorizeUrl([
            'response_type' => 'code',
            'scope' => 'read_write',
            'client_id' => env('STRIPE_CLIENT_ID'),
        ]);

        return redirect($url);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }


}
