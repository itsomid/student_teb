@extends('dashboard.layout.master')
@section('title', '')
@section('content')
    <div class="content">
        <div class="card ">
            <h3 class="card-header">
                افزودن رکورد جدید برای تاریخچه ی
                {{$commission->support->name}}
                <a href="{{route('admin.commission.history.index', ['commission' => $commission->id])}}" class=" btn btn-warning" style="float: left">
                    <i class="fa fa-undo mx-2"></i>
                    بازگشت
                </a>
            </h3>
            <div class="card-body">
                <form action="{{route('admin.commission.history.update' , ['commission' => $commission->id, 'history' => $history->id])}}" method="post">
                    @method('PATCH')
                    @csrf
                    <div class="row">
                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="created_at">تاریخ ایجاد</label>
                                <input required
                                       type="text"
                                       name="created_at"
                                       class="form-control"
                                       autocomplete="off"
                                       data-jdp
                                       value="{{$history->created_at()}}"
                                       placeholder="جهت درج تاریخ کلیک کنید"
                                >
                            </div>
                        </div>

                        <div class="col-md-2 text-center">
                            <br>
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
@section('vendor-script')
    @vite(['resources/assets/js/jalalidatepicker.js'])
@endsection

