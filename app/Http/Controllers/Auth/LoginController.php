<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;
use Session;
use Illuminate\Support\Facades\DB;
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
    protected $redirectTo = 'dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function login(Request $request)
    {


        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // This section is the only change
        if ($this->guard()->validate($this->credentials($request))) 
        {
            $user = $this->guard()->getLastAttempted();

            // Make sure the user is active $user->status== "1" &&
            if ($this->attemptLogin($request) && $user->status == 1) 
            {
                // Send the normal successful login response
                $msg = env('MSG_USER_LOGGEDIN');         
                return redirect('admin/dashboard')->withLoginSuccess( $msg );                
            } 
            elseif ($this->attemptLogin($request) && $user->status == 2) 
            {
                Auth::logout();
                $msg = env('MSG_USER_NOTACTIVE');
                return \Redirect::back()->withLoginFailed( $msg);
            }
            else 
            {              
                Auth::logout();
                $msg = env('MSG_INVALID_LOGIN');
                 return \Redirect::back()->withLoginFailed( $msg);
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    

        //  if ($request->isMethod('post')) {
             
        //      $email = $request->email;
        //      $password = $request->password;
        //      $this->validateLogin($request);
        //      //$credentials = $request->only('email', 'password');
        //      if (Auth::attempt(['email' => $email, 'password' => $password, 'status'=>1])) {
        //       //if (Auth::attempt($credentials)) {         
        //           $msg = env('MSG_USER_LOGGEDIN');         
        //           return redirect('admin/dashboard')->withLoginSuccess( $msg );                
        //       }else {
        //          $msg = env('MSG_INVALID_LOGIN');
        //          return \Redirect::back()->withLoginFailed( $msg);
        //       }            
        // }

        
    
    }

     public function logout()
    {
        Auth::logout();
        $msg = env('MSG_USER_LOGGEDOUT');
        return redirect('/login')->withLogoutSuccess( $msg ); 
    }


    public function checkemail(\Illuminate\Http\Request $request)
    {
       

        
        if ($request->isMethod('post')) {
            $valid = true;
            $message = '';
            $email = $request->email;
            
            $user = DB::table('users')->where(['email'=> $email,'status'=>1])->first();

            if(empty($user)){
                $valid = false;
                $message = 'Email not found in system';                
            }
            
            $response = array('valid' => $valid,'message' => $message);
            echo json_encode($response);
            exit;
        
        }
        
    }
}
