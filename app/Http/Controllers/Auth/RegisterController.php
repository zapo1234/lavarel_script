<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        //

        return redirect('register');
    }

    protected function validator(array $data)
    
    {

        $messages = [
			'name.max' => 'Votre prénom ne peut avoir plus de :max caractères.',
			'name.required' => 'Vous devez saisir votre prénom.',
			'email.unique' => 'Cette adresse email est déjà utilisée.',
			'email.email' => 'Le format de votre adresse email n\'est pas correct.',
			'email.required' => 'Vous devez saisir une adresse email valide.',
			'password.min' => 'Votre mot de passe doit contenir au moins :min caractères.',
            'password.required' => 'Vous devez saisir un mot de passe.',
            'password.same' => 'vos mots de pass sont pas identiques',
		];


        return Validator::make($data, [
            'name' => ['required', 'string', 'max:55'],
            'email' => ['required', 'string', 'email', 'max:55', 'unique:users'],
            'password' => 'min:5|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:5',
        ],$messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
