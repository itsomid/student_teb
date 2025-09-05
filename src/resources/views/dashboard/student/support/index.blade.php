@extends('dashboard.layout.master')
@section('title', 'تاریخچه ی پشتیبان های دانشجو')
@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="card-title header-elements">
                    <h5 class="m-0 me-2">تاریخچه ی تغییر پشتیبان برای {{$student->name}}</h5>
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
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach($userSupports as $userSupport)
                            <tr>
                                <td>{{$userSupport->id}}</td>
                                <td>{{$student->name}}</td>
                                <td>{{$admins->where('id', $userSupport->user_support_id)->first()->fullname()}}</td>
                                <td>
                                    @foreach($admins->where('id', $userSupport->user_support_id)->first()->roles as $role)
                                        {{$role->name}}
                                    @endforeach
                                </td>
                                <td>
                                    {{$userSupport->start_time()}}
                                </td>
                                <td>
                                    {{$userSupport->end_time()}}
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
