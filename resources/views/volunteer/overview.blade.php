@extends('layouts.default_with_menu')

@section('content')
<div class="container">
        <!-- ส่วนบนของการ์ดข้อมูล (4 คอลัมน์) -->
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label">ปีที่ทำกิจกรรม</label>
                <div class="card p-4 shadow-sm rounded-3">
                    <table style="width: 101%;">
                        <tr>
                            <td class="text-left">2568</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label">สถานะของกิจกรรม</label>
                <div class="card p-4 shadow-sm rounded-3">
                    <table style="width: 101%;">
                        <tr>
                            <td class="text-left">ยังไม่ส่งกิจกรรม</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label">กำหนดส่ง</label>
                <div class="card p-4 shadow-sm rounded-3">
                    <table style="width:110%;">
                        <tr>
                            <td class="text-left">15 มกราคม 2569 </td>
                            <td class="text-left"> 📅</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label">หมวดหมู่ทั้งหมด</label>
                <div class="card p-4 shadow-sm rounded-3">
                    <table>
                        <tr>
                            <td class="text-left" style="width: 74%;">{{ $categoryCount }}</td>
                            <td class="text-right">หมวดหมู่</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- สถานะหมวดหมู่เพิ่มเติม -->
        <div class="row g-3 mt-0">
            <div class="col-md-3">
                <label class="form-label">หมวดหมู่ที่ทำสำเร็จ</label>
                <div class="card p-4 shadow-sm rounded-3">
                    <table>
                        <tr>
                            <td class="text-left" style="width: 74%;">{{ $completedCategories }}</td>
                            <td class="text-right">หมวดหมู่</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label">หมวดหมู่ที่ยังไม่ทำ</label>
                <div class="card p-4 shadow-sm rounded-3">
                    <table>
                        <tr>
                            <td class="text-left" style="width: 74%;">{{ $categoryCount - $completedCategories }}</td>
                            <td class="text-right">หมวดหมู่</td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- <div class="col-md-3">
                <label class="form-label">หมวดหมู่ที่ผ่านทั้งหมด</label>
                <div class="card p-4 shadow-sm rounded-3">
                    <table>
                        <tr>
                            <td class="text-left" style="width: 74%;">{{ $approvedCategories }}</td>
                            <td class="text-right">หมวดหมู่</td>
                        </tr>
                    </table>
                </div>
            </div> --}}

            {{-- <div class="col-md-3">
                <label class="form-label">หมวดหมู่ที่ต้องแก้ไขทั้งหมด</label>
                <div class="card p-4 shadow-sm rounded-3">
                    <table>
                        <tr>
                            <td class="text-left" style="width: 74%;">{{ $rejectedCategories }}</td>
                            <td class="text-right">หมวดหมู่</td>
                        </tr>
                    </table>
                </div>
            </div> --}}
        </div>

        <!-- หัวข้อหมวดหมู่ -->
        <h4 class="mt-4 fw-bold">หมวดหมู่</h4><br>

        <!-- การ์ดหมวดหมู่ -->
        <div class="row g-3">
            @foreach ($categories as $category)
                <div class="col-sm-6 col-md-4 col-lg-4">
                    <div class="card p-3 shadow-sm rounded-4" style="max-width: 25rem;">
                        <h5 class="fw-bold d-flex align-items-center">
                            {{ $category->cat_name }}
                            @if ($category->cat_ismandatory)
                                <span class="text-danger ms-2">*</span> <!-- แสดง * เฉพาะหมวดหมู่บังคับ -->
                            @endif
                        </h5>
                        <p class="text-muted">รายละเอียด</p>
                        <p class="card-text">{{ $category->description }}</p>


                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
