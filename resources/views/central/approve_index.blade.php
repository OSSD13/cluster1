@extends('layouts.default_with_menu')

@section('content')
    <div class="container" style="margin-top: -40px;">
        <div class="row mb-3 align-items-end">
            <div class="container mt-4">
                {{-- 🔍 Search --}}
                <div class="mb-3">
                    <form method="GET" action="{{ route('central.approve.index') }}" class="mb-3">
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

                {{-- 📊 Summary Filters --}}
                <div class="row g-3 align-items-end mb-4">
                    {{-- ปี --}}
                    <div class="col-md-3">
                        <label class="form-label fw-bold">ปีที่ทำกิจกรรม</label>
                        <form method="GET" action="{{ route('central.approve.index') }}" id="yearForm">
                            <select name="year_id" id="yearFilter" class="form-select shadow-sm"
                                onchange="document.getElementById('yearForm').submit()">
                                @foreach ($years as $year)
                                    <option value="{{ $year->year_id }}"
                                        {{ $year->year_id == $selectedYearId ? 'selected' : '' }}>
                                        {{ $year->year_name }}
                                    </option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    {{-- จังหวัด --}}


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
                <div class="card shadow-sm">
                    <div class="card-body p-3">
                        <h6 class="mb-3 " style="font-size: 23px; padding-left: 10px;">ตารางการทำงาน</h6>
                        <div class="table-responsive">
                            <table class="table align-middle table-hover">
                                <thead class="table-light small text-center" style="border-radius: 10px;">
                                    <tr>
                                        <th style="width: 60px;"></th>
                                        <th class="text-start " style="padding-left: 100px;" >จังหวัด</th>
                                        <th style="width: 150px;">การกระทำ</th>
                                    </tr>
                                </thead>
                                <tbody id="activityTableBody">
                                    @forelse ($provinces as $index => $province)
                                        <tr>
                                            <td class="text-center">{{ $index + 1 }}</td>
                                            <td class="text-start " style="padding-left: 100px;">{{ $province->pvc_name }}</td>
                                            <td class="text-center">
                                                <a href="{{ route('central.province.index', ['pvc_id' => $province->pvc_id, 'year_id' => $selectedYearId]) }}"
                                                   class="btn btn-sm btn-primary rounded-pill px-3">รายละเอียด</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center text-muted">ไม่มีข้อมูลกิจกรรมของปีที่เลือก</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        @endsection

        @section('javascript')
            <script>
                $(document).ready(function() {
                    $('#yearFilter').on('change', function() {
                        const yearId = $(this).val();

                        $.ajax({
                            url: '{{ route('central.provinceData') }}',
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
                                            <a href="/report/${item.activity_id}" class="btn btn-primary btn-sm px-4 rounded-pill">รายละเอียด</a>
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
