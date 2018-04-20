<?php
namespace App\Http\Controllers;
use App\Auth\SocialUserResolver;
use Auth;
use DB;
use Socialite;

class AuthController extends Controller
{
    private const CLIENT_ID = 2;
    private $clientSecret;

    public function __construct()
    {
        $client = DB::table('oauth_clients')->
            where('id', self::CLIENT_ID)->first();
        $this->clientSecret = $client->secret;
    }

    public function redirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }
    public function callback()
    {
        $authUser = Socialite::driver('google')->stateless()->user();
        $user=SocialUserResolver::findOrCreateBySocialField($authUser);
        Auth::login($user);
        return redirect('/');
    }
}