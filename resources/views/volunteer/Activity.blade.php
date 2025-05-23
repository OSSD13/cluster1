@extends('layouts.default_with_menu')
@section('page-title', 'เขียนงาน')
@section('content')
<body>
    <div class="content-container">
        <div class="container">
            <div class="card shadow">
                <div class="card-body">
                    <!-- Form ส่งข้อมูลไปที่ activity.store -->
                    <form method="POST" enctype="multipart/form-data" action="{{ route('activity.store') }}">
                        @csrf
                        <!-- ชื่อกิจกรรม & วันที่ทำกิจกรรม -->
                        <div class="row">
                            <div class="col-md-8">
                                <label for="act_title">ชื่อกิจกรรม <span style="color: red;">*</span></label>
                                <input type="text" id="act_title" name="act_title" class="form-control" placeholder="ชื่อกิจกรรม" required>
                            </div>
                            <div class="col-md-4">
                                <label for="act_date">วันที่ทำกิจกรรม <span style="color: red;">*</span></label>
                                <div class="input-group">
                                    <input type="date" id="act_date" name="act_date" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <!-- หมวดหมู่ -->
                        <div class="mb-3">
                            <label for="category_id" class="form-label">หมวดหมู่</label>
                            <select name="act_cat_id" id="act_cat_id" class="form-select" required>
                                <option value="" disabled selected>เลือกหมวดหมู่</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->cat_id }}">{{ $category->cat_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- เนื้อหา -->
                        <div class="mb-3">
                            <label for="act_description" class="form-label">เนื้อหา</label>
                            <textarea name="act_description" id="act_description" rows="5" class="form-control" required></textarea>
                        </div>

                        <!-- อัปโหลดรูปภาพ (หลายรูป) -->
                        <div class="mb-3">
                            <label for="images" class="form-label">รูปภาพกิจกรรม</label>
                            <div class="upload-container">
                                <input type="file" name="images[]" id="images" class="file-input" accept="image/*" multiple onchange="previewImages(event)">
                                <label for="images" class="upload-label">อัพโหลด</label>
                            </div>
                            <!-- ส่วนแสดงภาพที่อัปโหลด -->
                            <div class="image-preview mt-3" id="imagePreviewContainer" style="display: none;">
                                <div class="image-preview-grid" id="imagePreviewRow"></div>
                            </div>
                        </div>

                        <!-- ปุ่มบันทึก -->
                        <button type="submit" class="btn btn-save">บันทึกแบบร่าง</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

<style>
    body {
        background-color: #ffffff;
        display: flex;
        /* margin-left: 10vh; */
        align-items: center;
    }
    /* ตั้งค่าหน้าฟอร์ม */
    .content-container {
        width: 80vh;
        margin-left: 30vh; /*  เว้นระยะห่างจาก Sidebar */
        margin-top: 10vh; /*  เว้นระยะห่างจาก Header */
        padding: 20px;
        transition: all 0.3s ease-in-out;
    }

    .container {
        width: 100%;
        background: rgb(255, 255, 255);
    }

    /* ปุ่มบันทึกแบบร่าง */
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

    /*  ปรับช่องอัปโหลดไฟล์ให้เหมือนภาพตัวอย่าง */
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
        font-weight: regular;
    }

    .upload-label:hover {
        background: #c6daff;
    }

    /*  รูปแบบการแสดงภาพที่อัปโหลด */
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

    /*  ปุ่มลบรูป */
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
        font-size: 16px;
        font-weight: semi-bold;
    }
/*  ป้องกัน textarea ขยายขนาด */
textarea.form-control {
    resize: none; /*  ปิดการขยายขนาด */
}
</style>

<!--  JavaScript แสดงภาพตัวอย่างแบบ **หลายรูป** -->
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

                        //  สร้าง div สำหรับรูปแต่ละรูป
                        const imageWrapper = document.createElement("div");
                        imageWrapper.classList.add("image-preview-item");

                        //  ปุ่มลบรูป
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

