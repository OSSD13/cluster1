@extends('layouts.default_with_menu')
@section('page-title', 'กำหนดหมวดหมู่')
@section('content')

<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card shadow" style="width: 900px;">

        <div class="card-body">
            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('categories.update' , $category->cat_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="cat_name" class="form-label">หมวดหมู่<span style="color: red;"> *</span></label>
                    <input type="text" name="cat_name" id="cat_name" class="form-control @error('cat_name') is-invalid @enderror" value="{{ old('cat_name', $category->cat_name) }}" required>
                    @error('cat_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">รายละเอียด (ถ้ามี)</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="row">
                        <div class="col">
                            <label class="form-label" style="display: block; margin-bottom: 6px;">ประเภทหมวดหมู่ <span style="color: red;">*</span></label>
                        </div>
                        <div class="col">
                            <div style="display: inline-block; margin-right: 20px;">
                                <input type="radio" name="cat_ismandatory" id="mandatory_no" value="0"
                                    {{ old('cat_ismandatory', $category->cat_ismandatory) == '0' ? 'checked' : '' }}
                                    style="margin-right: 6px;">
                                <label for="mandatory_no">ไม่บังคับ</label>
                            </div>
                        </div>
                        <div class="col">
                            <div style="display: inline-block;">
                                <input type="radio" name="cat_ismandatory" id="mandatory_yes" value="1"
                                    {{ old('cat_ismandatory', $category->cat_ismandatory) == '1' ? 'checked' : '' }}
                                    style="margin-right: 6px;">
                                <label for="mandatory_yes">บังคับ</label>
                            </div>
                        </div>

                        @error('cat_ismandatory')
                        <div style="color: red; margin-top: 4px;">{{ $message }}</div>
                        @enderror

                    </div>
                </div>


                <div class="mb-3" style="display: none;">
                    <label for="expiration_date" class="form-label">วันหมดอายุ</label>
                    <input type="date" name="expiration_date" id="expiration_date"
                        class="form-control @error('expiration_date') is-invalid @enderror"
                        value="{{ old('expiration_date', \Carbon\Carbon::now()->addYear()->month(1)->day(31)->format('Y-m-d')) }}"
                        readonly>
                    @error('expiration_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3" style="display: none;">
                    <label for="cat_year_id" class="form-label">ปีที่ทำกิจกรรม</label>
                    <select name="cat_year_id" id="cat_year_id" class="form-select @error('cat_year_id') is-invalid @enderror" required>
                        @foreach($years as $year)
                        <option value="{{ $year->year_id }}" {{ old('cat_year_id' , $category->cat_year_id) == $year->year_id ? 'selected' : '' }}>
                            {{ $year->year_name }}
                        </option>
                        @endforeach
                    </select>
                    @error('cat_year_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 justify-content-between">
                    <a href="{{ route('categories.index') }}" class="btn btn-danger btn-lg w-25">ยกเลิก</a>
                    <button type="submit" class="btn btn-primary btn-lg w-25">บันทึก</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection