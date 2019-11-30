<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Package;

class PackagesController extends Controller
{
    public function get(Request $request)
    {// todo: update using query search
        $name = $request->get('name', '');
        $id = $request->get('id', '');

        if (! empty($name)) {
            $query = Package::where('name', '=', $name);
            if (! empty($id)) {
                $query = $query->where('id', '=', $id);
            }
        } else {
            if (! empty($id)) {
                $query = Package::where('id', '=', $id);
            } else {
                $query = Package::query();
            }
        }

        return $this->response([
            'status' => 'success',
            'payload' => $query->get(),
        ], 200);
    }

    public function getNames(Request $request)
    {
        try {
            $needle = $request->get('search', '');
            $limit = $request->get('limit', 10);

            $list = Package::where('name', 'like', '%' . $needle . '%')
                ->limit($limit)
                ->get()
                ->pluck('name');

            return $this->response([
                'status' => 'success',
                'payload' => $list,
            ], 200);
        } catch (\Exception $e) {

            return $this->response([
                'status' => 'error',
                'payload' => [
                    'message' => $e->getMessage(),
                ],
            ], 200);
        }
    }
}
