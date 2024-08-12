@extends('dashboard.layout.master')
@section('title', '')
@section('content')
    <div class="content">
        <div class="card card-primary">
            <h3 class="card-header">
                افزودن رکورد جدید برای تاریخچه ی
                {{$commission->support->name}}
                <a href="{{route('admin.commission.history.index', ['commission' => $commission->id])}}" class=" btn btn-warning" style="float: left">
                    <i class="fa fa-undo"></i>
                    بازگشت
                </a>
            </h3>
            <div class="card-body">
                <form action="{{route('admin.commission.history.store' , ['commission' => $commission->id])}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="type">انتخاب نوع همکاری</label>
                                <select name="type" id="type" class="form-control">
                                    @foreach($types as $type)
                                        <option value="{{$type->id}}">{{$type->title}} | {{$type->percentage}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label for="type">میزان پورسانت  (حداکثر 0.6)</label>
                            <input required
                                   dir="ltr"
                                   type="number"
                                   min="0"
                                   max="1"
                                   step="0.00001"
                                   class="form-control"
                                   name="percentage"
                                   value="{{old('percentage')}}"
                                   placeholder=" درصد همکاری به اعشار"
                            >
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="description">توضیحات</label>
                                <select name="action" id="description" class="form-control">
                                    @foreach(\App\Models\Commission::ACTIONS as $action => $detail)
                                        <option value="{{$action}}">{{$detail['description']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="created_at">تاریخ ایجاد</label>
                                    <input required
                                           type="text"
                                           name="created_at"
                                           class="form-control"
                                           autocomplete="off"
                                           placeholder="جهت درج تاریخ کلیک کنید"
                                    >
                            </div>
                        </div>

                        <div class="col-md-12 text-center mt-4">
                            <button class="btn btn-success text-white" type="submit">
                                <i class="fa fa-save mx-2"></i>
                                ثبت رکورد
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection


