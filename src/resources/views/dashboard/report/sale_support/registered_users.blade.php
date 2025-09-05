@extends('dashboard.layout.master')
@section('title', 'گزارش ثبت نامی ها')

@section('content')
    @can('student.manage-all-user')
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">جست و جو</h5>
                <form class="row mt-3 d-flex align-items-end justify-content-between"
                      action="{{route('admin.admin.index')}}" method="get">

                    <div class="col-md-10 user_role">
                        <label class="form-label" for="key">نام یا شماره تماس یا ایمیل یا ID</label>
                        <input type="text" class="form-control" name="key" placeholder="دنبال چی میگردی؟">
                    </div>
                    <div class="col-md-2 mt-2 text-center">
                        <button class="btn btn-success">
                            <i class="fa-solid fa-magnifying-glass mx-2"></i>
                            جست و جو
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endcan

    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex align-items-start justify-content-between">
                <div class="content-left">
                    <span>تعداد کاربران</span>
                    <div class="d-flex align-items-center my-1">
                        <h4 class="mb-0 me-2">{{count($students)}}</h4>
                    </div>
                </div>
                <span class="badge bg-label-success rounded p-2">
                            <i class="fa-solid fa-user-check"></i>
                        </span>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if(count($students))
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>شماره موبایل</th>
                            <th>نام(فارسی)</th>
                            <th>نام(انگلیسی)</th>
                            <th>پشتیبان</th>
                            <th>تایید حساب</th>
                        </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        @foreach($students as $student)
                            <tr>
                                <td>
                                    {{$student->id}}
                                </td>

                                <td>
                                    {{$student->mobile}}
                                </td>
                                <td>
                                    {{$student->name}}
                                </td>
                                <td>
                                    {{$student->name_english}}
                                </td>
                                <td>
                                    @if($student->saleSupport)
                                        {{$student->saleSupport->fullname()}}
                                    @endif

                                </td>
                                <td class="text-center">
                                    @if($student->verified_by_supporter)
                                        <i class="fa-solid fa-circle-check text-success"></i>
                                    @else
                                        <i class="fa-solid fa-skull-crossbones text-danger"></i>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else

                <p class="text-center h4 mt-5"> هنوز دانشجوی با کد معرف شما ثبت نام نکرده است🙄</p>

            @endif
        </div>
        <div class="row justify-content-center">
            {{--                {{$students->links()}}--}}
        </div>
    </div>
@endsection
