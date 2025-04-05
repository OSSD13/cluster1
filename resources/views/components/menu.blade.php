<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!-- Sidebar Brand (โลโก้และชื่อแบรนด์) -->
    <div class="sidebar-brand bg-white">
        <a href="../index.html" class="brand-link">
            <img src="{{ url('public/assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
                class="brand-image opacity-75 shadow" />
            <span class="brand-text fw-light" style="border: none; background: none; color: black;">VAR Service</span>
        </a>
    </div>

    <!-- Sidebar Wrapper -->
    <div class="sidebar-wrapper bg-white">
        <nav class="mt-2">
            <!-- Sidebar Menu -->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                <!-- ของผู้ใช้งาน -->

                @role('Volunteer')
                <li class="nav-item">
                    <form action="{{ route('overview.index') }}" method="GET">
                        @csrf
                        <button type="submit" class="nav-link " style="border: none; background: none; color: black;">
                            <i class="bi bi-house-door"></i>
                            <p> ภาพรวม</p>
                        </button>
                    </form>
                </li>
                <li class="nav-item">
                    <a href="{{ route('activity.index') }}" class="nav-link" style="border: none; background: none; color: black;">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        <p >เขียนงาน</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('/activities/historyActivity') }}" class="nav-link" style="border: none; background: none; color: black;">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        <p>กิจกรรมที่เคยทำ</p>
                    </a>
                </li>
                @endrole
                @role('Central Officer')
                <li class="nav-item">
                    <form action="{{ url('central/overview') }}" method="GET">
                        @csrf
                        <button type="submit" class="nav-link " style="border: none; background: none; color: black;">
                            <i class="bi bi-house-door"></i>
                            <p> ภาพรวม</p>
                        </button>
                    </form>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/categories') }}" class="nav-link" style="border: none; background: none; color: black;">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        <p>สร้างหมวดหมู่</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('#') }}" class="nav-link" style="border: none; background: none; color: color: rgb(202, 202, 202);;">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        <p>อนุมัติงาน</p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ url('#') }}" class="nav-link" style="border: none; background: none; color: color: rgb(202, 202, 202);;">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        <p>รายงาน</p>
                    </a>
                </li>


                @endrole


                @role('Province Officer')
                <li class="nav-item">
                    <form action="{{ route('overview.index') }}" method="GET">
                        @csrf
                        <button type="submit" class="nav-link " style="border: none; background: none; color: black;">
                            <i class="bi bi-house-door"></i>
                            <p> ภาพรวม</p>
                        </button>
                    </form>
                </li>
                <li class="nav-item">
                    <a href="{{ route('province.index') }}" class="nav-link" style="border: none; background: none; color: black;">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        <p>อนุมัติงาน</p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ url('#') }}" class="nav-link" style="border: none; background: none; color: rgb(202, 202, 202);">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        <p>กิจกรรมที่ไม่ผ่าน</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/report') }}" class="nav-link" style="border: none; background: none; color: rgb(0, 0, 0);">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        <p>รายงาน</p>
                    </a>
                </li>



                @endrole



                @role('admin')
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link" style="border: none; background: none; color: black;">
                        <i class="bi bi-folder"></i>
                        <p>
                            ข้อมูลระบบ
                            <i class="bi bi-chevron-down"></i> <!-- ลูกศรบอกว่ามีเมนูย่อย -->
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item" style="border: none; background: none; color: black;">
                            <a href="{{ url('/user') }}" class="nav-link">
                                <i class="bi bi-people"></i>
                                <p>ผู้ใช้งาน</p>
                            </a>
                        </li>
                        <li class="nav-item" style="border: none; background: none; color: black;">
                            <a href="{{ url('/') }}" class="nav-link">
                                <i class="bi bi-gear"></i>
                                <p>ตั้งค่า</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/categories') }}" class="nav-link" style="border: none; background: none; color: black;">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        <p>เมนูแอดมิน</p>
                    </a>
                </li>
                @endrole
                <li class="nav-item" >
                    <form action="{{ route('logout') }}" method="POST" >
                        @csrf
                        <button type="submit" class="nav-link " style="border: none; background: none; color: red;">
                            <i class="bi bi-box-arrow-right"></i>
                            <p >ออกจากระบบ</p>
                        </button>
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>
