@extends('dashboard.layout.master')
@section('title', '')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <div class="card">
                    <h3 class="card-header">
                        ویرایش نوع همکاری {{$type->title}}
                        <a href="{{route('admin.commission_type.index')}}" class=" btn btn-warning" style="float: left">
                            <i class="fa fa-undo mx-1"></i>
                            بازگشت
                        </a>
                    </h3>
                    <div class="card-body">
                        <form action="{{route('admin.commission_type.update', ['commission_type' => $type->id])}}" method="post">
                            @method('PATCH')
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>عنوان</label>
                                    <input type="text" class="form-control" name="title" value="{{old('title') ?? $type->title}}" placeholder="عنوان را وارد کنید">
                                    @if($errors->has('title'))
                                        <small class="text-danger">{{$errors->first('title')}}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12 my-3">
                                    <label>درصد همکاری</label>
                                    <input dir="ltr" type="number" min="0" max="1" step="0.00001" class="form-control" name="percentage" value="{{old('percentage') ?? $type->percentage}}" placeholder="درصد را وارد کنید">
                                    @if($errors->has('percentage'))
                                        <small class="text-danger">{{$errors->first('percentage')}}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12 text-center">
                                    <button class="btn btn-success">
                                        ثبت تغییرات
                                        <i class="fa fa-pen mx-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>

    </div>
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#selectSupport').select2();
        });
    </script>
@endsection
