@extends('layouts.default_with_menu')

@section('content')
    <div class="container mt-4">
        <!-- ส่วนหัวของ Dashboard -->
        <div class="row mb-4">
            <div class="col-md-3">
                <label class="form-label">ปี</label>
                <input type="text" class="form-control text-center bg-light" value="2568" readonly>
            </div>
            <div class="col-md-3">
                <label class="form-label">กำหนดส่ง</label>
                <div class="input-group">
                    <input type="text" class="form-control text-center bg-light" value="15 มกราคม 2569" readonly>
                    <span class="input-group-text">📅</span>
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label">หมวดหมู่ทั้งหมด</label>
                <input type="text" class="form-control text-center bg-light" value="{{ count($categories) }}" readonly>
            </div>
            <div class="col-md-3 text-end">
                <form action="{{ route('categories.publishAll') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success mt-4">ส่งหมวดหมู่</button>
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
                                        <span class="badge bg-danger">บังคับ</span>
                                    @else
                                        <span class="badge bg-secondary">ไม่บังคับ</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($category->status == 'published')
                                        <span class="badge bg-success">ส่งแล้ว</span>
                                    @else
                                        <span class="badge bg-warning text-dark">ยังไม่ส่ง</span>
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
            <a href="{{ route('categories.create') }}" class="btn btn-lg btn-primary">สร้างหมวดหมู่</a>
        </div>
    </div>
@endsection
