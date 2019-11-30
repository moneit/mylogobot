<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Account;

class AccountController extends Controller
{
    public function get()
    {
        try {
            return $this->response([
                'status' => 'success',
                'payload' => Account::where('user_id', '=', \Auth::id())->with(['country'])->firstOrFail(),
            ]);
        } catch(\Exception $e) {
            return $this->response([
                'status' => 'failure',
                'payload' => [
                    'message' => $e->getMessage()
                ],
            ]);
        }
    }
}
