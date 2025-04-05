@extends('layouts.default_with_menu')

@section('content')

<div class="container" style="margin-top: -20px;">
    <div class="row mb-3 align-items-end">
        <!-- ปีที่ทำกิจกรรม -->
        <div class="col-md-3">
            <label class="form-label fw-semibold small">ปีที่ทำกิจกรรม</label>
            <select class="form-select form-select-sm" style="height: 40px; font-size: 0.85rem;">
                <option selected>2568</option>
            </select>
        </div>

        <!-- หมวดหมู่ทั้งหมด -->
        <div class="col-md-3">
            <label class="form-label fw-semibold small">หมวดหมู่ทั้งหมด</label>
            <div class="form-control form-control-sm bg-light d-flex justify-content-between align-items-center" style="height: 40px; font-size: 0.85rem;">
                <span>{{ count($categories) }}</span>
                <span class="text-muted">หมวดหมู่</span>
            </div>
        </div>

        <!-- กิจกรรมที่ทำทั้งหมด -->
        <div class="col-md-3">
            <label class="form-label fw-semibold small">กิจกรรมที่ทำทั้งหมด</label>
            <div class="form-control form-control-sm bg-light d-flex justify-content-between align-items-center" style="height: 40px; font-size: 0.85rem;">
                <span>{{ empty($activities) ? 0 : count($activities) }}</span>
                <span class="text-muted">กิจกรรม</span>
            </div>
        </div>

        <!-- ปุ่มส่งกิจกรรม -->
        <div class="col-md-3 text-end d-flex justify-content-end align-items-center">
            <form action="{{ route('activities.submitAll') }}" method="POST">
                @csrf
                @if ($checkAcSent)
                    <button class="btn btn-sm" style="background-color: #6c757d; color: white;" disabled>ส่งกิจกรรมทั้งหมด</button>
                @else
                    <button type="submit" class="btn btn-sm" style="background-color: #198754; color: white;">ส่งกิจกรรมทั้งหมด</button>
                @endif
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-3">
            <h6 class="mb-3 fw-bold">ตารางการทำงาน</h6>
            <table class="table table-sm table-striped text-center align-middle">
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
                <tbody class="small">
                    @if ($activities == null)
                        <tr>
                            <td colspan="7" class="text-center text-muted">ไม่มีข้อมูลกิจกรรม</td>
                        </tr>
                    @else
                        @foreach ($activities as $index => $activity)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $activity->category->cat_name ?? 'ไม่ระบุหมวดหมู่' }}</td>
                                <td>{{ $activity->act_title ?? 'ไม่มีชื่อกิจกรรม' }}</td>
                                <td>{{ \Carbon\Carbon::parse($activity->act_date)->format('d/m/Y') ?? '-' }}</td>
                                <td>
                                    @if ($activity->category->cat_ismandatory ?? false)
                                        <span class="badge bg-danger-subtle text-danger fw-semibold">บังคับ</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">ไม่บังคับ</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($activity->status == 'Saved')
                                        <span class="badge bg-primary-subtle text-primary fw-normal">
                                            <span class="dot me-1" style="background-color: #0d6efd;"></span>
                                            บันทึกแล้ว
                                        </span>
                                    @elseif ($activity->status == 'Sent' || $activity->status == 'Approve_by_province')
                                        <span class="badge bg-success-subtle text-success fw-normal">
                                            <span class="dot me-1" style="background-color: #1e9b1e;"></span>
                                            ส่งแล้ว
                                        </span>
                                    @elseif ($activity->status == 'Edit' || $activity->status == 'unapproved_by_central')
                                        <span class="badge bg-warning-subtle text-warning fw-normal">
                                            <span class="dot me-1" style="background-color: #b8860b;"></span>
                                            แก้ไข
                                        </span>
                                    @elseif ($activity->status == 'Approve_by_central')
                                        <span class="badge bg-secondary-subtle text-muted fw-normal">
                                            <span class="dot me-1" style="background-color: #6c757d;"></span>
                                            เสร็จสิ้น
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if (in_array($activity->status, ['Saved','Edit','unapproved_by_central']))
                                        <a href="{{ route('activities.edit', $activity->act_id) }}">
                                            <button type="button" class="btn btn-warning btn-sm custom-btn">แก้ไข</button>
                                        </a>
                                    @endif
                                    @if (in_array($activity->status, ['Sent','Edit','Approve_by_central','unapproved_by_central','Approve_by_province']))
                                        <a href="{{ route('activities.detail', $activity->act_id) }}">
                                            <button class="btn bg-primary text-white btn-sm custom-btn">รายละเอียด</button>
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

<style>
    .dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }

    .custom-btn {
        font-size: 0.75rem;
        color: white;
    }
</style>

@endsection
