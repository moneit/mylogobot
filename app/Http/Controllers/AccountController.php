<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Account\UpdateRequest as AccountUpdateRequest;
use App\Account;
use App\Country;
use App\Order;

class AccountController extends Controller
{
    public function get($tab = NULL)
    {
        return view('my_account')->with([
            'tab' => $tab,
            'user' => \Auth::user(),
            'orders' => Order::where('user_id', \Auth::id())->with(['package', 'currencySymbol'])->get(),
        ]);
    }

    public function update(AccountUpdateRequest $request)
    {
        $user = [
            'name' => $request->get('name'),
            'email' => $request->get('email'),
        ];
        if (!empty($request->get('password'))) {
            $user['password'] = Hash::make($request->get('password'));
        }
        \Auth::user()->update($user);

        $account = [];
//        if (!empty($request->get('country'))) { // remove validation to erase values in table
            $country = $request->get('country');
            $countryId = Country::where('name', $country)->firstOrFail()->id;
            $account['country_id'] = $countryId;
//        }
//        if (!empty($request->get('vat'))) {
            $vat = $request->get('vat');
            $account['vat'] = $vat;
//        }
//        if (!empty($request->get('state'))) {
            $state = $request->get('state');
            $account['state'] = $state;
//        }
//        if (!empty($request->get('city'))) {
            $city = $request->get('city');
            $account['city'] = $city;
//        }
//        if (!empty($request->get('address'))) {
            $address = $request->get('address');
            $account['address'] = $address;
//        }
//        if (!empty($request->get('postal_code'))) {
            $postalCode = $request->get('postal_code');
            $account['postal_code'] = $postalCode;
//        }

//        if (! empty($account)) {
            $userAccount = Account::updateOrcreate(
                ['user_id' => \Auth::id()],
                $account
            );
//        }

        return redirect()->route('my_account');
    }
}
