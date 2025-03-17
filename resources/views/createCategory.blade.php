@extends('layouts.default_with_menu')
@section('page-title', 'กำหนดหมวดหมู่')
@section('content')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: start;
            height: 100vh;
            margin: 0;
        }
    .container {
        margin-top: 8vh; /* เว้นระยะห่างจาก Header */
        margin-left: 20%; /* เว้นระยะห่างจาก Sidebar */
        background: white;
        padding: 30px;  /* เพิ่มพื้นที่ภายในของกล่อง */
        border-radius: 8px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        width: 70vh;  /* เพิ่มความกว้างของกล่องทั้งหมด */
        height: 45vh;  /* ปล่อยให้ความสูงปรับตามเนื้อหา */
    }
    label {
        display: inline-block;
        margin-top: 10px;
        font-weight: semi-bold;
    }
    input, textarea {
        width: 100%;
        padding: 8px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    textarea {
        height: 150px;  /* เพิ่มความสูงของกล่องรายละเอียด */
        resize: none;  /* ป้องกันการปรับขนาดของกล่องข้อความ */
    }
    .radio-group-inline {
        display: inline-flex;
        gap: 15px; /* ระยะห่างระหว่างตัวเลือก */
        align-items: center;
        margin-top: 10px;
    }
    .radio-item {
        display: flex;
        align-items: center;
    }
    .radio-item label {
        min-width: 120px; /* เพิ่มความกว้างให้กับ label */
    }
    .radio-item label[for="optional"] {
        margin-left: 10px; /* เพิ่มระยะห่างทางด้านซ้ายของ 'ไม่บังคับ' */
        font-weight: normal; /* ปรับเป็นตัวอักษรธรรมดา */
    }
    .radio-item label[for="required"] {
        margin-left: 10px; /* เพิ่มระยะห่างทางด้านซ้ายของ 'บังคับ' */
        font-weight: normal; /* ปรับเป็นตัวอักษรธรรมดา */
    }
    .buttons {
        margin-top: 20px;
        display: flex;
        justify-content: space-between;
    }
    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }
    .btn-cancel {
        border-radius:1vh;
        background-color: red;
        color: white;
    }
    .btn-save {
        border-radius: 1vh;
        background-color: #2079FF;
        color: white;
    }
    .btn-cancel:hover {
        color: white;
        background-color: rgb(255, 78, 78); /* เปลี่ยนเป็นสีแดงเข้มขึ้น */
        opacity: 0.9;
    }

    .btn-save:hover {
        color: white;
        background-color: hsl(211, 100%, 72%); /* เปลี่ยนเป็นสีน้ำเงินเข้มขึ้น */
        opacity: 0.9;
    }
</style>


<div class="container">
    <form action="{{route('categories.store')}}" method="POST">
        @csrf
        <label for="cat_name">หมวดหมู่ <span style="color: red;">*</span></label>
        <input type="text" id="cat_name" name="cat_name" placeholder="ชื่อหมวดหมู่" required>


        <label for="description">รายละเอียด (ถ้ามี)</label>
        <textarea id="description" name="description" placeholder="รายละเอียดของหมวดหมู่"></textarea>

        <label style="margin-right: 10px;">ประเภทหมวดหมู่ <span style="color: red;">*</span></label>
        <div class="radio-group-inline" id="cat_ismandatory" name="cat_ismandatory">
            <div class="radio-item" >
                <input type="radio" id="optional" name="categoryType" value="0" checked>
                <label for="optional">ไม่บังคับ</label>
            </div>
            <div class="radio-item" >
                <input type="radio" id="required" name="categoryType" value="1">
                <label for="required">บังคับ</label>
            </div>
        </div>

        <div class="buttons">
            <button type="button" class="btn btn-cancel">ยกเลิก</button>
            <button type="submit" class="btn btn-save">บันทึก</button>
        </div>
    </form>
</div>


@endsection
