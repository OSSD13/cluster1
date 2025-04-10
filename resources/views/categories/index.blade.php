@extends('layouts.default_with_menu')
@section('page-title', 'กำหนดหมวดหมู่')
@section('content')

<div class="container" style="margin-top: -20px;">
    <div class="container mt-4">
        <div class="row mb-4">
            <div class="col-md-3">
                <form method="GET" action="{{ route('categories.index') }}" id="yearForm">
                    <label for="year_id" class="form-label">ปี</label>
                    <select name="year_id" id="yearFilter" class="form-select bg-white d-flex justify-content-between align-items-center" style="height: 55px; font-size: 1rem; padding: 0.75rem;"
                        onchange="document.getElementById('yearForm').submit()">
                    @foreach ($years as $year)
                        <option value="{{ $year->year_id }}" {{ $year->year_id == $selectedYearId ? 'selected' : '' }}>
                            {{ $year->year_name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="col-md-3">
            <label class="form-label">กำหนดส่ง</label>
            @php
    use Carbon\Carbon;

    $category = $categories->first();
    $date = $category->expiration_date ?? now();

    Carbon::setLocale('th'); // ตั้งค่าภาษาไทย

    $carbonDate = Carbon::parse($date)->subDays(15); // 🔥 ลบ 15 วัน

    $formattedDate = $carbonDate->translatedFormat('j F Y');

    // ถ้าอยากให้เป็น พ.ศ. ต้องบวก 543 ด้วย
    $formattedDate = str_replace(
        $carbonDate->year,
        $carbonDate->year ,
        $formattedDate
    );
@endphp

<div class="form-control bg-white d-flex justify-content-between align-items-center" style="height: 55px; font-size: 1rem; padding: 0.75rem;">
    {{ $formattedDate }}
</div>
        </div>

        <div class="col-md-3">
            <label class="form-label">หมวดหมู่ทั้งหมด</label>
            <div class="form-control bg-white d-flex justify-content-between align-items-center" style="height: 55px; font-size: 1rem; padding: 0.75rem;">
            {{ count($categories) }}
            </div>
        </div>

        <div class="col-md-3 text-end">
            <form action="{{ route('categories.publishAll') }}" method="POST">
                @csrf
                <button type="submit" class="btn {{ $selectedYearId >= $latestYearID->year_id ? 'btn-success' : '' }} mt-4" style="background-color: {{ $selectedYearId >= $latestYearID->year_id ? '#45DA56' : '#E9E9E9' }}; border-color: {{ $selectedYearId >= $latestYearID->year_id ? '#45DA56' : '#E9E9E9' }}; color: {{ $selectedYearId >= $latestYearID->year_id ? 'white' : 'black' }}; padding: 8px 24px;" {{ $selectedYearId < $latestYearID->year_id ? 'disabled' : '' }}>
                    ส่งหมวดหมู่
                </button>
            </form>
        </div>
    </div>
</div>

<div class="card shadow-sm">
    <div class="card-body p-3">
        <h6 class="mb-3 fw-bold">หมวดหมู่กิจกรรม</h6>
        <table class="table table-sm text-center align-middle custom-table">
            <thead class="table-light small">
                <tr>
                    <th>ลำดับ</th>
                    <th>หมวดหมู่</th>
                    <th class="text-center">ประเภท</th>
                    <th class="text-center">สถานะ</th>
                    <th class="text-center">การกระทำ</th>
                </tr>
            </thead>
            <tbody class="small" id="activityTableBody">
                @foreach ($categories as $index => $category)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $category->cat_name }}</td>
                    <td class="text-center">
                        @if ($category->cat_ismandatory)
                            <span class="badge-custom mandatory">บังคับ</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($category->status == 'published')
                            <span class="status-badge success">● ส่งแล้ว</span>
                        @else
                            <span class="status-badge pending">● ยังไม่ส่ง</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="d-flex justify-content-center align-items-center action-buttons-wrapper">
                            @if ($category->status == 'pending')
                                <a href="{{ route('categories.edit', $category->cat_id) }}" class="btn-custom edit-btn">แก้ไข</a>
                                <a href="{{ route('categories.detail', $category->cat_id) }}" class="btn-custom detail-btn">รายละเอียด</a>
                            @elseif ($category->status == 'published')
                                <a href="{{ route('categories.detail', $category->cat_id) }}" class="btn-custom detail-btn">รายละเอียด</a>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if ($selectedYearId >= $latestYearID->year_id)
<div class="text-center mt-4">
    <a href="{{ route('categories.create') }}" class="btn btn-lg btn-primary" style="background-color: #81B7D8; border-color: #81B7D8; color: white;padding: 8px 36px;">
        สร้างหมวดหมู่
    </a>
</div>
@endif

<style>
    /* ป้ายประเภทหมวดหมู่ */
    .badge-custom.mandatory {
        background-color: #FFE1E1;
        color: #D32F2F;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 5px 12px;
        border-radius: 1.25rem;
        display: inline-block;
    }

    /* สถานะ */
    .status-badge {
        font-weight: 600;
        font-size: 0.85rem;
        padding: 5px 12px;
        border-radius: 1.25rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .status-badge.success {
        background-color: #E0F6E9;
        color: #2E7D32;
    }

    .status-badge.pending {
        background-color: #F5F5F5;
        color: #757575;
    }

    /* ปุ่ม */
    .btn-custom {
        padding: 6px 16px;
        font-size: 0.85rem;
        font-weight: 500;
        border-radius: 0.5rem;
        text-decoration: none;
        display: inline-block;
        margin: 2px;
        transition: 0.2s;
    }

    .edit-btn {
        background-color: #FFB200;
        color: #fff;
    }

    .detail-btn {
        background-color: #2079FF;
        color: #fff;
    }

    .btn-custom:hover {
        filter: brightness(0.95);
    }

    .action-buttons-wrapper {
        gap: 10px;
    }

    /* พื้นหลังและองค์ประกอบทั่วไป */
    .card {
        background-color: #ffffff;
        border-radius: 1rem;
    }

    .form-control, .form-select {
        border-radius: 0.75rem;
    }
</style>
@endsection
