@extends('dashboard.layout.master')
@section('title', 'افزودن محصول جدید')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">فرم افزودن محصول</h5>
            <form action="{{route('admin.course.store')}}" method="post" enctype="multipart/form-data"> @csrf
                <div class="row">
                    <div class="col-md-6">
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

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="original_price">قیمت (ریال):</label>
                            <input name="original_price"
                                   type="number"
                                   id="original_price"
                                   class="form-control"
                                   value="{{old('original_price')}}"
                                   placeholder="قیمت را وارد کنید." required>
                            @error('original_price')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="off_price">قیمت حراجی با اعمال کد تخفیف (ریال):</label>
                            <input name="off_price"
                                   type="number"
                                   id="off_price"
                                   class="form-control"
                                   value="{{old('off_price')}}"
                                   placeholder="قیمت حراجی را وارد کنید.">
                            @error('off_price')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="product_type_id">نوع محصول:</label>
                            <select class="select2 form-select" id="product_type_id" name="product_type_id">
{{--                                @foreach($types as $type)--}}
{{--                                    <option value="{{$type->id}}" {{old('product_type_id') == $type->id ? 'selected' : null}}>{{$type->name}}</option>--}}
{{--                                @endforeach--}}
                            </select>
                            @error('product_type_id')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="city">استاد:</label>
                            <dynamic-select
                                url="{{route('api.user.index', ['role' => 'teacher'])}}"
                                label="اننتخاب استاد"
                                input_name="user_id"
                                default_selected="{{old('user_id')}}"
                                option_title="name"
                                option_value="id"
                            ></dynamic-select>
                        </div>
                    </div>

                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="img_filename">input_img:</label>
                            <input class="form-control-file form-control" type="file" id="img_filename" name="img_filename">
                            @error('img_filename')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <div class="form-group mt-3">
                                <label for="description">توضیحات</label>
                                <textarea class="form-control" id="description" name="description" id="description" rows="5">{{old('description')}}</textarea>
                                @error('description')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="categories">دسته بندی:</label>
                            <select id="categories" class="form-select text-capitalize mb-md-0 " name="categories[]" multiple>
{{--                                @foreach($categories as $category)--}}
{{--                                    <option value="{{$category->id}}">{{$category->name}}</option>--}}
{{--                                @endforeach--}}
                            </select>
                            @error('categories')<small class="text-danger">{{$message}}</small>@enderror

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="password">fake price:</label>
                            <input type="text"
                                   name="password"
                                   id="password"
                                   class="form-control"
                                   placeholder="enter fake price"
                                   value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="password">Full Price (only for show in store list):</label>
                            <input type="text"
                                   name="password"
                                   id="password"
                                   class="form-control"
                                   placeholder="enter Full Price"
                                   value="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="password">مدت زمان اشتراک ( به روز ):</label>
                            <input type="text"
                                   name="password"
                                   id="password"
                                   class="form-control"
                                   placeholder="مدت زمان اشتراک"
                                   value="">
                        </div>
                    </div>
                    <hr class="mt-3">
                    <h5 class="card-title">وضعیت محصول</h5>
                    <div class="col-md-4 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="is_purchasable">قابل خرید مجزا میباشد</label>
                                <input class="form-check-input"
                                       value="1"
                                       type="checkbox"
                                       role="switch"
                                       id="is_purchasable"
                                       name="is_purchasable"
                                    {{old('is_purchasable') == 1 ? 'checked' : '' }}>
                                @error('is_purchasable')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="has_installment"> قابلیت قسط بندی دارد</label>
                                <input class="form-check-input"
                                       value="1"
                                       type="checkbox"
                                       role="switch"
                                       id="has_installment"
                                       name="has_installment"
                                    {{old('has_installment') == 1 ? 'checked' : '' }}>
                                @error('has_installment')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="show_in_list"> نمایش در لیست محصولات</label>
                                <input class="form-check-input"
                                       type="checkbox"
                                       role="switch"
                                       id="show_in_list"
                                       name="show_in_list"
                                       value="1"
                                    {{old('show_in_list') == 1 ? 'checked' : '' }}>
                                @error('show_in_list')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>

                    <hr class="mt-3">
                    <h5 class="card-title">مدیریت اقساط محصول</h5>

                    <div class="col-md-4 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-group">
                                <label class="form-label" for="installment_count">تعداد قسط ها با خود پرداخت اولیه:</label>
                                <input class="form-control"
                                       type="number"
                                       value="{{old('installment_count')  ? old('installment_count')  : 4 }}"
                                       id="installment_count"
                                       name="installment_count"
                                       placeholder="پیش فرض: ۴">
                                @error('installment_count')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-group">
                                <label class="form-label" for="first_installment_ratio">میزان پرداختی اولیه (بصورت درصد %):</label>
                                <input name="first_installment_ratio"
                                       type="number"
                                       id="first_installment_ratio"
                                       max="100"
                                       min="0"
                                       value="{{old('first_installment_ratio')  ? old('first_installment_ratio')  : 33}}"
                                       class="form-control"
                                       placeholder="پیش فرض ۳۳">
                                @error('first_installment_ratio')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-group">
                                <label class="form-label" for="final_installment_date">زمان سر رسید قسط آخر:</label>
                                <input name="final_installment_date"
                                       type="text"
                                       id="final_installment_date"
                                       class="form-control"
                                       data-jdp
                                       value="{{old('final_installment_date')}}"
                                       autocomplete="off"
                                       placeholder="زمان سر رسید قسط آخر را وارد کنید.">
                                @error('final_installment_date')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
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
