@extends('layouts.default_with_menu')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold">หมวดหมู่กิจกรรมที่ {{ $user->user_fullname }} ส่งมา</h4>

        <div class="btn-group">
            <form method="POST" action="{{ route('province.approve', $user->user_id) }}">
                @csrf
                <button class="btn btn-primary" type="submit">ส่งให้ส่วนกลาง</button>
            </form>
            <form method="POST" action="{{ route('province.reject', $user->user_id) }}">
                @csrf
                <button class="btn btn-danger" type="submit">ส่งกลับให้เจ้าหน้าที่อาสา</button>
            </form>
        </div>
    </div>

    <div class="row">
        @forelse ($categories as $category)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="fw-bold">{{ $category->cat_name }}
                            @if($category->cat_ismandatory) <span class="text-danger">*</span> @endif
                        </h5>
                        <hr>
                        <p class="mb-1 fw-semibold">รายละเอียด</p>
                        <p class="text-muted">{{ $category->description }}</p>

                        <a href="{{ route('province.approve.category.activities', ['user_id' => $user->user_id, 'cat_id' => $category->cat_id]) }}" class="btn btn-outline-primary btn-sm w-100 mt-2">
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
