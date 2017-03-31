<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
         $user = Socialite::with('azure')->user();
      } catch (Exception $e){
         return redirect('auth/azure');
      }

      $authUser = $this->findOrCreateUser($user);

      Auth::login($authUser, true);
      //dd($user);

      return redirect()->action('HomeController@index');
    }

    private function findOrCreateUser($azureUser)
    {
      $authUser = User::where('azure_id', $azureUser->id)->first();

      if($authUser){
         return $authUser;
      }

      return User::create([
         'name' => $azureUser->name,
         'email' => $azureUser->email,
         'azure_id' => $azureUser->id,
      ]);
    }


}
