@extends('layouts.default_with_menu')

@section('content')
<a href="{{ route('province.index') }}" class="btn btn-light mb-3 ">
    <i class="bi bi-chevron-left"></i>
</a>
<style>
    .no-padding-top {
    padding-top: 0 !important;
}
</style>
<div class="container no-padding-top py-4">
    <div class="d-flex justify-content-end mb-3">

        <div class="btn-group">
            <form method="POST" action="{{ route('province.approve',$user->user_id) }}?year_id={{ $selectedYearId }}">
                @csrf
                <button class="btn btn-primary fw-light" type="submit">ส่งให้ส่วนกลาง</button>
            </form>
            <form method="POST" action="{{ route('province.rejectActivity', $user->user_id) }}?year_id={{ $selectedYearId }}">
                @csrf
                <button class="btn btn-danger fw-light ms-3" type="submit">ส่งกลับให้เจ้าหน้าที่อาสา</button>
            </form>
        </div>
    </div>

    <div class="row">
        @forelse ($categories as $category)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100" style="border-radius: 12px">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-0">
                            <div style="flex: 1; min-width: 0;">
                                <p class="mb-0 fw-light text-truncate" style="max-width: 100%; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $category->cat_name }}
                                </p>
                            </div>
                            @if($category->cat_ismandatory)
                                <span class="text-danger ms-2">*</span>
                            @endif
                        </div>


                        <hr>
                        <p class="mb-1 fw-light">รายละเอียด</p>
                        <p class="text-muted fw-light mb-4">{{ $category->description }}</p>
                        
                        <div class="d-flex justify-content-end mt-2">
                            <a href="{{ route('province.approve.category.activities', ['user_id' => $user->user_id, 'cat_id' => $category->cat_id]) }}"
                               class="btn btn-sm custom-btn mt-2" style="border-radius: 12px; position: absolute; bottom: 10px; right: 10px;">
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
