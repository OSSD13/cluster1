@extends('layouts.default_with_menu')

@section('page-title', 'กิจกรรมที่เคยทำ')
@section('content')

<div class="container" style="margin-top: -11px;">
    <div class="row mb-3 align-items-end">
        <!-- ปีที่ทำกิจกรรม -->
        <div class="col-md-3">
            <label class="form-label fw-semibold small">ปีที่ทำกิจกรรม</label>
            <form method="GET" action="{{ route('activities.history') }}" id="yearForm">
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

        <!-- จำนวนหมวดหมู่ทั้งหมด -->
        <div class="col-md-3">
            <label class="form-label fw-semibold small">หมวดหมู่ทั้งหมด</label>
            <div class="form-control bg-white d-flex justify-content-between align-items-center" style="height: 55px; font-size: 1rem; padding: 0.75rem;">
                <span id="categoryCount">{{ count($categories) }}</span>
                <span class="text-muted">หมวดหมู่</span>
            </div>
        </div>

        <!-- จำนวนกิจกรรมทั้งหมด -->
        <div class="col-md-3">
            <label class="form-label fw-semibold small">กิจกรรมที่ทำทั้งหมด</label>
            <div class="form-control bg-white d-flex justify-content-between align-items-center" style="height: 55px; font-size: 1rem; padding: 0.75rem;">
                <span id="activityCount">{{ empty($activities) ? 0 : count($activities) }}</span>
                <span class="text-muted">กิจกรรม</span>
            </div>
        </div>

        <!-- ปุ่มส่งกิจกรรม -->
        <div class="col-md-3 text-end d-flex justify-content-end align-items-center">
            <form action="{{ route('activities.submitAll') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-submit-all">{{ $checkAcSent ? 'ส่งกิจกรรมทั้งหมด' : 'ส่งกิจกรรมทั้งหมด' }}</button>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-3">
            <h6 class="mb-3 fw-bold">ตารางการทำงาน</h6>
            <table class="table table-sm text-center align-middle custom-table">
                <thead class="table-light small">
                    <tr>
                        <th> </th>
                        <th>หมวดหมู่</th>
                        <th>ชื่อกิจกรรม</th>
                        <th>วันที่ทำกิจกรรม</th>
                        <th>ประเภท</th>
                        <th>สถานะ</th>
                        <th>การกระทำ</th>
                    </tr>
                </thead>
                <tbody class="small" id="activityTableBody">
                    @php
                        $row = 1;
                        $statusText = [
                            'Saved' => 'บันทึกแล้ว',
                            'Sent' => 'ส่งแล้ว',
                            'Approve_by_province' => 'ส่งแล้ว',
                            'Edit' => 'แก้ไข',
                            'unapproved_by_central' => 'แก้ไข',
                            'Approve_by_central' => 'เสร็จสิ้น',
                        ];
                    @endphp
                    @if ($activities == null || count($activities) === 0)
                        <tr>
                            <td colspan="7" class="text-center text-muted">ไม่มีข้อมูลกิจกรรม</td>
                        </tr>
                    @else
                        @foreach ($activities as $activity)
                            <tr>
                                <td>{{ $row++ }}</td>
                                <td>{{ $activity->category->cat_name ?? '-' }}</td>
                                <td>{{ $activity->act_title ?? '-' }}</td>
                                <td>{{ \Carbon\Carbon::parse($activity->act_date)->format('d/m/Y') ?? '-' }}</td>
                                <td>{{ $activity->category->cat_ismandatory ? 'บังคับ' : 'ไม่บังคับ' }}</td>
                                <td>{{ $statusText[$activity->status] ?? $activity->status }}</td>
                                <td>
                                    <a href="{{ route('activities.detail', $activity->act_id) }}" class="btn btn-sm btn-outline-primary">รายละเอียด</a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('javascript')
<script>
    $(document).ready(function () {
        $('#yearFilter').on('change', function () {
            const yearId = $(this).val();

            $.ajax({
                url: '{{ route("activities.activityData") }}',
                method: 'GET',
                data: { year_id: yearId },
                success: function (response) {
                    let rows = '';
                    let row = 1;
                    response.activities.forEach(activity => {
                        rows += `
                            <tr>
                                <td>${row++}</td>
                                <td>${activity.category.cat_name ?? '-'}</td>
                                <td>${activity.act_title ?? '-'}</td>
                                <td>${activity.act_date ? new Date(activity.act_date).toLocaleDateString('th-TH') : '-'}</td>
                                <td>${activity.category.cat_ismandatory ? 'บังคับ' : 'ไม่บังคับ'}</td>
                                <td>${activity.status}</td>
                                <td>
                                    <a href="/activities/${activity.act_id}/detail" class="btn btn-sm btn-outline-primary">รายละเอียด</a>
                                </td>
                            </tr>`;
                    });
                    $('#activityTableBody').html(rows);
                    $('#activityCount').text(response.activities.length);
                    $('#categoryCount').text(response.categories.length);
                },
                error: function () {
                    alert('โหลดข้อมูลล้มเหลว กรุณาลองใหม่');
                }
            });
        });
    });
</script>
@endsection
@endsection
