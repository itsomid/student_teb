@extends('dashboard.layout.master')
@section('title', 'مدیریت کدهای معرف')
@section('content')

        <div class="card">
            <div class="card-body border-bottom">
                <h5 class="card-title">فیلتر کدهای معرف</h5>
                <form class="row" action="{{route('admin.referral_code.index')}}">
                    <div class="col-md-6 user_role">
                        <label class="form-label" for="UserRole">کد:</label>
                        <input type="text" name="code_like" class="form-control" value="{{request()->input('code_like', null)}}" placeholder="کد معرف را وارد کنید">
                    </div>
                    <div class="col-md-6 user_status">
                        <label class="form-label" for="sale_support_id">کاربر :</label>
                        <select id="sale_support_id" class="form-select text-capitalize mb-md-0 " name="sale_support_id">
                            <option class="text-capitalize" value="" > همه  </option>
                            @foreach($admins as $admin)
                                <option value="{{$admin->id}}" class="text-capitalize" {{ (request()->has('sale_support_id') && request()->input('sale_support_id') == $admin->id)  ? 'selected' : null}}>
                                    {{$admin->fullname()}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 text-right  mt-4">
                        <button  class="btn btn-primary">
                            <i class="fa fa-search mx-2"></i>
                            جستجو
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-body">
                <div class="card-title header-elements">
                    <h5 class="m-0 me-2">لیست کدهای معرف</h5>
                    <div class="card-title-elements ms-auto">
                        <a href="{{route('admin.referral_code.create')}}" class="btn btn-primary">
                            <i class="fa fa-plus mx-2"></i>
                            افزودن کد معرف جدید
                        </a>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>کد</th>
                            <th>تعداد ثبت نامی</th>
                            <th>اعتبار هدیه</th>
                            <th>پشتیبان</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach($referralCodes as $referralCode)
                            <tr>
                                <td>
                                    {{$referralCode->code}}
                                </td>

                                <td>
                                    <span class="me-2">{{$referralCode->registered_users_count}}</span>
                                    <a href="" >(مشاهده)</a>
                                </td>
                                <td>
                                    {{$referralCode->gift_credit}}
                                </td>
                                <td>
                                    {{ $referralCode->admin->fullname()}}
                                </td>

                                <td class="d-flex align-items-center">
                                    <a class="btn btn-success text-white btn-sm me-2" href="{{ route('admin.referral_code.edit', ['referral_code' => $referralCode->id]) }}">
                                        <i class="fa-regular fa-pen me-2"></i>
                                        ویرایش
                                    </a>
{{--                                    TODO: Complete report--}}
                                    <a class="btn btn-info text-white btn-sm" href="">
                                        <i class="fa-regular fa-user me-2"></i>
                                        گزارش ثبت نام
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
{{--                @include('dashboard.layout.pagination', ['collection' => $regentCodes])--}}
            </div>
        </div>

@endsection
