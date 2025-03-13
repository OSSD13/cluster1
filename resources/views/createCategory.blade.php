@extends('layouts.default_with_menu')
@section('content')

<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f8f8;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
        width: 600px;
    }

    label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    input, textarea {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        margin-bottom: 15px;
    }

    textarea {
        height: 100px;
        resize: none;
    }

    .radio-group {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 20px;
    }

    .radio-item {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .buttons {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
    }

    .btn {
        padding: 12px 20px;
        font-size: 16px;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        cursor: pointer;
    }

    .btn-cancel {
        background-color: red;
        color: white;
    }

    .btn-save {
        background-color: #007bff;
        color: white;
    }
    .radio-group {
    display: flex;
    align-items: center;
    gap: 30px; /* ปรับระยะห่างระหว่าง radio button */
    flex-wrap: nowrap;
}

.radio-item {
    display: flex;
    align-items: center;
    gap: 8px; /* ปรับระยะห่างระหว่าง radio และ label */
}

</style>

<div class="container">
    <form>
        <label for="category">หมวดหมู่ <span style="color: red;">*</span></label>
        <input type="text" id="category" placeholder="ชื่อหมวดหมู่" required>

        <label for="details">รายละเอียด (ถ้ามี)</label>
        <textarea id="details" placeholder="รายละเอียดของหมวดหมู่"></textarea>

        <label>ประเภทหมวดหมู่ <span style="color: red;">*</span></label>
<div class="radio-group">
    <div class="radio-item">
        <input type="radio" id="optional" name="categoryType" value="optional" checked>
        <label for="optional"  style="width: 100px">ไม่บังคับ</label>
    </div>
    <div class="radio-item">
        <input type="radio" id="required" name="categoryType" value="required">
        <label for="required">บังคับ</label>
    </div>
</div>

        <div class="buttons">
            <button type="button" class="btn btn-cancel">ยกเลิก</button>
            <button type="submit" class="btn btn-save">บันทึกการแก้ไข</button>
        </div>
    </form>
</div>

@endsection
