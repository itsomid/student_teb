@extends('dashboard.layout.master')
@section('title', 'افزودن جلسه جدید برای دوره')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">
                افزودن جلسه جدید برای دوره
                {{$course->product->name}}
            </h5>
            <form action="{{route('admin.classes.store', ['course' => $course->id])}}" method="post">
                @csrf
                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">نام:</label>
                            <input name="name"
                                   id="name"
                                   class="form-control"
                                   placeholder="نام را وارد کنید."
                                   value="{{old('name')}}"
                                   required>
                            @error('name')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>

                    <div class="col-md-12 mb-1">
                        <div class="form-group mt-3">
                            <div class="form-group mt-3">
                                <label for="description">توضیحات</label>
                                <textarea class="form-control" name="description" id="description" rows="5">{{old('description')}}</textarea>
                                @error('description')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="holding_date">تاریخ و ساعت برگزاری:</label>
                            <input type="text"
                                   name="holding_date"
                                   id="holding_date"
                                   class="form-control"
                                   placeholder="تاریخ و ساعت برگزاری را وارد کنید"
                                   data-jdp
                                   value="{{old('holding_date')}}">
                            @error('holding_date')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="status">وضعیت کلاس:</label>
                            <select id="status" class="form-select text-capitalize mb-md-0 mb-2xx" name="status">
                                @foreach(\App\Models\Classes::statuses as $status => $status_label)
                                    <option value="{{$status}}">{{$status_label}}</option>
                                @endforeach
                            </select>

                            @error('status')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="parent_id">برای کلاس های مشترک (ایدی کلاس مشترک):</label>
                            <input type="number"
                                   name="parent_id"
                                   id="parent_id"
                                   class="form-control"
                                   placeholder="ایدی کلاس مشترک را وارد کنید"
                                   value="{{old('parent_id')}}">

                            @error('parent_id')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group mt-3">
                            <label for="studio_description">توضیحات استودیو:</label>
                            <textarea class="form-control"
                                      placeholder="توضیحات استودیو"
                                      rows="2"
                                      name="studio_description"
                                      id="studio_description">{{old('studio_description')}}</textarea>

                            @error('studio_description')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>


                    <hr class="mt-3">
                    <h5 class="card-title">وضعیت دوره</h5>

                    <div class="col-md-3 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="qa_is_active">پرسش پاسخ آفلاین</label>
                                <input
                                    class="form-check-input"
                                    name="qa_is_active"
                                    type="checkbox"
                                    role="switch"
                                    id="qa_is_active"
                                    {{old('qa_is_active') == 'on' ? 'checked' : null}}>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="homework_is_active">امکان ارسال تکلیف</label>
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    role="switch"
                                    name="homework_is_active"
                                    id="homework_is_active"
                                    {{old('homework_is_active') == 'on' ? 'checked' : null}}>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="homework_is_mandatory">اجباری بودن تکلیف</label>
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    role="switch"
                                    name="homework_is_mandatory"
                                    id="homework_is_mandatory"
                                    {{old('homework_is_mandatory') == 'on' ? 'checked' : null}}>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="report_is_mandatory">اجباری بودن کارنامه</label>
                                <input class="form-check-input"
                                       type="checkbox"
                                       role="switch"
                                       name="report_is_mandatory"
                                       id="report_is_mandatory"
                                      {{old('report_is_mandatory') == 'on' ? 'checked' : null}}>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="is_free"> جلسه اول رایگان</label>
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    role="switch"
                                    id="is_free"
                                    name="is_free"
                                    {{old('report_is_mandatory') == 'on' ? 'checked' : null}}>
                            </div>
                        </div>
                    </div>


                    <hr class="mt-3">
                    <h5 class="card-title">مدیریت لینک های برگزاری</h5>
                    <div class="col-md-12">
                        <div class="form-group mt-3">
                            <label for="offline_link_woza">لینک آفلاین woza:</label>
                            <input type="text"
                                   name="offline_link_woza"
                                   id="offline_link_woza"
                                   class="form-control"
                                   placeholder="aparat, webrtc stream key, link to m3u8"
                                   value="{{old('offline_link_woza')}}">
                            @error('offline_link_woza')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group mt-3">
                            <label for="offline_link_vod">لینک آفلاین VOD:</label>
                            <input type="text"
                                   name="offline_link_vod"
                                   id="offline_link_vod"
                                   class="form-control"
                                   placeholder=""
                                   value="{{old('offline_link_vod')}}">
                            @error('offline_link_vod')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="emergency_link">لینک اضطراری:</label>
                            <textarea rows="2" class="form-control" name="emergency_link" id="emergency_link">{{old('emergency_link')}}</textarea>
                            @error('emergency_link')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-12 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="attached_file_link">لینک جزوه:</label>
                            <textarea rows="2" class="form-control" name="attached_file_link" id="attached_file_link">{{old('attached_file_link')}}</textarea>
                            @error('attached_file_link')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <hr class="mt-3">
                    <h5 class="card-title">موارد دیگر</h5>
                    <div class="col-md-12 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="familiarity_way">سرور های شفا‌آموز کانکت:</label>
                            <select id="familiarity_way" class="form-select text-capitalize mb-md-0 mb-2xx" multiple>
                                <option value="">انتخاب نشده</option>
                                <option>dawdawd</option>
                                <option>dawdawd</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class=" d-flex justify-content-center mt-3">
                    <div class="col-md-1">
                        <button class="btn btn-primary w-100">
                            <i class="fa fa-save mx-2"></i>
                            ذخیره
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
