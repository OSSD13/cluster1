<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Activity;
use Illuminate\Http\Request;

class centralController extends Controller
{
    //
    public function reportIndex(Request $request)
    {
        $years = \App\Models\Year::orderByDesc('year_name')->get();
        $latestYear = \App\Models\Year::orderByDesc('year_name')->first();
        $selectedYearId = $request->input('year_id', $latestYear->year_id);
        $selectedProvinceId = $request->input('province_id');

        $provinces = \App\Models\Provinces::whereHas('users.activities', function ($query) use ($selectedYearId) {
            $query->where('status', 'Approve_by_central')
                ->whereHas('category', fn($q) => $q->where('cat_year_id', $selectedYearId));
        })->get();
        $provinceIds = $provinces->pluck('pvc_id');

        $activities = Activity::where('status', 'Approve_by_central')
            ->when($selectedProvinceId, function ($query) use ($selectedProvinceId) {
                return $query->whereHas('creator', fn($q) => $q->where('province', $selectedProvinceId));
            }, function ($query) use ($provinces) {
                return $query->whereHas('creator', fn($q) => $q->whereIn('province', $provinces->pluck('pvc_id')));
            })
            ->whereHas('category', fn($q) => $q->where('cat_year_id', $selectedYearId))
            ->get();

        $userCount = $activities->count();
        $activityCount = $activities->count();

        return view('central.report_index', compact(
            'years',
            'selectedYearId',
            'provinces',
            'selectedProvinceId',
            'userCount',
            'activityCount'
        ));
    }

    public function report(Request $request, $id)
    {
        $latestYear = \App\Models\Year::orderByDesc('year_name')->first();
        $selectedYearId = $request->input('year_id', $latestYear->year_id);
        $province = \App\Models\Provinces::find($id);
        $provinceName = $province ? $province->pvc_name : '-';
        $provinceId = $province ? $province->pvc_id : null;

        $activities = Activity::where('status', 'Approve_by_central')
            ->whereHas('creator', fn($q) => $q->where('province', $provinceId))
            ->whereHas('category', fn($q) => $q->where('cat_year_id', $selectedYearId))
            ->with(['creator', 'category'])
            ->get();

        $groupedActivities = $activities
            ->groupBy(fn($activity) => $activity->creator->user_fullname)
            ->sortKeys();

        $years = \App\Models\Year::orderByDesc('year_name')->get();
        $userCount = $groupedActivities->count();
        $activityCount = $activities->count();
        
        return view('province.report', compact(
            'groupedActivities',
            'years',
            'selectedYearId',
            'userCount',
            'activityCount',
            'provinceId',
            'provinceName',
        ));
    }

    public function provinceData(Request $request)
    {
        $yearId = $request->input('year_id');
        $index = 0;

        // ดึงเฉพาะจังหวัดที่มี user และ user เหล่านั้นมี activity ที่ผ่านสถานะ Approve_by_central
        $provinces = \App\Models\Provinces::whereHas('users.activities', function ($query) use ($yearId) {
            $query->where('status', 'Approve_by_central')
                ->whereHas('category', fn($q) => $q->where('cat_year_id', $yearId));
        })->get();

        $provinceIds = $provinces->pluck('pvc_id');

        $activities = Activity::where('status', 'Approve_by_central')
            ->whereHas('creator', fn($q) => $q->whereIn('province', $provinceIds))
            ->whereHas('category', fn($q) => $q->where('cat_year_id', $yearId))
            ->with(['creator.provinceData', 'category'])
            ->get();

        $data = $activities->groupBy(function ($a) {
            return $a->creator->provinceData->pvc_name ?? 'ไม่ทราบจังหวัด';
        })->map(function ($group, $provinceName) use (&$index) {
            return [
                'index' => ++$index,
                'province' => $provinceName,
            ];
        })->values();

        return response()->json([
            'data' => $data
        ]);
    }
    public function activityData(Request $request, $id)
    {
        $provinceId = $id;
        $yearId = $request->input('year_id');

        // ดึงกิจกรรมที่ตรงกับจังหวัดและสถานะ sent
        $query = Activity::where('status', 'Sent')
            ->whereHas('creator', function ($q) use ($provinceId) {
                $q->where('province', $provinceId);
            })
            ->with(['creator.provinceData', 'category']);

        // กรองปีจาก category
        if ($yearId) {
            $query->whereHas('category', function ($q) use ($yearId) {
                $q->where('cat_year_id', $yearId);
            });
        }

        $activities = $query->get();

        // ✅ Group by ผู้สร้าง ไม่ซ้ำ
        $grouped = $activities->groupBy(function ($a) {
            return $a->creator->user_fullname;
        });

        $data = $grouped->map(function ($group) {
            $first = $group->first();
            return [
                'fullname' => $first->creator->user_fullname,
                'province' => $first->creator->provinceData->pvc_name ?? '-',
                'activity_id' => $first->activity_id,
            ];
        })->values();

        return response()->json([
            'data' => $data,
            'userCount' => $data->count(),
            'activityCount' => $activities->count(),
        ]);
    }
}
