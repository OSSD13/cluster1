@extends('layouts.default_with_menu')
@section('page-title', 'กิจกรรมที่เคยทำ')
@section('content')
    <div class="container">
        <!-- ส่วนบนของการ์ดข้อมูล (4 คอลัมน์) -->
        <div class="row g-3">
            <div class="col-md-3">
                <label class="form-label fw-normal">ปีที่ทำกิจกรรม</label>
                <div class="card p-4 shadow-sm rounded-3">
                    <table style="width: 101%;">
                        <tr>
                            <td class="text-left">{{ $latestYear->year_name }}</td>
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

                            <td class="text-left">
                                @php
                                    \Carbon\Carbon::setLocale('th');
                                @endphp

                                {{ \Carbon\Carbon::parse($category_due_date)->translatedFormat('j F Y') }}
                            </td>


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

            <div class="col-md-3">
                <label class="form-label">กิจกรรมที่ผ่านทั้งหมด</label>
                <div class="card p-4 shadow-sm rounded-3">
                    <table>
                        <tr>
                            <td class="text-left" style="width: 74%;">{{  $completedActivities }}</td>
                            <td class="text-right">หมวดหมู่</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label">กิจกรรมที่แก้ไขทั้งหมด</label>
                <div class="card p-4 shadow-sm rounded-3">
                    <table>
                        <tr>
                            <td class="text-left" style="width: 74%;">{{ $EditActivity }}</td>
                            <td class="text-right">หมวดหมู่</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- {{-- <div class="col-md-3">
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
    </div> --}} -->

        </div>


        <h4 class="mt-4 fw-bold">หมวดหมู่</h4><br>
        <style>
            .row.g-3 {
                /* Select the row containing your category cards */
                display: flex;
                flex-wrap: wrap;
                /* Allow cards to wrap to the next line */
            }

            .col-sm-6,
            .col-md-4,
            .col-lg-4 {
                /* Target the columns containing each card */
                display: flex;
                flex-direction: column;
                /* Arrange card content vertically */
            }

            .card.p-3.shadow-sm.rounded-4 {
                /* Target the card itself */
                flex-grow: 1;
                /* Allow the card to grow and take up available vertical space */
                display: flex;
                flex-direction: column;
                /* Ensure inner elements are also in a column */
            }

            .card-text {
                flex-grow: 1;
                /* Allow the description to take up remaining vertical space */
            }
        </style>
        @if ($categories->count() > 0)
            <div class="row g-3">
                @foreach ($categories as $category)
                        <div class="col-sm-6 col-md-4 col-lg-4 mb-3">
                            <div class="card p-3 shadow-sm rounded-4" style="width: 100%;">
                                <h5 class="d-flex align-items-center"
                                    style="border-bottom: 1px solid #dcdcdc; padding-bottom: 10px;-webkit-line-clamp: 1; -webkit-box-orient: vertical; display: -webkit-box; overflow: hidden; text-overflow: ellipsis; font-weight: 600;">
                                    {{ $category->cat_name }}
                                    @if ($category->cat_ismandatory)
                                        <span class="text-danger ms-2">*</span>
                                    @endif
                                </h5>
                                <p class="text-muted">รายละเอียด</p>
                                <p class="card-text">
                                    {{ $category->description }}
                                </p>
                            </div>
                        </div>
                        @if (($loop->iteration % 3) == 0 && !$loop->last)
                            </div>
                            <div class="row g-3">
                        @endif
                @endforeach
            </div>
        @else
            <div class="alert alert-warning text-center mt-4">ยังไม่มีหมวดหมู่สำหรับปีล่าสุด</div>
        @endif

    </div>
@endsection
