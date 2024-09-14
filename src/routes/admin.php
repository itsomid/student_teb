<?php

use App\Http\Controllers\Admin\CcServerController;
use App\Http\Controllers\Admin\CommissionHistoryManagementController;
use App\Http\Controllers\Admin\CommissionManagementController;
use App\Http\Controllers\Admin\CommissionTypeManagementController;
use App\Http\Controllers\Admin\DistributeStudentsController;
use App\Http\Controllers\Admin\HomeworkController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\InstallmentManagementController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\RandomStudentsDistributionController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SalesReportByCategory;
use App\Http\Controllers\Admin\SelectiveStudentsDistributionController;
use App\Http\Controllers\Admin\StudentAccountController;
use App\Http\Controllers\Admin\SelectsApiController;
use App\Http\Controllers\Admin\StudentTokenController;
use App\Http\Controllers\Admin\SupportMapController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\TransactionReportController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CouponRangeController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DebitCardTransactionController;
use App\Http\Controllers\Admin\ExternalSettingController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\InternalSettingController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductTypeController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ReferralCodeController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RoleUserController;
use App\Http\Controllers\Admin\SessionController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserSupportController;
use App\Http\Controllers\Admin\SaleSupportReportController;
use App\Http\Controllers\Admin\SupportsAllocationRateController;
use App\Http\Controllers\Admin\ThemeController;
use App\Http\Controllers\Admin\ClassController;

Route::get('/teacher-commission/{teacher}', [\App\Http\Controllers\Admin\TeacherCommissionController::class, 'calculate']);
Route::post('/teacher-commission-percentage/{teacher}', [\App\Http\Controllers\Admin\TeacherCommissionController::class, 'saveCommissionPercentage'])->name('teacher-commission.save-percentage');

Route::get('/students_select' ,[SelectsApiController::class, 'students'])->name('students.select.index');
Route::get('/admins_select' ,[SelectsApiController::class, 'admins'])->name('admins.select.index');

Route::post('/set-theme', [ThemeController::class, 'setTheme'])->name('set-theme');
Route::get('/', [HomeController::class, 'index'])->name('dashboard');

Route::get('/inquiry',  [InquiryController::class, 'index']) ->name('inquiry.index') ->can('admin.inquiry');
Route::post('/inquiry', [InquiryController::class, 'submit'])->name('inquiry.submit')->can('admin.inquiry');

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/{admin}', [ProfileController::class, 'update'])->name('profile.update');
Route::get('/profile/password', [ProfileController::class, 'passwordEdit'])->name('profile.password.edit');
Route::patch('/profile/{admin}/update-password', [ProfileController::class, 'passwordUpdate'])->name('profile.password.update');
Route::get('/profile/2fa', [ProfileController::class, 'twoFAEdit'])->name('profile.2fa.edit');

Route::get('/admins', [AdminController::class, 'index'])->name('admin.index')->can('admin.index');
Route::get('/admins/create', [AdminController::class, 'create'])->name('admin.create')->can('admin.create');
Route::post('/admins', [AdminController::class, 'store'])->name('admin.store')->can('admin.create');
Route::get('/admins/{admin}/edit', [AdminController::class, 'edit'])->name('admin.edit')->can('admin.edit');
Route::patch('/admins/{admin}', [AdminController::class, 'update'])->name('admin.update')->can('admin.edit');
Route::get('/admins/{admin}/password', [AdminController::class, 'passwordEdit'])->name('admin.password.edit')->can('admin.edit');
Route::patch('/admins/{admin}/password', [AdminController::class, 'passwordUpdate'])->name('admin.password.update')->can('admin.edit');
Route::get('/admins/{admin}/toggle', [AdminController::class, 'toggle'])->name('admin.toggle')->can('admin.toggle');

Route::get('/admins/{admin}/login_as_admin', [AdminController::class, 'login_as_admin'])->name('admin.login_as_admin')->can('admin.login_as_admin');
Route::get('/admins/back_to_admin_panel', [AdminController::class, 'back_to_admin_panel'])->name('admin.back_to_admin_panel');

Route::get('/role/{admin}', [RoleUserController::class, 'edit'])->name('role.user.edit')->can('role.admin.edit');
Route::patch('/role/{admin}', [RoleUserController::class, 'update'])->name('role.user.update')->can('role.admin.edit');

