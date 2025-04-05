@extends('layouts.default_with_menu')

@section('content')
    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4>เพิ่มหมวดหมู่</h4>
            </div>
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

                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="cat_name" class="form-label">ชื่อหมวดหมู่</label>
                        <input type="text" name="cat_name" id="cat_name" class="form-control @error('cat_name') is-invalid @enderror" value="{{ old('cat_name') }}" required>
                        @error('cat_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">คำอธิบายหมวดหมู่</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cat_ismandatory" class="form-label">ประเภทหมวดหมู่</label>
                        <select name="cat_ismandatory" id="cat_ismandatory" class="form-select @error('cat_ismandatory') is-invalid @enderror" required>
                            <option value="1" {{ old('cat_ismandatory') == '1' ? 'selected' : '' }}>บังคับ</option>
                            <option value="0" {{ old('cat_ismandatory') == '0' ? 'selected' : '' }}>ไม่บังคับ</option>
                        </select>
                        @error('cat_ismandatory')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="expiration_date" class="form-label">วันหมดอายุ</label>
                        <input type="date" name="expiration_date" id="expiration_date"
                        class="form-control @error('expiration_date') is-invalid @enderror"
                        value="{{ old('expiration_date', \Carbon\Carbon::now()->addYear()->month(1)->day(31)->format('Y-m-d')) }}"
                        readonly>
                        @error('expiration_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="cat_year_id" class="form-label">ปีที่ทำกิจกรรม</label>
                        <select name="cat_year_id" id="cat_year_id" class="form-select @error('cat_year_id') is-invalid @enderror" required>
                            @foreach($years as $year)
                            <option value="{{ $year->year_id }}" {{ old('cat_year_id') == $year->year_id ? 'selected' : '' }}>
                                {{ $year->year_name }}
                            </option>
                            @endforeach
                        </select>
                        @error('cat_year_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">บันทึก</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">ย้อนกลับ</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
