@extends('dashboard.layout.master')
@section('title', 'تغییر پشتیبان کاربر')

@section('content')


    <div class="card">
        <div class="card-body">
            <h5 class="card-title">تغییر پشتیبان {{$student->name}}</h5>
                <div class="row">
                    <div class="col-md-6">
                        <form method="post" action="{{route('admin.student.edit-support-sms', ['student' => $student->id])}}" > @csrf
                            <div class="row">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="product" class="mb-3">پشتیبان فروش :</label>
                                        @include('components.admin-selection-component',[
                                            'inputName'         => 'user_id',
                                            'placeholderName'   => 'انتخاب پشتیبان فروش جدید',
                                            'admins'            => $supports,
                                            'defaultValue'      => old('user_id')
                                        ])
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex align-items-center justify-content-center mt-3">
                                    <button class="btn btn-primary text-white" {{request()->has('sms') ? 'disabled' : ''}} >
                                        <i class="fa-sharp fa-solid fa-paper-plane mx-2"></i>
                                        ارسال کد
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="col-md-6">
                        <form method="post" action="{{route('admin.student.update-support', ['student' => $student->id])}}" >
                            @method('PATCH')
                            @csrf
                            <div class="row align-items-center">
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <label for="code" class="mb-3">کد تایید :</label>
                                        <input type="number" name="code" class="form-control" placeholder="کد تایید را وارد کنید." {{!request()->has('sms') ? 'disabled' : ''}}>
                                        <input type="hidden" value="{{request()->input('support_id')}}" name="user_id">
                                    </div>
                                    <small class="text-danger"> @error('code'){{$message}} @enderror</small>
                                </div>
                                <div class="col-md-2  d-flex align-items-center justify-content-center mt-3">
                                    <button class="btn btn-primary" {{!request()->has('sms') ? 'disabled' : ''}}>
                                        <i class="fa fa-save mx-2"></i>
                                        ذخیره
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
    </div>
@endsection
