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

        {{-- ประเภท --}}
        <td class="text-center">
            @php
                $mandatoryText = ($activity->category->cat_ismandatory ?? false) ? 'บังคับ' : 'ไม่บังคับ';
                $mandatoryClass = ($activity->category->cat_ismandatory ?? false)
                    ? 'bg-danger-subtle text-danger'
                    : 'bg-secondary-subtle text-secondary';
            @endphp

            <span class="badge badge-status justify-content-center {{ $mandatoryClass }}">
                <span class="status-text">{{ $mandatoryText }}</span>
            </span>
        </td>

        {{-- สถานะ --}}
        <td>
            @php
                $statusColor = [
                    'Saved' => '#0d6efd',
                    'Sent' => '#90ee90',
                    'Approve_by_province' => '#90ee90',
                    'Edit' => '#b8860b',
                    'unapproved_by_central' => '#b8860b',
                    'Approve_by_central' => '#6c757d',
                ];

                $statusText = [
                    'Saved' => 'บันทึกแล้ว',
                    'Sent' => 'ส่งแล้ว',
                    'Approve_by_province' => 'ส่งแล้ว',
                    'Edit' => 'แก้ไข',
                    'unapproved_by_central' => 'แก้ไข',
                    'Approve_by_central' => 'เสร็จสิ้น',
                ];

                $bgClass = match($activity->status) {
                    'Saved' => 'bg-primary-subtle text-primary',
                    'Sent', 'Approve_by_province' => '',
                    'Edit', 'unapproved_by_central' => 'bg-warning-subtle text-warning',
                    'Approve_by_central' => 'bg-secondary-subtle text-muted',
                    default => 'bg-light text-dark'
                };

                $inlineBg = '';
                if (in_array($activity->status, ['Sent', 'Approve_by_province'])) {
                    $inlineBg = 'background-color: #e6f9e6; color: #207720;';
                }
            @endphp

            <span class="badge badge-status {{ $bgClass }}" style="{{ $inlineBg }}">
                <span class="dot-container">
                    <span class="dot" style="background-color: {{ $statusColor[$activity->status] ?? '#000' }};"></span>
                </span>
                <span class="status-text">{{ $statusText[$activity->status] ?? 'ไม่ทราบสถานะ' }}</span>
            </span>
        </td>

        {{-- การกระทำ --}}
        <td class="text-center">
            <div class="d-flex justify-content-center">
                <div class="d-flex flex-column flex-md-row gap-1 align-items-center action-wrapper">
                    @if (in_array($activity->status, ['Saved','Edit','unapproved_by_central']))
                        <a href="{{ route('activities.edit', $activity->act_id) }}">
                            <button type="button" class="btn btn-warning btn-sm action-btn">แก้ไข</button>
                        </a>
                    @else
                        <div class="action-placeholder"></div>
                    @endif

                    @if (in_array($activity->status, ['Sent','Edit','Approve_by_central','unapproved_by_central','Approve_by_province']))
                        <a href="{{ route('activities.detail', $activity->act_id) }}">
                            <button class="btn bg-primary text-white btn-sm action-btn">รายละเอียด</button>
                        </a>
                    @else
                        <div class="action-placeholder"></div>
                    @endif
                </div>
            </div>
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
    .dot-container {
        width: 14px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        flex-shrink: 0;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        min-width: 90px;
        font-size: 0.75rem;
        padding: 0.4rem 0.6rem;
        border-radius: 0.5rem;
        justify-content: flex-start;
    }

    .status-text {
        white-space: nowrap;
    }

    .action-btn {
        min-width: 85px;
        font-size: 0.75rem;
        color: white;
        padding: 0.3rem 0.5rem;
    }

    .action-wrapper {
        min-width: 180px;
        justify-content: center;
    }

    .action-placeholder {
        width: 85px;
        height: 30px;
    }

    /* ปรับแถว: สีขาวสำหรับเลขคี่, สีเทาอ่อนสำหรับเลขคู่ */
    .custom-table tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }

    .custom-table tbody tr:nth-child(even) {
        background-color:rgb(2, 11, 21);
    }
</style>

@endsection