Route::get('/permissions', [PermissionController::class, 'index'])->name('permission.index')->can('permission.index');
Route::get('/permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('permission.edit')->can('permission.edit');
Route::patch('/permissions/{permission}', [PermissionController::class, 'update'])->name('permission.update')->can('permission.edit');

Route::get('/users/{admin}/session', [SessionController::class, 'index'])->name('session.index')->can('session.index');
Route::delete('/users/{admin}/session/{session}', [SessionController::class, 'destroy'])->name('session.destroy')->can('session.destroy');
Route::delete('/users/{admin}/session/purge', [SessionController::class, 'purge'])->name('session.purge')->can('session.destroy');


Route::get('/students', [StudentController::class, 'index'])->name('student.index')->can('student.index');
Route::get('/students/create', [StudentController::class, 'create'])->name('student.create')->can('student.create');
Route::post('/students', [StudentController::class, 'store'])->name('student.store')->can('student.create');
Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('student.edit')->can('student.edit');
Route::patch('/students/{student}/update', [StudentController::class, 'update'])->name('student.update')->can('student.edit');
Route::get('/students/{student}/edit_support', [StudentController::class, 'editSupport'])->name('student.edit-support')->can('student.edit-support');
Route::post('/students/{student}/edit_support_sms', [StudentController::class, 'editSupportSMS'])->name('student.edit-support-sms')->can('student.edit-support');
Route::patch('/students/{student}/update_support', [StudentController::class, 'updateSupport'])->name('student.update-support')->can('student.edit-support');
Route::patch('students/{student}/verify', [StudentController::class, 'verifyStudent'])->name('student.verify')->can('student.verify');

Route::get('/students/{student}/tokens',                  [StudentTokenController::class, 'index'])  ->name('student.token.index') ->can('student.edit');
Route::patch('/students/{student}/tokens/{token}/revoke', [StudentTokenController::class, 'revoke']) ->name('student.token.revoke')->can('student.edit');


Route::get('/user_support', [UserSupportController::class, 'index'])->name('user_support.get')->can('student.support.history');

Route::get('/referral-codes', [ReferralCodeController::class, 'index'])->name('referral_code.index')->can('referral_code.index');
Route::get('/referral-codes/create', [ReferralCodeController::class, 'create'])->name('referral_code.create')->can('referral_code.create');
Route::post('/referral-codes', [ReferralCodeController::class, 'store'])->name('referral_code.store')->can('referral_code.create');
Route::get('/referral-codes/{referral_code}/edit', [ReferralCodeController::class, 'edit'])->name('referral_code.edit')->can('referral_code.edit');
Route::patch('/referral-codes/{referral_code}', [ReferralCodeController::class, 'update'])->name('referral_code.update')->can('referral_code.edit');

Route::get('/orders',           [OrderController::class, 'index'])            ->name('orders.index')          ->can('order.index');
Route::get('/transactions',     [TransactionController::class, 'index'])      ->name('transaction.index')     ->can('transaction.index');

Route::get('/reports/transaction',    [TransactionReportController::class, 'index']) ->name('transaction.report.index');

Route::get('/debit-cards', [DebitCardTransactionController::class, 'index'])->name('debit-card.index')->can('debit-card.index');
Route::get('/debit-cards/create', [DebitCardTransactionController::class, 'create'])->name('debit-card.create')->can('debit-card.create');
Route::post('/debit-cards', [DebitCardTransactionController::class, 'store'])->name('debit-card.store')->can('debit-card.create');
Route::get('/debit-cards/{debit_card}/edit', [DebitCardTransactionController::class, 'edit'])->name('debit-card.edit')->can('debit-card.edit');
Route::patch('/debit-cards/{debit_card}', [DebitCardTransactionController::class, 'update'])->name('debit-card.update')->can('debit-card.edit');
Route::delete('/debit-cards/{debit_card}', [DebitCardTransactionController::class, 'destroy'])->name('debit-card.destroy')->can('debit-card.delete');

Route::get('/product_types', [ProductTypeController::class, 'index'])->name('product_type.index')->can('product_type.index');
Route::get('/product_types/create', [ProductTypeController::class, 'create'])->name('product_type.create')->can('product_type.create');
Route::post('/product_types', [ProductTypeController::class, 'store'])->name('product_type.store')->can('product_type.create');
Route::get('/product_types/{product_type}/edit', [ProductTypeController::class, 'edit'])->name('product_type.edit')->can('product_type.edit');
Route::patch('/product_types/{product_type}', [ProductTypeController::class, 'update'])->name('product_type.update')->can('product_type.edit');

Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.index')->can('coupons.index');
Route::get('/coupons/excel', [CouponController::class, 'excel'])->name('coupons.excel')->can('coupons.excel');

Route::get('/coupons/create_specified_students_coupon',    [CouponController::class, 'createSpecifiedStudentsCoupon'])    ->name('coupons.create_specified_students_coupon')           ->can('coupons.create');
Route::get('/coupons/create_mass_creation',                [CouponController::class, 'createMassCreation'])               ->name('coupons.create-mass-creation')                       ->can('coupons.create');
Route::get('/coupons/create_conditional_student_discount', [CouponController::class, 'createConditionalStudentDiscount']) ->name('coupons.create-conditional-student-discount')        ->can('coupons.create');

Route::post('/coupons/store_specified_students_coupon',    [CouponController::class, 'storeSpecifiedStudentsCoupon'])     ->name('coupons.store-specified-students-coupon')           ->can('coupons.create');
Route::post('/coupons/store_mass_creation',                [CouponController::class, 'storeMassCreation'])                ->name('coupons.store-mass-creation')                       ->can('coupons.create');
Route::post('/coupons/store_conditional_student_discount', [CouponController::class, 'storeConditionalStudentDiscount'])   ->name('coupons.store-conditional-student-discount')       ->can('coupons.create');

Route::get('/coupons/{coupon}/edit', [CouponController::class, 'edit'])->name('coupons.edit')->can('coupons.edit');

Route::patch('/coupons/{coupon}/update_specified_students_coupon',    [CouponController::class, 'updateSpecifiedStudentsCoupon'])     ->name('coupons.update-specified-students-coupon')           ->can('coupons.edit');
Route::patch('/coupons/{coupon}/update_conditional_student_discount', [CouponController::class, 'updateConditionalStudentDiscount'])  ->name('coupons.update-conditional-student-discount')       ->can('coupons.edit');

Route::delete('/coupons/{coupon}', [CouponController::class, 'destroy'])->name('coupons.destroy')->can('coupons.destroy');

Route::get('/coupons-range', [CouponRangeController::class, 'edit'])->name('coupons.range.edit')->can('coupons.range.edit');
Route::patch('/coupons-range', [CouponRangeController::class, 'update'])->name('coupons.range.update')->can('coupons.range.edit');

Route::get('/roles', [RoleController::class, 'index'])->name('role.index')->can('role.index');
Route::get('/roles/create', [RoleController::class, 'create'])->name('role.create')->can('role.create');
Route::post('/roles', [RoleController::class, 'store'])->name('role.store')->can('role.create');
Route::get('/roles/{role}/edit', [RoleController::class, 'edit'])->name('role.edit')->can('role.edit');
Route::patch('/roles/{role}', [RoleController::class, 'update'])->name('role.update')->can('role.edit');

Route::get('/custom-packages', [\App\Http\Controllers\Admin\CustomPackageController::class, 'index'])->name('custom-package.index')->can('custom-package.index');
Route::get('/custom-packages/create', [\App\Http\Controllers\Admin\CustomPackageController::class, 'create'])->name('custom-package.create')->can('custom-package.create');
Route::post('/custom-packages', [\App\Http\Controllers\Admin\CustomPackageController::class, 'store'])->name('custom-package.store')->can('custom-package.create');
Route::get('/custom-packages/{product}/edit', [\App\Http\Controllers\Admin\CustomPackageController::class, 'edit'])->name('custom-package.edit')->can('custom-package.edit');
Route::patch('/custom-packages/{product}', [\App\Http\Controllers\Admin\CustomPackageController::class, 'update'])->name('custom-package.update')->can('custom-package.edit');

Route::get('/courses', [CourseController::class, 'index'])->name('course.index')->can('course.index');
Route::get('/courses/create', [CourseController::class, 'create'])->name('course.create')->can('course.create');
Route::post('/courses', [CourseController::class, 'store'])->name('course.store')->can('course.create');
Route::get('/courses/{course}/edit', [CourseController::class, 'edit'])->name('course.edit')->can('course.edit');
Route::patch('/courses/{course}', [CourseController::class, 'update'])->name('course.update');

Route::get('/courses/{course}/classes', [ClassController::class, 'index'])->name('classes.index')->can('classes.index');
Route::get('/courses/{course}/classes/create', [ClassController::class, 'create'])->name('classes.create')->can('classes.create');
Route::post('/courses/{course}/classes', [ClassController::class, 'store'])->name('classes.store')->can('classes.create');
Route::get('/courses/{course}/classes/{classes}/edit', [ClassController::class, 'edit'])->name('classes.edit')->can('classes.edit');
Route::patch('/courses/{course}/classes/{classes}', [ClassController::class, 'update'])->name('classes.update')->can('classes.edit');

Route::get('/classes-block/block', [\App\Http\Controllers\Admin\ClassBlockController::class, 'index'])->name('class-block.index')->can('class-block.index');
Route::get('/classes-block/create', [\App\Http\Controllers\Admin\ClassBlockController::class, 'create'])->name('class-block.create')->can('class-block.create');
Route::post('/classes-block', [\App\Http\Controllers\Admin\ClassBlockController::class, 'store'])->name('class-block.store')->can('class-block.create');
Route::get('/classes-block/{classBlock}/edit', [\App\Http\Controllers\Admin\ClassBlockController::class, 'edit'])->name('class-block.edit')->can('class-block.edit');
Route::patch('/classes-block/{classBlock}', [\App\Http\Controllers\Admin\ClassBlockController::class, 'update'])->name('class-block.update')->can('class-block.edit');

Route::get('/product_categories', [ProductCategoryController::class, 'index'])->name('product_category.index')->can('product_category.index');
Route::get('/product_categories/create', [ProductCategoryController::class, 'create'])->name('product_category.create')->can('product_category.create');
Route::post('/product_categories', [ProductCategoryController::class, 'store'])->name('product_category.store')->can('product_category.create');
Route::get('/product_categories/{product_category}/edit', [ProductCategoryController::class, 'edit'])->name('product_category.edit')->can('product_category.edit');
Route::patch('/product_categories/{product_category}', [ProductCategoryController::class, 'update'])->name('product_category.update')->can('product_category.edit');
Route::delete('/product_categories/{product_category}', [ProductCategoryController::class, 'destroy'])->name('product_category.destroy')->can('product_category.delete');

Route::get('/internal-settings', [InternalSettingController::class, 'index'])->name('internal.setting.index')->can('setting.int.index');
Route::post('/internal-settings/update-permissions', [InternalSettingController::class, 'updatePermissions'])->name('setting.int.update-permissions')->can('setting.int.index');

Route::get('/supports_allocation_rate',   [SupportsAllocationRateController::class, 'edit'])->name('supports-allocation-rate.edit')->can('supports.allocation-rate-management');
Route::patch('/supports_allocation_rate', [SupportsAllocationRateController::class, 'update'])->name('supports-allocation-rate.update')->can('supports.allocation-rate-management');

Route::get('/external-settings', [ExternalSettingController::class, 'index'])->name('external-setting.index')->can('setting.ext.index');
Route::post('/external-settings/update-ref-address', [ExternalSettingController::class, 'updateRefAddress'])->name('setting.ext.update-ref-address')->can('setting.ext.index');

Route::get('/report/registered_users', [SaleSupportReportController::class, 'registeredUsers'])->name('report.registered_users')->can('report.registered_users');

Route::get('/report/registered_users/{student}/verificationLogs', [SaleSupportReportController::class, 'verificationHistory'])->name('registered-users.verificationLogs')->can('report.registered_users');;

Route::get('/student-account/charge' , [StudentAccountController::class, 'chargeForm'])->name('student-account.charge-form');
Route::post('/student-account/charge', [StudentAccountController::class, 'chargeAccount'])->name('student-account.charge');

Route::get('cc_servers',                  [CcServerController::class, 'index'])     ->name('cc_servers.index')        ->can('cc_servers');
Route::get('cc_servers/create',           [CcServerController::class, 'create'])    ->name('cc_servers.create')       ->can('cc_servers');
Route::post('cc_servers',                 [CcServerController::class, 'store'])     ->name('cc_servers.store')        ->can('cc_servers');
Route::get('cc_servers/{cc_server}/edit', [CcServerController::class, 'edit'])      ->name('cc_servers.edit')         ->can('cc_servers');
Route::put('cc_servers/{cc_server}',      [CcServerController::class, 'update'])    ->name('cc_servers.update')       ->can('cc_servers');
Route::delete('cc_servers/{cc_server}',   [CcServerController::class, 'destroy'])   ->name('cc_servers.destroy')      ->can('cc_servers');


Route::get('/sales_report_by_category',                         [SalesReportByCategory::class, 'index'])                     ->name('sales-report-by-category.form')     ->can('sales_report_by_category');

Route::get('/commission/',                                      [CommissionManagementController::class, 'index'])            ->name('commission.index')  ->can('commission');
Route::post('/commission/',                                     [CommissionManagementController::class, 'store'])            ->name('commission.store')  ->can('commission');
Route::get('/commission/{commission}/edit',                     [CommissionManagementController::class, 'edit'])             ->name('commission.edit')   ->can('commission');
Route::patch('/commission/{commission}',                        [CommissionManagementController::class, 'update'])           ->name('commission.update') ->can('commission');
Route::delete('/commission/{commission}',                       [CommissionManagementController::class, 'destroy'])          ->name('commission.destroy')->can('commission');

Route::get('/commission/{commission}/history',                  [CommissionHistoryManagementController::class, 'index'])     ->name('commission.history.index') ->can('commission');
Route::get('/commission/{commission}/history/create',           [CommissionHistoryManagementController::class, 'create'])    ->name('commission.history.create')->can('commission');
Route::post('/commission/{commission}/history',                 [CommissionHistoryManagementController::class, 'store'])     ->name('commission.history.store') ->can('commission');
Route::get('/commission/{commission}/history/{history}/edit',   [CommissionHistoryManagementController::class, 'edit'])      ->name('commission.history.edit')  ->can('commission');
Route::patch('/commission/{commission}/history/{history}',      [CommissionHistoryManagementController::class, 'update'])    ->name('commission.history.update')->can('commission');

Route::get('/commission_type',                                  [CommissionTypeManagementController::class, 'index'])        ->name('commission_type.index')  ->can('commission');
Route::post('/commission_type',                                 [CommissionTypeManagementController::class, 'store'])        ->name('commission_type.store')  ->can('commission');
Route::get('/commission_type/{commission_type}/edit',           [CommissionTypeManagementController::class, 'edit'])         ->name('commission_type.edit')   ->can('commission');
Route::patch('/commission_type/{commission_type}',              [CommissionTypeManagementController::class, 'update'])       ->name('commission_type.update') ->can('commission');
Route::delete('/commission_type/{commission_type}',             [CommissionTypeManagementController::class, 'destroy'])      ->name('commission_type.destroy')->can('commission');

Route::get('/course/search/{name}', [\App\Http\Controllers\Admin\CourseSearchController::class, '__invoke']);

Route::get('/installments',                                     [InstallmentManagementController::class, 'index'])           ->name('installment.index')          ->can('installment.index');

Route::get('/students_random_distribution',                     [RandomStudentsDistributionController::class, 'index'])              ->name('random.students.distribution.index')       ->can('random-students-distribution');
Route::post('/students_random_distribution',                    [RandomStudentsDistributionController::class, 'distribute'])         ->name('random.students.distribution.distribute')  ->can('random-students-distribution');

Route::get('/students_selective_distribution',                  [SelectiveStudentsDistributionController::class, 'index'])           ->name('selective.students.distribution.index')     ->can('selective-students-distribution');
Route::post('/students_selective_distribution',                 [SelectiveStudentsDistributionController::class, 'distribute'])      ->name('selective.students.distribution.distribute')->can('selective-students-distribution');


Route::get('/homeworks',                    [HomeworkController::class, 'index'])       ->name('homework.index')     ->can('homework');
Route::patch('/homeworks/{id}/set_score',   [HomeworkController::class, 'setScore'])    ->name('homework.set_score') ->can('homework');
Route::delete('/homeworks/{id}',            [HomeworkController::class, 'destroy'])     ->name('homework.destroy')   ->can('homework');

Route::get('/reports',                      [ReportController::class, 'index'])         ->name('reports.index')      ->can('report');;
Route::patch('/reports/{id}/set_score',     [ReportController::class, 'setScore'])      ->name('reports.set_score')  ->can('report');;
Route::delete('/reports/{id}',              [ReportController::class, 'destroy'])       ->name('reports.destroy')    ->can('report');;

Route::get('support_map',                    [SupportMapController::class, 'index'])     ->name('support_map.index')        ->can('support_map');
Route::post('support_map',                   [SupportMapController::class, 'store'])     ->name('support_map.store')        ->can('support_map');
Route::get('support_map/{support_map}/edit', [SupportMapController::class, 'edit'])      ->name('support_map.edit')         ->can('support_map');
Route::patch('support_map/{support_map}',      [SupportMapController::class, 'update'])    ->name('support_map.update')       ->can('support_map');
Route::delete('support_map/{support_map}',   [SupportMapController::class, 'destroy'])   ->name('support_map.destroy')      ->can('support_map');
