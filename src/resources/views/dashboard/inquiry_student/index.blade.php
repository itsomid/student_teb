@extends('dashboard.layout.master')
@section('title', 'مدیریت کدهای معرف')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">استعلام دانش آموز</h5>
                    <form action="{{route('admin.inquiry.submit')}}" class="row mt-3 d-flex align-items-end justify-content-between" method="post">
                        @csrf
                        <div class="col-md-4 user_role">
                            <label class="form-label" for="UserRole">شماره موبایل یا ایدی دانش آموز: :</label>
                            <input type="number" name="mobile" class="form-control" placeholder="شماره موبایل یا ایدی دانش آموز">
                        </div>
                        <div class="col-md-2 mt-2">
                            <button type="submit" class="btn btn-primary mt-2">
                                <span class="mx-2">جستجو</span>
                                <i class="fa-regular fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @isset($student)
        <div class="row">
            <div class="col-xl-5 col-lg-5 col-md-5 order-1 order-md-0">
                <!-- User Card -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">
                                <img class="img-fluid rounded mb-3 pt-1 mt-4"
                                     src="{{auth()->user()->avatar()}}"
                                     height="100"
                                     width="100"
                                     alt="User avatar"/>
                                <div class="user-info text-center">
                                    <h4 class="mb-2">{{$student->name}}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="info-container">
                            <ul class="list-unstyled">
                                <p class="mt-4 small text-uppercase text-muted">وضعیت کلی پنل دانش آموز:</p>
                                <li class="mb-2 d-flex  text-center">
                                    <h6 class="bg-success rounded p-1 text-white">
                                        دسترسی باز است (حالات بدهکاری مالی یا بلاکی از جلسات کلاس در نظر گرفته نشده است)
                                    </h6>
                                </li>
                                <hr>
                                <p class="mt-4 small text-uppercase text-muted">جزئیات</p>
                                <li class="mb-2 d-flex justify-content-between">
                                    <span class="fw-semibold me-1">ایدی کاربر:</span>
                                    <span>{{$student->id}}</span>
                                </li>
                                <li class="mb-2 d-flex justify-content-between">
                                    <span class="fw-semibold me-1">ایمیل:</span>
                                    <span>{{$student->email}}</span>
                                </li>
                                <li class="mb-2 pt-1  d-flex justify-content-between">
                                    <span class="fw-semibold me-1">شماره تماس:</span>
                                    <span>{{$student->mobile}}</span>
                                </li>
                                <li class="mb-2 pt-1  d-flex justify-content-between">
                                    <span class="fw-semibold me-1">اعتبار:</span>
                                    <span>۱۲۶,۰۰۰ تومان</span>
                                </li>
                                <li class="mb-2 pt-1  d-flex justify-content-between">
                                    <span class="fw-semibold me-1">تاریخ ایجاد حساب:</span>
                                    <span>
                                     {{$student->created_at()}}
                                </span>
                                </li>
                                <li class="mb-2 pt-1  d-flex justify-content-between">
                                    <span class="fw-semibold me-1">وضعیت:</span>
                                    <span class="badge bg-label-{{auth()->user()->status(true)}}">
                                    {{auth()->user()->status()}}
                                </span>
                                </li>

                                <hr>
                                <p class="mt-4 small text-uppercase text-muted">اطلاعات پشتیبان</p>
                                <li class="mb-2 pt-1  d-flex justify-content-between">
                                    <span class="fw-semibold me-1">پشتیبان:</span>
                                    <span> رمضان علی</span>
                                </li>
                                <li class="mb-2 pt-1  d-flex justify-content-between">
                                    <span class="fw-semibold me-1">شماره تماس پشتیبان:</span>
                                    <span>09056723950</span>
                                </li>
                                <hr>
                                <p class="mt-4 small text-uppercase text-muted">عملیات</p>
                                <li class="mb-2 pt-1 d-flex justify-content-center">
                                    <button type="button" class="btn btn-success mx-1">
                                        <span class="mx-1">ورود به castle</span>
                                        <i class="fa-sharp fa-solid fa-castle"></i>
                                    </button>
                                    <button type="button" class="btn btn-warning mx-1">
                                        <span class="mx-1">همگام سازی</span>
                                        <i class="fa-solid fa-arrows-rotate"></i>
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- /User Card -->
            </div>
            <div class="col-xl-7 col-lg-7 col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="card-title">
                            <h6>درس های خریداری شده دانش آموز</h6>
                            <p class="small text-uppercase text-muted">
                                تعداد درس های خریداری شده: <strong class="text-dark">2</strong>
                            </p>
                        </div>
                        <div class="user-products-inquiry-section">
                            <img  src="https://cdn2.com/uploads/images/shop/1685361606880.png" width="100" height="100" alt="عکس دوره">
                            <div>
                                <span>نام محصول : <strong>نام محصول</strong></span>
                                <span>آیدی درس : <strong>۱۲۱۲۱#</strong></span>
                            </div>
                        </div>
                        <hr>
                        <div class="user-products-inquiry-section">
                            <img  src="https://cdn2.com/uploads/images/shop/1685361606880.png" width="100" height="100" alt="عکس دوره">
                            <div>
                                <span>نام محصول : <strong>نام محصول</strong></span>
                                <span>آیدی درس : <strong>۱۲۱۲۱#</strong></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

@endsection
