@extends('dashboard.layout.master')
@section('title', 'مدیریت دوره ها')
@section('content')
    <div class="row">
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">جست و جو</h5>
                <form class="row mt-3 d-flex align-items-end justify-content-between"
                      action="{{route('admin.course.index')}}"
                      method="get">
                    <div class="col-md-10 user_role">
                        <label class="form-label" for="key">نام دوره</label>
                        <input type="text" class="form-control" name="name"  placeholder="نام دوره را وارد کنید" value="{{ request('name') }}">
                    </div>
                    <div class="col-md-2 mt-2 text-center">
                        <button class="btn btn-success">
                            <i class="fa-solid fa-magnifying-glass mx-2"></i>
                            جست و جو
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="card-title header-elements">
                    <h5 class="m-0 me-2">لیست انواع محصولات</h5>
                    @can('admin.create')
                        <div class="card-title-elements ms-auto">
                            <a href="{{route('admin.course.create')}}" class="btn btn-primary">
                                <i class="fa fa-plus mx-2"></i>
                                افزودن دوره جدید
                            </a>
                        </div>
                    @endcan
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>نام</th>
                            <th>ساعات برگزاری</th>
                            <th>تاریخ شروع</th>
                            <th>آمار کلاس</th>
                            <th>مدیریت کلاس ها</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach($courses as $course)
                            <tr>
                                <td>
                                    <p title="{{$course->about_course}}">
                                        {{$course->product->name}}
                                    </p>
                                </td>
                                <td>
                                    @foreach($course->holding_days() as $day)
                                        {{$day}}
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($course->holding_time() as $time)
                                        {{$time}}
                                    @endforeach
                                </td>
                                <td>
                                    <a href="" class="btn btn-sm btn-primary">آمار کلاس</a>
                                    <a href="" class="btn btn-sm btn-warning">آمار آزمون</a>
                                </td>
                                <td >
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="fa-solid fa-screen-users"></i>
                                        </button>
                                        <div class="dropdown-menu custom">
                                            <a class="dropdown-item btn btn-sm btn-danger  text-white"  href="">
                                                کلاس های آینده در یک نگاه
                                            </a>
                                            <a class="dropdown-item btn btn-sm btn-success"  href="{{route('admin.classes.index', ['course' => $course->id])}}">
                                                مدیریت جلسات کلاس
                                            </a>
                                            <a class="dropdown-item btn btn-sm btn-success"  href="">
                                                مدیریت آزمون ها
                                            </a>
                                            <a class="dropdown-item btn btn-sm btn-primary"  href="">
                                                آمار حضور غیاب
                                            </a>
                                            <a class="dropdown-item btn btn-sm btn-primary"  href="">
                                                نمرات کوییز در یک نگاه
                                            </a>
                                        </div>
                                    </div>
                                </td>
                                <td >
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            @can('course.edit')
                                                <a class="dropdown-item"  href="{{route('admin.course.edit', ['course' => $course->id])}}">
                                                    <i class="fa-regular fa-pen mx-1"></i>
                                                    ویرایش دوره
                                                </a>
                                            @endcan

                                            <a class="dropdown-item" href="">
                                                <i class="fa-regular fa-eye mx-1"></i>
                                                مشاهده دوره
                                            </a>
                                            <a class="dropdown-item" href="">
                                                <i class="fa-regular fa-copy mx-1"></i>
                                                duplicate
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
