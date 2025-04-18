@extends('layouts.default_with_menu')

@section('page-title', 'กำหนดหมวดหมู่')
@section('content')
<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card shadow" style="width: 900px;">
        <div class="card-body">
            @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="cat_name" class="form-label ">หมวดหมู่<span style="color:red"> *</span></label>
                    <input type="text" name="cat_name" id="cat_name" placeholder="ชื่อหมวดหมู่"
                        class="form-control @error('cat_name') is-invalid @enderror" value="{{ old('cat_name') }}"
                        required>
                    @error('cat_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">รายละเอียด (ถ้ามี)</label>
                    <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror"
                        placeholder="รายละเอียดของหมวดหมู่"
                        rows="10">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- <div class="mb-3">
                        <label for="cat_ismandatory" class="form-label">ประเภทหมวดหมู่</label>
                        <select name="cat_ismandatory" id="cat_ismandatory"
                            class="form-select @error('cat_ismandatory') is-invalid @enderror" required>
                            <option value="1" {{ old('cat_ismandatory') == '1' ? 'selected' : '' }}>บังคับ</option>
                            <option value="0" {{ old('cat_ismandatory') == '0' ? 'selected' : '' }}>ไม่บังคับ</option>
                        </select>
                        @error('cat_ismandatory')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div> -->

                <div class="mb-3">
                    <div class="row">
                        <div class="col-3">
                            <label class="form-label">ประเภทหมวดหมู่<span style="color:red"> *</span></label>
                        </div>
                        <div class="col-3">
                            <div class="form-check">
                                <input type="radio" name="cat_ismandatory" id="cat_ismandatory_0" value="0"
                                    class="form-check-input @error('cat_ismandatory') is-invalid @enderror"
                                    {{ old('cat_ismandatory') == '0' ? 'checked' : '' }} required>
                                <label for="cat_ismandatory_0" class="form-check-label">ไม่บังคับ</label>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="form-check">
                                <input type="radio" name="cat_ismandatory" id="cat_ismandatory_1" value="1"
                                    class="form-check-input @error('cat_ismandatory') is-invalid @enderror"
                                    {{ old('cat_ismandatory') == '1' ? 'checked' : '' }} required>
                                <label for="cat_ismandatory_1" class="form-check-label">บังคับ</label>
                            </div>
                        </div>

                    </div>
                    @error('cat_ismandatory')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 d-none">
                    <label for="expiration_date" class="form-label">วันหมดอายุ</label>
                    <input type="date" name="expiration_date" id="expiration_date"
                        class="form-control @error('expiration_date') is-invalid @enderror"
                        value="{{ old('expiration_date', \Carbon\Carbon::now()->addYear()->month(1)->day(31)->format('Y-m-d')) }}"
                        readonly>
                    @error('expiration_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 d-none">
                    <label for="cat_year_id" class="form-label">ปีที่ทำกิจกรรม</label>
                    <select name="cat_year_id" id="cat_year_id" class="form-select shadow-sm" required>
                        <option value="{{ $selectedYearId }}" selected>
                            {{ $years->firstWhere('year_id', $selectedYearId)?->year_name ?? '-' }}
                        </option>
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