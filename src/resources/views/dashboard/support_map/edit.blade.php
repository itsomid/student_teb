@extends('dashboard.layout.master')
@section('title', 'پایه بندیِ پشتیبان ها')
@section('content')
    <div class="row">
        <form action="{{route('admin.support_map.update', $support_map->id)}}" method="post">
            @method('PATCH')
            @csrf
            <div  class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="title">عنوان را وارد کنید</label>
                                <input type="text"
                                       id="title"
                                       class="form-control"
                                       name="title"
                                       value="{{old('title') ?? $support_map->title}}"
                                       placeholder="عنوان را وارد کنید">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div  class="card mt-4">
                <div class="card-body">
                    <h6>انتخاب پایه ها</h6>
                    <div class="row">
                        @foreach(\App\Data\Grades::get() as $key=>$label)
                            <div class="col-md-3">
                                <div class="form-check form-check-primary mt-4">
                                    <input class="form-check-input" type="checkbox"
                                           name="grades[]"
                                           value="{{$key}}"
                                           id="gradeCheck{{$key}}"
                                            {{is_array($support_map->grades) && in_array($key,$support_map->grades) ? 'checked' : null}}
                                            {{ in_array($key,$selectedGrades)? 'disabled' : null}}
                                    />
                                    <label class="form-check-label" for="gradeCheck{{$key}}">{{$label}}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div  class="card mt-4">
                <div class="card-body">
                    <h6>انتخاب پشتیبان ها</h6>
                    <div class="row">
                        @foreach($onsite_supports as $support)
                            <div class="col-md-3">
                                <div class="form-check form-check-primary mt-4">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="admins[]"
                                           value="{{$support->id}}"
                                           id="supportCheck{{$support->id}}"
                                           {{in_array($support->id,$support_map->admins()->pluck('id')->toArray()) ? 'checked' : null}}
                                           {{in_array($support->id,$selectedAdmins) ? 'disabled' : null}}
                                    />
                                    <label class="form-check-label" for="supportCheck{{$support->id}}">
                                        {{$support->fullname()}}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <button class="btn btn-primary mt-3 float-left">
                ثبت تغییرات
            </button>
        </form>
    </div>
@endsection

