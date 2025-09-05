@extends('dashboard.layout.master')
@section('title', 'تاریخچه ی پشتیبان های دانشجو')
@section('content')
    <div class="row">
        <div class="card mb-5">
            <form action="{{route('admin.user_support.get')}}" method="get">
                <div class="row justify-content-center card-body ">
                    <div class="col-md-12">
                        <div class="form- mb-5">
                            <label for="username">نام دانشجو:</label>
                            <input class="form-control" id="username" type="text" name="student_name" value="{{request()->input('fields')['user.name'] ?? ''}}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="start_time">تاریخ شروع:</label>
                            <input class="form-control" id="start_time" type="text" name="start_time" value="" data-jdp>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="end_time">تاریخ پایان:</label>
                            <input class="form-control" id="end_time" type="text" name="end_time" value="" data-jdp>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        <button class="btn btn-primary my-3">
                            <i class="fa fa-search mx-2"></i>
                            جست و جو
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="card-title header-elements">
                    <h5 class="m-0 me-2">تاریخچه ی تغییر پشتیبان دانشجوان </h5>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>نام دانشجو</th>
                            <th>پشتیبان</th>
                            <th>نقش پشتیبان</th>
                            <th>زمان آغاز</th>
                            <th>زمان پایان</th>
                            <th>توضیحات</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach($userSupports as $userSupport)
                            <tr
                                @if(($userSupport->expired_at && $userSupport->expired_at->isPast()) || ($userSupport->end_time && $userSupport->end_time->isPast()))
                                    class="table-danger"
                                @endif>
                                <td>{{$userSupport->id}}</td>
                                <td>{{$userSupport->student->name}}</td>
                                <td>{{$userSupport->supporter->fullname()}}</td>
                                <td>
                                    {{$userSupport->support_role}}
                                </td>
                                <td>
                                    {{$userSupport->start_time}}
                                </td>
                                <td>
                                    {{$userSupport->end_time}}
                                </td>
                                <td>
                                    {{$userSupport->description}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row justify-content-center">
                {{$userSupports->links()}}
            </div>
        </div>
    </div>
@endsection
