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

                <li class="nav-item">
                    <a href="{{ url('/') }}" class="nav-link" style="border: none; background: none; color: black;">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        <p>สร้างกิจกรรม</p>
                    </a>
                </li>


            </ul>
        </nav>
    </div>
</aside>