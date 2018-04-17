<?php
namespace App\Auth;
use App\User;
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
        return $this->findOrCreate($user);
    }
    protected function findOrCreate($user) : \Illuminate\Database\Eloquent\Model
    {
        /** @var User $model */
        return User::firstOrCreate(['google_id' => $user->id], [
            'name' => $user->name,
            'email' => $user->email,
            'google_id' => $user->id,
            'language' => $user->user['language']
        ]);
    }
}