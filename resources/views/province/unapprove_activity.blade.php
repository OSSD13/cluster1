@extends('layouts.default_with_menu')

@section('content')
<div class="container mt-4">
    <div class="container" style="margin-top: -5px;">
        {{-- 🔍 Search --}}
        <div class="d-flex justify-content-between">
            <div class="p-2">
                <div class="position-relative" style="max-width: 350px;">
                    <input type="text"
                        class="form-control ps-5 rounded-3"
                        placeholder="ค้นหา..."
                        style="height: 45px; font-size: 1rem; border: 1px solid #333;">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                </div>

            </div>
            <div class="p-2">
                <form method="POST" action="{{ route('province.rejectAllInProvince') }}">
                    @csrf
                    <button class="btn btn-danger" type="submit">ส่งกลับกิจกรรมของทุกคนในจังหวัด</button>
                </form>
            </div>
        </div>

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
        <div class="card shadow-sm">
            <div class="card-body p-3">
                <h5 class="mb-3 fw-bold" >ตารางเจ้าหน้าที่อาสากิจกรรมไม่ผ่าน</h5>
                <table class="table table-striped" >
                    <thead class="table-light"  >
                        <tr>
                            <th></th>
                            <th>ชื่อเจ้าหน้าที่อาสา</th>
                            <th>จังหวัด</th>
                            <th>สถานะ</th>
                            <th class="text-center">การกระทำ</th>
                        </tr>
                    </thead>
                    <thead class="table-light"  >
                    <tbody id="activityTableBody" >
                        @php
                        $grouped = $activities->groupBy(fn($a) => $a->creator->user_fullname);
                        @endphp

                        @forelse ($grouped as $fullname => $userActivities)
                        @php
                        $first = $userActivities->first();
                        $creator = $first->creator;
                        $province = $creator->provinceData->pvc_name ?? '-';
                        @endphp
                        <tr class="align-middle" >
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-start" >{{ $fullname }}</td>
                            <td>{{ $province }}</td>
                            <td>
                                <span class="badge bg-warning text-dark">ส่งกลับ</span>
                            </td>
                            <td class="text-center">
                                <form method="POST" action="{{ route('province.unapprove.click', $creator->user_id) }}">
                                    @csrf
                                    <button class="btn btn-primary" type="submit">ส่งกลับให้เจ้าหน้าที่อาสา</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted" >ไม่มีข้อมูลกิจกรรมของปีที่เลือก</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function () {
        $('#yearFilter').on('change', function () {
            const yearId = $(this).val();

            $.ajax({
                url: '{{ route("province.considerData") }}',
                type: 'GET',
                data: { year_id: yearId },
                success: function (response) {
                    const selectedYear = $('#yearFilter').val();
                    let rows = '';
                    let index = 1;
                    response.data.forEach((item) => {
                        if (item.category && item.category.cat_year_id == selectedYear) {
                            rows +=
                            <tr>
                                <td>${index++}</td>
                                <td class="text-start">${item.fullname}</td>
                                <td>${item.province}</td>
                                <td><span class="badge bg-secondary text-white">ยังไม่ตรวจสอบ</span></td>
                                <td class="text-center">
                                    <a href="/activities/review/${item.activity_id}" class="btn btn-primary btn-sm px-4 rounded-pill">รายละเอียด</a>
                                </td>
                            </tr>;
                        }
                    });

                    $('#activityTableBody').html(rows);
                    $('#volunteerCount').text(response.userCount + ' คน');
                    $('#activityCount').text(response.activityCount + ' กิจกรรม');
                },
                error: function () {
                    alert('โหลดข้อมูลล้มเหลว กรุณาลองใหม่');
                }
            });
        });
    });
</script>
    @endsection