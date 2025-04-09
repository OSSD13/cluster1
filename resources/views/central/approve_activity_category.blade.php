    @extends('layouts.default_with_menu')

@section('content')
<a href="{{ route('central.province.index', ['pvc_id' => $provinceID]) }}" class="btn btn-light mb-3 ">
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
            <form method="POST" action="{{ route('central.approve', $user->user_id) }}?pvc_id={{ $provinceID }}&year_id={{ $selectedYearId }}">
                @csrf
                <button class="btn btn-primary fw-light" type="submit">อนุมัติ</button>
            </form>
            <form method="POST" action="{{ route('central.rejectActivity', $user->user_id) }}?pvc_id={{ $provinceID }}&year_id={{ $selectedYearId }}">
                @csrf
                <button class="btn btn-danger fw-light ms-3" type="submit">ส่งกลับให้เจ้าหน้าที่อาสา</button>
            </form>
        </div>
    </div>

    <div class="row">
        <style>
            .category-grid {
                display: grid;
                grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                gap: 1.5rem;
            }

            .category-grid .card {
                height: 100%;
                border-radius: 20px;
                display: flex;
                flex-direction: column;
            }
            </style>

        @forelse ($categories as $category)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100" style="border-radius: 20px">
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
                        <p class="text-muted fw-light">{{ $category->description }}</p>
                        <div class="d-flex justify-content-end mt-2">
                            <a href="{{ route('central.approve.category.activities', ['user_id' => $user->user_id, 'cat_id' => $category->cat_id]) }}"
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
            <p class="text-muted">ไม่มีหมวดหมู่กิจกรรมที่ส่งมา</p>
        @endforelse
    </div>
</div>
@endsection
