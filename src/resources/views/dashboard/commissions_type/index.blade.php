@extends('dashboard.layout.master')
@section('title', '')
@section('content')
    <div class="content">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <h3 class="card-header">
                        افزودن جدید
                    </h3>
                    <div class="card-body">
                        <form action="{{route('admin.commission_type.store')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>عنوان</label>
                                    <input type="text" class="form-control" name="title" value="{{old('title')}}" placeholder="عنوان را وارد کنید">
                                    @if($errors->has('title'))
                                        <small class="text-danger">{{$errors->first('title')}}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12 my-4">
                                    <label>درصد همکاری</label>
                                    <input dir="ltr" type="number" min="0" max="1" step="0.0001" class="form-control" name="percentage" value="{{old('percentage')}}" placeholder="درصد را وارد کنید">
                                    @if($errors->has('percentage'))
                                        <small class="text-danger">{{$errors->first('percentage')}}</small>
                                    @endif
                                </div>
                                <div class="form-group col-md-12 text-center">
                                    <button class="btn btn-success">
                                        افزودن
                                        <i class="fa fa-plus mx-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <h3 class="card-header">
                        انواع همکاری در فروش تعریف شده
                        <a href="{{route('admin.commission.index')}}" class=" btn btn-success" style="float: left">
                            <i class="fa fa-list mx-2"></i>
                            لیست تیم فروش
                        </a>
                    </h3>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="payments-table">
                                <thead>
                                <tr>
                                    <th>عنوان</th>
                                    <th>درصد مشارکت در فروش</th>
                                    <th>تاریخ آخرین ویرایش</th>
                                    <th class="text-center">عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($types as $type)
                                    <tr @if(!is_null($type->deleted_at)) class="text-muted" style="background-color: #cac8c8" @endif>
                                        <td>
                                            {{$type->title}}
                                            @if(!is_null($type->deleted_at))
                                                <b class="text-danger">حذف شده</b>
                                            @endif
                                        </td>
                                        <td>{{$type->percentage}}</td>
                                        <td>
                                            {{$type->created_at}}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{route('admin.commission_type.edit', ['commission_type' => $type->id])}}" class="btn btn-warning btn-sm">
                                                <i class="fa fa-pencil"></i> 
                                                ویرایش
                                            </a>
                                            <form action="{{route('admin.commission_type.destroy', ['commission_type' => $type->id])}}" method="post" style="display: inline">
                                                @csrf @method('DELETE')
                                                @if(is_null($type->deleted_at))
                                                    <button class="btn btn-danger text-white btn-sm" type="submit">
                                                        <i class="fa fa-trash"></i> 
                                                        حذف
                                                    </button>
                                                @else
                                                    <button class="btn btn-success text-white btn-sm" type="submit">
                                                        <i class="fa fa-recycle"></i> 
                                                        بازیابی
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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
