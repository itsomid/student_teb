@extends('dashboard.layout.master')
@section('title', 'افزایش اعتبار')
@section('content')
    <section class="form-control-repeater">
        <div class="card">

            <div class="card-body">
                <h5 class="card-title">فرم افزایش اعتبار</h5>
                <form class="row" method="post" action="{{route('admin.student-account.charge')}}">
                    @csrf

                    <div class="col-md-6">
                        <label for="selectStudent" class="form-label mb-0">دانش آموز:
                        </label>
                        <div class="form-group">
                            <select name="user_id"
                                    id="selectStudent"
                                    class="select2 form-control"
                                    src="{{route('admin.students.select.index')}}">
                            </select>
                            @error('user_id')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="numeral-mask" class="form-label mb-0">میزان اعتبار مورد نظر (به ریال وارد شود):</label>
                        <input type="text"
                               name="amount"
                               id="numeral-mask" class="form-control numeral-mask"
                               placeholder="مبلغ را وارد کنید">
                        @error('amount')<small class="text-danger">{{$message}}</small>@enderror
                    </div>

                    <div class="col-md-6 user_role mt-3">
                        <label class="form-label" for="user_description">توضیحات تراکنش (اختیاری):</label>
                        <textarea class="form-control" id="user_description" name="user_description" placeholder="توضیحات..."></textarea>

                    </div>
                    <div class="mt-4">
                        <p class="mb-2">اعتبار حقیقی یا مجازی:</p>
                        <div class="form-check form-check-inline mb-2">
                            <input class="form-check-input" type="radio" name="moneyType" value="real" checked>
                            <label class="form-check-label" for="optional_address">
                                پول حقیقی
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="moneyType" value="gift_credit" disabled="">
                            <label class="form-check-label" for="disabledRadio1">
                                پول مجازی (هدیه)
                            </label>
                        </div>
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

