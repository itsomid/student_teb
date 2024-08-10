@extends('dashboard.layout.master')
@section('title', '')
@section('content')
    <div class="content">
        <div class="card">
            <h3 class="card-header">
                تاریخچه تغییرات
                {{$commission->support->name}}

                <a href="{{route('admin.commission.index')}}" class=" btn btn-warning" style="float: left">
                    <i class="fa fa-undo mx-2"></i>
                    بازگشت
                </a>
                <a href="{{route('admin.commission.history.create', ['commission' => $commission->id])}}" class=" btn btn-info" style="float: left">
                    <i class="fa fa-plus mx-2"></i>
                    ایجاد رکورد جدید
                </a>
            </h3>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="payments-table">
                        <thead>
                        <tr>
                            <th>تغییر دهنده</th>
                            <th>نوع همکاری</th>
                            <th>درصد مشارکت در فروش</th>
                            <th>توضیح</th>
                            <th >تاریخ تغییر</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($histories as $history)
                            <tr>
                                <td>{{$history->changer->fullname()}}</td>
                                <td>{{$history->type->title}}</td>
                                <td>{{$history->percentage}}</td>
                                <td>
                                    <span class="text-{{$history->theme}}">{{$history->description}}</span>
                                </td>
                                <td>
                                    {{$history->created_at()}}

                                    <a href="{{route('admin.commission.history.edit', ['commission' => $commission->id, 'history' => $history->id])}}">
                                        <i class="fa fa-pencil"></i>
                                    </a>
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
