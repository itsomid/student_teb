@extends('dashboard.layout.master')
@section('title', 'مدیریت آزمون های دوره')
@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="card-title header-elements">
                    <h5 class="m-0 me-2">آزمون های کلاس [نام دوره]</h5>
                    <div class="card-title-elements ms-auto">
                        <a href="" class="btn btn-primary">
                            <i class="fa fa-plus mx-2"></i>
                            افزودن آزمون جدید
                        </a>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>نام</th>
                            <th>جمع نمره</th>
                            <th>محدودیت زمانی (ثانیه)</th>
                            <th>قابل شرکت مجدد</th>
                            <th>سوالات</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @for($i = 0; $i <= 10; $i++)
                            <tr>
                                <td>
                                    1
                                </td>
                                <td>
                                    جلسه اول
                                </td>

                                <td>
                                    8taei
                                </td>
                                <td>
                                    ۱۵ شهریور
                                </td>
                                <td>
                                    ۱۵ شهریور
                                </td>
                                <td>
                                    <a href="" class="btn btn-primary btn-block btn-sm">
                                        <i class="fa-sharp fa-solid fa-question mx-1"></i>
                                        سوالات
                                    </a>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"  href="">
                                                <i class="fa-regular fa-pen mx-1"></i>
                                                ویرایش آزمون
                                            </a>
                                            <a class="dropdown-item" href="">
                                                <i class="fa-regular fa-eye mx-1"></i>
                                                مشاهده آزمون
                                            </a>
                                            <a class="dropdown-item" href="">
                                                <i class="fa-regular fa-trash mx-1"></i>
                                               حذف آزمون
                                            </a>
                                            <button class="dropdown-item"  type="button" data-bs-toggle="modal" data-bs-target="#exampleModal_{{$i}}" data-bs-whatever="@mdo">
                                                <i class="fa-regular fa-trash mx-1"></i>
                                                حذف آزمون
                                            </button>
                                            <a class="dropdown-item" href="">
                                                <i class="fa-regular fa-check mx-1"></i>
                                                تصحیح پاسخنامه ها
                                            </a>

                                            <a class="dropdown-item" href="">
                                                <i class="fa-regular fa-copy mx-1"></i>
                                                duplicate
                                            </a>
                                        </div>
                                        <div class="modal fade" id="exampleModal_{{$i}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-top">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">تایید حذف آزمون</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        آیا از حذف این آزمون مطمئن هستید؟
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">بستن</button>
{{--                                                        <form action="{{route('admin.coupons.destroy', ['coupon' => $coupon->id])}}" method="post">--}}
{{--                                                            @csrf--}}
{{--                                                            @method('DELETE')--}}
                                                            <button type="submit" class="btn btn-danger text-white" data-bs-dismiss="modal">بله</button>
{{--                                                        </form>--}}
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
@endsection
