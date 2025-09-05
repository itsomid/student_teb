<!DOCTYPE html>

<html
    lang="en"
    class="light-style customizer-hide"
    dir="rtl"
    data-theme="theme-default"
    data-template="horizontal-menu-template">
<head>
    <meta charset="utf-8" />
    <meta name="viewport"  content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>
        @yield('title')
        |  درسینو
    </title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../assets/img/favicon/favicon.ico" />
    @vite(['resources/assets/scss/admin/auth.scss'])
</head>
<body>
<!-- Content -->

<div class="container-xxl">
    <div class="authentication-wrapper authentication-basic ">
        <div class="authentication-inner">
            <!-- Login -->
                @yield('content')
            <!-- /Register -->
        </div>
    </div>
</div>
<!-- / Content -->

<!-- Core JS -->
@vite(['resources/assets/js/main.js'])

@vite(['resources/js/app.js'])
</body>
</html>
