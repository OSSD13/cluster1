<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <aside id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <img src="resources/views/img/logo.png" style="width: 50px ; height: 50px;" alt="">
                    <a href="{{url("/")}}">VAR</a>
                </div>
            </div>

            <hr class="sidebar-divider">

            <ul class="sidebar-nav">

                <li class="sidebar-item">
                    <a href="{{ url('/') }}" class="sidebar-link {{ Request::is('/') ? 'active' : '' }}">
                        <i class="bi bi-pie-chart-fill"></i>
                        <span>ภาพรวม</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('/createcategory') }}" class="sidebar-link {{ Request::is('createcategory') ? 'active' : '' }}">
                        <i class="bi bi-clipboard-plus-fill"></i>
                        <span>กำหนดหมวดหมู่</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link {{ Request::is('approvework') ? 'active' : '' }}">
                        <i class="bi bi-clipboard-check-fill"></i>
                        <span>อนุมัติงาน</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link {{ Request::is('report') ? 'active' : '' }}">
                        <i class="bi bi-clock-fill"></i>
                        <span>รายงาน</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="{{ url('/Activity') }}" class="sidebar-link {{ Request::is('Activity') ? 'active' : '' }}">
                        <i class="fa-solid fa-pen-to-square"></i>
                        <span>เขียนงาน</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link {{ Request::is('rejectedactivities') ? 'active' : '' }}">
                        <i class="bi bi-clipboard2-x-fill"></i>
                        <span>กิจกรรมที่ไม่ผ่าน</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link {{ Request::is('pastactivities') ? 'active' : '' }}">
                        <i class="bi bi-clipboard2-pulse-fill"></i>
                        <span>กิจกรรมที่เคยทำ</span>
                    </a>
                </li>
            </ul>

            <!-- Logout Button (อยู่ด้านล่างสุด) -->
            <div class="sidebar-footer">
                <a href="#" class="sidebar-link logout">
                    <i class="lni lni-exit"></i>
                    <span>ออกจากระบบ</span>
                </a>
            </div>
        </aside>
    </div>
</body>

</html>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Poppins', sans-serif;
        display: flex;
    }

    /* ====== Sidebar ====== */
    #sidebar {
        position: fixed;
        left: 0;
        top: 0;
        height: 100vh;
        width: 250px;
        background-color: #ffffff;
        display: flex;
        flex-direction: column;
        padding-top: 0px;
        z-index: 1000;
        border-right: 2px solid #ddd;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    }

    .sidebar-header {
        text-align: start;
        padding: 15px;
        font-size: 1.2rem;
        font-weight: bold;
    }

    .sidebar-logo a {
        color: rgb(0, 0, 0);
        font-size: 1.2rem;
        font-weight: bold;
        text-decoration: none;
    }

    .sidebar-nav {
        flex: 1;
        padding: 10px;
    }

    .sidebar-item {
        list-style: none;
        margin-bottom: 10px;
    }

    .sidebar-link {
        color: #365A72;
        display: flex;
        align-items: center;
        padding: 12px 20px;
        font-size: 16px;
        text-decoration: none;
        transition: 0.3s;
        border-radius: 8px;
    }

    .sidebar-link i {
        font-size: 20px;
        margin-right: 10px;
    }

    /* ✅ เพิ่มเอฟเฟกต์ Hover ให้เหมือนภาพที่ส่งมา */
    .sidebar-link:hover {
        background-color: #d6eaff;
    }

    .sidebar-link.active {
        background-color: #81B7D8; /* สีฟ้า */
        color: white;
        font-weight: semi-bold;
    }

    /* ✅ ให้ไอคอนเปลี่ยนเป็นสีขาวเมื่อ Hover */
    .sidebar-link:hover i {

    }

    .sidebar-link.active i {
        color: white;
    }

    /* ====== Logout Button (อยู่ด้านล่างสุด) ====== */
    .sidebar-footer {
        margin-top: auto;
        padding: 15px;
    }

    .logout {
        background-color: transparent;
        color: red;
        font-weight: semi-bold;
        display: flex;
        align-items: center;
        padding: 12px 20px;
        text-decoration: none;
        transition: 0.3s;
    }

    .logout i {
        font-size: 20px;
        margin-right: 10px;
    }

    .logout:hover {
        background-color: rgba(255, 0, 0, 0.1);
        border-radius: 8px;
    }

    /* Responsive (ทำให้ Sidebar ลดขนาดลงในจอเล็ก) */
    @media (max-width: 768px) {
        #sidebar {
            width: 200px;
        }

        .sidebar-link {
            padding: 10px 15px;
            font-size: 14px;
        }

        .logout {
            padding: 10px 15px;
            font-size: 14px;
        }
    }
    .sidebar-divider {
            width: 90%;
            border-top: 2px solid #767676; /* สีเทาเข้มขึ้น */
            margin: 0 auto;
            }
</style>
