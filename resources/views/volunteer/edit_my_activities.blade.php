@extends('layouts.default_with_menu')
@section('page-title', 'แก้ไขงาน')
@section('content')

<a href="{{ route('activities.history') }}" class="btn btn-light mb-3 mt-3">
    <i class="bi bi-chevron-left"></i>
</a>

<!-- Wrapper ที่จัด layout ให้อยู่ตรงกลาง -->
<div class="d-flex justify-content-center">
    <div class="d-flex gap-3" style="max-width: 1000px; width: 100%;">

        <!-- กล่องคอมเมนต์ -->
        @if($comment)
        <div class="col-12 col-md-4 align-self-start">
            <div class="card shadow w-100">
                <div class="card-body">
                    <h2 class="text-lg font-semibold mb-2">คอมเมนต์</h2>
                    <hr class="mb-2">
                    <div class="text-sm text-gray-800">
                        <p class="font-medium">รายละเอียด</p>
                        <p style="white-space: pre-wrap;">{{ $comment }}</p>
                    </div>
                </div>
            </div>
        </div>
        @else
        @endif

        <!-- ฟอร์มด้านขวา -->
        <div class="flex-grow-1">
            <div class="card shadow">
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data"
                        action="{{ route('activities.update', $activity->act_id) }}">
                        @csrf
                        @method('PUT')

                        <!-- ชื่อกิจกรรม & วันที่ -->
                        <div class="row">
                            <div class="col-md-8">
                                <label for="act_title">ชื่อกิจกรรม <span style="color: red;">*</span></label>
                                <input type="text" id="act_title" name="act_title" class="form-control"
                                    value="{{ old('act_title', $activity->act_title) }}" required>
                            </div>
                            <div class="col-md-4">
                                <label for="act_date">วันที่ทำกิจกรรม <span style="color: red;">*</span></label>
                                <input type="date" id="act_date" name="act_date" class="form-control"
                                    value="{{ old('act_date', \Carbon\Carbon::parse($activity->act_date)->format('Y-m-d')) }}"
                                    required>
                            </div>
                        </div>

                        <!-- หมวดหมู่ -->
                        <div class="mb-3 mt-3">
                            <label for="act_cat_id">หมวดหมู่</label>
                            <select name="act_cat_id" id="act_cat_id" class="form-select" required>
                                <option value="" disabled selected>เลือกหมวดหมู่</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->cat_id }}"
                                    {{ $category->cat_id == $activity->act_cat_id ? 'selected' : '' }}>
                                    {{ $category->cat_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- เนื้อหา -->
                        <div class="mb-3">
                            <label for="act_description">เนื้อหา</label>
                            <textarea name="act_description" id="act_description" rows="5" class="form-control"
                                required>{{ old('act_description', $activity->act_description) }}</textarea>
                        </div>

                        <!-- รูปภาพ -->
                        <div class="mb-3">
                            <label for="images">รูปภาพกิจกรรม</label>
                            <div class="upload-container">
                                <input type="file" name="images[]" id="images" class="file-input" accept="image/*"
                                    multiple onchange="previewImages(event)">
                                <label for="images" class="upload-label">อัพโหลด</label>
                            </div>
                            <div class="image-preview mt-3" id="imagePreviewContainer" style="display: block;">
                                <div class="image-preview-grid" id="imagePreviewRow">
                                    @foreach($activity->images as $image)
                                    <div class="image-preview-item" data-id="{{ $image->img_id }}">
                                        <?php $image_path = 'storage/activity_images/' . $image->img_path; ?>
                                        <img src="{{ asset($image_path) }}" alt="{{ $image->img_name }}">

                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- ปุ่มบันทึก -->
                        <button type="submit" class="btn btn-save">บันทึกการแก้ไข</button>
                    </form>
                    <!-- ✅ ฟอร์มลบภาพ อยู่ข้างนอก -->
                    @foreach($activity->images as $image)
                        <div class="image-preview-item">
                            <img src="{{ asset($image->img_path) }}" alt="{{ $image->img_name }}">

                            <form action="{{ route('images.destroy', $image->img_id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="remove-image"onclick="return confirm('ยืนยันลบภาพนี้?')">x</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
<div style="text-align: right; margin-top: 20px;">
    <form action="{{ url('/activity/' . $activity->act_id) }}" onsubmit="clickme(event)" method="post">
        @csrf
        @method("delete")
        <button type="submit" class="btn btn-danger btn-lg">ลบกิจกรรม </button>
    </form>
</div>

<!-- สไตล์ -->
<style>
    .btn-save {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: auto;
        padding: 1vh 5vh;
        border-radius: 5vh;
        font-weight: bold;
        background-color: #FFD573;
        color: rgb(0, 0, 0);
        border: none;
    }

    .btn-save:hover {
        background-color: #ffe7b0;
        opacity: 0.9;
    }

    .upload-container {
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 8px;
        padding: 20px 0;
        width: 100%;
    }

    .file-input {
        display: none;
    }

    .upload-label {
        background: #84ABFF;
        color: rgb(0, 0, 0);
        padding: 5px 20px;
        border-radius: 1vh;
        cursor: pointer;
    }


    .upload-label:hover {
        background: #c6daff;
    }

    .image-preview-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        justify-content: center;
        align-items: center;
    }

    .image-preview-item {
        position: relative;
        width: 150px;
        height: 100px;
    }
        .content-container {
            width: 120vh;
            margin-left: 20vh;
            margin-top: 0vh;
            padding: 0px;
            transition: all 0.3s ease-in-out;
        }

    .image-preview-item img {
        width: 100%;
        height: 100%;
        border-radius: 8px;
        object-fit: cover;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .remove-image {
        position: absolute;
        top: -5px;
        right: -5px;
        background: red;
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }

    textarea.form-control {
        resize: none;
    }
</style>

<script>
    let uploadedImages = [];

    function previewImages(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('imagePreviewContainer');
        const previewRow = document.getElementById('imagePreviewRow');

        if (files.length > 0) {
            previewContainer.style.display = 'block';

            Array.from(files).forEach(file => {
                if (file.type.startsWith("image/")) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const imgElement = document.createElement("img");
                        imgElement.src = e.target.result;

                        const imageWrapper = document.createElement("div");
                        imageWrapper.classList.add("image-preview-item");

                        const removeButton = document.createElement("div");
                        removeButton.classList.add("remove-image");
                        removeButton.innerHTML = "×";
                        removeButton.onclick = function() {
                            imageWrapper.remove();
                            uploadedImages = uploadedImages.filter(img => img !== e.target.result);
                            if (uploadedImages.length === 0) {
                                previewContainer.style.display = 'none';
                            }
                        };

                        imageWrapper.appendChild(imgElement);
                        imageWrapper.appendChild(removeButton);
                        previewRow.appendChild(imageWrapper);

                        uploadedImages.push(e.target.result);
                    };

                    reader.readAsDataURL(file);
                }
            });
        }
    }
</script>

@endsection
