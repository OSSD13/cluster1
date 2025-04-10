<aside class="app-sidebar shadow d-flex flex-column" style="background-color: white; width: 250px; height: 100vh;">
    <div class=" d-flex justify-content-starat #align-items-center p-3">
        {{-- Logo --}}
        <img src="{{ url('public/assets/img/logo.png') }}" alt="Logo" class="img-fluid" width="60"
            style="margin-right: 10px" />
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
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-chart-pie-icon lucide-chart-pie">
                        <path
                            d="M21 12c.552 0 1.005-.449.95-.998a10 10 0 0 0-8.953-8.951c-.55-.055-.998.398-.998.95v8a1 1 0 0 0 1 1z" />
                        <path d="M21.21 15.89A10 10 0 1 1 8 2.83" />
                    </svg>
                    <span>ภาพรวม</span>
                </a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('activity.index') }}"
                    class="nav-link sidebar-link {{ Request::is('activity') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-notebook-pen-icon lucide-notebook-pen">
                        <path d="M13.4 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7.4" />
                        <path d="M2 6h4" />
                        <path d="M2 10h4" />
                        <path d="M2 14h4" />
                        <path d="M2 18h4" />
                        <path
                            d="M21.378 5.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                    </svg>
                    <span>เขียนงาน</span>
                </a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('activities.history') }}"
                    class="nav-link sidebar-link {{ Request::is('activities/historyActivity') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-history-icon lucide-history">
                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                        <path d="M3 3v5h5" />
                        <path d="M12 7v5l4 2" />
                    </svg>
                    <span>กิจกรรมที่เคยทำ</span>
                </a>
            </li>
            @endrole

            {{-- Province Officer --}}
            @role('Province Officer')
            <li class="nav-item mb-3">
                <a href="{{ route('overview.index') }}"
                    class="nav-link sidebar-link {{ Request::is('overview*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-chart-pie-icon lucide-chart-pie">
                        <path
                            d="M21 12c.552 0 1.005-.449.95-.998a10 10 0 0 0-8.953-8.951c-.55-.055-.998.398-.998.95v8a1 1 0 0 0 1 1z" />
                        <path d="M21.21 15.89A10 10 0 1 1 8 2.83" />
                    </svg>
                    <span>ภาพรวม</span>
                </a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('province.index') }}"
                    class="nav-link sidebar-link {{ Request::is('province/approve*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-book-check-icon lucide-book-check">
                        <path
                            d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20" />
                        <path d="m9 9.5 2 2 4-4" />
                    </svg>
                    <span>อนุมัติงาน</span>
                </a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('province.unapprove') }}"
                    class="nav-link sidebar-link text-muted {{ Request::is('province/unapprove') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-book-x-icon lucide-book-x">
                        <path d="m14.5 7-5 5" />
                        <path
                            d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20" />
                        <path d="m9.5 7 5 5" />
                    </svg>
                    <span>กิจกรรมที่ไม่ผ่าน</span>
                </a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('province.report') }}"
                    class="nav-link sidebar-link {{ Request::is('report') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-history-icon lucide-history">
                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                        <path d="M3 3v5h5" />
                        <path d="M12 7v5l4 2" />
                    </svg>
                    <span>รายงาน</span>
                </a>
            </li>
            @endrole

            {{-- Central Officer --}}
            @role('Central Officer')
            <li class="nav-item mb-3">
                <a href="{{ route('overview.index') }}"
                    class="nav-link sidebar-link {{ Request::is('overview*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-chart-pie-icon lucide-chart-pie">
                        <path
                            d="M21 12c.552 0 1.005-.449.95-.998a10 10 0 0 0-8.953-8.951c-.55-.055-.998.398-.998.95v8a1 1 0 0 0 1 1z" />
                        <path d="M21.21 15.89A10 10 0 1 1 8 2.83" />
                    </svg>
                    <span>ภาพรวม</span>
                </a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{ route('categories.index') }}"
                    class="nav-link sidebar-link {{ Request::is('categories*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-notebook-pen-icon lucide-notebook-pen">
                        <path d="M13.4 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-7.4" />
                        <path d="M2 6h4" />
                        <path d="M2 10h4" />
                        <path d="M2 14h4" />
                        <path d="M2 18h4" />
                        <path
                            d="M21.378 5.626a1 1 0 1 0-3.004-3.004l-5.01 5.012a2 2 0 0 0-.506.854l-.837 2.87a.5.5 0 0 0 .62.62l2.87-.837a2 2 0 0 0 .854-.506z" />
                    </svg>
                    <span>กำหนดหมวดหมู่</span>
                </a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{route('central.approve.index')}}"
                    class="nav-link sidebar-link text-muted {{ Request::is('central/approve/*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-book-check-icon lucide-book-check">
                        <path
                            d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20" />
                        <path d="m9 9.5 2 2 4-4" />
                    </svg>
                    <span>อนุมัติงาน</span>
                </a>
            </li>
            <li class="nav-item mb-3">
                <a href="{{route('central.report.index')}}"
                    class="nav-link sidebar-link text-muted {{ Request::is('*report*') ? 'active' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-history-icon lucide-history">
                        <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                        <path d="M3 3v5h5" />
                        <path d="M12 7v5l4 2" />
                    </svg>
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
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-log-out-icon lucide-log-out">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                    <polyline points="16 17 21 12 16 7" />
                    <line x1="21" x2="9" y1="12" y2="12" />
                </svg>
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
        color: #365A72;
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
        color: #365A72;
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
        font-size: 24px;
        /* เดิมอาจเป็น 1.3rem */
        font-weight: 400;
        color: #2C3E50;
    }

    i {
        font-size: 24px;
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
