<?php

namespace App\Http\Controllers\Auth;

use App\Country;
use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/my-account';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
//            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
//            'country' => ['required', 'string', 'exists:countries,name'],
//            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $tempPwd = isset($data['password']) ? $data['password'] : str_random(10);

        return User::create([
            'name' => isset($data['name']) ? $data['name'] : '',
            'email' => $data['email'],
            'password' => Hash::make($tempPwd),
            'temp_pwd' => $tempPwd,
            'api_token' => uniqid(base64_encode(str_random(30))),
        ]);
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        $country = null;
        if ($request->has('country')) {
            $country = Country::where('name', $request->get('country'))->firstOrFail(); // todo: catch exception, send notification
        }
        event(new UserRegistered($user, $country));

        $refererSegments = explode('/', request()->headers->get('referer'));
        $refererPath = array_pop($refererSegments);
        if ('recommendations' === $refererPath) {
            return redirect()->route('recommendation');
        }

        return redirect()->intended($this->redirectPath());
    }
}
