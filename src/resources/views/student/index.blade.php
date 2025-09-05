<!doctype html>
<html lang="en" data-bs-theme="auto">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="آموزشگاه آنلاین شفا‌آموز">
    <meta name="generator" content="">
    <title>شفا‌آموز | پنل کاربری</title>
    @vite(['resources/assets/scss/student/app.scss'])
</head>
<body>
<header class="side-nav-open show-backdrop">
    <nav class="w-100">
        <div id="navbar" class="d-flex justify-content-between container">
            <i class="fa-solid fa-bars"></i>
            <a id="header-navbar-logo" href="/">
                <img alt="شفا‌آموز" class="img-fluid" width="120">
            </a>
            <div class="left-section d-flex align-items-center">

                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                    <div class="navbar-avatar">
                        <i class="fa-light fa-user-graduate ms-2"></i>
                        <span class="arrow">
                          <i class="fa-regular fa-angle-down"></i>
                        </span>

                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="d-flex">
                                <div class="menu-avatar ms-4">
                                    <i class="fa-sharp fa-solid fa-user-graduate"></i>
                                </div>
                                <div class="flex-grow-1 text-end">
                                    <span class="fw-semibold d-block">{{auth()->user()->name}}</span>
                                    <small class="text-muted">{{auth()->user()->mobile}}</small>
                                </div>
                            </div>
                        </a>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex justify-content-start" href="">
                            <i class="fal fa-user ms-2"></i>
                            <span class="align-middle">پروفایل</span>

                        </a>
                    </li>
                    <li>
                        <a href="{{route('student.auth.logout')}}" class="dropdown-item d-flex justify-content-start">
                            <i class="far fa-sign-out ms-2"></i>
                            <span class="align-middle">خروج از سیستم</span>

                        </a>
                    </li>
                </ul>

            </div>
        </div>
    </nav>
</header>

</body>
</html>
