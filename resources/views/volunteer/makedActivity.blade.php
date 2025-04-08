@extends('layouts.default_with_menu') {{-- ใช้ layout หลักที่มีเมนูนำทาง --}}
@section('page-title', 'กิจกรรมที่เคยทำ')
@section('content') {{-- เริ่มต้น section content ที่จะใส่ลงใน layout หลัก --}}

<div class="container" style="margin-top: -11px;">
    <div class="row mb-3 align-items-end">
        <!-- ปีที่ทำกิจกรรม -->
        <div class="col-md-3">
            <label class="form-label fw-semibold small">ปีที่ทำกิจกรรม</label>
            <select class="form-select" style="height: 55px; font-size: 1rem; padding: 0.75rem;">
                <option selected>2568</option> {{-- ปีที่แสดง (ปัจจุบัน fix ไว้ที่ 2568) --}}
            </select>
        </div>


        <!-- จำนวนหมวดหมู่ทั้งหมด -->
        <div class="col-md-3">
            <label class="form-label fw-semibold small">หมวดหมู่ทั้งหมด</label>
            <div class="form-control bg-white d-flex justify-content-between align-items-center" style="height: 55px; font-size: 1rem; padding: 0.75rem;">
                <span>{{ count($categories) }}</span> {{-- นับจำนวนหมวดหมู่ --}}
                <span class="text-muted">หมวดหมู่</span>
            </div>
        </div>

        <!-- จำนวนกิจกรรมทั้งหมด -->
        <div class="col-md-3">
            <label class="form-label fw-semibold small">กิจกรรมที่ทำทั้งหมด</label>
            <div class="form-control bg-white d-flex justify-content-between align-items-center" style="height: 55px; font-size: 1rem; padding: 0.75rem;">
                <span>{{ empty($activities) ? 0 : count($activities) }}</span> {{-- ถ้าไม่มีข้อมูล ให้แสดง 0 --}}
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
                    <button type="submit" class="btn btn-sm" style="background-color:rgb(39, 219, 135); color: white;">ส่งกิจกรรมทั้งหมด</button>
                @endif
            </form>
        </div>
    </div>

    <div class="card shadow-sm"> {{-- เริ่มต้น card แสดงตารางกิจกรรม --}}
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
                    @php
                        // กำหนดข้อความและสีตามสถานะต่าง ๆ ของกิจกรรม
                        $statusText = [
                            'Saved' => 'บันทึกแล้ว',
                            'Sent' => 'ส่งแล้ว',
                            'Approve_by_province' => 'ส่งแล้ว',
                            'Edit' => 'แก้ไข',
                            'unapproved_by_central' => 'แก้ไข',
                            'Approve_by_central' => 'เสร็จสิ้น',
                        ];
                        $statusColor = [
                            'Saved' => '#0d6efd',
                            'Sent' => '#90ee90',
                            'Approve_by_province' => '#90ee90',
                            'Edit' => '#b8860b',
                            'unapproved_by_central' => '#b8860b',
                            'Approve_by_central' => '#6c757d',
                        ];
                        $row = 1; // ตัวแปรลำดับแถว
                    @endphp

                    @if ($activities == null || count($activities) === 0)
                        <tr>
                            <td colspan="7" class="text-center text-muted">ไม่มีข้อมูลกิจกรรม</td>
                        </tr>
                    @else
                        @foreach ($activities as $activity)
                            @if (isset($statusText[$activity->status])) {{-- แสดงเฉพาะกิจกรรมที่มีสถานะที่กำหนด --}}
                                <tr>
                                    <td>{{ $row++ }}</td>
                                    <td>{{ $activity->category->cat_name ?? 'ไม่ระบุหมวดหมู่' }}</td> {{-- ชื่อหมวดหมู่ --}}
                                    <td>{{ $activity->act_title ?? 'ไม่มีชื่อกิจกรรม' }}</td> {{-- ชื่อกิจกรรม --}}
                                    <td>{{ \Carbon\Carbon::parse($activity->act_date)->format('d/m/Y') ?? '-' }}</td> {{-- วันที่ทำกิจกรรม --}}

                                    {{-- ประเภทของกิจกรรม (บังคับ / ไม่บังคับ) --}}
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

                                    {{-- สถานะของกิจกรรม --}}
                                    <td>
                                        @php
                                            // กำหนดคลาสสีพื้นหลังจากสถานะ
                                            $bgClass = match($activity->status) {
                                                'Saved' => 'bg-primary-subtle text-primary',
                                                'Sent', 'Approve_by_province' => '',
                                                'Edit', 'unapproved_by_central' => 'bg-warning-subtle text-warning',
                                                'Approve_by_central' => 'bg-secondary-subtle text-muted',
                                                default => 'bg-light text-dark'
                                            };

                                            // สำหรับสถานะ "ส่งแล้ว" จะใช้ inline style
                                            $inlineBg = '';
                                            if (in_array($activity->status, ['Sent', 'Approve_by_province'])) {
                                                $inlineBg = 'background-color: #e6f9e6; color: #207720;';
                                            }
                                        @endphp

                                        <span class="badge badge-status {{ $bgClass }}" style="{{ $inlineBg }}">
                                            <span class="dot-container">
                                                <span class="dot" style="background-color: {{ $statusColor[$activity->status] ?? '#000' }};"></span>
                                            </span>
                                            <span class="status-text">{{ $statusText[$activity->status] }}</span>
                                        </span>
                                    </td>

                                    {{-- ปุ่มการกระทำ (แก้ไข/รายละเอียด) --}}
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center">
                                            <div class="d-flex flex-column flex-md-row gap-1 align-items-center action-wrapper">
                                                {{-- เงื่อนไขปุ่มแก้ไข --}}
                                                @if (in_array($activity->status, ['Saved','Edit','unapproved_by_central']))
                                                    <a href="{{ route('activities.edit', $activity->act_id) }}">
                                                        <button type="button" class="btn btn-warning btn-sm action-btn">แก้ไข</button>
                                                    </a>
                                                @else
                                                    <div class="action-placeholder"></div>
                                                @endif

                                                {{-- เงื่อนไขปุ่มรายละเอียด --}}
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
                            @endif
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- CSS ปรับแต่งเพิ่มเติม --}}
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

    .custom-table {
        table-layout: fixed;
        width: 100%;
        word-wrap: break-word;
        white-space: normal;
    }

    .custom-table th,
    .custom-table td {
        overflow-wrap: break-word;
        word-break: break-word;
        white-space: normal;
        vertical-align: middle;
    }

    .custom-table th:nth-child(1),
    .custom-table td:nth-child(1) {
        width: 5%;
    }

    .custom-table th:nth-child(2),
    .custom-table td:nth-child(2) {
        width: 15%;
    }

    .custom-table th:nth-child(3),
    .custom-table td:nth-child(3) {
        width: 20%;
    }

    .custom-table th:nth-child(4),
    .custom-table td:nth-child(4) {
        width: 15%;
    }

    .custom-table th:nth-child(5),
    .custom-table td:nth-child(5) {
        width: 10%;
    }

    .custom-table th:nth-child(6),
    .custom-table td:nth-child(6) {
        width: 15%;
    }

    .custom-table th:nth-child(7),
    .custom-table td:nth-child(7) {
        width: 20%;
    }

    .custom-table tbody tr:nth-child(odd) {
        background-color: #ffffff;
    }

    .custom-table tbody tr:nth-child(even) {
        background-color: rgb(2, 11, 21);
    }
</style>

@endsection {{-- ปิด section content --}}
