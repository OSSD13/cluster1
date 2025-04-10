@extends('layouts.default_with_menu')
@section('page-title', 'อนุมัติงาน')
@section('content')
    <div class="container" style="margin-top: -40px;">
        <div class="row mb-3 align-items-end">
            <div class="container mt-4">
                {{-- 🔍 Search --}}
                <div class="mb-3">
                    <form method="GET" action="{{ route('central.province.index',['pvc_id' => $provinceID]) }}" class="mb-3">
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
                        <form method="GET" action="{{ route('central.province.index', ['pvc_id' => $provinceID]) }}"
                            id="yearForm">
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
                    <div class="col-md-3">
                        <label class="form-label">จังหวัด</label>
                        <div class="form-control shadow-sm bg-white">
                            {{ $pr ?? '-' }}
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
                <div class="card shadow-sm">
                    <div class="card-body p-3">
                        <h6 class="mb-3 fw-bold">ตารางการทำงาน</h6>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light small">
                                    <tr>
                                        <th> </th>
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
                                                <span
                                                    class="badge bg-light text-dark d-flex align-items-center gap-2 px-2 py-2 rounded-pill"
                                                    style="font-weight: 500;">
                                                    <span class="bg-secondary rounded-circle d-inline-block"
                                                        style="width: 10px; height: 10px;"></span>
                                                    ยังไม่ตรวจสอบ
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('central.approve.category', ['user_id' => $creator->user_id]) }}?year_id={{ $selectedYearId }}&pvc_id={{ $provinceID }}"
                                                    class="btn btn-sm btn-outline-primary">รายละเอียด</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">
                                                ไม่มีข้อมูลกิจกรรมของปีที่เลือก</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endsection

            {{-- จำนวนอาสา --}}
            <div class="col-md-3">
                <label class="form-label fw-semibold small">จำนวนอาสา</label>
                <div class="form-control shadow-sm bg-white text-end d-flex justify-content-between align-items-center"
                id="volunteerCount"
                style="height: 55px; font-size: 1rem; padding: 0.75rem;">
                <span>{{ $userCount }} </span>
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
            <h6 class="mb-3 fw-bold">ตารางการทำงาน</h6>
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-light small">
                        <tr>
                            <th> </th>
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
                                <span class="badge d-inline-flex align-items-center gap-2 px-3 py-2 rounded-pill" style="background-color:rgba(209, 213, 213, 0.85); color: #6c757d; font-weight: 500;">
                                <span class="bg-secondary rounded-circle d-inline-block"
                                            style="width: 8px; height: 8px;"></span>
                                        ยังไม่ตรวจสอบ

                </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('central.approve.category', ['user_id' => $creator->user_id])}}?year_id={{$selectedYearId}}&pvc_id={{$provinceID}}"
                                       class="btn bg-primary text-white btn-sm action-btn">รายละเอียด</a>
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
@endsection

@section('javascript')
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
        @section('javascript')
            <script>
                $(document).ready(function() {
                    $('#yearFilter').on('change', function() {
                        const yearId = $(this).val();

                        $.ajax({
                            url: '{{ route('province.considerData') }}',
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
                                            <
                                            tr >
                                            <
                                            td > $ {
                                                index++
                                            } < /td> <
                                            td class = "text-start" > $ {
                                                item.fullname
                                            } < /td> <
                                            td > $ {
                                                item.province
                                            } < /td> <
                                            td > < span class =
                                            "badge bg-secondary text-white" > ยั งไม่ ตรวจสอบ <
                                            /span></td >
                                            <
                                            td class = "text-center" >
                                            <
                                            a href = "/activities/review/${item.activity_id}"
                                        class = "btn btn-primary btn-sm px-4 rounded-pill" >
                                        รายละเอียด < /a> <
                                            /td> <
                                            /tr>;
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

        public static function categoriesWithComments()
        {
            return \App\Models\Category::whereHas('activities.approvals', function ($query) {
                $query->whereNotNull('apv_comment');
            })->get();
        }
