<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function get(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);
            $page = $request->get('current_page', 1);
            $columns = ['*'];
            $pageName = 'page';

            $orderColumn = $request->get('order_column', 'name');
            $orderDirection = $request->get('order_direction', 'asc');

            $user_name = $request->get('user_name', '');
            $user_email = $request->get('user_email', '');
            $country = $request->get('country', '');

            $users = User::with(['account:id,user_id,country_id', 'account.country:id,name',])
                ->where('name', 'like', '%' . $user_name . '%')
                ->where('email', 'like', '%' . $user_email . '%')
                ->whereHas('account.country', function($query) use ($country) { $query->where('name', 'like', '%' . $country . '%'); })
                ->orderBy($orderColumn, $orderDirection)
                ->select(['id', 'name', 'email', 'created_at'])
                ->paginate($perPage, $columns, $pageName, $page);
        } catch (\Exception $e) {
            return $this->response([
                'status' => 'failure',
                'payload' => [
                    'message' => $e->getMessage()
                ],
            ], 200);
        }

        return $this->response([
            'status' => 'success',
            'payload' => $users,
        ], 200);
    }

    public function getDetails(Request $request)
    {
        try {
            $userId = $request->get('id');

            $user = User::with(['account:id,user_id,country_id,address,city,state,postal_code,vat', 'account.country:id,name', 'logos:id,svg,user_id'])
                ->select(['id', 'name', 'email'])
                ->findOrFail($userId);
        } catch (\Exception $e) {
            return $this->response([
                'status' => 'failure',
                'payload' => [
                    'message' => $e->getMessage()
                ],
            ], 200);
        }

        return $this->response([
            'status' => 'success',
            'payload' => $user,
        ], 200);
    }

    public function getEmailList(Request $request)
    {
        try {
            $needle = $request->get('search', '');
            $limit = $request->get('limit', 10);

            $list = User::where('email', 'like', '%' . $needle . '%')
                ->limit($limit)
                ->get()
                ->pluck('email');

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

    public function getNameList(Request $request)
    {
        try {
            $needle = $request->get('search', '');
            $limit = $request->get('limit', 10);

            $list = User::where('name', 'like', '%' . $needle . '%')
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

    public function loginUsingId(Request $request)
    {
        try {
            $id = $request->get('id');

            \Auth::loginUsingId($id);
        } catch (\Exception $e) {

            return $this->response([
                'status' => 'error',
                'payload' => [
                    'message' => $e->getMessage(),
                ],
            ], 200);
        }

        return $this->response([
            'status' => 'success',
            'payload' => [],
        ], 200);
    }
}
