@extends('dashboard.layout.master')
@section('title', 'مدیریت دانش آموزان')
@section('content')
    <div class="row g-4 mb-4">
        <div class="col-sm-12 col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>همه ی کاربران</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{$students->total()}}</h4>
                            </div>
                        </div>
                        <span class="badge bg-label-primary rounded p-2">
                            <i class="fa-solid fa-users"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-start justify-content-between">
                        <div class="content-left">
                            <span>تعداد کاربران تایید شده</span>
                            <div class="d-flex align-items-center my-1">
                                <h4 class="mb-0 me-2">{{$verified_students_count}}
                                    @if($students->total())
                                        (%{{round($verified_students_count/$students->total()*100)}})</h4>
                                @endif
                            </div>
                        </div>
                        <span class="badge bg-label-success rounded p-2">
                            <i class="fa-solid fa-user-check"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">خروجی اکسل</h5>
            <form class="row mt-3 d-flex align-items-end justify-content-between">
                <div class="col-md-4 user_role">
                    <label class="form-label" for="UserRole">از آیدی :</label>
                    <input type="number" class="form-control" placeholder="آیدی دانش آموز">
                </div>
                <div class="col-md-4 user_role">
                    <label class="form-label" for="UserRole">تا آیدی :</label>
                    <input type="number" class="form-control" placeholder="آیدی دانش آموز">
                </div>
                <div class="col-md-2 mt-2">
                    <button class="btn btn-success class ">دانلود خروجی اکسل</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-body border-bottom">
            <h5 class="card-title">فیلتر دانش آموزان</h5>
            <form class="row" action="{{route('admin.student.index')}}" method="get">
                <div class="col-md-4 user_role">
                    <label class="form-label" for="UserRole">جستجو متن :</label>
                    <input type="text" name="search_key" class="form-control">
                </div>

                <div class="col-md-4 user_status">
                    <label class="form-label" for="referral_code_id">جستجو کد معرف :</label>
                    <select id="referral_code_id" name="referral_code_id"
                            class="form-select text-capitalize mb-md-0 ">
                        <option value=""> همه</option>

                        @foreach($referral_codes as $referral_code)
                            <option value="{{$referral_code->id}}"
                                    class="text-capitalize" {{request()->input('referral_code_id') == $referral_code->id ? 'selected' : null}}>
                                {{$referral_code->code}}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 user_status mt-2">
                    <label class="form-label" for="sex">جنسیت :</label>
                    <select id="gender" class="form-select text-capitalize mb-md-0 " name="gender">
                        <option value=""> همه</option>
                        <option value="male"
                                class="text-capitalize" {{request()->input('gender') == 'male' ? 'selected' : null}}>
                            پسر
                        </option>
                        <option value="female"
                                class="text-capitalize" {{request()->input('gender') == 'female' ? 'selected' : null}}>
                            دختر
                        </option>
                    </select>
                </div>
                <div class="col-md-4 user_status mt-2">
                    <label class="form-label" for="field_of_study">رشته تحصیلی :</label>
                    <select id="field_of_study" class="form-select text-capitalize mb-md-0 "
                            name="field_of_study">
                        <option value=""> همه</option>

                        @foreach(\App\Data\FieldOfStudy::get() as $key=>$field_of_study)
                            <option value="{{$key}}"
                                    {{request()->input('field_of_study') === $key ? 'selected' : null}} class="text-capitalize">{{$field_of_study}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 user_status mt-2">
                    <label class="form-label" for="grade">سال تحصیلی :</label>
                    <select id="grade" name="grade" class="form-select text-capitalize mb-md-0 ">
                        <option value=""> همه</option>
                        @foreach(\App\Data\Grades::get() as $key=>$grade)
                            <option value="{{$key}}"
                                    {{request()->input('grade') == $key ? 'selected' : null}} class="text-capitalize">{{$grade}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4 user_status mt-2">
                    <label class="form-label" for="sales_description">توضیحات پشتیبان :</label>
                    <select id="sales_description" name="sales_description"
                            class="form-select text-capitalize mb-md-0 ">
                        <option value="">همه</option>
                        @foreach($salesDescriptions as $key=>$desc)
                            <option
                                value="{{$desc['sales_description']}}" {{request()->input('sales_description') === $desc['sales_description'] ? 'selected' : null}}>{{$desc['sales_description']}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary mt-2 text-white">
                        <span class="mx-2">جستجو</span>
                        <i class="fa-regular fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="card-title header-elements">
                <h5 class="m-0 me-2">لیست دانش آموزان</h5>
                <div class="card-title-elements ms-auto">
                    <a href="{{route('admin.student.create')}}" class="btn btn-primary">
                        <i class="fa fa-plus mx-2"></i>
                        افزودن دانش آموز جدید
                    </a>
                </div>
            </div>
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
                            <th>معرف</th>
                            <th>تایید حساب</th>
                            <th>عملیات</th>
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
                                    {{$student->saleSupport?->fullname()}}
                                </td>
                                <td>
                                    @if($student->referrer)
                                        {{$student->referrer?->code}} ({{$student->referrer?->admin?->fullname()}})
                                    @endif

                                </td>

                                <td class="text-right">

                                    <form action="{{route('admin.student.verify', ['student'=>$student])}}"
                                          method="post">
                                        @csrf
                                        @method('patch')
                                        <div class="btn-group">
                                            <button type="submit"
                                                    class="btn {{$student->verified_by_supporter ? 'btn-success' : 'btn-danger'}} btn-sm text-white">

                                                @if($student->verified_by_supporter)
                                                    تایید شده
                                                    <i class="fa-solid fa-circle-check mx-2"></i>
                                                @else
                                                    تایید نشده
                                                    <i class="fa-solid fa-skull-crossbones mx-2"></i>
                                                @endif

                                            </button>
                                            <a class="btn {{$student->verified_by_supporter ? 'btn-success' : 'btn-danger'}} dropdown-toggle dropdown-toggle-split text-white"
                                               data-bs-toggle="dropdown"
                                               aria-haspopup="true"
                                               aria-expanded="false">
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item"
                                                       href="{{route('admin.registered-users.verificationLogs' , ['student'=>$student->id])}}">تاریخچه
                                                        تایید حساب</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </form>


                                </td>
                                <td class="d-flex align-items-center">
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a class="btn btn-outline-secondary text-dark" href="">
                                            <i class="fa-sharp fa-solid fa-castle"></i>
                                        </a>
                                        @can('student.edit-note')
                                            <a class="btn {{$student->sales_description ? 'btn-primary' :'btn-outline-secondary text-dark'}}"
                                               href="#"
                                               data-bs-toggle="modal"
                                               data-bs-target="#noteModal{{$student->id}}">
                                                <i class="fa-regular fa-user-pen"></i>
                                            </a>
                                        @endcan
                                    </div>
                                    <div class="dropdown mx-3">

                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                               href="{{route('admin.student.edit', ['student'=>$student->id])}}">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                                ویرایش کاربر
                                            </a>
                                            @can('student.edit-note')
                                                <a class="dropdown-item" href="#">
                                                    <i class="fa-regular fa-comments"></i>
                                                    شروع چت
                                                </a>
                                            @endcan
                                            <a class="dropdown-item"
                                               href="{{route('admin.student.edit-support' , ['student' => $student->id] )}}">
                                                <i class="fa-solid fa-user-pen"></i>
                                                تغییر پشتیبان فروش
                                            </a>
                                            @can('student.support.history')
                                                <a class="dropdown-item"
                                                   href="{{route('admin.user_support.get', ['student_id' => $student->id])}}">
                                                    <i class="fa-solid fa-history"></i>
                                                    تاریخچه ی پشتیبان ها
                                                </a>

                                            @endcan

                                        </div>
                                    </div>
                                    @can('student.edit-note')
                                        <note-modal
                                            :id="'noteModal' + {{$student->id}}"
                                            :url="'{{route('api.student.update-note', ['student'=>$student->id])}}'"
                                            :sales_description="'{{$student->sales_description}}'"
                                        ></note-modal>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-center h4 mt-5">شما هنوز دانش آموزی نداری🙄</p>
            @endif
        </div>
        <div class="row justify-content-center">
            {{$students->links()}}
        </div>
    </div>

@endsection
