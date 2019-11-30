<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class OrderController extends Controller
{
    public function show($orderId)
    {
        $order = Order::findOrFail($orderId);

        if (\Auth::user()->cannot('read', $order)) {
            abort(403);
        }

        return view('receipt')->with([
            'order' => $order,
        ]);
    }
}
