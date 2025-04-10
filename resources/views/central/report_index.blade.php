@extends('layouts.default_with_menu')
@section('page-title', 'รายงาน')
@section('content')
<div class="container mt-4">
    {{-- 🔍 Search --}}
    <div class="mb-3">
        <div class="position-relative" style="max-width: 350px;">
            <form method="GET" action="{{ route('central.report.index') }}" class="mb-3">
                <div class="input-group">
                    <button class="btn " type="submit">
                        <span class="input-group-text">
                            <i
                                class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i></i>
                        </span>
                    </button>
                    <input type="text" name="search" class="form-control" placeholder="ค้นหาชื่อ..."
                        value="{{ request('search') }}">
                </div>
            </form>
        </div>
    </div>

    {{-- 📊 Summary Filters --}}
    <div class="row g-3 mb-4">
        {{-- ปีที่ทำกิจกรรม --}}
        <div class="col-md-3">
            <label class="form-label fw-bold">ปีที่ทำกิจกรรม</label>
            <form method="GET" action="{{ route('central.report.index') }}" id="yearForm">
                <select name="year_id" id="yearFilter" class="form-select shadow-sm"
                    onchange="document.getElementById('yearForm').submit()" style="height: 72px;">
                    @foreach ($years as $year)
                    <option value="{{ $year->year_id }}"
                        {{ $year->year_id == $selectedYearId ? 'selected' : '' }}>
                        {{ $year->year_name }}
                    </option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- จำนวนอาสา --}}
        <div class="col-md-3">
            <label class="form-label fw-bold">จำนวนอาสา</label>
            <div class="form-control shadow-sm bg-white d-flex justify-content-between align-items-center"
                style="height: 72px;">
                <span>{{ $userCount }}</span>
                <span>คน</span>
            </div>
        </div>

        {{-- จำนวนกิจกรรม --}}
        <div class="col-md-3">
            <label class="form-label fw-bold">จำนวนกิจกรรม</label>
            <div class="form-control shadow-sm bg-white d-flex justify-content-between align-items-center"
                style="height: 72px;">
                <span>{{ $activityCount }}</span>
                <span>กิจกรรม</span>
            </div>
        </div>


        {{-- 📋 ตารางกิจกรรม --}}
        <div class="card shadow-sm">
            <div class="card-body p-3">
                <h6 class="mb-3 fs-5 ps-3 fw-bold">ตารางการทำงาน</h6>
                <div class="table-responsive">
                    <table class="table align-middle table-hover text-center">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 60px;"></th>
                                <th class="text-start ps-5">จังหวัด</th>
                                <th style="width: 150px;">การกระทำ</th>
                            </tr>
                        </thead>
                        <tbody id="activityTableBody">
                            @forelse ($provinces as $index => $province)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="text-start ps-5">{{ $province->pvc_name }}</td>
                                <td>
                                    <a href="{{ route('central.report', ['pvc_id' => $province->pvc_id, 'year_id' => $selectedYearId]) }}"
                                        class="btn btn-sm btn-primary rounded-pill px-3">รายละเอียด</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-muted">ไม่มีข้อมูลกิจกรรมของปีที่เลือก</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination + Rows Per Page --}}

            </div>
        @endsection

                @section('javascript')
                <script>
                    $(document).ready(function() {
                        $('#yearFilter').on('change', function() {
                            const yearId = $(this).val();

                            $.ajax({
                                url: "{{ route('central.report.index') }}",
                                type: 'GET',
                                data: {
                                    year_id: yearId
                                },
                                success: function(response) {
                                    const selectedYear = $('#yearFilter').val();
                                    let rows = '';
                                    let index = 1;
                                    response.data.forEach((item) => {
                                        if (item.category && item.category.cat_year_id ==
                                            selectedYear) {
                                            rows +=
                                                `<tr>
                                            <td>${index++}</td>
                                            <td class="text-start">${item.fullname}</td>
                                            <td>${item.province}</td>
                                            <td><span class="badge bg-secondary text-white">ยังไม่ตรวจสอบ</span></td>
                                            <td class="text-center">
                                            <a href="${detailUrl}" class="btn btn-primary btn-sm px-4 rounded-pill">รายละเอียด</a>
                                            </td>
                                            </tr>`;
                                        }
                                    });

                                    $('#activityTableBody').html(rows);
                                    $('#volunteerCount').text(response.userCount + ' คน');
                                    $('#activityCount').text(response.activityCount + ' กิจกรรม');
                                },
                                error: function() {
                                    alert('โหลดข้อมูลล้มเหลว กรุณาลองใหม่');
                                }
                            });
                        });
                    });
                </script>
                @endsection

