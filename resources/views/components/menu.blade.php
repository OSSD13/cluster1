<div class="sidebar">
    <div class="sidebar-header">
      <div class="logo-container">
        <img src="/resources/views/img/Component 33.png" alt="Logo">
      </div>
      <h2>VAR</h2>
    </div>

    <ul class="sidebar-menu">
      <li class="active">
        <a href="#">
          <i class="bi bi-pie-chart-fill"></i> ภาพรวม
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bi bi-journal-text"></i> กำหนดหมวดหมู่
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bi bi-check-square"></i> อนุมัติงาน
        </a>
      </li>
      <li>
        <a href="#">
          <i class="bi bi-clock-history"></i> รายงาน
        </a>
      </li>
    </ul>

    <div class="logout">
      <a href="#">
        <i class="bi bi-box-arrow-right"></i> ออกจากระบบ
      </a>
    </div>
  </div>
  <style>
    /* Layout หลักของ Sidebar */
.sidebar {
  width: 250px;
  height: 100vh;
  background-color: #fff;
  padding: 20px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  border-right: 1px solid #ddd;
  position: fixed;
  top: 0;
  left: 0;
  transition: all 0.3s ease;
}

/* ส่วนหัวของ Sidebar */
.sidebar-header {
  display: flex;
  align-items: center;
  gap: 10px;
  padding-bottom: 10px;
  border-bottom: 1px solid #ddd;
}

.logo-container {
  background-color: #e5c0a1;
  padding: 10px;
  border-radius: 10px;
}

.logo-container img {
  width: 50px;
  height: 50px;
}

.sidebar h2 {
  font-size: 18px;
  font-weight: bold;
  color: #121212;
  margin: 0;
}

/* เมนูด้านข้าง */
.sidebar-menu {
  list-style: none;
  padding: 0;
  margin-top: 20px;
  flex-grow: 1;
}

.sidebar-menu li {
  padding: 10px;
  font-size: 16px;
}

.sidebar-menu li a {
  text-decoration: none;
  color: #333;
  display: flex;
  align-items: center;
  gap: 10px;
  font-weight: 500;
  padding: 10px;
  border-radius: 8px;
}



/* ปุ่มออกจากระบบ */
.logout {
  margin-top: auto;
  padding-bottom: 20px;
}

.logout a {
  text-decoration: none;
  color: red;
  font-weight: bold;
  display: flex;
  align-items: center;
  gap: 10px;
}

/* Responsive: ซ่อน Sidebar บนหน้าจอขนาดเล็ก */
@media (max-width: 292px) {
  .sidebar {
    width: 60px;
    overflow: hidden;
    padding: 10px;
  }

  .sidebar h2 {
    display: none;
  }

  .sidebar-menu li a {
    justify-content: center;
  }

  .sidebar-menu li a span {
    display: none;
  }

  .logout a {
    justify-content: center;
  }
}
  </style>
