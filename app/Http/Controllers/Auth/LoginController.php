<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use \App\User;
use Socialite;
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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function destroy()
    {
       Auth::logout();
       return redirect('/');
    }

    public function store()
    {
       if(!Auth::attempt(request(['email','password']))) {
            return back();
       }
       else{
            if(Auth::user()->role == 'admin'){
                return redirect('/admin');
            }
       }
    }

    public function redirectToProvider()
    {
        return Socialite::driver('facebook')->stateless()->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('facebook')->stateless()->user();
        if($user->email){
            if(sizeof(User::where('email','=',$user->email)->get()) > 0){
                $user = User::where('email','=',$user->email)->get();
                $user = User::find($user[0]['id']);
                $user->login_with = 1;
                $user->save();
                if($user){
                    Auth::login($user);
                    if(Auth::user()->role == 'admin'){
                        return redirect('/admin');
                    }
                    return redirect('/');
                 }
            }
            else{
                $user = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => bcrypt($user->id),
                    'role' => 'non-student',
                    'login_with' => 1,
                ]);

                if($user){
                    Auth::login($user);
                    if(Auth::user()->role == 'admin'){
                        return redirect('/admin');
                    }
                    return redirect('/');
                }
            }
                 
        }
        return back()->withErrors(array('message' => 'User email is not public.Please try with another account.'));
        
    }

    public function redirectToLinkedinProvider()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    public function handleProviderLinkedinCallback()
    {
        $user = Socialite::driver('linkedin')->user();
        if($user->email){
            if(sizeof(User::where('email','=',$user->email)->get()) > 0){
                $user = User::where('email','=',$user->email)->get();
                $user = User::find($user[0]['id']);
                $user->login_with = 2;
                $user->save();
                if($user){
                    Auth::login($user);
                    if(Auth::user()->role == 'admin'){
                        return redirect('/admin');
                    }
                    return redirect('/');
                 }
            }
            else{
                $user = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'password' => bcrypt($user->id),
                    'role' => 'non-student',
                    'login_with' => 2,
                ]);

                if($user){
                    Auth::login($user);
                    if(Auth::user()->role == 'admin'){
                        return redirect('/admin');
                    }
                    return redirect('/');
                }
            }
                 
        }
        return back()->withErrors(array('message' => 'User email is not public.Please try with another account.'));
        
    }


}
