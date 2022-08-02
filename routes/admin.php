<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\dashboard\DashboardController;
use App\Http\Controllers\backend\LoginController;
use App\Http\Controllers\backend\dashboard\SystemsettingController;
use App\Http\Controllers\backend\audittrails\AuditTrailsController;
use App\Http\Controllers\backend\dashboard\SmtpsettingController;
use App\Http\Controllers\backend\feedback_type\FeedbackTypeController;
use App\Http\Controllers\backend\industry\IndustryController;

Route::get('/admin-logout', [LoginController::class, 'logout'])->name('admin-logout');

$adminPrefix = "admin";
Route::group(['prefix' => $adminPrefix, 'middleware' => ['admin']], function() {
    Route::get('dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::get('admin-update-profile', [DashboardController::class, 'update_profile'])->name('admin-update-profile');
    Route::post('admin-save-profile', [DashboardController::class, 'save_profile'])->name('admin-save-profile');

    Route::get('admin-change-password', [DashboardController::class, 'change_password'])->name('admin-change-password');
    Route::post('save-password', [DashboardController::class, 'save_password'])->name('save-password');

    Route::post('common-ajaxcall', [CommonController::class, 'ajaxcall'])->name('common-ajaxcall');

    Route::get('admin-system-setting',[SystemsettingController::class,'system_setting'])->name('admin-system-setting');
    Route::post('save-system-setting',[SystemsettingController::class,'system_setting'])->name('save-system-setting');

    Route::get('smtp-setting',[SmtpsettingController::class,'smtp_setting'])->name('smtp-setting');
    Route::post('save-smtp-setting',[SmtpsettingController::class,'smtp_setting'])->name('save-smtp-setting');

    $adminPrefix = "audittrails";
    Route::group(['prefix' => $adminPrefix, 'middleware' => ['admin']], function() {
        Route::get('audit-trails', [AuditTrailsController::class, 'list'])->name('audit-trails');
        Route::post('audit-trails-ajaxcall', [AuditTrailsController::class, 'ajaxcall'])->name('audit-trails-ajaxcall');
    });

    //Industry
    Route::get('industry',[IndustryController::class,'list'])->name('industry');
    Route::post('industry-ajaxcall',[IndustryController::class,'ajaxcall'])->name('industry-ajaxcall');
    Route::get('add-industry',[IndustryController::class,'add'])->name('add-industry');
    Route::post('add-save-industry',[IndustryController::class,'save_add_industry'])->name('add-save-industry');
    Route::get('edit-industry/{id}',[IndustryController::class,'edit'])->name('edit-industry');
    Route::post('edit-save-industry',[IndustryController::class,'save_edit_industry'])->name('edit-save-industry');

    //Feedback Type
    Route::get('feedback-type',[FeedbackTypeController::class,'list'])->name('feedback-type');
    Route::get('add-feedback-type',[FeedbackTypeController::class,'add'])->name('add-feedback-type');
    Route::post('add-save-feedback-type',[FeedbackTypeController::class,'save_add_feedback_type'])->name('add-save-feedback-type');
    Route::get('edit-feedback-type/{id}',[FeedbackTypeController::class,'edit'])->name('edit-feedback-type');
    Route::post('edit-save-feedback-type',[FeedbackTypeController::class,'save_edit_feedback_type'])->name('edit-save-feedback-type');


    Route::post('feedback-type-ajaxcall',[FeedbackTypeController::class,'ajaxcall'])->name('feedback-type-ajaxcall');


});



?>
