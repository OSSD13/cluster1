<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\provinceController;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\UserMiddleware;
use App\Http\Controllers\centralController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageController;

/**
 * ------------------------------
 * Routes สำหรับการ Login / Logout
 * ------------------------------
 */
Route::get('/cluster1/login', [LoginController::class, 'index'])->name('logined');
Route::post('/cluster1/login', [LoginController::class, 'login'])->name('login');
Route::post('/cluster1/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/cluster1/register', [RegisterController::class, 'index'])->name('register');
Route::post('/cluster1/register', [RegisterController::class, 'create']);

Route::get('/.env', function () {
    return redirect('/cluster1');
});

/**
 * ------------------------------
 * Routes ที่ต้องมี Authentication
 * ------------------------------
 */
Route::middleware([UserMiddleware::class])->group(function () {

    // หน้าแรก

    Route::get('/cluster1', [HomeController::class, 'overview']);

    Route::get('/cluster1/overview', [HomeController::class, 'overview'])->name('overview.index');

    // กำหนดเส้นทาง resource สำหรับ activities
    Route::resource('/cluster1/activity', ActivityController::class);
    //Route::resource('activities', ActivityController::class);

    // จัดการผู้ใช้
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/cluster1/user/{id}', [UserController::class, 'edit']);
    Route::put('/cluster1/user/{id}', [UserController::class, 'saveEdit'])->name('user.update');
    Route::delete('/cluster1/user/{id}', [UserController::class, 'delete'])->name('user.delete');

    // Error Pages
    Route::get('/cluster1/central/overview', [centralController::class, 'overview']);

    /**
     * ------------------------------
     * Routes สำหรับ Activities
     * ------------------------------
     */
    Route::get('/cluster1/activities/historyActivity', [ActivityController::class, 'historyActivity'])->name('activities.history');
    Route::get('/cluster1/activity', [ActivityController::class, 'index'])->name('activity.index');
    Route::get('/cluster1/activity/create', [ActivityController::class, 'historyActivity'])->name('activity.create');
    Route::post('/cluster1/activity', [ActivityController::class, 'store'])->name('activity.store');
    Route::get('/cluster1/activities/{id}/edit', [ActivityController::class, 'edit'])->name('activities.edit');
    Route::put('/cluster1/activities/{id}', [ActivityController::class, 'update'])->name('activities.update');
    Route::get('/cluster1/activities/{id}/detail', [ActivityController::class, 'detail'])->name('activities.detail');
    //Route::delete('/activity/{id}', [ActivityController::class, 'destroy'])->name('activities.delete');

    // Route สำหรับลบภาพ
    // ตรวจสอบให้แน่ใจว่า route นี้เป็น method DELETE

    // แก้จาก /images/{id}
    Route::delete('/cluster1/activity-images/{id}', [ImageController::class, 'destroy'])->name('images.destroy');
    // Routes สำหรับให้ User2 ตรวจสอบกิจกรรม

    // Routes สำหรับให้ User1 ตรวจสอบและอนุมัติขั้นสุดท้าย


    /**
     * ------------------------------
     * Routes สำหรับ Categories
     * ------------------------------
     */
    Route::get('/cluster1/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/cluster1/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/cluster1/categories', [CategoryController::class, 'store'])->name('categories.store');

    // เผยแพร่หรือยกเลิกการเผยแพร่หมวดหมู่ (User1)
    Route::post('/cluster1/categories/publishAll', [CategoryController::class, 'publishAll'])->name('categories.publishAll');
    Route::post('/cluster1/categories/{id}/publish', [CategoryController::class, 'publish'])->name('categories.publish');
    Route::post('/cluster1/categories/{id}/unpublish', [CategoryController::class, 'unpublish'])->name('categories.unpublish');
    Route::get('/cluster1/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/cluster1/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');

    /**
     * ------------------------------
     * Routes สำหรับ Dashboard ของ User3
     * ------------------------------
     */
    Route::post('/cluster1/activities/submitAll', [ActivityController::class, 'submitAll'])->name('activities.submitAll');
    // --------------------------------
    // Route for Province
    // --------------------------------
    Route::get('/cluster1/province/approve', [provinceController::class, 'reviewList'])->name('province.index');
    Route::get('/cluster1/province/approve/category/{user_id}', [provinceController::class, 'showCategoryToSelect'])->name('province.approve.category');
    Route::get('/cluster1/province/approve/category/{user_id}/activities/{cat_id}', [provinceController::class, 'showActivities'])->name('province.approve.category.activities');
    Route::get('/cluster1/province/approve/category/{user_id}/activities/{cat_id}/detail/{act_id}', [provinceController::class, 'showActivityDetail'])->name('province.approve.category.activities.detail');
    Route::get('/cluster1/consider-event/activity-data', [provinceController::class, 'considerData'])->name('province.considerData');
    Route::get('/cluster1/report', [provinceController::class, 'report'])->name('province.report');
    Route::get('/cluster1/report/activity-data', [provinceController::class, 'activityData'])->name('province.activityData');
    Route::post('/cluster1/province/approve/{id}', [provinceController::class, 'approveActivity'])->name('province.approve');
    Route::post('/cluster1/province/reject/{id}', [provinceController::class, 'rejectActivity'])->name('province.rejectActivity');
    Route::post('/cluster1/province/reject/sentback{id}', [provinceController::class, 'unapproveByCentral'])->name('province.unapprove.click');
    Route::post('/cluster1/province/reject/all', [provinceController::class, 'rejectAllInProvince'])->name('province.rejectAllInProvince');
    Route::get('/cluster1/province/unapprove', [provinceController::class, 'showUnapprovedActivities'])->name('province.unapprove');

    // Route สำหรับความคิดเห็น
    Route::post('/cluster1/province/comment/{activityId}', [provinceController::class, 'storeComment'])->name('province.comment.store');

    // ปุ่มแสดงความคิดเห็น
    Route::get('/cluster1/province/approve_activity_activity_detail', function () {
        return view('province.approve_activity_activity_detail');
    });
});
