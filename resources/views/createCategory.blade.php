@extends('layouts.default_with_menu')
@section('page-title', 'กำหนดหมวดหมู่')
@section('content')
    <style>
        body {
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: start;
            min-height: 100vh;
            margin: 0;
        }

        .container {
            margin-top: 8vh;
            margin-left: 20%;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 600px;
        }

        label {
            display: inline-block;
            margin-top: 10px;
            font-weight: semi-bold;
        }

        input,
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        textarea {
            height: 150px;
            resize: none;
        }

        .radio-group-inline {
            display: flex;
            gap: 30px;
            margin-top: 10px;
            flex-wrap: nowrap;
            /* ไม่ให้ขึ้นบรรทัดใหม่ */
            align-items: center;
        }

        .radio-item {
            display: flex;
            align-items: center;
            white-space: nowrap;
            /* ป้องกัน label ขึ้นบรรทัดใหม่ */
        }

        .radio-item label {
            margin-left: 8px;
            font-weight: normal;
            margin-bottom: 0;
        }

        .buttons {
            width: 100%;
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .btn {

            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 120px;
        }

        .btn-cancel {
            border-radius: 1vh;
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
            background-color: rgb(255, 78, 78);
            opacity: 0.9;
        }

        .btn-save:hover {
            color: white;
            background-color: hsl(211, 100%, 72%);
            opacity: 0.9;
        }

        @media (max-width: 768px) {
            .container {
                margin: 20px auto;
                padding: 20px;
                margin-left: 0;
            }

            .radio-group-inline {
                flex-direction: column;
                align-items: flex-start;
            }

            .buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>

    <div class="container">
        <form action="{{route('categories.store')}}" method="POST">
            @csrf
            <label for="cat_name">หมวดหมู่ <span style="color: red;">*</span></label>
            <input type="text" id="cat_name" name="cat_name" placeholder="ชื่อหมวดหมู่" required>

            <label for="description">รายละเอียด (ถ้ามี)</label>
            <textarea id="description" name="description" placeholder="รายละเอียดของหมวดหมู่"></textarea>

            <div style="display: flex; align-items: end; gap: 20px; flex-wrap: wrap; margin-top: 5px; padding: 1px;">
                <span style="white-space: nowrap;">ประเภทหมวดหมู่ <span style="color: red;">*</span></span>

                <div class="radio-group-inline" id="cat_ismandatory" name="cat_ismandatory">
                    <div class="radio-item">
                        <input type="radio" id="optional" name="categoryType" style="margin-top: 10px" value="0" checked>
                        <label for="optional">ไม่บังคับ</label>
                    </div>
                    <div class="radio-item">
                        <input type="radio" id="required" name="categoryType" style="margin-top: 10px" value="1">
                        <label for="required">บังคับ</label>
                    </div>
                </div>
            </div>

            <div class="buttons">
                <button type="button" class="btn btn-cancel" onclick="history.back()">ยกเลิก</button>
                <button type="submit" class="btn btn-save">บันทึก</button>
            </div>
        </form>
    </div>
@endsection
