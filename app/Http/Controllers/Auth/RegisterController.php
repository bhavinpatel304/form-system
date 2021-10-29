<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

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
    protected $redirectTo = '/dashboard';

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
    protected function validator(array $data)
    {
        $rules = [
            'fname' => ['required', 'string'],
            'lname' => ['required', 'string'],
            'email' => ['required', 'string', 'email',  'unique:users'],
            'password' => ['required', 'string', 'min:8'],           
        ];

        $messages = [
            'fname.required'=>'Please enter first name.',
            'lname.required'=>'Please enter last name.',
            'email.required'=>'Please enter email address.',
            'email.email'=>'Please enter valid email address.',
            'email.unique'=>'This email has already been taken.',
            'password.required'=>'Please enter password.',
            'password.min'=>'Password must be minimum 8 characters long.',
        ];
        return Validator::make($data, $rules,$messages  );
        
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        
        // return User::create([
        //     'fname' => $data['fname'],
        //     'lname' => $data['lname'],
        //     'email' => $data['email'],
        //     'password' => Hash::make($data['password']),
        //     'created_at' => new \DateTime(),
        //     'updated_at' => new \DateTime(),
        // ]);
    }
}
