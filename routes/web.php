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
Route::get('/login', [LoginController::class, 'index'])->name('logined');
Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/.env', function () {
    return redirect('/');
});

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
    Route::get('/activities/activity-data', [ActivityController::class, 'activityData'])->name('activities.activityData');
    //Route::delete('/activity/{id}', [ActivityController::class, 'destroy'])->name('activities.delete');

    // Route สำหรับลบภาพ
    // ตรวจสอบให้แน่ใจว่า route นี้เป็น method DELETE

    // แก้จาก /images/{id}
    Route::delete('/activity-images/{id}', [ImageController::class, 'destroy'])->name('images.destroy');
    // Routes สำหรับให้ User2 ตรวจสอบกิจกรรม

    // Routes สำหรับให้ User1 ตรวจสอบและอนุมัติขั้นสุดท้าย


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
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::get('/categories/{id}/detail', [CategoryController::class, 'detail'])->name('categories.detail');

    /**
     * ------------------------------
     * Routes สำหรับ Dashboard ของ User3
     * ------------------------------
     */
    Route::post('/activities/submitAll', [ActivityController::class, 'submitAll'])->name('activities.submitAll');
    // --------------------------------
    // Route for Province
    // --------------------------------
    Route::get('/province/approve', [provinceController::class, 'reviewList'])->name('province.index');
    Route::get('/province/approve/category/{user_id}', [provinceController::class, 'showCategoryToSelect'])->name('province.approve.category');
    Route::get('/province/approve/category/{user_id}/activities/{cat_id}', [provinceController::class, 'showActivities'])->name('province.approve.category.activities');
    Route::get('/province/approve/category/{user_id}/activities/{cat_id}/detail/{act_id}', [provinceController::class, 'showActivityDetail'])->name('province.approve.category.activities.detail');
    Route::get('/consider-event/activity-data', [provinceController::class, 'considerData'])->name('province.considerData');
    Route::get('/province/report', [provinceController::class, 'report'])->name('province.report');
    Route::get('/province/report/activity-data', [provinceController::class, 'activityData'])->name('province.activityData');
    Route::get('/province/unapprove', [provinceController::class, 'showUnapprovedActivities'])->name('province.unapprove');

    Route::post('/province/approve/{id}', [provinceController::class, 'approveActivity'])->name('province.approve');
    Route::post('/province/reject/{id}', [provinceController::class, 'rejectActivity'])->name('province.rejectActivity');
    Route::post('/province/reject/sentback/{id}', [provinceController::class, 'unapproveByCentral'])->name('province.unapprove.click');
    Route::post('/province/reject/sentback', [provinceController::class, 'rejectAllInProvince'])->name('province.rejectAllInProvince');

    // Route สำหรับความคิดเห็น
    Route::post('/province/comment/{activityId}', [provinceController::class, 'storeComment'])->name('province.comment.store');

    // ปุ่มแสดงความคิดเห็น
    Route::get('/province/approve_activity_activity_detail', function () {
        return view('province.approve_activity_activity_detail');
    });

    // --------------------------------
    // Route for Centrlal
    // --------------------------------
    Route::get('/central/report/index', [centralController::class, 'reportIndex'])->name('central.report.index');
    Route::get('/central/report/{pvc_id}', [centralController::class, 'report'])->name('central.report');
    Route::get('/central/report/province-data', [centralController::class, 'provinceData'])->name('central.provinceData');
    Route::get('/central/report/activity-data', [centralController::class, 'activityData'])->name('central.activityData');

    Route::get('/central/approve/index', [centralController::class, 'approveIndex'])->name('central.approve.index');
    Route::get('/central/approve/approve-index-data', [centralController::class, 'approveIndexData'])->name('central.approve.index.data');
    Route::get('/central/approve/province/{pvc_id}', [centralController::class, 'selectVolunteer'])->name('central.province.index');
    Route::get('/central/approve/category/{user_id}', [centralController::class, 'showCategoryToSelect'])->name('central.approve.category');
    Route::get('/central/approve/category/{user_id}/activities/{cat_id}', [centralController::class, 'selectActivities'])->name('central.approve.category.activities');
    Route::get('/central/approve/category/{user_id}/activities/{cat_id}/detail/{act_id}', [centralController::class, 'showActivityDetail'])->name('central.approve.category.activities.detail');

    Route::post('/central/approve/submit/{id}', [centralController::class, 'approveActivity'])->name('central.approveActivity');
    Route::post('/central/approve/reject/{id}', [centralController::class, 'rejectActivity'])->name('central.rejectActivity');
});
