@extends('dashboard.layout.master')
@section('title', 'نشست های فعال '. $student->name)
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>IP Address</th>
                        <th>token (hashed)</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($tokens as $token)
                        <tr>
                            <td>{{$token->id}}</td>
                            <td>{{$token->name}}</td>
                            <td>
                                <span id="monospace-text" style="font-family: monospace; cursor: pointer; user-select: text;">
                                    {{$token->token}}
                                </span>
                            </td>
                            <td>
                                <form action="{{route('admin.student.token.revoke', ['student'=>$student->id, 'token' => $token->id])}}" method="post">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-danger">منقضی سازی</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
