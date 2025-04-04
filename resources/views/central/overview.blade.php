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
                            <td class="text-left">2568</td>
                        </tr>
                    </table>
                </div>
            </div>


            <div class="col-md-3">
                <label class="form-label">กำหนดส่ง</label>
                <div class="card p-4 shadow-sm rounded-3">
                    <table style="width:110%;">
                        <tr>
                            <td class="text-left">15 มกราคม 2569 </td>
                            <td class="text-left"> 📅</td>
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
            <div class="card p-4 shadow-sm rounded-3 ">
                <p style="font-weight: 600;">กราฟแสดงข้อมูลอัตราการทำสำเร็จของแต่ละหมวดหมู่</p>
                <div class="container col-md-9">
                    @if (empty($successRates) || array_sum($successRates) == 0)
                        <div class="text-center text-muted p-4">ยังไม่มีข้อมูลอัตราการสำเร็จ</div>
                    @else
                        <canvas id="completion_rate_chart"></canvas>
                    @endif
                </div>
            </div>

            <div class="card p-4 shadow-sm rounded-3 ">
                <p style="font-weight: 600;">กราฟแสดงข้อมูลจำนวนกิจกรรมในแต่ละหมวดหมู่</p>
                <div class="container col-md-9">
                    @if ($activityCount == 0)
                        <div class="text-center text-muted p-4">ยังไม่มีข้อมูลกิจกรรม</div>
                    @else
                        <canvas id="activity_count_chart" style=""></canvas>
                    @endif

                </div>
            </div>



        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($labels);
        const successRates = @json($successRates);
        const activityCounts = @json($activityCounts);

        // กราฟที่ 1: อัตราการสำเร็จ
        new Chart(document.getElementById('completion_rate_chart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'เปอร์เซ็นต์ความสำเร็จ',
                    data: successRates,
                    backgroundColor: 'rgba(122, 235, 122, 0.7)' // สีเขียวอ่อน
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom' // ✅ legend อยู่ด้านล่าง
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: {
                            callback: value => value + '%'
                        }
                    }
                }
            }
        });

        // กราฟที่ 2: จำนวนกิจกรรม
        new Chart(document.getElementById('activity_count_chart'), {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'จำนวนกิจกรรม',
                    data: activityCounts,
                    backgroundColor: 'rgba(129, 183, 216, 0.7)' // สีฟ้าอ่อน
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'bottom' // ✅ legend อยู่ด้านล่าง
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

@endsection
