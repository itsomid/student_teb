<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="" class="app-brand-link layout-menu-toggle" draggable="false">
            <img  src="{{asset('assets/images/logos/logo_sec_horiz.png')}}" class="img-fluid w-50" >
        </a>
        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            {{--            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>--}}
            <i class="fa-solid fa-scrubber d-none d-xl-block align-middle "></i>
            {{--            <i class="fa-solid fa-scrubber"></i>--}}
            <i class="fa-light fa-xmark d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item @if(request()->is('admin')) active @endif">
            <a href="{{route('admin.dashboard')}}" class="menu-link">
                {{--                    <i class=" tf-icons ti ti-users"></i>--}}
                <i class="menu-icon  fa-regular fa-chart-pie-simple fa-sm"></i>
                <div data-i18n="Page 1">داشبورد</div>
            </a>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">افراد و دپارتمان ها</span>
        </li>
        @can('admin.index')
            <li class="menu-item @if(request()->is('admin/admin*')) active @endif">
                <a href="{{route('admin.admin.index')}}" class="menu-link">
                    {{--                    <i class=" tf-icons ti ti-users"></i>--}}
                    <i class="menu-icon fa-light fa-user fa-sm"></i>
                    <div data-i18n="Page 1">مدیریت همکاران</div>
                </a>
            </li>
        @endcan
        <li class="menu-item @if(request()->is(['student-account*'])) active open @endif">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon fa-light fa-money-check-dollar-pen fa-sm"></i>
                <div>مدیریت تراکنش ها</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item @if(request()->is('student-account/charge*')) active @endif">
                    <a href="{{route('admin.student-account.charge-form')}}" class="menu-link">
                        <i class="menu-icon fa-light fa-user-group fa-sm"></i>
                        <div data-i18n="Page 1">افزایش اعتبار</div>
                    </a>
                </li>
            </ul>
        </li>

        @can('student.index')
            <li class="menu-item @if(request()->is('admin/students*')) active @endif">
                <a href="{{route('admin.student.index')}}" class="menu-link">
                    <i class="menu-icon fa-light fa-screen-users fa-sm"></i>
                    <div data-i18n="Page 1">مدیریت دانش آموزان</div>
                </a>
            </li>
        @endcan
        @can('student.index')
            <li class="menu-item @if(request()->is('admin/inquiry*')) active @endif">
                <a href="{{route('admin.inquiry.index')}}" class="menu-link">
                    <i class="menu-icon fa-light fa-screen-users fa-sm"></i>
                    <div data-i18n="Page 1">استعلام شماره تماس</div>
                </a>
            </li>
        @endcan
        @can('student.support.history')
            <li class="menu-item @if(request()->is('admin/user_support*')) active @endif">
                <a href="{{route('admin.user_support.get')}}" class="menu-link">
                    <i class="menu-icon fa-light fa-history fa-sm"></i>
                    <div data-i18n="Page 1">تاریخچه تغییر پشتیبانان</div>
                </a>
            </li>
        @endcan
        @can('referral_code.index')
            <li class="menu-item @if(request()->is('admin/referral-codes*')) active @endif">
                <a href="{{route('admin.referral_code.index')}}" class="menu-link">
                    <i class="menu-icon fa-regular fa-user-tag fa-sm"></i>
                    <div data-i18n="Page 1">کدهای معرف</div>
                </a>
            </li>
        @endcan
        @can('product_type.index')
            <li class="menu-item @if(request()->is(['admin/roles*','admin/permissions*'])) active open @endif">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon fa-light fa-user-group fa-sm"></i>
                    <div>نقش ها و مجوزها</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item @if(request()->is('admin/roles*')) active @endif">
                        <a href="{{route('admin.role.index')}}" class="menu-link">
                            <i class="menu-icon fa-light fa-user-group fa-sm"></i>
                            <div data-i18n="Page 1"> نقش ها</div>
                        </a>
                    </li>
                    <li class="menu-item @if(request()->is('admin/permissions*')) active @endif">
                        <a href="{{route('admin.permission.index')}}" class="menu-link">
                            <i class="menu-icon fa-light fa-key fa-sm"></i>
                            <div data-i18n="Page 1"> مجوزها</div>
                        </a>
                    </li>
                </ul>

            </li>
        @endcan

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">بخش مدیریت فروش</span>
        </li>
        @can('report.registered_users')
        <li class="menu-item @if(request()->is('admin/report/registered_users*')) active @endif">
            <a href="{{route('admin.report.registered_users')}}" class="menu-link">

                <i class="menu-icon fa-solid fa-user-group fa-sm"></i>
                <div data-i18n="Page 1">گزارش ثبت نامی ها</div>
            </a>
        </li>
        @endcan
        @can('supports.allocation-rate-management')
            <li class="menu-item @if(request()->is('admin/supports_allocation_rate*')) active @endif">
                <a href="{{route('admin.supports-allocation-rate.edit')}}" class="menu-link">
                    <i class="menu-icon fa-regular fa-split"></i>
                    <div>ضریب هر پشتیبان</div>
                </a>
            </li>
        @endcan
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text"> مالی و خرید ها</span>
        </li>
        @can('debit-card.index')
            <li class="menu-item @if(request()->is('admin/debit-cards*')) active @endif">
                <a href="{{route('admin.debit-card.index')}}" class="menu-link">
                    <i class="menu-icon fa-regular fa-money-bill fa-sm"></i>
                    <div data-i18n="Page 1">مدیریت کارت به کارت ها</div>
                </a>
            </li>
        @endcan
        @can('debit-card.index')
            <li class="menu-item @if(request()->is('admin/coupons*')) active @endif">
                <a href="{{route('admin.coupons.index')}}" class="menu-link">
                    <i class="menu-icon fa-regular fa-percentage fa-sm"></i>
                    <div data-i18n="Page 1">کدهای تخفیف</div>
                </a>
            </li>
        @endcan
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">محصولات و کلاس ها</span>
        </li>
        @can('product_type.index')
            <li class="menu-item @if(request()->is('admin/product_types*')) active @endif">
                <a href="{{route('admin.product_type.index')}}" class="menu-link">
                    <i class="menu-icon fa-light fa-user-group fa-sm"></i>
                    <div data-i18n="Page 1">ماهیت محصولات</div>
                </a>
            </li>
        @endcan
        @can('product_category.index')
            <li class="menu-item @if(request()->is('admin/product_categories*')) active @endif">
                <a href="{{route('admin.product_category.index')}}" class="menu-link">
                    <i class="menu-icon fa-light fa-user-group fa-sm"></i>
                    <div data-i18n="Page 1">دسته بندی محصولات</div>
                </a>
            </li>
        @endcan
        @can('product_type.index')
            <li class="menu-item @if(request()->is('admin/courses*')) active open @endif">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon fa-light fa-user-group fa-sm"></i>
                    <div>مدیریت محصولات</div>
                </a>
                <ul class="menu-sub">
                    @can('course.index')
                        <li class="menu-item @if(request()->is('admin/courses*')) active @endif">
                            <a href="{{route('admin.course.index')}}" class="menu-link">
                                <i class="menu-icon fa-light fa-book fa-sm"></i>
                                <div data-i18n="Page 1"> مدیریت دوره ها</div>
                            </a>
                        </li>
                    @endcan
                        @can('custom-package.index')
                            <li class="menu-item @if(request()->is('admin/custom-package*')) active @endif">
                                <a href="{{route('admin.custom-package.index')}}" class="menu-link">
                                    <i class="menu-icon fa-light fa-book fa-sm"></i>
                                    <div data-i18n="Page 1"> مدیریت پکیج سفارشی</div>
                                </a>
                            </li>
                        @endcan
                </ul>
            </li>
        @endcan

        @canany(['setting.int.index', 'setting.ext.index'])
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">مدیریت سیستم</span>
            </li>
            <li class="menu-item @if(request()->is('admin/setting*')) active @endif">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon fa-light fa-cog fa-sm"></i>
                    <div> پیکربندی سیستم</div>
                </a>
                <ul class="menu-sub">
                    @can('setting.int.index')
                        <li class="menu-item">
                            <a href="{{route('admin.internal.setting.index')}}" class="menu-link">
                                <div>تنظیمات داخلی</div>
                            </a>
                        </li>
                    @endcan
                    @can('setting.ext.index')
                        <li class="menu-item">
                            <a href="{{route('admin.external-setting.index')}}" class="menu-link">
                                <div>تنظیمات خارجی</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            <li class="menu-item @if(request()->route()->getName() == 'telescope') active @endif">
                <a href="{{route('telescope')}}" class="menu-link">
                    <i class="menu-icon fa-sharp fa-light fa-telescope fa-sm"></i>
                    <div data-i18n="Page 1"> تلسکوپ</div>
                </a>
            </li>

            <li class="menu-item @if(request()->is('/pulse*')) active @endif">
                <a href="{{url('./pulse')}}" class="menu-link">
                    <i class="menu-icon fa-sharp fa-light  fa-monitor-heart-rate fa-sm"></i>
                    <div data-i18n="Page 1"> Pulse</div>
                </a>
            </li>

            <li class="menu-item @if(request()->is('/log-viewer*')) active @endif">
                <a href="{{url('./log-viewer')}}" class="menu-link">
                    <i class="menu-icon fa-sharp fa-light  fa-monitor-heart-rate fa-sm"></i>
                    <div data-i18n="Page 1"> Logs and Errors</div>
                </a>
            </li>
        @endcan


    </ul>
</aside>
