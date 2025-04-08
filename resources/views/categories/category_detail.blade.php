@extends('layouts.default_with_menu')
@section('page-title', 'รายละเอียดหมวดหมู่')
@section('content')
<a href="{{ route('categories.index') }}" class="btn btn-light mb-3 ">
    <i class="bi bi-chevron-left"></i>
</a>

<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card shadow" style="width: 900px;">
        <div class="card-body">
            <div class="mb-3">
                <label for="cat_name" class="form-label">หมวดหมู่ <span class="text-danger">*</span></label>
                <input type="text" class="form-control bg-white rounded border" id="cat_name" value="{{ $category->cat_name }}" disabled>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">รายละเอียด (ถ้ามี)</label>
                <textarea class="form-control bg-white rounded border" id="description" rows="10" style="resize: none;" disabled>{{ $category->description }}</textarea>
            </div>

            <div class="mb-3 d-flex align-items-center gap-3">
                <label class="form-label mb-0">ประเภทหมวดหมู่ <span class="text-danger">*</span></label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cat_ismandatory" id="mandatory" value="1" {{ $category->cat_ismandatory == 1 ? 'checked' : '' }} disabled>
                        <label class="form-check-label" for="mandatory">บังคับ</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="cat_ismandatory" id="optional" value="0" {{ $category->cat_ismandatory == 0 ? 'checked' : '' }} disabled>
                        <label class="form-check-label" for="optional">ไม่บังคับ</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection