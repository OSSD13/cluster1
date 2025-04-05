@extends('layouts.default_with_menu')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">กิจกรรมที่ {{ $user->user_fullname }} ส่งมา</h4>
    </div>

    <div class="row">
        @forelse ($activities as $activity)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="fw-bold">{{ $activity->act_title }}
                        </h5>
                        <hr>
                        <p class="mb-1 fw-semibold">รายละเอียด</p>
                        <p class="text-muted">{{ $activity->act_description }}</p>

                        <a href="{{ route('province.approve.category.activities.detail', ['user_id' => $user->user_id, 'cat_id' => $category->cat_id, 'act_id'=> $activity->act_id]) }}" class="btn btn-outline-primary btn-sm w-100 mt-2">
                            รายละเอียด
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">ไม่มีหมวดหมู่กิจกรรมที่ส่งมา</p>
        @endforelse
    </div>
</div>
@endsection
