@extends('dashboard.layout.master')
@section('title', 'مدیریت کد تخفیف')
@section('content')
    <div class="row mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        @can('coupons.excel')
                            <a href="{{route('admin.coupons.excel')}}" class="btn btn-success col-md-2">
                                خروجی اکسل
                                <i class="fa-solid fa-arrow-down-to-line mx-2"></i>
                            </a>
                        @endcan

                        <a href="" class="btn btn-primary col-md-2">
                            ماشین حساب
                            <i class="fa-solid fa-calculator mx-2"></i>
                        </a>
                        @can('coupons.range.edit')
                            <a href="{{route('admin.coupons.range.edit')}}" class="btn btn-warning col-md-2">
                            بازه تخفیف
                            <i class="fa-solid fa-calendar-days mx-2"></i>
                        </a>
                        @endcan
                        <a href="" class="btn btn-primary col-md-2">
                            تمدید جمعی
                            <i class="fa-solid fa-arrows-rotate mx-2"></i>
                        </a>
                        <a href="" class="btn btn-success col-md-2">
                            گزارش تخفیف
                            <i class="fa-solid fa-file-chart-pie mx-2"></i>
                        </a>
                    </div>
                </div>
            </div>
    </div>

    <div class="row">
        <div class="card">
            <div class="card-body border-bottom">
                <h5 class="card-title">فیلتر کد تخفیف</h5>
                <form class="row" action="{{route('admin.coupons.index')}}" method="get">
                    <div class="col-md-4 user_role">
                        <label class="form-label" for="UserRole">کد تخفیف :</label>
                        <input type="text" name="coupon" class="form-control" placeholder="کد تخفیف را وارد کنید" value="{{request()->input('coupon')}}">
                        @error('coupon') <small class="text-danger">{{$message}}</small> @enderror
                    </div>
                    <div class="col-md-4 user_role">
                        <label class="form-label" for="creator_user_id">:ID سازنده ی کد تخفیف</label>
                        <input type="text" id="creator_user_id" name="creator_user_id" class="form-control"  placeholder="ID را وارد کنید" value="{{request()->input('creator_user_id')}}">
                        @error('creator_user_id') <small class="text-danger">{{$message}}</small> @enderror
                    </div>
                    <div class="col-md-4 user_role">
                        <label class="form-label" for="UserRole">شماره موبایل کاربر :</label>
                        <dynamic-select
                            url="{{route('api.student.index')}}"
                            label="اننتخاب دانش آموز"
                            input_name="user_id"
                            default_selected="{{request()->input('user_id' , null)}}"
                            option_title="name"
                            option_value="id"
                        ></dynamic-select>
                        @error('user_id') <small class="text-danger">{{$message}}</small> @enderror
                    </div>
                    <div class="col-md-4 user_role">
                        <label class="form-label" for="discount_percentage">درصد تخفیف :</label>
                        <input type="text" id="discount_percentage" name="discount_percentage" class="form-control"  placeholder="درصد تخفیف را وارد کنید" value="{{request()->input('discount_percentage')}}">
                        @error('discount_percentage') <small class="text-danger">{{$message}}</small> @enderror
                    </div>
                    <div class="col-md-4 user_role">
                        <label class="form-label" for="description">توضیحات :</label>
                        <input type="text" name="description" id="description" class="form-control"  placeholder="توضیحات را وارد کنید" value="{{request()->input('description')}}">
                        @error('description') <small class="text-danger">{{$message}}</small> @enderror
                    </div>
                    <div class="col-md-12">
                        <button type="submit" name="action" value="search" class="btn btn-primary mt-2 text-white">
                            <span class="mx-2">جستجو</span>
                            <i class="fa-regular fa-search"></i>
                        </button>

                        @can('coupons.excel')
                            <button type="submit" name="action" value="excel" class="btn btn-success mt-2 mx-2 text-white">
                                دانلود اکسل با اعمال فیلتر
                                <i class="fa-solid fa-file-excel mx-2"></i>
                            </button>
                        @endcan

                        @if(request()->hasAny(['coupon', 'creator_user_id', 'user_id', 'discount_percentage', 'description']))
                            <a class="btn btn-danger mt-2 text-white float-end" href="{{route('admin.coupons.index')}}">
                                <span class="mx-2">حذف فیلتر ها</span>
                                <i class="fa-regular fa-remove"></i>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="card-title header-elements">
                    <h5 class="m-0 me-2">لیست کد تخفیف</h5>
                    <div class="card-title-elements ms-auto">
                        @can('coupons.create')
                            <a href="{{route('admin.coupons.create')}}" class="btn btn-primary">
                                <i class="fa fa-plus mx-2"></i>
                                افزودن کد تخفیف
                            </a>
                        @endcan
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>کد تخفیف</th>
                            <th>موبایل کاربر</th>
                            <th>سازنده کد</th>
                            <th>تعداد استفاده</th>
                            <th class="text-center">توضیحات</th>
                            <th>درصد تخفیف/مبلغ تخفیف</th>
                            <th>زمان انقضا</th>
                            <th>مبلغ استفاده شده کد تخفیف:</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach($coupons as $coupon)
                                <tr>
                                    <td>
                                        {{$coupon->id}}
                                    </td>

                                    <td>
                                        {{$coupon->coupon}}
                                    </td>
                                    <td>
                                        {{$coupon->creator_user->mobile}}
                                    </td>
                                    <td>
                                        {{$coupon->creator_user->name}}
                                    </td>
                                    <td>
                                       {{$coupon->number_of_use}}
                                    </td>
                                    <td class="text-center">
                                        {{$coupon->description}}
                                    </td>
                                    <td class="text-center">
                                        {{$coupon->discount_percentage}}
                                        %
                                        /
                                        {{$coupon->discount_amount}}
                                        0 ریال
                                    </td>
                                    <td class="text-center">
                                        {{$coupon->expired_at}}
                                    </td>
                                    <td class="text-center">
                                        ۱۲۰۰۰۰
                                    </td>
                                    <td class="d-flex align-items-center">
                                        <div class="dropdown mx-3">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                   href="{{route('admin.coupons.edit' , ['coupon' => $coupon->id])}}">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                    ویرایش کد تخفیف
                                                </a>

                                                @can('coupons.destroy')
                                                    <form action="{{route('admin.coupons.destroy', ['coupon' => $coupon->id])}}" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="dropdown-item" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal_{{$coupon->id}}" data-bs-whatever="@mdo">
                                                            <i class="fa-solid fa-trash"></i>
                                                            حذف کد تخفیف
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                            <div class="modal fade" id="exampleModal_{{$coupon->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-top">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">تایید حذف کد تخفیف</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            آیا از حذف این کد تخفیف مطمئن هستید؟
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">بستن</button>
                                                            <form action="{{route('admin.coupons.destroy', ['coupon' => $coupon->id])}}" method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger text-white" data-bs-dismiss="modal">بله</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach($i = 0; $i <= 10; $i++)
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
