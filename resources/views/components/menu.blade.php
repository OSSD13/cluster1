<aside class="app-sidebar shadow d-flex flex-column" style="background-color: white; width: 250px; height: 100vh;">
    <div class=" d-flex justify-content-starat #align-items-center p-3">
        {{-- Logo --}}
        <img src="{{ url('public/assets/img/logo.png') }}" alt="Logo" class="img-fluid" width="60" style="margin-right: 10px" />
        <h4 class="mt-3" style="color: #2C3E50; font-weight: bold;">VAR</h4>


    </div>
    <hr style="width: 85%; border-top: 2px solid #818181; margin: 8px auto 10px auto;">

    <div class="flex-grow-1 overflow-auto">
        <ul class="nav flex-column px-3 pt-2">
            {{-- Volunteer --}}
            @role('Volunteer')
            <li class="nav-item mb-3">
                <a href="{{ route('overview.index') }}"
                    class="nav-link sidebar-link {{ Request::is('overview*') ? 'active' : '' }}">
                    <i class="bi bi-house-fill"></i>
                    <span>ภาพรวม</span>
                </a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('activity.index') }}"
                    class="nav-link sidebar-link {{ Request::is('activity') ? 'active' : '' }}">
                    <i class="bi bi-pen-fill"></i>
                    <span>เขียนงาน</span>
                </a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('activities.history') }}"
                    class="nav-link sidebar-link {{ Request::is('activities/historyActivity') ? 'active' : '' }}">
                    <i class="bi bi-clock-fill"></i>
                    <span>กิจกรรมที่เคยทำ</span>
                </a>
            </li>
            @endrole

            {{-- Province Officer --}}
            @role('Province Officer')
            <li class="nav-item mb-3">
                <a href="{{ route('overview.index') }}"
                    class="nav-link sidebar-link {{ Request::is('overview*') ? 'active' : '' }}">
                    <i class="bi bi-house-fill"></i>
                    <span>ภาพรวม</span>
                </a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('province.index') }}"
                    class="nav-link sidebar-link {{ Request::is('province/approve') ? 'active' : '' }}">
                    <i class="bi bi-check2-square sidebar-icon"></i>
                    <span>อนุมัติงาน</span>
                </a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('province.unapprove') }}"
                    class="nav-link sidebar-link text-muted {{ Request::is('province/unapprove') ? 'active' : '' }}">
                    <i class="bi bi-x-circle sidebar-icon"></i>
                    <span>กิจกรรมที่ไม่ผ่าน</span>
                </a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('province.report') }}" class="nav-link sidebar-link {{ Request::is('report') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph sidebar-icon"></i>
                    <span>รายงาน</span>
                </a>
            </li>
            @endrole

            {{-- Central Officer --}}
            @role('Central Officer')
            <li class="nav-item mb-3">
                <a href="{{ route('overview.index') }}"
                    class="nav-link sidebar-link {{ Request::is('overview*') ? 'active' : '' }}">
                    <i class="bi bi-house-fill"></i>
                    <span>ภาพรวม</span>
                </a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('categories.index') }}"
                    class="nav-link sidebar-link {{ Request::is('categories*') ? 'active' : '' }}">
                    <i class="bi bi-journal-text sidebar-icon"></i>
                    <span>กำหนดหมวดหมู่</span>
                </a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{route('central.approve.index')}}"
                    class="nav-link sidebar-link text-muted {{ Request::is('activities/approve*') ? 'active' : '' }}">
                    <i class="bi bi-check2-square sidebar-icon"></i>
                    <span>อนุมัติงาน</span>
                </a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{route('central.report.index')}}" class="nav-link sidebar-link text-muted {{ Request::is('report*') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-bar-graph sidebar-icon"></i>
                    <span>รายงาน</span>
                </a>
            </li>
            @endrole

            {{-- Admin --}}
        </ul>
    </div>

    {{-- Logout ปุ่มติดล่าง --}}
    <div class="p-3 mt-auto">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link sidebar-link sidebar-link-logout text-danger">
                <i class="bi bi-box-arrow-right sidebar-icon" style="color: tomato"></i>
                <span>ออกจากระบบ</span>
            </button>
        </form>
    </div>
</aside>

<style>
    .sidebar-link {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #2C3E50;
        font-size: 1rem;
        padding: 10px 12px;
        border-radius: 8px;
        transition: background-color 0.2s ease-in-out;
        text-decoration: none;
        width: 100%;
        text-align: left;
    }

    /* Hover ปกติของเมนูทั้งหมด */
    .sidebar-link:hover {
        background-color: #c9eaff;
        text-decoration: none;
        color: #1d2b3a;
    }

    /* Hover สำหรับปุ่ม logout เท่านั้น */
    .sidebar-link-logout:hover {
        background-color: rgba(255, 99, 71, 0.1);
        /* tomato light */
        color: tomato !important;
    }

    .sidebar-link-logout .sidebar-icon {
        font-size: 1.8rem;
    }

    .sidebar-icon {
        font-size: 1.6rem;
        /* เดิมอาจเป็น 1.3rem */
        font-weight: 400;
        color: #2C3E50;
    }
    i{
        font-size: 1.6rem;
    }

    .sidebar-link.active {
        background-color: #81B7D8;
        color: #ffffff !important;
        font-weight: 600;
        border-radius: 8px;

    }

    .sidebar-link.active .sidebar-icon {
        color: #ffffff !important;
    }
</style>
