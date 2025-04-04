@extends('layouts.default_with_menu')

@section('content')

<div class="container mt-4">
    <!-- ค้นหา -->
    <div class="row mb-3">
        <div class="col-md-4">
            <input type="text" class="form-control" placeholder="🔍 ค้นหา">
        </div>
    </div>

    <!-- ส่วนหัวของหน้า -->
    <div class="row mb-4">
        <div class="col-md-3">
            <label class="form-label">ปีที่ทำกิจกรรม</label>
            <select class="form-select">
                <option selected>2568</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">จังหวัด</label>
            <input type="text" class="form-control text-center bg-light" value="ชลบุรี" readonly>
        </div>
        <div class="col-md-3">
            <label class="form-label">จำนวนอาสา</label>
            <input type="text" class="form-control text-center bg-light" value="123 คน" readonly>
        </div>
        <div class="col-md-3">
            <label class="form-label">จำนวนกิจกรรม</label>
            <input type="text" class="form-control text-center bg-light" value="235 กิจกรรม" readonly>
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
                        <th>ชื่อเจ้าหน้าที่อาสา</th>
                        <th>จังหวัด</th>
                        <th>สถานะ</th>
                        <th class="text-center">การกระทำ</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($activities as $index => $activity)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $activity->user->name ?? 'ไม่ระบุชื่อ' }}</td>
                            <td>{{ $activity->province ?? 'ไม่ระบุจังหวัด' }}</td>
                            <td>
                                <span class="badge bg-secondary">ยังไม่ตรวจสอบ</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('activities.review', $activity->id) }}" class="btn btn-primary btn-sm">รายละเอียด</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">ไม่มีข้อมูลกิจกรรม</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <label class="form-label">Show</label>
                    <select class="form-select d-inline-block w-auto">
                        <option>8</option>
                        <option>10</option>
                        <option>20</option>
                    </select>
                    <span>Row</span>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
