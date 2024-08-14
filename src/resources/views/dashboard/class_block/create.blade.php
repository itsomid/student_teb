@extends('dashboard.layout.master')
@section('title', 'افزایش اعتبار')
@section('content')
    <section class="form-control-repeater">
        <div class="card">

            <div class="card-body">
                <h5 class="card-title">بلاک کاربر از کلاس</h5>
                <form class="row" method="post" action="{{route('admin.student-account.charge')}}">
                    @csrf

                    <div class="col-md-6">
                        <label for="selectStudent" class="form-label mb-0">کلاس:
                        </label>
                        <class-selection-component input-name="product_id" default-value='{"product_id": 1, "product_name": "mehdi"}' ></class-selection-component>
                    </div>
                    <div class="col-md-12">
                        <label for="selectStudent" class="form-label mb-0">لیست کاربران بلاکی:
                        </label>
                        <div class="form-group">
                            <textarea cols="50" rows="10" class="form-control" name="users_list" placeholder="در هر خط یک شماره موبایل یا یک آیدی وارد شود، مثال:
09361956080
09396731636
11589
7746
09196479518"></textarea>
                            @error('users_list')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="numeral-mask" class="form-label mb-0">توضیحات:</label>
                        <textarea name="description" cols="50" rows="10" class="form-control"></textarea>
                        @error('description')<small class="text-danger">{{$message}}</small>@enderror
                    </div>

                    <div class="col-md-6 user_role mt-3">
                        <label class="form-label" for="user_description">توضیحات بلاک (اختیاری):</label>
                        <textarea class="form-control" id="user_description" name="user_description" placeholder="توضیحات..."></textarea>

                    </div>
                    <div class="row align-items-center g-2 mt-2">
                        <div class="col text-center">
                            <button type="submit" id="submitButton" class="btn btn-primary text-white">
                                <span class="fa fa-money-check-dollar ml-1"></span>
                                شارژ اکانت
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
@section('vendor-script')
    @vite([
            'resources/assets/vendor/libs/select2/select2.js',
            'resources/assets/vendor/libs/cleavejs/cleave.js',
            'resources/assets/vendor/js/forms-selects.js',
            'resources/assets/js/student.js',
            'resources/assets/js/forms-extras.js'
          ]);
@endsection
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection

