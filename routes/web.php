<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CarauselController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\KnowledgeController;
use App\Http\Controllers\TimeLineController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\CorsMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [ClientController::class, "home"])->name("client.home");
Route::get('/login', [UserController::class, "login"])->name("user.login");
Route::post('/login', [UserController::class, "checkLogin"])->name("user.checklogin");
Route::get('/change-pass', [UserController::class, "viewPassAdmin"])->name("user.viewchangepass");
Route::post('/change-pass', [UserController::class, "changePassAdmin"])->name("user.changepass");
Route::get('/otp', [UserController::class, "viewOTP"])->name("user.viewOTP");
Route::post('/otp', [UserController::class, "checkOTP"])->name("user.checkOTP");
Route::get('/logout', [UserController::class, "logout"])->name("user.logout");
Route::post('/users', [UserController::class, 'addUserCourse'])->middleware([CorsMiddleware::class]);
Route::get('/course/{slug}/{id}', [ClientController::class, "course"])->name("client.course");
Route::get('/feedback', [FeedbackController::class, "index"])->name("client.feedback");
Route::get('/knowledge', [KnowledgeController::class, "index"])->name("client.knowledge");
Route::get('/knowledge/{slug}/{id}', [KnowledgeController::class, "detail"])->name("client.knowledge.detail");
Route::prefix('admin')->middleware(AuthMiddleware::class)->group(function () {
    Route::get('/', [AdminController::class, "home"])->name("admin.home");
    Route::get('/course', [CourseController::class, "index"])->name("admin.course.index");
    Route::get('/course/create', [CourseController::class, "create"])->name("admin.course.create");
    Route::post('/course/create', [CourseController::class, "store"])->name("admin.course.store");
    Route::get('/course/detail/{id}', [CourseController::class, "detail"])->name("admin.course.detail");
    Route::get('/course/edit/{id}', [CourseController::class, "edit"])->name("admin.course.edit");
    Route::post('/course/edit/{course}', [CourseController::class, "update"])->name("admin.course.update");
    Route::get('/course/delete/{id}', [CourseController::class, "delete"])->name("admin.course.delete");

    Route::post('/course/who/create', [CourseController::class, "createWhoCourse"])->name("admin.whoCourse.create");
    Route::post('/course/who/update/{whoCourse}', [CourseController::class, "updateWhoCourse"])->name("admin.whoCourse.update");
    Route::get('/course/achive/create/{id}', [CourseController::class, "createAchiveCourse"])->name("admin.achiveCourse.create");
    Route::get('/course/achive/delete/{id}', [CourseController::class, "deleteAchiveCourse"])->name("admin.achiveCourse.delete");
    Route::post('/course/achive/create/{id}', [CourseController::class, "storeAchiveCourse"])->name("admin.achiveCourse.store");
    Route::get('/course/achive/edit/{achiveCourse}', [CourseController::class, "editAchiveCourse"])->name("admin.achiveCourse.edit");
    Route::post('/course/achive/edit/{achiveCourse}', [CourseController::class, "updateAchiveCourse"])->name("admin.achiveCourse.update");
    Route::get('/course/module/create/{id}', [CourseController::class, "createModuleCourse"])->name("admin.moduleCourse.create");
    Route::post('/course/module/create/{id}', [CourseController::class, "storeModuleCourse"])->name("admin.moduleCourse.store");
    Route::get('/course/module/edit/{moduleCourse}', [CourseController::class, "editModuleCourse"])->name("admin.moduleCourse.edit");
    Route::post('/course/module/edit/{moduleCourse}', [CourseController::class, "updateModuleCourse"])->name("admin.moduleCourse.update");
    Route::get('/course/module/delete/{id}', [CourseController::class, "deleteModuleCourse"])->name("admin.moduleCourse.delete");
    
    //outline
    Route::get('/course/detail/{id}/outline', [CourseController::class, "outlineModuleCourse"])->name("admin.moduleOutline");
    Route::get('/course/outline/create', [CourseController::class, "createOutlineModuleCourse"])->name("admin.moduleOutline.create");
    Route::post('/course/outline/create', [CourseController::class, "storeOutlineModuleCourse"])->name("admin.moduleOutline.store");
    Route::get('/course/outline/edit/{id}', [CourseController::class, "editOutlineModuleCourse"])->name("admin.moduleOutline.edit");
    Route::post('/course/outline/edit/{outline}', [CourseController::class, "updateOutlineModuleCourse"])->name("admin.moduleOutline.update");
    Route::get('/course/outline/delete/{id}', [CourseController::class, "deleteOutlineModuleCourse"])->name("admin.moduleOutline.delete");
    //DesCourse
    Route::get('/course/des/create/{id}', [CourseController::class, "createDes"])->name("admin.desCourse.create");
    Route::post('/course/des/create/{id}', [CourseController::class, "storeDesCourse"])->name("admin.desCourse.store");
    Route::get('/course/des/edit/{id}', [CourseController::class, "editDes"])->name("admin.desCourse.edit");
    Route::post('/course/des/edit/{desC}', [CourseController::class, "updateDesCourse"])->name("admin.desCourse.update");
    // knowledge
    Route::get('/knowledge', [KnowledgeController::class, "indexAdmin"])->name("admin.knows.index");
    Route::get('/knowledge/create', [KnowledgeController::class, "createKnow"])->name("admin.knows.create");
    Route::post('/knowledge/create', [KnowledgeController::class, "storeKnow"])->name("admin.knows.store");
    Route::get('/knowledge/edit/{id}', [KnowledgeController::class, "editKnow"])->name("admin.knows.edit");
    Route::post('/knowledge/edit/{know}', [KnowledgeController::class, "updateKnow"])->name("admin.knows.update");
    Route::get('/knowledge/delete/{id}', [KnowledgeController::class, "destroy"])->name("admin.knows.delete");
    // Carausels
    Route::get('/carausel', [CarauselController::class, "index"])->name("admin.carausel.index");
    Route::get('/carausel/create', [CarauselController::class, "create"])->name("admin.carausel.create");
    Route::post('/carausel/create', [CarauselController::class, "store"])->name("admin.carausel.store");
    Route::get('/carausel/edit/{id}', [CarauselController::class, "edit"])->name("admin.carausel.edit");
    Route::post('/carausel/edit/{carausel}', [CarauselController::class, "update"])->name("admin.carausel.update");
    Route::get('/carausel/delete/{id}', [CarauselController::class, "delete"])->name("admin.carausel.delete");
    //user
    Route::get('/user', [UserController::class, "index"])->name("admin.user.index");
    Route::get('/user/register', [UserController::class, "create"])->name("admin.user.create");
    Route::post('/user/register', [UserController::class, "register"])->name("admin.user.register");
    Route::get('/user/update/{id}', [UserController::class, "edit"])->name("admin.user.edit");
    Route::post('/user/update/{user}', [UserController::class, "update"])->name("admin.user.update");
    Route::get('/user/delete/{id}', [UserController::class, "delete"])->name("admin.user.delete");
    Route::get('/user/active/{id}', [UserController::class, "activeUser"])->name("admin.user.active");
    Route::get('/user/payUser/{id}', [UserController::class, "payUser"])->name("admin.user.payUser");
    //feedback
    Route::get('/feedback', [FeedbackController::class, "indexAdmin"])->name("admin.feedback.index");
    Route::get('/feedback/create', [FeedbackController::class, "create"])->name("admin.feedback.create");
    Route::post('/feedback/create', [FeedbackController::class, "store"])->name("admin.feedback.store");
    Route::get('/feedback/edit/{id}', [FeedbackController::class, "edit"])->name("admin.feedback.edit");
    Route::post('/feedback/edit/{feed}', [FeedbackController::class, "update"])->name("admin.feedback.update");
    Route::get('/feedback/delete/{id}', [FeedbackController::class, "delete"])->name("admin.feedback.delete");

    // banner
    Route::get('/banner/create', [BannerController::class, "index"])->name("admin.banner.index");
    Route::post('/banner/create', [BannerController::class, "store"])->name("admin.banner.store");
    Route::get('/banner/edit/{id}', [BannerController::class, "edit"])->name("admin.banner.edit");
    Route::post('/banner/edit/{banner}', [BannerController::class, "update"])->name("admin.banner.update");

    //Timeline
    Route::get('/timeline', [TimeLineController::class, "index"])->name("admin.timeline.index");
    Route::get('/timeline/create', [TimeLineController::class, "create"])->name("admin.timeline.create");
    Route::post('/timeline/create', [TimeLineController::class, "store"])->name("admin.timeline.store");
});
