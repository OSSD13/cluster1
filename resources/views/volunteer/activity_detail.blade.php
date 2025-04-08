@extends('layouts.default_with_menu')
@section('page-title', 'รายละเอียดงาน')
@section('content')

<a href="{{ route('activities.history') }}" class="btn btn-light mb-3 mt-3">
    <i class="bi bi-chevron-left"></i>
</a>

<div class="content-container">
    <div class="container">
        <div class="card shadow">
            <div class="card-body">
                <!-- ชื่อกิจกรรม & วันที่ทำกิจกรรม -->
                <div class="row mb-3">
                    <div class="col-md-8">
                        <label>ชื่อกิจกรรม</label>
                        <p>{{ $activity->act_title }}</p>
                    </div>
                    <div class="col-md-4">
                        <label>วันที่ทำกิจกรรม</label>
                        <p>{{ \Carbon\Carbon::parse($activity->act_date)->format('d/m/Y') }}</p>
                    </div>
                </div>

                <!-- หมวดหมู่ -->
                <div class="mb-3">
                    <label>หมวดหมู่</label>
                    <p>
                        {{ $categories->firstWhere('cat_id', $activity->act_cat_id)?->cat_name ?? 'ไม่ระบุ' }}
                    </p>
                </div>

                <!-- เนื้อหา -->
                <div class="mb-3">
                    <label>เนื้อหา</label>
                    <div class="border rounded p-2" style="background-color:#ffffff">
                        {{ $activity->act_description }}
                    </div>
                </div>

                <!-- รูปภาพ -->
                <div class="mb-3">
                    <label>รูปภาพกิจกรรม</label>
                    <div class="image-preview-grid mt-3">
                        @foreach($activity->images as $image)
                            <div class="image-preview-item">
                                <img src="{{ asset($image->img_path) }}" alt="{{ $image->img_name }}">
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>



    <style>
        body {
            background-color: #ffffff;
            display: flex;
            align-items: center;
        }

        .content-container {
            width: 80vh;
            margin-left: 30vh;
            margin-top: 10vh;
            padding: 20px;
            transition: all 0.3s ease-in-out;
        }

        .container {
            width: 100%;
            background: rgb(255, 255, 255);
        }

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
            color: rgb(0, 0, 0);
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

                        reader.onload = function (e) {
                            const imgElement = document.createElement("img");
                            imgElement.src = e.target.result;

                            const imageWrapper = document.createElement("div");
                            imageWrapper.classList.add("image-preview-item");

                            const removeButton = document.createElement("div");
                            removeButton.classList.add("remove-image");
                            removeButton.innerHTML = "×";
                            removeButton.onclick = function () {
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
