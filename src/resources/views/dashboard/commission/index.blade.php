@extends('dashboard.layout.master')
@section('title', '')
@section('content')
    <div class="content">
        <div class="card">
            <div class="card-body">
                <form action="{{route('admin.commission.store')}}" method="post">
                    @csrf
                    <div class="row align-content-stretch">
                        <div class="form-group col-md-5">
                            <label>پشتیبان فروش :</label>
                            <select id="selectSupport" name="support_id" class="form-control">
                                @foreach($supports as $support)
                                    <option value="{{$support->id}}"    {{old('support_id') == $support->id ? "selected" : null}}>
                                        {{$support->fullname()}}  |  {{$support->mobile}}
                                    </option>
                                @endforeach
                            </select>
                            @if($errors->has('support_id'))
                                <small class="text-danger">{{$errors->first('support_id')}}</small>
                            @endif
                        </div>


                        <div class="form-group col-md-5">
                            <label>نوع همکاری</label>
                            <select id="selectType" name="type_id" class="form-control">
                                @foreach($types as $type)
                                    <option value="{{$type->id}}" {{old('type_id') == $type->id ? "selected" : null}}>
                                        {{$type->title}} | {{$type->percentage}}
                                    </option>
                                @endforeach
                            </select>
                            @if($errors->has('type_id'))
                                <small class="text-danger">{{$errors->first('type_id')}}</small>
                            @endif
                        </div>
                        <div class="form-group col-md-2 align-content-end">
                            <label>  </label>
                            <button class="btn btn-success w-100">
                                افزودن
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <h3 class="card-header">
                لیست پشتیبان ها
                <a href="{{route('admin.commission_type.index')}}" class=" btn btn-primary" style="float: left">
                    <i class="fa fa-list mx-2"></i>
                    لیست انواع همکاری
                </a>
            </h3>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="payments-table">
                        <thead>
                        <tr>
                            <th>شناسه پشتیبان</th>
                            <th>پشتیبان</th>
                            <th>نوع همکاری</th>
                            <th>درصد مشارکت در فروش</th>
                            <th class="text-center">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($commissions as $commission)
                            <tr
                                    @if(!is_null($commission->deleted_at)) class="text-muted" style="background-color: #cac8c8" @endif
                                    @if(!is_null($commission->type->deleted_at)) style="background-color: #f62e2e; color: white" @endif
                            >
                                <td>
                                    #
                                    {{$commission->support_id}}
                                </td>
                                <td>
                                    {{$commission->support->fullname()}} | {{$commission->support->mobile}}
                                    @if(!is_null($commission->deleted_at))
                                        <b class="text-danger">حذف شده</b>
                                    @endif
                                </td>
                                <td>
                                    {{$commission->type->title}}
                                    @if(!is_null($commission->type->deleted_at))
                                        <b>
                                            <h3 style="display: inline">🚸</h3>
                                            این نوع همکاری حذف شده است
                                        </b>
                                    @endif
                                </td>
                                <td>{{$commission->type->percentage}}</td>
                                <td class="text-center">
                                    <a href="{{route('admin.commission.edit', ['commission' => $commission->id])}}" class="btn btn-warning btn-sm">
                                        <i class="fa fa-pencil"></i> 
                                        ویرایش
                                    </a>

                                    <a href="{{route('admin.commission.history.index', ['commission' => $commission->id])}}" class="btn btn-primary btn-sm">
                                        <i class="fa fa-history"></i> 
                                        تاریخچه
                                    </a>

                                    <form action="{{route('admin.commission.destroy', ['commission' => $commission->id])}}" method="post" style="display: inline">
                                        @csrf @method('DELETE')
                                        @if(is_null($commission->deleted_at))
                                            <button class="btn btn-danger btn-sm text-white" type="submit">
                                                <i class="fa fa-trash"></i> 
                                                حذف
                                            </button>
                                        @else
                                            <button class="btn btn-success btn-sm" type="submit">
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
@endsection

@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#selectSupport').select2();
        });
    </script>
@endsection
