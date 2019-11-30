<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\RecommendationTrack;
use Carbon\Carbon;
//use Maatwebsite\Excel\Facades\Excel;

class RecommendationTrackController extends Controller
{
    public function get(Request $request)
    {
        try {
            $perPage = $request->get('per_page', 10);\Log::error('per page', [$perPage]);
            $page = $request->get('current_page', 1);
            $columns = ['*'];
            $pageName = 'page';

            $orderColumn = $request->get('order_column', 'created_at');
            $orderDirection = $request->get('order_direction', 'desc');

            $startDateTime = $request->get('start_date_time', Carbon::today());
            $endDateTime = $request->get('end_date_time', Carbon::tomorrow());

            if ($perPage == -1) {
                $perPage = 1000;
                $page = 1;
            }

            $recommendationTracks = RecommendationTrack::with(['user:id,email', 'user.account:id,user_id,country_id', 'user.account.country:id,name'])
                ->whereBetween('created_at', [$startDateTime, $endDateTime])
                ->orderBy($orderColumn, $orderDirection)
                ->select(['company_name', 'slogan', 'details', 'created_at', 'user_id'])
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
            'payload' => $recommendationTracks,
        ], 200);
    }

//    public function export()
//    {
//        return Excel::download(new YourExport);
//    }
}
