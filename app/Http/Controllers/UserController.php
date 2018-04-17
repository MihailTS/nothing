<?php
namespace App\Http\Controllers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Laravel\Socialite\Facades\Socialite;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function testSocial(Request $request){
        return Socialite::driver('google')->stateless()->with(["access_type" => "offline", "prompt" => "consent select_account"])->redirect();
    }
    public function testSocialHandle(Request $request){
        $user = Socialite::driver('google')->stateless()->user();
        var_dump($user);
        return 123;
    }
    public function refreshTest(Request $request){
        $client = new \Google_Client;
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->refreshToken($request->get('token'));
        $client->setAccessType('offline');
        var_dump($client->getAccessToken());
        return 1235;
    }
    /**
     * Obtain the user information from Facebook.
     *
     * @return JsonResponse
     */
    /*public function testSocialHandle(Request $request)
    {
        // this user we get back is not our user model, but a special user object that has all the information we need
        $providerUser = Socialite::driver('google')->stateless()->user();

        // we have successfully authenticated via facebook at this point and can use the provider user to log us in.

        // for example we might do something like... Check if a user exists with the email and if so, log them in.
        $user = User::query()->firstOrNew(['email' => $providerUser->getEmail()]);

        // maybe we can set all the values on our user model if it is new... right now we only have name
        // but you could set other things like avatar or gender
        if (!$user->exists) {
            $user->name = $providerUser->getName();
            $user->save();
        }

        /**
         * At this point we done.  You can use whatever you are using for authentication here...
         * for example you might do something like this if you were using JWT

        var_dump($user);
        $token = JWTAuth::fromUser($user);

        return new JsonResponse([
            'token' => $token
        ]);
    }*/

    public function testToken(Request $request){
        var_dump(Socialite::driver('google')->stateless()->userFromToken($request->get('token')));
        //$user = $socialite->user($accessToken);
        /*$gClient = new \Google_Client();
        $google_redirect_url = route('glogin');
        $gClient->setApplicationName(config('services.google.app_name'));
        $gClient->setClientId(config('services.google.client_id'));
        $gClient->setClientSecret(config('services.google.client_secret'));
        $gClient->setRedirectUri($google_redirect_url);
        $gClient->setAccessToken($request->get('token'));
        //var_dump($gClient->getAccessToken());
        var_dump($gClient->isAccessTokenExpired());*/
        //$gClient->setDeveloperKey(config('services.google.api_key'));
        /*$gClient->setScopes(array(
            'https://www.googleapis.com/auth/plus.me',
            'https://www.googleapis.com/auth/userinfo.email',
            'https://www.googleapis.com/auth/userinfo.profile',
        ));*/
        //$google_oauthV2 = new \Google_Service_Oauth2($gClient);
        //$gClient->refreshToken("1/4bDBHeBn9MT0KaRPx6ifLnyCHNbCWWgaMsebICSPI0c");
        //$user = Socialite::driver('google')->stateless()->with(["access_type" => "offline", "prompt" => "consent select_account"])->userFromToken($request->get('access_token'));
        //var_dump($user);
        return 1234;
    }
    public function googleLogin(Request $request)  {
        $google_redirect_url = route('glogin');
        $gClient = new \Google_Client();
        $gClient->setApplicationName(config('services.google.app_name'));
        $gClient->setClientId(config('services.google.client_id'));
        $gClient->setClientSecret(config('services.google.client_secret'));
        $gClient->setRedirectUri($google_redirect_url);
        $gClient->setDeveloperKey(config('services.google.api_key'));
        $gClient->setScopes(array(
            'https://www.googleapis.com/auth/plus.me',
            'https://www.googleapis.com/auth/userinfo.email',
            'https://www.googleapis.com/auth/userinfo.profile',
        ));
        $google_oauthV2 = new \Google_Service_Oauth2($gClient);
        if ($request->get('code')){
            $gClient->authenticate($request->get('code'));
            $request->session()->put('token', $gClient->getAccessToken());
        }
        if ($request->session()->get('token'))
        {
            $arToken = $request->session()->get('token');
            $gClient->setAccessToken($arToken);
            var_dump($request->session()->get('token'));
        }
        if ($gClient->getAccessToken())
        {
            //For logged in user, get details from google using access token
            $guser = $google_oauthV2->userinfo->get();

            $request->session()->put('name', $guser['name']);
            var_dump($google_oauthV2->getClient());
            if ($user = User::where('email',$guser['email'])->first())
            {
                //logged your user via auth login
            }else{
                //register your user with response data
            }
            //return redirect()->route('user.glist');
        } else
        {
            //For Guest user, get google login url
            $authUrl = $gClient->createAuthUrl();
            return redirect()->to($authUrl);
        }
    }
    public function listGoogleUser(Request $request){
        $users = User::orderBy('id','DESC')->paginate(5);
        return view('users.list',compact('users'))->with('i', ($request->input('page', 1) - 1) * 5);;
    }
}