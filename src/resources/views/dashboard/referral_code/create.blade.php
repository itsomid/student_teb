@extends('dashboard.layout.master')
@section('title', 'مدیریت کدهای معرف')
@section('content')
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">افزودن کد معرف جدید</h5>
                <form class="row" method="post" action="{{route('admin.referral_code.store')}}"> @csrf
                    <div class="col-md-6 user_role mt-3">
                        <label class="form-label" for="regentCodeInput">کد:</label>
                        <input type="text"
                               name="code"
                               id="regentCodeInput"
                               class="form-control"
                               value="{{old('code')}}"
                               placeholder="کد یا شناسه ی دلخواه چند حرفی را وارد کنید">
                        @error('code')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-6 user_role mt-3">
                        <label class="form-label" for="giftCreditInput">مقدار اعتبار هدیه:</label>
                        <input type="text"
                               name="gift_credit"
                               id="giftCreditInput"
                               class="form-control number_sep"
                               value="{{old('gift_credit')}}"
                               placeholder="مقدار اعتبار هدیه را وارد کنید">
                        @error('gift_credit')
                            <small class="text-danger">{{$message}}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label mt-5" for="sale_support_id">کاربر :</label>
                        <select id="sale_support_id" name="sale_support_id" class="select2 form-select form-select-lg" data-allow-clear="true" data-placeholder="لطفا پشتیبان اننتخاب کنید">
                            <option></option>
                            @foreach($admins as $admin)
                                <option value="{{$admin->id}}" {{old('sale_support_id') == $admin->id ? 'selected' : null }}>
                                    {{$admin->fullname()}} | {{$admin->mobile}}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    <div class="col-md-12 text-right mt-5">
                        <button class="btn btn-primary mt-2">
                            <i class="fa fa-plus mx-2"></i>
                            ثبت و ذخیره
                        </button>
                    </div>
                </form>
            </div>
        </div>

@endsection
@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js'])
    @vite(['resources/assets/vendor/js/forms-selects.js'])
@endsection
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection
