
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Navbar Example</title>
  <!-- การเชื่อมโยงกับ Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  
  <!-- อาสา -->
  <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary mb-3">
    <div class="container-fluid">
      <!-- แบรนด์หรือโลโก้ -->
      <a class="navbar-brand" href="#">แบรนด์ของฉัน</a>
      <!-- เมนู -->
      <div class="navbar-nav">
        <a class="nav-link" href="#">เขียนงาน</a>
        <a class="nav-link" href="#">ภาพรวม</a>
        <a class="nav-link" href="#">กิจกรรมที่เคยทำ</a>
      </div>
    </div>
  </nav>

  <!-- จังหวัด -->
  <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary mb-3">
    <div class="container-fluid">
      <!-- แบรนด์หรือโลโก้ -->
      <a class="navbar-brand" href="#">แบรนด์ของฉัน</a>
      <!-- เมนู -->
      <div class="navbar-nav">
        <a class="nav-link" href="#">ภาพรวม</a>
        <a class="nav-link" href="#">อนุมัติงาน</a>
        <a class="nav-link" href="#">กิจกรรมที่ไม่ผ่าน</a>
        <a class="nav-link" href="#">รายงาน</a>
      </div>
    </div>
  </nav>

  <!-- ส่วนกลาง -->
  <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary mb-3">
    <div class="container-fluid">
      <!-- แบรนด์หรือโลโก้ -->
      <a class="navbar-brand" href="#">แบรนด์ของฉัน</a>
      <!-- เมนู -->
      <div class="navbar-nav">
        <a class="nav-link" href="#">ภาพรวม</a>
        <a class="nav-link" href="#">กำหนดหมวดหมู๋</a>
        <a class="nav-link" href="#">อนุมัติงาน</a>
        <a class="nav-link" href="#">รายงาน</a>
      </div>
    </div>
  </nav>

  <!-- การเชื่อมโยงกับ Bootstrap JS และ Popper -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>