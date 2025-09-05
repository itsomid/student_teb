@extends('dashboard.layout.master')
@section('title', 'مدیریت دانشجوان')
@section('content')
    <div class="row g-4 mb-4">
        <div class="col-sm-12 col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>مجموع بدهی دانشجوان</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">171,068,362 ریال</h4>
                            </div>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="fa-solid fa-users"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>تعداد نفراتی که دوره کامل ثبت نام کرده اند</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">6</h4>
                            </div>
                        </div>
                        <span class="badge bg-label-success rounded p-2">
                            <i class="fa-solid fa-user-check"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-title header-elements">
                        <h5 class="m-0 me-2">نمودار تعداد فروش</h5>
                    </div>
                    <div class="mb-5 card">
                        <div class="card-body user-course-buy-count">
                            <span>1 دوره : 1 نفر</span>
                            <span>4 دوره : 1 نفر</span>
                            <span>5 دوره : 1 نفر</span>
                            <span>8 دوره : 1 نفر</span>
                            <span>13 دوره : 6 نفر</span>
                        </div>
                    </div>
                    <installment-chart></installment-chart>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-title header-elements">
                        <h5 class="m-0 me-2">کاربرانی که بدهکار شده اند</h5>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>شماره موبایل</th>
                                <th>نام(فارسی)</th>
                                <th>اعتبار</th>
                                <th>پشتیبان فروش</th>
                                <th>تراکنش ها</th>
                                <th>عملیات</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                                @for($i = 0; $i <= 10; $i++)
                                <tr>
                                    <td>
                                        1159
                                    </td>
                                    <td>
                                        09102773857
                                    </td>
                                    <td>
                                        محمد عرب
                                    </td>
                                    <td>
                                        -4,360,800 ریال
                                    </td>

                                    <td>
                                        پردیس سخی پور
                                    </td>
                                    <td>
                                        <a class="btn btn-success btn-sm" href="#">
                                            لیست تراکنش ها
                                        </a>
                                    </td>
                                    <td>
                                        <div class="dropdown mx-3">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                   href="#">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                    ویرایش
                                                </a>
                                                <button class="dropdown-item" href="#" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal_{{$i}}" data-bs-whatever="@mdo">
                                                    <i class="fa-solid fa-calculator"></i>
                                                    ماشین حساب
                                                </button>
                                            </div>
                                            <div class="modal fade" id="exampleModal_{{$i}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-top">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">مشاهده میزان بدهکاری محاسبه شده</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            اعتبار دانشجو x برابر با y میباشد
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">بستن</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="card-title header-elements">
                        <h5 class="m-0 me-2">قسط های یک هفته آینده</h5>
                    </div>
                    <div class="table-responsive text-nowrap">
                        <table class="table">
                            <thead>

                            <tr>
                                <th>کاربر</th>
                                <th>پشتیبان</th>
                                <th>مقدار</th>
                                <th>تاریخ سر رسید</th>
                            </tr>
                            </thead>
                            <tbody class="table-border-bottom-0">
                            @for($i = 0; $i <= 10; $i++)
                                <tr>
                                    <td>
                                        1159
                                    </td>
                                    <td>
                                        محمد عرب
                                    </td>
                                    <td>
                                        12
                                    </td>
                                    <td>
                                        17 شهریور
                                    </td>
                                </tr>
                            @endfor
                            <tr>
                                <td>
                                    <h6 class="m-0"> مجموع:۱۲۱۳۱
                                    </h6>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
