@extends('layouts.default_with_menu')
@section('page-title', 'กำหนดหมวดหมู่')
@section('content')
    <div class="container mt-4">
        <!-- ส่วนหัวของ Dashboard -->
        <div class="row mb-4">

            <!-- แสดงตามปีที่เลือก -->
            <div class="col-md-3">
                <form method="GET" action="{{ route('categories.index') }}" id="yearForm">
                    <label for="year_id" class="form-label">ปี</label>

                    <select name="year_id" id="yearFilter" class="form-select"
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
                <div class="input-group">
                    <input type="text" class="form-control start bg-light" value="15 มกราคม 2569" readonly>
                    <span class="input-group-text">📅</span>
                </div>

                <!-- <div class="input-group">
                    <input type="date" id="act_date" name="act_date" class="form-control"
                    value="{{ \Carbon\Carbon::parse($activity->act_date ?? now())->format('Y-m-d') }}"required>
                </div> -->

            </div>
            <div class="col-md-3">
                <label class="form-label">หมวดหมู่ทั้งหมด</label>
                <input type="text" class="form-control start bg-light" value="{{ count($categories) }}" readonly>
            </div>
            @if ($selectedYearId >= $latestYearID->year_id)
            <div class="col-md-3 text-end">
                <form action="{{ route('categories.publishAll') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success mt-4" style="background-color: #45DA56; border-color: #45DA56; color: white;padding: 8px 24px; " >ส่งหมวดหมู่</button>
                </form>
            </div>
            @else
            <div class="col-md-3 text-end">
                <form action="{{ route('categories.publishAll') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn  mt-4" style="background-color: #E9E9E9;border-color:#E9E9E9;  color: rgb(0, 0, 0) ;padding: 8px 24px; " disabled >ส่งหมวดหมู่</button>
                </form>
            </div>
            @endif
        </div>

        <!-- ตารางแสดงหมวดหมู่กิจกรรม -->
        <div class="card shadow">
            <div class="card-body">
                <h5 class="mb-3 fw-bold">หมวดหมู่กิจกรรม</h5>
                <table class="table table-striped">
                    <thead class="table-light">
                        <tr>
                            <th>ลำดับ</th>
                            <th>หมวดหมู่</th>
                            <th>ประเภท</th>
                            <th>สถานะ</th>
                            <th class="text-center">การกระทำ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $index => $category)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $category->cat_name }}</td>
                                <td>
                                    @if ($category->cat_ismandatory)
                                        <span style="background-color: #FFBEBE; color: #DC2626; padding: 0.85px 15px; border-radius: 20px; font-size: 0.75rem; font-weight: bold">บังคับ</span>
                                    @endif
                                </td>
                                <td>
                                    <!-- @if ($category->status == 'published')
                                        <span class="badge bg-success" >ส่งแล้ว</span>
                                    @else
                                        <span class="badge bg-warning text-dark" >ยังไม่ส่ง</span>
                                    @endif -->
                                    @if ($category->status == 'published')
                                        <span style="background-color:rgba(0, 255, 30, 0.3); color: #43AF00; padding: 0.85px 15px; border-radius: 20px; font-size: 0.75rem; font-weight: bold">
                                        • ส่งแล้ว
                                        </span>
                                    @else
                                        <span style="background-color:rgba(180, 180, 180, 0.3); color: #898989; padding: 0.85px 15px; border-radius: 20px; font-size: 0.75rem; font-weight: bold">
                                        • ยังไม่ส่ง
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center mt-4">
                                    @if ($category->status == 'pending')
                                    <a href="{{route('categories.edit', $category->cat_id)}}" class="btn btn-lg btn-warning btn-sm" style="background-color: #FFB200; color: #FFFFFF;" >แก้ไข</a>
                                    <a href="{{route('categories.detail', $category->cat_id) }}" class="btn btn-info btn-sm" style = "background-color: #2079FF; color: #FFFFFF;">รายละเอียด</a>
                                    @endif
                                    @if ($category->status == 'published')
                                    <a href="{{route('categories.detail', $category->cat_id) }}" class="btn btn-info btn-sm" style = "background-color: #2079FF; color: #FFFFFF;">รายละเอียด</a>
                                @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ปุ่มสร้างหมวดหมู่ -->
{{-- {{dd($selectedYearId, $latestYearID->year_id)}} --}}
        @if ($selectedYearId >= $latestYearID->year_id)
        <div class="text-center mt-4">
            <a href="{{ route('categories.create') }}" class="btn btn-lg btn-primary" style="background-color: #81B7D8; border-color: #81B7D8; color: white;padding: 8px 36px; ">
                สร้างหมวดหมู่
            </a>
        </div>
        @endif
        <!-- เหลือเอาปุ่มออกถ้าปีที่เลือกไม่ใช่ปีปัจจุบัน -->

    </div>
@endsection
