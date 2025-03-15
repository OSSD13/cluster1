@extends('layouts.default_with_menu')
@section('page-title', 'ภาพรวม')

@section('content')

<style>
    .content-container {
        margin-left: 38vh; /* เว้นระยะห่างจาก Sidebar */
        margin-top: 8vh; /* เว้นระยะห่างจาก Header */
        padding: 20px;
        transition: all 0.3s ease-in-out;
    }

    .container {
        width: 100%; /* ทำให้ container กว้างพอดีกับหน้าจอ */
        background: rgb(255, 255, 255);



    }

    .card {
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        background: white;
        color: #333;
        height: 70%;
    }

    /* ปรับให้การ์ดเรียง 4 อันต่อแถว */
    .row {
        display: flex;
        flex-wrap: wrap; /* ถ้ามีมากกว่า 4 อัน ให้ขึ้นบรรทัดใหม่ */
        gap: 15px;
        justify-content: flex-start;
    }

    .col-md-3 {
        flex: 1;
        min-width: calc(100% / 4 - 20px); /* คำนวณให้มี 4 อันพอดี */
        max-width: calc(100% / 4 - 20px);
    }

    @media (max-width: 1200px) {
        .col-md-3 {
            min-width: calc(100% / 3 - 20px); /* ลดเหลือ 3 อันต่อแถวเมื่อจอเล็กลง */
            max-width: calc(100% / 3 - 20px);
        }
    }

    @media (max-width: 768px) {
        .col-md-3 {
            min-width: calc(100% / 2 - 20px);
            max-width: calc(100% / 2 - 20px);
        }
    }
    p {
        margin-bottom: 0;
    }
</style>

<div class="content-container">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <label class="form-label">ปีที่ทำกิจกรรม</label>
                <div class="card">
                    <p>2568</p>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label">สถานะของกิจกรรม</label>
                <div class="card">
                    <p>ยังไม่ส่งกิจกรรม</p>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label">กำหนดส่ง</label>
                <div class="card">
                    <p>15 มกราคม 2569 📅</p>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label">หมวดหมู่ทั้งหมด</label>
                <div class="card">
                    <p>6 หมวดหมู่</p>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label">หมวดหมู่ที่ทำสำเร็จ</label>
                <div class="card">
                    <p>0 หมวดหมู่</p>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label">หมวดหมู่ที่ยังไม่ทำ</label>
                <div class="card">
                    <p>6 หมวดหมู่</p>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label">หมวดหมู่ที่ผ่านทั้งหมด</label>
                <div class="card">
                    <p>4 หมวดหมู่</p>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label">หมวดหมู่ที่ต้องแก้ไข</label>
                <div class="card">
                    <p>2 หมวดหมู่</p>
                </div>
            </div>
        </div>

        <!-- ✅ หัวข้อหมวดหมู่ -->
        <h4 class="mt-4 fw-bold">หมวดหมู่</h4>

        <!-- ✅ การ์ดหมวดหมู่ -->
        {{-- <div class="row">
            @foreach ($categories as $category)
                <div class="col-sm-6 col-md-4">
                    <div class="card p-3">
                        <h5>{{ $category->cat_name }}</h5>
                        <p>{{ $category->description }}</p>
                    </div>
                </div>
            @endforeach
        </div> --}}
    </div>
</div>

@endsection
