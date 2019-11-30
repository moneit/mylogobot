<?php

namespace App\Http\Controllers\Auth;

use App\Country;
use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Auth\Events\Registered;
use Laravel\Socialite\Facades\Socialite;
use Mpociot\VatCalculator\VatCalculator;

class SocialAuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Redirect the user to the authentication page that the user chose.
     *
     * @param String
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider($provider)
    {
        $refererSegments = explode('/', request()->headers->get('referer'));
        $refererPath = array_pop($refererSegments);
        if ('recommendations' === $refererPath) {
            \Cache::put('redirectToRecommendation', 'yes', 3);
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @param String
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {

        try {
            $user = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            return redirect('/?signin=true');
        }

        try {
            $existingUser = User::where('email', $user->email)->first();

            if($existingUser){
                // log in
                auth()->login($existingUser, true);
            } else {
                // create a new user
                $newUser                    = new User;
                $newUser->name              = $user->name;
                $newUser->email             = $user->email;
                $newUser->provider          = $provider;
                $newUser->provider_id       = $user->id;
                $newUser->api_token         = uniqid(base64_encode(str_random(30)));
                $newUser->save();

                event(new Registered($newUser));

                $country = Country::where('code', (new VatCalculator())->getIPBasedCountry())->firstOrFail(); // todo: catch exception, send notification
                event(new UserRegistered($newUser, $country));

                auth()->login($newUser, true);
            }
        } catch(\Exception $e) {
            \Log::error('Error happened in social auth', [$e->getMessage()]);
        }

        if (\Cache::get('redirectToRecommendation') === 'yes') {
            \Cache::put('redirectToRecommendation', 'no');

            return redirect()->route('recommendation');
        }

        return redirect()->intended('my-account');
    }
}
