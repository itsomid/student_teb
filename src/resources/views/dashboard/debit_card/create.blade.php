@extends('dashboard.layout.master')
@section('title', 'ایجاد تراکنش کارت به کارت جدید')
@section('content')

    @if(session()->has('status'))
        <div class="alert alert-success" role="alert">
            <div class="alert-body">
                <i class="fa-sharp fa-solid fa-circle-check"></i>
                تراکنش کارت به کارت با موفقیت ایجاد شد
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">فرم افزودن تراکنش کارت به کارت</h5>
            <form action="{{route('admin.debit-card.store')}}" method="post" enctype="multipart/form-data">@csrf
                <div class="row">
                    <div class="col-md-6 user_role">
                        <label class="form-label" for="tracking_code">شماره پیگیری تراکنش :</label>
                        <input type="text" id="tracking_code" class="form-control" name="tracking_code"  placeholder="شماره پیگیری را وارد کنید" value="{{old('tracking_code')}}">
                        @error('tracking_code') <small class="text-danger">{{$message}}</small> @enderror
                    </div>
                    <div class="col-md-6 user_role">
                        <label class="form-label" for="amount">مبلغ (ریال) :</label>
                        <input type="number" id="amount" class="form-control" name="amount"  placeholder="مبلغ را وارد کنید" value="{{old('amount')}}">
                        @error('amount') <small class="text-danger">{{$message}}</small> @enderror
                    </div>
                    <div class="col-md-6 user_role  mt-3">
                        <label class="form-label" for="transaction_date">تاریخ تراکنش :</label>
                        <input type="text" class="form-control" name="transaction_date"  placeholder="تاریخ تراکنش را وارد کنید" data-jdp value="{{old('transaction_date')}}">
                        @error('transaction_date') <small class="text-danger">{{$message}}</small> @enderror
                    </div>
                    <div class="col-md-6 user_role mt-3">
                        <label class="form-label" for="key">کاربر :</label>
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
                    <div class="col-md-6 mt-2 user_role">
                        <label class="form-label" for="description">توضیحات تراکنش :</label>
                        <textarea class="form-control" name="description" id="description">{{old('description')}}</textarea>
                        @error('description') <small class="text-danger">{{$message}}</small> @enderror
                    </div>
                    <div class="col-md-6 mt-2 user_role">
                        <label class="form-label" for="filename">فیش :</label>
                        <input class="form-control-file form-control" name="filename" type="file" id="filename">
                        @error('filename') <small class="text-danger">{{$message}}</small> @enderror
                    </div>
                </div>
                <div class=" d-flex justify-content-center mt-3">
                    <div class="col-md-1">
                        <button class="btn btn-primary w-100">
                            <i class="fa fa-save mx-2"></i>
                            ذخیره
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
