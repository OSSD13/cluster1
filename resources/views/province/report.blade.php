@extends('layouts.default_with_menu')

@section('css')
<style>
    table th, table td {
        vertical-align: top !important;
    }
    th:first-child,
    td:first-child {
        width: 50px; /* ลดขนาดช่องลำดับ */
    }
    .table th,
    .table td {
        padding: 0.75rem 0.75rem;
    }
    .table td.text-start {
        white-space: pre-line;
    }
</style>
@endsection

@section('content')
<div class="container py-4">

    {{-- 🔍 Filter & Summary --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-2 fw-bold">ปีที่ทำกิจกรรม</div>
        <div class="col-md-2">
            <form method="GET" action="{{ route('province.report') }}">
                <select name="year_id" class="form-select" onchange="this.form.submit()">
                    @foreach($years as $year)
                        <option value="{{ $year->year_id }}" {{ $year->year_id == $selectedYearId ? 'selected' : '' }}>
                            {{ $year->year_name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <div class="col-md-2 fw-bold">จังหวัด</div>
        <div class="col-md-2">
            <div class="form-control-plaintext">
                {{ auth()->user()->provinceData->pvc_name ?? '-' }}
            </div>
        </div>

        <div class="col-md-2 text-end fw-bold">จำนวนอาสา</div>
        <div class="col-md-1 text-end">
            {{ $userCount }} คน
        </div>

        <div class="col-md-1 text-end fw-bold">กิจกรรม</div>
        <div class="col-md-1 text-end">
            {{ $activityCount }}
        </div>
    </div>

    {{-- 📋 Main Report Table --}}
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>ลำดับ</th>
                    <th class="text-start">ชื่อ-นามสกุล</th>
                    <th class="text-start">หมวดกิจกรรม</th>
                    <th class="text-start">กิจกรรม</th>
                    <th>วันที่</th>
                </tr>
            </thead>
            <tbody>
                @php $index = 1; @endphp
                @foreach($groupedActivities as $fullname => $userActivities)
                    <tr>
                        <td rowspan="{{ $userActivities->count() + $userActivities->groupBy('category.cat_name')->count() }}">
                            {{ $index++ }}
                        </td>
                        <td rowspan="{{ $userActivities->count() + $userActivities->groupBy('category.cat_name')->count() }}" class="text-start">
                            {{ $fullname }}
                        </td>
                        @php $firstGroup = true; @endphp
                        @foreach($userActivities->groupBy('category.cat_name') as $catName => $activitiesByCategory)
                            @if(!$firstGroup)
                                <tr>
                            @endif
                                <td rowspan="{{ $activitiesByCategory->count() }}" class="text-start">
                                    {{ $catName }}
                                </td>

                                {{-- วนแสดงกิจกรรมทั้งหมดในหมวดนั้น --}}
                                @foreach($activitiesByCategory as $key => $activity)
                                    @if($key > 0)<tr>@endif
                                        <td class="text-start">{{ $activity->act_title }}</td>
                                        <td>{{ \Carbon\Carbon::parse($activity->created_at)->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            @php $firstGroup = false; @endphp
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
$(document).ready(function () {
    let table = $('#activityTable').DataTable({
        processing: true,
        ajax: {
            url: '{{ route("province.activityData") }}',
            data: function (d) {
                d.year_id = $('#yearFilter').val();
            },
            dataSrc: function (json) {
                console.log("📦 Data loaded:", json);
                return json.data;
            }
        },
        columns: [
            { data: 'fullname' },
            { data: 'category' },
            { data: 'title' },
            { data: 'date' }
        ],
        dom: 'Bfrtip',
        buttons: [
            { extend: 'excel', className: 'btn btn-sm btn-success', text: '💾 Excel' },
            { extend: 'pdf', className: 'btn btn-sm btn-danger', text: '📄 PDF' },
            { extend: 'print', className: 'btn btn-sm btn-secondary', text: '🖨️ พิมพ์' }
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

    $('#yearFilter').on('change', function () {
        table.ajax.reload();
    });
});
</script>
@endsection