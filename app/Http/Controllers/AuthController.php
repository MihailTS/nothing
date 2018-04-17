<?php
namespace App\Http\Controllers;
use DB;
use Socialite;
use Illuminate\Http\Request;
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
        $user = Socialite::driver('google')->stateless()->user();
        $proxy = Request::create(
            '/oauth/token',
            'POST',
            [
                'grant_type' => 'social',
                'client_id' => self::CLIENT_ID,
                'client_secret' => $this->clientSecret,
                'network' => 'google',
                'access_token' => $user->token,
            ]
        );
        return app()->handle($proxy);
    }
}