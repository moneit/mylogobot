<?php

namespace App\Http\Controllers;


class AdminController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function loginUsingId($userId)
    {
        \Auth::loginUsingId($userId);

        return redirect()->route('my_account');
    }
}
