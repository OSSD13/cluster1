@extends('layouts.default_with_menu')
@section('page-title', 'อนุมัติงาน')
@section('content')
    <a href="javascript:history.back()" class="btn btn-light mb-3">

        <i class="bi bi-chevron-left"></i>
    </a>

        <div class="row">
            @forelse ($activities as $activity)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100" style="border-radius: 12px;">
                        <div class="card-body d-flex flex-column" style="position: relative; flex: 1; min-width: 0;">
                            <p class="mb-0 fw-light text-truncate" style="max-width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $activity->act_title }}">
                                {{ $activity->act_title }}
                            </p>
                            <hr>

                            <p class="mb-1 fw-light">รายละเอียด</p>
                            <!-- <div class="text-muted" style="
                                display: -webkit-box;
                                -webkit-line-clamp: 2;
                                -webkit-box-orient: vertical;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                max-height: 3em;
                            ">
                                {{ $activity->act_description }}
                            </div>
                            <a href="{{ route('province.approve.category.activities.detail', ['user_id' => $user->user_id, 'cat_id' => $category->cat_id, 'act_id'=> $activity->act_id]) }}" class="text-decoration-none text-dark">
                                ...ดูเพิ่มเติม
                            </a>
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('province.approve.category.activities.detail', ['user_id' => $user->user_id, 'cat_id' => $category->cat_id, 'act_id'=> $activity->act_id]) }}"
                                    class="btn btn-sm btn-custom-blue" style="width: 30%; background-color: #81B7D8; color: white; border-radius: 12px;">
                                    รายละเอียด
                                </a>
                            </div> -->

                            <p class="text-muted mb-4 fw-light" style="
                                display: -webkit-box;
                                -webkit-line-clamp: 2;
                                -webkit-box-orient: vertical;
                                overflow: hidden;
                                text-overflow: ellipsis;
                                max-height: 3em;
                            ">
                                {{ $activity->act_description }}
                                @if (mb_strlen($activity->act_description) >70) <!-- ตรวจสอบว่าคำอธิบายยาวเกินตัวอักษร -->
                                    <a href="{{ route('province.approve.category.activities.detail', ['user_id' => $user->user_id, 'cat_id' => $category->cat_id, 'act_id'=> $activity->act_id]) }}"
                                        class="text-decoration-none">ดูเพิ่มเติม</a>
                                @endif

                                <!-- ขยายการ์ดตามรายละเอียด -->
                                <!-- <p class="text-muted mb-0 two-lines">
                                    {{ $activity->act_description }}
                                </p> -->
                            </p>

                            <div class="d-flex justify-content-start mt-2">
                                @php
                                    $commentShown = false; // ตัวแปรช่วยเพื่อเช็คว่ามีการแสดงคอมเมนต์แล้ว
                                @endphp
                                @foreach($approval as $apv)
                                    @if ($activity->act_id == $apv->apv_act_id && !$commentShown)
                                        <span class="text-dark fw-light">มีคอมเมนต์*</span>
                                        @php
                                            $commentShown = true; // เมื่อแสดงคอมเมนต์แล้วจะเปลี่ยนค่าตัวแปร
                                        @endphp
                                    @endif
                                @endforeach
                            </div>


                            <div class="d-flex justify-content-end mt-2">
                                <a href="{{ route('province.approve.category.activities.detail', ['user_id' => $user->user_id, 'cat_id' => $category->cat_id, 'act_id'=> $activity->act_id]) }}"
                                   class="btn btn-sm custom-btn" style="border-radius: 12px; position: absolute; bottom: 10px; right: 10px;">
                                   <style>
                                   .custom-btn {
                                    background-color: #81b7d8;
                                    color: white;
                                    border: 1px solid #81b7d8;
                                    transition: background-color 0.3s, border-color 0.3s;
                                    }

                                    .custom-btn:hover {
                                    background-color: #5d93b3;
                                    border-color: #5d93b3;
                                    color: white;
                                    }

                                    .custom-btn:active {
                                    background-color: #4a7d9b !important;
                                    border-color: #4a7d9b !important;
                                    color: white !important;
                                    }

                                    </style>
                                    รายละเอียด
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted fw-light">ไม่มีหมวดหมู่กิจกรรมที่ส่งมา</p>
            @endforelse
        </div>
    </div>

@endsection
