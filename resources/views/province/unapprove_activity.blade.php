@extends('layouts.default_with_menu')

@section('content')
    <div class="container mt-4">
        {{-- 🔍 Search --}}
        <div class="row mb-3">
            <div class="col-3">
                <input type="text" class="form-control shadow-sm" placeholder="🔍 ค้นหา..." />
            </div>
        </div>
        <div class="col-3">
            <form method="POST" action="{{ route('province.rejectAllInProvince') }}">
                @csrf
                <button class="btn btn-danger" type="submit">ส่งกลับกิจกรรมของทุกคนในจังหวัด</button>
            </form>
        </div>

        {{-- 📊 Summary Filters --}}
        <div class="row g-3 align-items-end mb-4">
            {{-- ปี --}}
            <div class="col-md-3">
                <label class="form-label fw-bold">ปีที่ทำกิจกรรม</label>
                <div class="form-control shadow-sm bg-white">
                    {{ $years->firstWhere('year_id', $selectedYearId)?->year_name ?? '-' }}
                </div>
            </div>

            {{-- จังหวัด --}}
            <div class="col-md-3">
                <label class="form-label">จังหวัด</label>
                <div class="form-control shadow-sm bg-white">
                    {{ auth()->user()->provinceData->pvc_name ?? '-' }}
                </div>
            </div>

            {{-- จำนวนอาสา --}}
            <div class="col-md-3">
                <label class="form-label">จำนวนอาสา</label>
                <div class="form-control shadow-sm bg-white text-end" id="volunteerCount">
                    {{ $userCount }} คน
                </div>
            </div>

            {{-- จำนวนกิจกรรม --}}
            <div class="col-md-3">
                <label class="form-label">จำนวนกิจกรรม</label>
                <div class="form-control shadow-sm bg-white text-end" id="activityCount">
                    {{ $activityCount }} กิจกรรม
                </div>
            </div>
        </div>

        {{-- 📋 ตารางกิจกรรม --}}
        <div class="card shadow">
            <div class="card-body">
                <h5 class="mb-3 fw-bold">ตารางการทำงาน</h5>
                <table class="table table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อเจ้าหน้าที่อาสา</th>
                            <th>จังหวัด</th>
                            <th>สถานะ</th>
                            <th class="text-center">การกระทำ</th>
                        </tr>
                    </thead>
                    <tbody id="activityTableBody">
                        @php
                            $grouped = $activities->groupBy(fn($a) => $a->creator->user_fullname);
                        @endphp

                        @forelse ($grouped as $fullname => $userActivities)
                            @php
                                $first = $userActivities->first();
                                $creator = $first->creator;
                                $province = $creator->provinceData->pvc_name ?? '-';
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-start">{{ $fullname }}</td>
                                <td>{{ $province }}</td>
                                <td>
                                    <span class="badge bg-warning text-dark">รอตรวจสอบ</span>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('province.unapprove.click', $creator->user_id) }}">
                                        @csrf
                                        <button class="btn btn-danger" type="submit">ส่งกลับให้เจ้าหน้าที่อาสา</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">ไม่มีข้อมูลกิจกรรมของปีที่เลือก</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

