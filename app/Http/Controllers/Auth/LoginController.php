<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Redirect;
// use Illuminate\Http\Request;
use Socialite;
use Auth;
use App\User;

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
    protected $redirectTo = 'home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function redirectToProvider()
    {
      return Socialite::with('azure')->redirect();
    }

    public function handleProviderCallback()
    {
      try {
         $azureUser = Socialite::with('azure')->user();
      } catch (Exception $e){
         return redirect('auth/azure');
      }

      $authUser = $this->findOrCreateUser($azureUser);
      
      $yep = 'yep';
      $nope = 'nope';
      
      if($authUser->active){
         Auth::login($authUser, true);

         return redirect()->intended('home');
      }
      
      return Redirect::route('activation');

      
    }

    private function findOrCreateUser($user)
    {
      $authUser = User::where('azure_id', $user->id)->first();

      if($authUser){
         return $authUser;
      }

      return User::create([
         'name' => $user->name,
         'email' => $user->email,
         'azure_id' => $user->id,
      ]);
    }


}
