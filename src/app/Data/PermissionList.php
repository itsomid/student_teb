<?php
namespace App\Data;

class PermissionList {
    const PREFIX= "";
    public static function get() : array
    {
        $permissions= [
            ['admin.index'                           ,'مشاهده لیست پرسنل'],
            ['admin.index.statistic_boxes'           ,'مشاهده باکس آمار در لیست پرسنل'],
            ['admin.index.table.mobile'              ,'مشاهده  ستون شماره تماس ها در لیست پرسنل'],
            ['admin.index.table.email'               ,'مشاهده  ستون آدرس ایمیل ها در لیست پرسنل'],
            ['admin.index.table.supervisor'          ,'مشاهده  ستون سرپرست ها در لیست پرسنل'],
            ['admin.create'                          ,'افزودن پرسنل جدید'],
            ['admin.edit'                            ,'ویرایش پرسنل'],
            ['admin.toggle'                          ,'مسدودسازی پرسنل'],
            ['admin.manage-all-sales-support'        ,'مشاهده تمام پشتیبانان فروش'],
            ['admin.login_as_admin'                  ,'ورود به عنوان ادمین'],
            ['admin.inquiry'                         ,'استعلام شماره تماس'],

            ['supports.allocation-rate-management'   ,'نرخ تخصیص دانش آموز به پشتیبان'],

            ['role.admin.edit'                       ,'ویرایش نقش پرسنل'],
            ['role.index'                            ,'لیست نقش ها'],
            ['role.create'                           ,'افزودن نقش'],
            ['role.edit'                             ,'ویرایش نقش'],
            ['role.destroy'                          ,'حذف نقش'],
            ['permission.index'                      ,'مشاهده لیست مجوز ها'],
            ['permission.edit'                       ,'ویرایش مجوز'],

            ['order.index'                          ,'مشاهده لیست سفارش ها'],

            ['transaction.index'                    ,'مشاهده لیست تراکنش ها'],


            ['session.index'                        ,'مشاهده نشست های فعال'],
            ['session.destroy'                      ,'حذف نشست های فعال'],

            ['student.index'                        ,'مشاهده صفحه لیست دانش آموزان'],
            ['student.manage-all-user'              ,'مشاهده تمام دانش آموزان'],
            ['student.create'                       ,'افزودن دانش آموز جدید'],
            ['student.edit'                         ,'ویرایش دانش آموز'],
            ['student.edit-note'                    ,'ویرایش یادداشت دانش آموز'],
            ['student.edit-support'                 ,'ویرایش پشتیبان دانش آموز'],
            ['student.verify'                       ,'تایید شماره دانش آموز'],
            ['student.support.history'              ,'مشاهده تاریخچه ی تغییر پشتیبان دانش آموزان'],
            ['student.excel'                        ,'دانلود خروجی اکسل از لیست دانش آموزان'],
            ['student.group-register'               ,'ثبت نام گروهی دانش آموز'],

            ['referral_code.index'                  ,'مشاهده کد های معرف'],
            ['referral_code.create'                 ,'افزودن کد معرف'],
            ['referral_code.edit'                   ,'ویرایش کد معرف'],

            ['card-transaction.index'                     ,'مشاهده لیست کارت به کارت ها'],
            ['card-transaction.index.access-all'          ,'مشاهده ی لیست همه ی کارت به کارت ها'],
            ['card-transaction.create'                    ,'افزودن کارت به کارت'],
            ['card-transaction.edit'                      ,'ویرایش کارت به کارت'],
            ['card-transaction.delete'                    ,'حذف کارت به کارت'],

            ['product_type.index'                   ,'مشاهده لیست ماهیت محصولات'],
            ['product_type.create'                  ,'افزودن ماهیت محصولات'],
            ['product_type.edit'                    ,'ویرایش ماهیت محصولات'],

            //Custom Package Permission Lists
            ['custom-package.index'                 ,'مشاهده لیست پکیج های سفارشی'],
            ['custom-package.create'                ,'افزودن پکیج سفارشی'],
            ['custom-package.edit'                  ,'ویرایش پکیج سفارشی'],

            ['course.index'                         ,'مشاهده لیست دوره ها'],
            ['course.create'                        ,'افزودن دوره جدید'],
            ['course.edit'                          ,'ویرایش دوره'],

            ['classes.index'                        ,'مشاهده لیست کلاس ها'],
            ['classes.create'                       ,'افزودن کلاس جدید'],
            ['classes.edit'                         ,'ویرایش کلاس'],

            ['cc_servers'                           ,'سرورهای درسینو کانکت'],
            ['commission'                           ,'پورسانت تیم فروش'],
            ['sales_report_by_category'             ,'آمار فروش بر اساس دسته بندی'],


            ['class-block.index'                        ,'مشاهده لیست کاربران بلاک شده از کلاس'],
            ['class-block.create'                       ,'بلاک کاربر از کلاس'],
            ['class-block.edit'                         ,'ویرایش کلاس'],

            ['product_category.index'               ,'مشاهده دسته بندی محصولات'],
            ['product_category.create'              ,'افزودن دسته بندی محصولات جدید'],
            ['product_category.edit'                ,'ویرایش دسته بندی محصولات'],
            ['product_category.delete'              ,'حذف دسته بندی محصولات'],

            ['report'                               ,'مدیریت کارنامه ها'],
            ['homework'                             ,'مدیریت تکالیف'],

            ['support_map'                          ,'پایه بندی پشتیبان ها'],
            ['schedule-weekly.index'                ,'مشاهده برنامه هفتگی'],

            ['coupons.index'                        ,'مشاهده لیست کدهای تخفیف'],
            ['coupons.excel'                        ,'دانلود خروجی اکسل از کدهای تخفیف'],
            ['coupons.create'                       ,'افزودن کدهای تخفیف'],
            ['coupons.set.condition'                ,'دسترسی به شرایط کد تخفیف'],
            ['coupons.edit'                         ,'ویرایش کدهای تخفیف'],
            ['coupons.destroy'                      ,'حذف کد تخفیف'],
            ['coupons.range.edit'                   ,'ویرایش بازه ی ایجاد کد تخفیف'],
            ['coupons.all-data'                     ,'مشاهده تمام اطلاعات کد تخفیف'],

            ['setting.int.index'                    ,'مشاهده تنظیمات داخلی'],
            ['setting.int.view-logs'                ,'مشاهده لاگ ها و خطاهای سیستم'],
            ['setting.ext.index'                    ,'مشاهده تنظیمات خارجی'],

            ['report.registered_users'              ,'آمار ثبت نام نماینده های فروش'],

            ['random-students-distribution'         ,'پخش تصادفی دانش‌آموزها'],
            ['selective-students-distribution'      ,'پخش انتخابی دانش‌آموزها'],

            ['student-account.charge'               ,'افزایش اعتبار دانش آموز'],
            ['installment.index'                    ,'مشاهده اقساط'],

        ];

        $permissions = array_map(fn($permission) => [$permission[0] , $permission[1]] , $permissions);
        return  $permissions;
    }
}
