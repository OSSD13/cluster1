@extends('layouts.default_with_menu')

@section('content')

    <div class="container mt-4">
        <!-- ส่วนหัวของหน้า -->
        <div class="row mb-4">
            <div class="col-md-3">
                <label class="form-label">ปีที่ทำกิจกรรม</label>
                <select class="form-select">
                    <option selected>2568</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">หมวดหมู่ทั้งหมด</label>
                <input type="text" class="form-control text-center bg-light" value="{{ count($categories) }} หมวดหมู่"
                    readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">กิจกรรมที่ทำทั้งหมด</label>
                <input type="text" class="form-control text-center bg-light"
                    value="{{ empty($activities) ? 0 : count($activities) }} กิจกรรม" readonly>
            </div>
            <div class="col-md-3 text-end">
                <!-- ปุ่มส่งกิจกรรมทั้งหมดไปให้ User2 ตรวจสอบ -->
                <form action="{{ route('activities.submitAll') }}" method="POST">
                    @csrf
                    @if ($checkAcSent)
                        <button class="btn btn-dark mt-4" disabled>ส่งงานทั้งหมด</button>
                    @elseif (!$checkAcSent)
                        <button type="submit" class="btn btn-success mt-4">ส่งงานทั้งหมด</button>
                    @endif

                </form>
            </div>
        </div>

        <!-- ตารางแสดงกิจกรรม -->
        <div class="card shadow">
            <div class="card-body">
                <h5 class="mb-3 fw-bold">ตารางการทำงาน</h5>
                <table class="table table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>ลำดับ</th>
                            <th>หมวดหมู่</th>
                            <th>ชื่อกิจกรรม</th>
                            <th>วันที่ทำกิจกรรม</th>
                            <th>ประเภท</th>
                            <th>สถานะ</th>
                            <th class="text-center">การกระทำ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($activities == null)
                            <tr>
                                <td colspan="7" class="text-center text-muted">ไม่มีข้อมูลกิจกรรม</td>
                            </tr>
                        @else
                                    @foreach ($activities as $index => $activity)
                                                <tr>
                                                    <td>{{
                                        $index + 1

                                                                    }}</td>
                                                    <td>{{ $activity->category->cat_name ?? 'ไม่ระบุหมวดหมู่' }}</td>
                                                    <td>{{ $activity->act_title ?? 'ไม่มีชื่อกิจกรรม' }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($activity->act_date)->format('d/m/Y') ?? '-' }}</td>
                                                    <td>
                                                        @if ($activity->category->cat_ismandatory ?? false)
                                                            <span class="badge bg-danger">บังคับ</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($activity->status == 'Saved')
                                                            <span class="badge bg-primary">บันทึกแล้ว</span>
                                                        @endif
                                                        @if ($activity->status == 'Sent'||$activity->status == 'Approve_by_province')
                                                            <span class="badge bg-success text-white">ส่งแล้ว</span>
                                                        @endif

                                                        @if ($activity->status == 'Edit'||$activity->status == 'unapproved_by_central')
                                                            <span class="badge bg-warning text-black">แก้ไข</span>
                                                        @endif

                                                        @if ($activity->status == 'Approve_by_central')
                                                            <span class="badge bg-secondary text-white">เสร็จสิ้น</span>
                                                        @endif

                                                    </td>
                                                    <td class="text-center">
                                                        @if ($activity->status == 'Saved'||$activity->status == 'Edit'||$activity->status == 'unapproved_by_central')
                                                            <a href="{{ route('activities.edit', $activity->act_id) }}">
                                                                <button type="button" class="btn btn-warning btn-sm">แก้ไข</button>
                                                            </a>
                                                        @endif

                                                        {{-- @if ($activity->status == 'Edit')
                                                            <a href="{{ route('activities.edit', $activity->act_id) }}">
                                                                <button type="button" class="btn btn-warning">แก้ไข</button>
                                                            </a>
                                                        @endif --}}

                                                        @if ($activity->status == 'Sent'||$activity->status == 'Edit'||$activity->status == 'Approve_by_central'||$activity->status == 'unapproved_by_central'||$activity->status == 'Approve_by_province')
                                                            <a href="{{ route('activities.detail', $activity->act_id) }}">
                                                                <button class="btn bg-primary text-white btn-sm">รายละเอียด</button>
                                                            </a>
                                                        @endif
                                                    </td>
                                                </tr>
                                    @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
