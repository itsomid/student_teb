@extends('dashboard.layout.master')
@section('title', 'مدیریت سرور های cc')
@section('content')
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="card-title header-elements">
                    <h5 class="m-0 me-2">لیست سرور های cc</h5>
                    <div class="card-title-elements ms-auto">
                        <a href="{{route('admin.cc_servers.create')}}" class="btn btn-primary">
                            <i class="fa fa-plus mx-2"></i>
                            افزودن سرور
                        </a>
                    </div>
                </div>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>عنوان</th>
                            <th>آدرس</th>
                            <th>عملیات</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach($cc_servers as $cc_server)
                            <tr>
                                <td>{{$cc_server->id}}</td>

                                <td>{{$cc_server->name}}</td>

                                <td>
                                    <a href="{{$cc_server->url}}">
                                        {{$cc_server->url}}
                                    </a>
                                </td>

                                <td>
                                    <form action="{{ route('admin.cc_servers.destroy', $cc_server->id) }}" method="POST">
                                        <a class="btn btn-primary text-white" href="{{ route('admin.cc_servers.edit', $cc_server->id) }}">ویرایش</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger text-white">حذف</button>
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
