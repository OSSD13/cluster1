@extends('layouts.default_with_menu')

@section('content')
<div class="container">
    <!-- ส่วนบนของการ์ดข้อมูล (4 คอลัมน์) -->
    <div class="row g-3">


        <div class="col-md-3">
            <label class="form-label">ปีที่ทำกิจกรรม</label>
            <form method="GET" action="{{ route('overview.index') }}" id="yearForm">
                <select name="year_id" id="year_id" class="form-select shadow-sm p-4" required>
                    @foreach ($years as $year)
                    <option value="{{ $year->year_id }}" {{ $year->year_id == $selectedYearId ? 'selected' : '' }}>
                        {{ $year->year_name }}
                    </option>
                    @endforeach
                </select>
            </form>
            {{ $selectedYearId }}
        </div>


        <div class="col-md-3">
            <label class="form-label">กำหนดส่ง</label>
            <div class="card p-4 shadow-sm rounded-3">
                <table style="width:110%;">
                    <tr>
                        <td class="text-left">
                            {{ \Carbon\Carbon::parse($category_due_date)->translatedFormat('j F Y') }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="col-md-3">
            <label class="form-label">หมวดหมู่ทั้งหมด</label>
            <div class="card p-4 shadow-sm rounded-3">
                <table>
                    <tr>
                        <td class="text-left" style="width: 74%;">{{ $categoryCount }}</td>
                        <td class="text-right">หมวดหมู่</td>
                    </tr>
                </table>
            </div>
        </div>


        <div class="col-md-3">
            <label class="form-label">กิจกรรมทั้งหมด</label>
            <div class="card p-4 shadow-sm rounded-3">
                <table>
                    <tr>
                        <td class="text-left" style="width: 74%;">{{ $activityCount }}</td>
                        <td class="text-right">กิจกรรม</td>
                    </tr>
                </table>
            </div>
        </div>




        <!-- กราฟ -->
        <div class="card p-4 shadow-sm rounded-3 mt-4">
            <p style="font-weight: 600;">กราฟแสดงจำนวนกิจกรรมที่อนุมัติและยังไม่อนุมัติในแต่ละหมวดหมู่</p>
            <div class="container col-md-9">
                <canvas id="unapproved_activity_chart"></canvas>
            </div>
        </div>
        <div class="card p-4 shadow-sm rounded-3 mt-4">
            <p style="font-weight: 600;">กราฟแสดงจำนวนกิจกรรมในแต่ละหมวดหมู่</p>
            <div class="container col-md-9">
                <canvas id="activity_count_chart"></canvas>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const labels = @json($labels);
            const approvedCounts = @json($approvedCounts);
            const unapprovedCounts = @json($unapprovedCounts);
            const activityCounts = @json($activityCounts);
            //const labels = @json($labels).slice(0, 10);
            //const activityCounts = @json($activityCounts).slice(0, 10);

            // ✅ กราฟกิจกรรมที่ยังไม่อนุมัติ
            new Chart(document.getElementById('unapproved_activity_chart'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                            label: 'กิจกรรมที่ยังไม่อนุมัติ',
                            data: unapprovedCounts,
                            backgroundColor: 'rgb(255, 106, 106)' // สีแดงอมชมพู
                        },
                        {
                            label: 'กิจกรรมที่อนุมัติแล้ว',
                            data: approvedCounts,
                            backgroundColor: 'rgba(53, 214, 117, 0.7)' // สีน้ำเงิน
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
            // ✅ กราฟกิจกรรมในแต่ละหมวดหมู่
            new Chart(document.getElementById('activity_count_chart'), {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'กิจกรรม',
                        data: activityCounts,
                        backgroundColor: '#81B7D8' // สีแดงอมชมพู
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>




    </div>
</div>




@endsection