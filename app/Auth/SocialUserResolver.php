<?php
namespace App\Auth;
use App\User;
use Auth;
use Debugbar;
use Log;
use Socialite;
use Adaojunior\Passport\SocialGrantException;
use Adaojunior\Passport\SocialUserResolverInterface;
class SocialUserResolver implements SocialUserResolverInterface
{
    public function resolve($network, $token, $accessTokenSecret = null)
    {
        switch ($network) {
            case 'google':
                return $this->google($token);
                break;
            default:
                throw SocialGrantException::invalidNetwork();
                break;
        }
    }
    public function google(string $token)
    {
        $user = Socialite::driver('google')->userFromToken($token);
        return self::findOrCreateBySocialField($user);
    }
    public static function findOrCreateBySocialField($user, $socialField = 'google_id') : User
    {
        return User::firstOrCreate([$socialField => $user->id], [
            'name' => $user->name,
            'email' => $user->email,
            $socialField => $user->id,
            'language' => $user->user['language']
        ]);
    }
}