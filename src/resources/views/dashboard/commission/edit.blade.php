@extends('dashboard.layout.master')
@section('title', '')
@section('content')
    <div class="content">
        <div class="card ">
            <h3 class="card-header">
                ویرایش نوع همکاری {{$commission->support->name}}
                <a href="{{route('admin.commission.index')}}" class=" btn btn-warning" style="float: left">
                    <i class="fa fa-undo"></i>
                    بازگشت
                </a>
            </h3>
            <div class="card-body">
                <form action="{{route('admin.commission.update', ['commission' => $commission->id])}}" method="post">
                    @method('PATCH')
                    @csrf
                    <div class="row align-content-scratch">
                        <div class="form-group col-md-6">
                            <label>نوع همکاری</label>
                            <select id="selectType" name="type_id" class="form-control">
                                @foreach($types as $type)
                                    <option value="{{$type->id}}" {{$commission->type_id == $type->id ? "selected" : null}}>
                                        {{$type->title}} | {{$type->percentage}}
                                    </option>
                                @endforeach
                            </select>
                            @if($errors->has('type_id'))
                                <small class="text-danger">{{$errors->first('type_id')}}</small>
                            @endif
                        </div>
                        <div class="form-group col-md-2 align-content-end">
                            <button class="btn btn-success w-100">
                                <span>ثبت تغییرات</span>
                                <i class="fa fa-pen mx-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
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
