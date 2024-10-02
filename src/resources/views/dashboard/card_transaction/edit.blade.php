@extends('dashboard.layout.master')
@section('title', 'ویرایش تراکنش کارت به کارت ')
@section('content')

    @if(session()->has('status'))
        <div class="alert alert-success" role="alert">
            <div class="alert-body">
                <i class="fa-sharp fa-solid fa-circle-check"></i>
                تراکنش کارت به کارت با موفقیت ویرایش شد
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">فرم افزودن تراکنش کارت به کارت</h5>
            <form action="{{route('admin.card-transaction.update', $cardTransaction->id)}}" method="post" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                <div class="row">
                    <div class="col-md-6 user_role">
                        <label class="form-label" for="tracking_code">شماره پیگیری تراکنش :</label>
                        <input type="text" id="tracking_code" class="form-control" name="tracking_code"  placeholder="شماره پیگیری را وارد کنید" value="{{old('tracking_code') ?? $cardTransaction->tracking_code}}">
                        @error('tracking_code') <small class="text-danger">{{$message}}</small> @enderror
                    </div>
                    <div class="col-md-6 user_role">
                        <label class="form-label" for="amount">مبلغ (ریال) :</label>
                        <input type="number" id="amount" class="form-control" name="amount"  placeholder="مبلغ را وارد کنید" value="{{old('amount') ?? $cardTransaction->amount}}">
                        @error('amount') <small class="text-danger">{{$message}}</small> @enderror
                    </div>
                    <div class="col-md-6 user_role  mt-3">
                        <label class="form-label" for="paid_date">تاریخ تراکنش :</label>
                        <input type="text" class="form-control" name="paid_date"  placeholder="تاریخ تراکنش را وارد کنید" value="{{old('paid_date') ?? $cardTransaction->paid_date()}}" data-jdp>
                        @error('paid_date') <small class="text-danger">{{$message}}</small> @enderror
                    </div>
                    <div class="col-md-6 user_role mt-3">
                        <label class="form-label" for="key">کاربر :</label>
                        <x-student-selection-component
                            name="student_id"
                            multiple="0"
                            selected="{{ $cardTransaction->student_id}}"
                            selected-label="{{ $cardTransaction->student->name }}">
                        </x-student-selection-component>
                        @error('student_id') <small class="text-danger">{{$message}}</small> @enderror
                    </div>
                    <div class="col-md-6 mt-2 user_role">
                        <label class="form-label" for="description">توضیحات تراکنش :</label>
                        <textarea class="form-control" name="description" id="description">{{old('description')  ?? $cardTransaction->description}}</textarea>
                        @error('description') <small class="text-danger">{{$message}}</small> @enderror
                    </div>
                    <div class="col-md-6 mt-2 user_role">
                        <label class="form-label"  for="filename">فیش :</label>
                        <input class="form-control-file form-control" name="filename" type="file" id="filename">
                        @error('filename') <small class="text-danger">{{$message}}</small> @enderror
                        <div class="text-center">
                            <img src="{{$cardTransaction->getImageUrl()}}" class="img-fluid w-50" >
                        </div>
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
