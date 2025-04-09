@extends('layouts.default_with_menu')
@section('page-title', 'กิจกรรมที่ไม่ผ่าน')
@section('content')
<div class="container mt-4">
    <div class="container" style="margin-top: -5px;">
        {{-- 🔍 Search --}}
        <div class="row g-2 align-items-center">
            <div class="col-md-8">
                <div class="position-relative">
                    <input type="text"
                        class="form-control ps-5 rounded-3"
                        style="height: 48px; font-size: 1rem;">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <form method="POST" action="{{ route('province.rejectAllInProvince') }}">
                    @csrf
                    <button class="btn btn-danger" type="submit">ส่งกลับให้เจ้าหน้าที่อาสา</button>
                </form>
            </div>
        </div>
        <br>



        {{-- 📊 Summary Filters --}}
        <div class="row g-3 align-items-end mb-4">
            {{-- ปี --}}
            <div class="col-md-3">
                <label class="form-label fw-semibold small">ปีที่ทำกิจกรรม</label>
                <form method="GET" action="{{ route('province.unapprove') }}" id="yearForm">
                    <select name="year_id" id="yearFilter" class="form-select shadow-sm"
                        onchange="document.getElementById('yearForm').submit()"
                        style="height: 55px; font-size: 1rem; padding: 0.75rem;">
                        @foreach ($years as $year)
                        <option value="{{ $year->year_id }}" {{ $year->year_id == $selectedYearId ? 'selected' : '' }}>
                            {{ $year->year_name }}
                        </option>
                        @endforeach
                    </select>
                </form>
            </div>

            {{-- จังหวัด --}}
            <div class="col-md-3">
                <label class="form-label fw-semibold small">จังหวัด</label>
                <div class="form-control shadow-sm bg-white d-flex align-items-center"
                    style="height: 55px; font-size: 1rem; padding: 0.75rem;">
                    {{ auth()->user()->provinceData->pvc_name ?? '-' }}
                </div>
            </div>

            {{-- จำนวนอาสา --}}
            <div class="col-md-3">
                <label class="form-label fw-semibold small">จำนวนอาสา</label>
                <div class="form-control shadow-sm bg-white text-end d-flex justify-content-between align-items-center"
                    id="volunteerCount"
                    style="height: 55px; font-size: 1rem; padding: 0.75rem;">
                    <span>{{ $userCount }}</span>
                    <span class="text-muted">คน</span>
                </div>
            </div>

            {{-- จำนวนกิจกรรม --}}
            <div class="col-md-3">
                <label class="form-label fw-semibold small">จำนวนกิจกรรม</label>
                <div class="form-control shadow-sm bg-white text-end d-flex justify-content-between align-items-center"
                    id="activityCount"
                    style="height: 55px; font-size: 1rem; padding: 0.75rem;">
                    <span>{{ $activityCount }}</span>
                    <span class="text-muted">กิจกรรม</span>
                </div>
            </div>
        </div>

        {{-- 📋 ตารางกิจกรรม --}}
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="mb-4 fw-bold">ตารางเจ้าหน้าที่อาสากิจกรรมไม่ผ่าน</h5>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light rounded-top">
                            <tr style="background-color: #f1f5f9;">
                                <th class="fw-semibold text-center"> </th>
                                <th class="fw-semibold text-center">ชื่อเจ้าหน้าที่อาสา</th>
                                <th class="fw-semibold text-center">จังหวัด</th>
                                <th class="fw-semibold text-center">สถานะ</th>
                                <th class="fw-semibold text-center">การกระทำ</th>
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
                            <tr class="border-top">
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $fullname }}</td>
                                <td class="text-center">{{ $province }}</td>
                                <td class="text-center">
                                    <span class="badge d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill"
                                        style="background-color: #fde68a; color: #92400e;">
                                        <span class="bg-warning rounded-circle" style="width: 8px; height: 8px;"></span>
                                        ส่งกลับ
                                    </span>
                                </td>
                                <td class="text-center">
                                    <form method="POST" action="{{ route('province.unapprove.click', $creator->user_id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary">
                                            ส่งกลับให้เจ้าหน้าที่อาสา
                                        </button>
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

    </div>
</div>
@endsection