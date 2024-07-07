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
                    <div class="col-md-4">
                        <label class="form-label" for="selectStudent">نوع کد تخفیف :</label>
                        <select name="coupon_type"
                                id="selectStudent"
                                class="select2 form-control">

                            <option value=" ">همه</option>
                            @foreach(\App\Models\Coupon::types()  as $key => $type)
                                <option @selected(request()->has('coupon_type') && request()->input('coupon_type') == $key)  value="{{$key}}">{{$type}}</option>
                            @endforeach
                        </select>
                        @error('consumer_user_id') <small class="text-danger">{{$message}}</small> @enderror
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
                            <!-- Dropdown with Icon -->
                            <div class="btn-group">
                                <button class="btn btn-primary text-white dropdown-toggle" type="button" id="dropdownMenuButtonIcon" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="ti ti-menu-2 ti-xs mx-2 "></i>
                                    <span class="mx-2">
                                        افزودن کد تخفیف
                                    </span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon">
                                    <li><a class="dropdown-item d-flex align-items-center" href="{{route('admin.coupons.create_specified_students_coupon')}}"><i class="ti ti-chevron-right scaleX-n1-rtl"></i> کد تخفیف معمولی</a></li>
                                    <li><a class="dropdown-item d-flex align-items-center" href="{{route('admin.coupons.create-mass-creation')}}"><i class="ti ti-chevron-right scaleX-n1-rtl"></i>کد تخفیف عمده</a></li>
                                    <li><a class="dropdown-item d-flex align-items-center" href="{{route('admin.coupons.create-conditional-student-discount')}}"><i class="ti ti-chevron-right scaleX-n1-rtl"></i>کد تخفیف شرطی</a></li>
                                </ul>
                            </div>
                        @endcan
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>نوع</th>
                            <th>کد تخفیف</th>
                            <th>سازنده کد</th>
                            <th>تعداد استفاده</th>
                            <th>درصد تخفیف/مبلغ تخفیف</th>
                            <th>زمان انقضا</th>
                            <th>مبلغ استفاده شده:</th>
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
                                        <span class="text-{{$coupon->type(true)}}">
                                            {{$coupon->type()}}
                                        </span>
                                    </td>
                                    <td>
                                        <span title="{{$coupon->description}}">
                                            {{$coupon->coupon}}
                                        </span>
                                    </td>
                                    <td>
                                        {{$coupon->creator->fullname()}}
                                    </td>
                                    <td>
                                       {{$coupon->number_of_use}}
                                    </td>
                                    <td class="text-center">
                                        {{$coupon->discount_percentage}}
                                        %
                                        /
                                        {{$coupon->discount_amount}}
                                        0 ریال
                                    </td>
                                    <td class="text-center">
                                        {{$coupon->expired_at()}}
                                    </td>
                                    <td class="text-center">
                                        N/A
                                    </td>
                                    <td class="d-flex align-items-center">
                                        <div class="dropdown mx-3">
                                            <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                <i class="fa-solid fa-ellipsis-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu">
                                                @if($coupon->type != \App\Enums\CouponTypesEnum::MASS_CREATION->value)
                                                    <a class="dropdown-item"
                                                       href="{{route('admin.coupons.edit' , ['coupon' => $coupon->id])}}">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                        ویرایش کد تخفیف
                                                    </a>
                                                @endif
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
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js',
            'resources/assets/vendor/js/forms-selects.js',
            'resources/assets/js/select2/student.js',
            'resources/assets/js/select2/admin.js'
          ])

@endsection
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection
