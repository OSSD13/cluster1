<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\volunteerController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProvinceController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\UserMiddleware;
use App\Http\Controllers\centralController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\imageController;

/**
 * ------------------------------
 * Routes สำหรับการ Login / Logout
 * ------------------------------
 */
Route::get('/login', [LoginController::class, 'index'])->name('logined');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'create']);

/**
 * ------------------------------
 * Routes ที่ต้องมี Authentication
 * ------------------------------
 */
Route::middleware([UserMiddleware::class])->group(function () {

    // หน้าแรก

    Route::get('/', [HomeController::class, 'overview']);

    Route::get('/overview', [HomeController::class, 'overview'])->name('overview.index');

    // กำหนดเส้นทาง resource สำหรับ activities
    Route::resource('activity', ActivityController::class);
    //Route::resource('activities', ActivityController::class);

    // จัดการผู้ใช้
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'edit']);
    Route::put('/user/{id}', [UserController::class, 'saveEdit'])->name('user.update');
    Route::delete('/user/{id}', [UserController::class, 'delete'])->name('user.delete');

    // Error Pages
    Route::get('/central/overview', [centralController::class, 'overview']);

    /**
     * ------------------------------
     * Routes สำหรับ Activities
     * ------------------------------
     */
    Route::get('/activities/historyActivity', [ActivityController::class, 'historyActivity'])->name('activities.history');
    Route::get('/activity', [ActivityController::class, 'index'])->name('activity.index');
    Route::get('/activity/create', [ActivityController::class, 'historyActivity'])->name('activity.create');
    Route::post('/activity', [ActivityController::class, 'store'])->name('activity.store');
    Route::get('/activities/{id}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
    Route::put('/activities/{id}', [ActivityController::class, 'update'])->name('activities.update');
    Route::get('/activities/{id}/detail', [ActivityController::class, 'detail'])->name('activities.detail');
    //Route::delete('/activity/{id}', [ActivityController::class, 'destroy'])->name('activities.delete');

    // Route สำหรับลบภาพ
    // ตรวจสอบให้แน่ใจว่า route นี้เป็น method DELETE

   // แก้จาก /images/{id}
   Route::post('/activity-images/{id}', [ImageController::class, 'destroy'])->name('images.destroy');
    // Routes สำหรับให้ User2 ตรวจสอบกิจกรรม
    Route::post('/activity/{id}/review', [ActivityController::class, 'review'])->name('activity.review');

    // Routes สำหรับให้ User1 ตรวจสอบและอนุมัติขั้นสุดท้าย
    Route::post('/activity/{id}/final-review', [ActivityController::class, 'finalReview'])->name('activity.finalReview');

    /**
     * ------------------------------
     * Routes สำหรับ Categories
     * ------------------------------
     */
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

    // เผยแพร่หรือยกเลิกการเผยแพร่หมวดหมู่ (User1)
    Route::post('/categories/publishAll', [CategoryController::class, 'publishAll'])->name('categories.publishAll');
    Route::post('/categories/{id}/publish', [CategoryController::class, 'publish'])->name('categories.publish');
    Route::post('/categories/{id}/unpublish', [CategoryController::class, 'unpublish'])->name('categories.unpublish');

    /**
     * ------------------------------
     * Routes สำหรับ Dashboard ของ User3
     * ------------------------------
     */
    Route::post('/activities/submitAll', [ActivityController::class, 'submitAll'])->name('activities.submitAll');
    // --------------------------------
    // Route for Province
    // --------------------------------
    Route::get('/province/approve', [ProvinceController::class, 'reviewList'])->name('province.index');
    Route::get('/province/approve/category/{user_id}', [ProvinceController::class, 'showCategoryToSelect'])->name('province.approve.category');
    Route::get('/province/approve/category/{user_id}/activities/{cat_id}', [ProvinceController::class, 'showActivities'])->name('province.approve.category.activities');
    Route::get('/province/approve/category/{user_id}/activities/{cat_id}/detail/{act_id}', [ProvinceController::class, 'showActivityDetail'])->name('province.approve.category.activities.detail');
    Route::get('/consider-event/activity-data', [ProvinceController::class, 'considerData'])->name('province.considerData');
    Route::get('/report', [ProvinceController::class, 'report'])->name('province.report');
    Route::get('/report/activity-data', [ProvinceController::class, 'activityData'])->name('province.activityData');
    Route::post('/province/approve/{id}', [ProvinceController::class, 'approveActivity'])->name('province.approve');
    Route::post('/province/reject/{id}', [ProvinceController::class, 'rejectActivity'])->name('province.reject');

    // Route สำหรับความคิดเห็น
    Route::post('/province/comment/{activityId}', [ProvinceController::class, 'storeComment'])->name('province.comment.store');

    // ปุ่มแสดงความคิดเห็น
    Route::get('/province/approve_activity_activity_detail', function () {
        return view('province.approve_activity_activity_detail');
    });
});

