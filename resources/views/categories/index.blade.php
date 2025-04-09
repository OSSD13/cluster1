@extends('layouts.default_with_menu')

@section('content')
    <div class="container mt-4">
        <!-- ส่วนหัวของ Dashboard -->
        <div class="row mb-4">
            <div class="col-md-3">
                <label class="form-label">ปี</label>
                <!-- <input type="text" class="form-control text-center bg-light" value="2568" readonly> -->
                <select name="year" id="year" class="form-control">
                    <!-- <option value="" disabled>แสดงปี 2560-2570</option> -->
                    @foreach(range(2560, 2570) as $year)
                        <option value="{{ $year }}" {{ $year == 2568 ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach

                </select>

            </div>
            <div class="col-md-3">
                <label class="form-label">กำหนดส่ง</label>
                <!-- <div class="input-group">
                    <input type="text" class="form-control text-center bg-light" value="15 มกราคม 2569" readonly>
                    <span class="input-group-text">📅</span>
                </div> -->

                <div class="input-group">
                    <input type="date" id="act_date" name="act_date" class="form-control"
                    value="{{ \Carbon\Carbon::parse($activity->act_date ?? now())->format('Y-m-d') }}"required>
                </div>

            </div>
            <div class="col-md-3">
                <label class="form-label">หมวดหมู่ทั้งหมด</label>
                <input type="text" class="form-control start bg-light" value="{{ count($categories) }}" readonly>
            </div>
            <div class="col-md-3 text-end">
                <form action="{{ route('categories.publishAll') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success mt-4" style="background-color: #45DA56; border-color: #45DA56; color: white;padding: 8px 24px; ">ส่งหมวดหมู่</button>
                </form>
            </div>
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
                                   <a href="{{route('categories.edit', $category->cat_id)}}" class="btn btn-lg btn-warning btn-sm">แก้ไข</a>
                                   <a href="{{ route('categories.detail', $category->cat_id) }}" class="btn btn-info btn-sm" style = "background-color:#2079FF">รายละเอียด</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ปุ่มสร้างหมวดหมู่ -->
        <div class="text-center mt-4">
            <a href="{{ route('categories.create') }}" class="btn btn-lg btn-primary" style="background-color: #81B7D8; border-color: #81B7D8; color: white;padding: 8px 36px; ">สร้างหมวดหมู่</a>
    
@endsection
