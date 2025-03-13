@extends('layouts.default_with_menu')

@section('content')


    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h4>สร้างกิจกรรมใหม่</h4>
        </div>
        <div class="card-body">
            {{-- action="{{ route('activity.store') }}" --}}
            <form  method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="title" class="form-label">หัวข้อ</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="category_id" class="form-label">หมวดหมู่</label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        <option value="" disabled selected>เลือกหมวดหมู่</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->cat_id }}">{{ $category->cat_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">เนื้อหา</label>
                    <textarea name="description" id="description" rows="5" class="form-control" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="image" class="form-label">แนบรูปภาพ</label>
                    <input type="file" name="image" id="image" class="form-control">
                </div>

                <button type="submit" class="btn btn-success">สร้างกิจกรรม</button>
            </form>
        </div>
    </div>
    <style>
        .card{
            width: 50%;
            margin: 0 auto;
            margin-top: 100px;
        }
    </style>


@endsection