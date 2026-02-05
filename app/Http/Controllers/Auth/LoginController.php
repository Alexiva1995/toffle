<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Crypt;

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

    // use AuthenticatesUsers;

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

    public function login(Request $request): RedirectResponse
    {
        $fields = [
            "email" => ['required'],
            "password" => ['required'],
        ];

        $msj = [];

        $this->validate($request, $fields, $msj);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $this->remember($request->remember, $request->email, $request->password);
            return redirect('/');
        }else{         
            return back()->with('danger', $this->msgError($request->email, $request->password));
        }
    }

    public function msgError(?string $email, ?string $password): string
    {
        $msg_error= '';
        $validator_password;
        $user = User::where('email', $email)->first();
        if ($user != null) {
            $user_token = Crypt::decrypt($user->token_crypt);
            $validator_password = ($user_token != $password ? false : '');
        }else{
            $validator_password = false;
        }

        // if (User::where('email', $email)->exists() == null && $validator_password == false) {
        //     $msg_error= 'Correo y Contraseña Incorrectos.';
        // }
        
        if (User::where('email', $email)->exists() == null){
            $msg_error= 'El Correo es Incorrecto.';
        }else if($validator_password == false){
            $msg_error= 'La Contraseña es Incorrecta.';
        }

        return $msg_error;
    }

    public function remember(mixed $remember, ?string $email, ?string $password): void
    {
        if ($remember) {
            session([
                'remember' => '1',
                'email' => $email,
                'password'=> $password
            ]);
        }else{
            session([
                'remember' => '0'
            ]);
            session()->forget('email');
            session()->forget('password');
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        return redirect()->route('login')->with('success', 'Sesión Finalizada');
    }

    // Login
    public function showLoginForm(): View
    {
      $pageConfigs = [
          'bodyClass' => "bg-full-screen-image",
          'blankPage' => true
      ];

      return view('/auth/login', [
          'pageConfigs' => $pageConfigs
      ]);
    }
}
