@extends('dashboard.layout.master')
@section('title', 'گزارش ثبت نامی ها')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title mb-5">تاریخچه ی تایید حساب {{$student->name}}</h5>

            @foreach($records as $record)
                در تاریخ
                {{$record->created_at()}}
                توسط
                {{$record->admin->fullname()}}
                {{$record->action}}
                شد
                <hr class="my-4">
            @endforeach
        </div>
    </div>
@endsection
