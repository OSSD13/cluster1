<div class="header">
    <div class="header-left">
        <h4 class="page-title">@yield('page-title', 'ภาพรวม')</h4>
    </div>
    <div class="header-right">
        <img src="resources/views/img/user.jpg" alt="User Avatar" class="user-avatar">
        <span class="user-name">Officer02</span>
    </div>
</div>

<style>
/* ======= Header หลัก ======= */
.header {
    position: fixed;
    top: 0;
    left: 250px; /* ปรับให้เท่ากับ Sidebar */
    width: calc(100% - 250px); /* ป้องกันไม่ให้เกินจอ */
    height: 60px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: white;
    padding: 0 20px;
    border-bottom: 1px solid #ddd;
    z-index: 1000;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
    flex-wrap: wrap; /* ป้องกันการล้นจอ */
}

/* ======= ข้อความ Page Title ======= */
.page-title {
    font-weight: bold;
    margin: 0;
}

/* ======= Avatar & User Name ======= */
.header-right {
    display: flex;
    align-items: center;
    gap: 10px;
}

.user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
}

.user-name {
    font-size: 16px;
    font-weight: semibold;
}

/* ======= Responsive (สำหรับจอเล็ก) ======= */
@media (max-width: 1024px) {
    .header {
        left: 0; /* ให้ Header เต็มจอ */
        width: 100%;
        padding: 0 15px;
    }

    .user-name {
        display: none; /* ซ่อนชื่อผู้ใช้เมื่อจอเล็กลง */
    }

    .user-avatar {
        width: 35px;
        height: 35px;
    }
}

@media (max-width: 768px) {
    .header {
        height: 50px; /* ลดความสูงของ Header */
    }

    .page-title {
        font-size: 18px; /* ลดขนาดหัวข้อ */
    }

    .user-avatar {
        width: 30px;
        height: 30px;
    }
}
</style>
