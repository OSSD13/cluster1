@extends('layouts.default_with_menu')

@section('css')
    <style>
        table th,
        table td {
            vertical-align: top !important;
        }

        th:first-child,
        td:first-child {
            width: 50px;
            /* ลดขนาดช่องลำดับ */
        }

        .table th,
        .table td {
            padding: 0.75rem 0.75rem;
        }

        .table td.text-start {
            white-space: pre-line;
        }

        table th,
        table td {
            vertical-align: top !important;
        }

        td.text-start {
            white-space: pre-line;
        }
    </style>
@endsection

@section('content')
    {{-- 🔍 Search Bar --}}
    <div class="row mb-3">
        <div class="col-6">
            <input type="text" class="form-control shadow-sm" placeholder="🔍 ค้นหา..." />
        </div>
    </div>

    {{-- 📊 Filter & Summary Info --}}
    <div class="row g-3 align-items-end mb-4 ">

        {{-- ปีที่ทำกิจกรรม --}}
        <div class="col-md-3">
            <label class="form-label fw-bold">ปีที่ทำกิจกรรม</label>
            <form method="GET" action="{{ route('province.report') }}" id="yearForm">
                <select name="year_id" class="form-select shadow-sm"
                    onchange="document.getElementById('yearForm').submit()" style="height: 72px;">
                    @foreach ($years as $year)
                        <option value="{{ $year->year_id }}" {{ $year->year_id == $selectedYearId ? 'selected' : '' }}>
                            {{ $year->year_name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        {{-- จังหวัด --}}
        <div class="col-md-3">
            <label class="form-label fw-bold">จังหวัด</label>
            <div class="form-control shadow-sm bg-white d-flex align-items-center" style="height: 72px;">
                {{-- แสดงชื่อจังหวัด --}}
                {{ auth()->user()->provinceData->pvc_name ?? '-' }}
            </div>
        </div>

        {{-- จำนวนอาสา --}}
        <div class="col-md-3">
            <label class="form-label fw-bold">จำนวนอาสา</label>
            <div class="form-control shadow-sm bg-white d-flex justify-content-between align-items-center" style="height: 72px;">
                <div>{{ $userCount }}</div>
                <div>คน</div>
            </div>
        </div>

        {{-- จำนวนกิจกรรม --}}
        <div class="col-md-3">
            <label class="form-label fw-bold">จำนวนกิจกรรม</label>
            <div class="form-control shadow-sm bg-white d-flex justify-content-between align-items-center" style="height: 72px;">
            <div>{{ $activityCount }}</div>
            <div>กิจกรรม</div>
            </div>
        </div>
    </div>
    {{-- 📋 Main Report Table --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th style="width: 50px;">ลำดับ</th>
                    <th style="width: 200px;">ชื่อ-นามสกุล</th>
                    <th>หมวดกิจกรรม</th>
                    <th>กิจกรรม</th>
                    <th style="width: 120px;">วันที่</th>
                </tr>
            </thead>
            <tbody>
                @php $index = 1; @endphp
                @foreach ($groupedActivities as $fullname => $userActivities)
                    {{-- แถวพาดหัวชื่ออาสา --}}
                    <tr>
                        <td>{{ $index++ }}</td>
                        <td colspan="4" class="text-start fw-bold">{{ $fullname }}</td>
                    </tr>

                    {{-- วนหมวดกิจกรรม --}}
                    @foreach ($userActivities->groupBy('category.cat_name') as $catName => $activitiesByCategory)
                        @php
                            $rowspan = $activitiesByCategory->count();
                            $first = true;
                        @endphp

                        @foreach ($activitiesByCategory as $key => $activity)
                            <tr>
                                {{-- แสดงชื่อหมวดกิจกรรมเฉพาะแถวแรกของกลุ่ม --}}
                                @if ($key === 0)
                                    <td></td> {{-- ช่องว่างแทนลำดับ --}}
                                    <td></td> {{-- ช่องว่างแทนชื่อ --}}
                                    <td rowspan="{{ $rowspan }}" class="text-start align-top">
                                        {{ $catName }}
                                    </td>
                                @endif

                                {{-- ถ้าไม่ใช่แถวแรกของกลุ่ม ให้เว้นช่องลำดับและชื่อ --}}
                                @if ($key > 0)
                                    <td></td>
                                    <td></td>
                                @endif

                                <td class="text-start">{{ $activity->act_title }}</td>
                                <td>{{ \Carbon\Carbon::parse($activity->act_date)->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
@endsection

@section('javascript')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    {{-- DataTables Buttons --}}
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

    {{-- File export libs --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.68/vfs_fonts.js"></script>

    <script>
        $(document).ready(function() {
            let table = $('#activityTable').DataTable({
                processing: true,
                ajax: {
                    url: '{{ route('province.activityData') }}',
                    data: function(d) {
                        d.year_id = $('#yearFilter').val();
                    },
                    dataSrc: function(json) {
                        console.log("📦 Data loaded:", json);
                        return json.data;
                    }
                },
                columns: [{
                        data: 'fullname'
                    },
                    {
                        data: 'category'
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'date'
                    }
                ],
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excel',
                        className: 'btn btn-sm btn-success',
                        text: '💾 Excel'
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-sm btn-danger',
                        text: '📄 PDF'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-sm btn-secondary',
                        text: '🖨️ พิมพ์'
                    }
                ],
                language: {
                    search: "🔍 ค้นหา:",
                    lengthMenu: "แสดง _MENU_ รายการ",
                    info: "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                    paginate: {
                        first: "หน้าแรก",
                        last: "หน้าสุดท้าย",
                        next: "ถัดไป",
                        previous: "ก่อนหน้า"
                    },
                    zeroRecords: "ไม่พบข้อมูล",
                    infoEmpty: "ไม่มีข้อมูลที่จะแสดง",
                    infoFiltered: "(กรองจากทั้งหมด _MAX_ รายการ)",
                    processing: "⏳ กำลังโหลดข้อมูล..."
                }
            });

            $('#yearFilter').on('change', function() {
                table.ajax.reload();
            });
        });
    </script>
@endsection
