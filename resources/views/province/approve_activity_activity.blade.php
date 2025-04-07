@extends('layouts.default_with_menu')

@section('content')
    <a href="javascript:history.back()" class="btn btn-light mb-3"> 
        
        <i class="bi bi-chevron-left"></i>
    </a>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold">กิจกรรมที่ {{ $user->user_fullname }} ส่งมา</h4>
        </div>
       
        <div class="row">
            @forelse ($activities as $activity)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100" style="border-radius: 12px;">
                        <div class="card-body d-flex flex-column" style="position: relative;">
                            <h5 class=" text-truncate" style="max-width: 100%;" title="{{ $activity->act_title }}">
                                {{ $activity->act_title }}
                            </h5>
                            <hr>
                            
                            <p class="mb-1 fw-semibold">รายละเอียด</p>
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

                            <p class="text-muted mb-0" style="
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

                            <div class="d-flex justify-content-end mt-auto">
                                <a href="{{ route('province.approve.category.activities.detail', ['user_id' => $user->user_id, 'cat_id' => $category->cat_id, 'act_id'=> $activity->act_id]) }}" 
                                    class="btn btn-sm btn-custom-blue" style="width: 30%; background-color: #81B7D8; color: white; border-radius: 12px;">
                                    รายละเอียด
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-muted">ไม่มีหมวดหมู่กิจกรรมที่ส่งมา</p>
            @endforelse
        </div>
    </div>
    
@endsection