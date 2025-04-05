@extends('layouts.default_with_menu')

@section('content')
    <div class="container">
        <!-- ส่วนบนของการ์ดข้อมูล (4 คอลัมน์) -->
        <div class="row g-3">


            <div class="col-md-3">
                <label class="form-label">ปีที่ทำกิจกรรม</label>
                <div class="card p-4 shadow-sm rounded-3">
                    <table style="width: 101%;">
                        <tr>
                            <td class="text-left">{{$years}}</td>
                        </tr>
                    </table>
                </div>
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
            {{-- <div class="card p-4 shadow-sm rounded-3 ">
                <p style="font-weight: 600;">กราฟแสดงข้อมูลอัตราการทำสำเร็จของแต่ละหมวดหมู่</p>
                <div class="container col-md-9">
                    @if (empty($successRates) || array_sum($successRates) == 0)
                        <div class="text-center text-muted p-4">ยังไม่มีข้อมูลอัตราการสำเร็จ</div>
                    @else
                        <canvas id="completion_rate_chart"></canvas>
                    @endif
                </div>
            </div> --}}


            <div class="card p-4 shadow-sm rounded-3">
                <p style="font-weight: 600;">กราฟแสดงข้อมูลจำนวนกิจกรรมที่อนุมัติแล้วในแต่ละหมวดหมู่</p>
                <div class="container col-md-9">
                    @if (count($approvedCounts) === 0)
                        <div class="text-center text-muted p-4">ยังไม่มีข้อมูลกิจกรรม</div>
                    @else
                        <canvas id="activity_count_chart"></canvas>
                    @endif
                </div>
            </div>

            <div class="card p-4 shadow-sm rounded-3 mt-4">
                <p style="font-weight: 600;">กราฟแสดงจำนวนกิจกรรมที่ยังไม่อนุมัติในแต่ละหมวดหมู่</p>
                <div class="container col-md-9">
                    @if (count($unapprovedCounts) === 0)
                        <div class="text-center text-muted p-4">ยังไม่มีข้อมูลกิจกรรม</div>
                    @else
                        <canvas id="unapproved_activity_chart"></canvas>
                    @endif
                </div>
            </div>



        </div>
    </div>


   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = @json($labels);
    const approvedCounts = @json($approvedCounts);
    const unapprovedCounts = @json($unapprovedCounts);

    // ✅ กราฟกิจกรรมอนุมัติ (เดิม)
    new Chart(document.getElementById('activity_count_chart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'กิจกรรมที่อนุมัติแล้ว',
                data: approvedCounts,
                backgroundColor: 'rgba(129, 183, 216, 0.7)'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // ✅ กราฟกิจกรรมที่ยังไม่อนุมัติ
    new Chart(document.getElementById('unapproved_activity_chart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'กิจกรรมที่ยังไม่อนุมัติ',
                data: unapprovedCounts,
                backgroundColor: 'rgba(255, 99, 132, 0.7)' // สีแดงอมชมพู
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

@endsection
