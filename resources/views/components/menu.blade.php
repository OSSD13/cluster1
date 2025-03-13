<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!-- Sidebar Brand (โลโก้และชื่อแบรนด์) -->
    <style>
        .sidebar-brand {
            width: 200px; /* ปรับความกว้างของ Sidebar */
            min-height: 80px; /* กำหนดความสูง */
            padding: 20px; /* เพิ่ม Padding ให้ดูโปร่งขึ้น */
        }

        /* ขยายความกว้างในหน้าจอใหญ่ขึ้น */
        @media (min-width: 768px) {
            .sidebar-brand {
                width: 250px;
                justify-content: start;
            }
        }

        /* ปรับเส้นขีดให้หนาขึ้นและมีระยะห่างที่เหมาะสม */
        .sidebar-divider {
            border-top: 2px solid #767676; /* สีเทาเข้มขึ้น */
            margin-top: 20px; /* เพิ่มระยะห่างด้านบน */
            margin-bottom: 0px; /* เพิ่มระยะห่างด้านล่าง */

        }
    </style>

    <div class=" bg-white p-3">
        <div class="d-flex align-items-center" >
            <img src="{{ url('public/assets/img/Logo_var.png') }}" alt="VAR Logo"
                class="brand-image" style="width: 56px; height: 56px;" />
            <span class="brand-text fw-semibold ms-2 text-dark fs-2">VAR</span>
        </div>
        <hr class="sidebar-divider"> <!-- เส้นขีดที่ปรับให้ดูดีขึ้น -->
    </div>

    <!-- Sidebar Wrapper -->
    <div class="sidebar-wrapper bg-white" style="height: 100vh; overflow-y: auto;">
        <nav class="mt-2">
            <!-- Sidebar Menu -->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <!-- ของผู้ใช้งาน -->



                <div class="d-flex flex-column" style="height: 100vh; position: relative;">
                    <!-- เนื้อหาอื่นๆ ของ Sidebar -->

                    <div class="d-flex align-items-center justify-content-start p-3"
                        style="position: absolute; bottom: 250px; left:-6%; width: 100%;">
                        <form action="{{ route('#') }}" method="POST">
                            @csrf
                            <button type="submit" class="nav-link" style="border: none; background: none; color: red;">
                                <i class="bi bi-box-arrow-right"></i>
                                <p>ออกจากระบบ</p>
                            </button>
                        </form>
                    </div>
                </div>

            </ul>
        </nav>
    </div>
</aside>
