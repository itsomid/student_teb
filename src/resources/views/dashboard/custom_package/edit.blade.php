@extends('dashboard.layout.master')
@section('title', 'افزودن پکیج سفارشی جدید ')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">افزودن پکیج سفارشی جدید </h5>

            <form action="{{route('admin.custom-package.update', $product->id)}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="row">

                    <div class="col-md-6  mb-1">
                        <div class="form-group">
                            <label for="name">نام:</label>
                            <input name="name"
                                   id="name"
                                   class="form-control"
                                   value="{{ $product->name }}"
                                   placeholder="نام را وارد کنید."
                                   required>
                            @error('name')<small class="text-danger">{{$message}}</small>@enderror

                        </div>
                    </div>

                    <div class="col-md-6  mb-1">
                        <div class="form-group">
                            <label for="original_price">قیمت (ریال):</label>
                            <input name="original_price" type="number" id="original_price" class="form-control"
                                   value="{{ $product->original_price }}"
                                   placeholder="قیمت را وارد کنید." required>
                            @error('original_price')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6  mb-1">
                        <div class="form-group">
                            <label for="holding_date">زمان برگزاری:</label>
                            <input name="holding_date" type="text" id="holding_date" class="form-control" data-jdp value="{{ $product->holding_date }}">
                            @error('holding_date')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6  mb-1">
                        <div class="form-group mt-3">
                            <label for="off_price">قیمت حراجی با اعمال کد تخفیف (ریال):</label>
                            <input name="off_price" type="number" id="off_price" class="form-control" value="{{ $product->off_price }}" placeholder="قیمت حراجی را وارد کنید.">
                            @error('off_price')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="user_id">استاد:</label>
                            <x-teacher-selection-component input-name="user_id" :default-value="$product->user_id"></x-teacher-selection-component>
                            @error('user_id')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>

                    <div class="col-md-6 mb-1">
                        <img src="{{ $product->getImageUrl() }}" alt="" class="img-fluid rounded h-50 w-25"><br>
                        <div class="form-group mt-3">
                            <label class="form-label" for="input_img">تصویر پکیج:</label>
                            <input class="form-control-file form-control" type="file" id="input_img" name="img_filename">
                            @error('img_filename')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-12 mb-1">
                        <div class="form-group mt-3">
                            <div class="form-group mt-3">
                                <label for="description">توضیحات</label>
                                <textarea class="form-control" name="description" id="description" rows="5">{{ $product->description }}</textarea>
                                @error('description')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-1">
                        <div class="form-group mt-3">
                            <label class="form-label" for="familiarity_way">دسته بندی:</label>
                            <select id="familiarity_way" class="form-select text-capitalize mb-md-0 " multiple name="categories">
                                <option value="">انتخاب نشده</option>
                                @foreach($categories as $category)
                                    {{--                                    @if(in_array($category->id, old('categories') ?? [])) selected @endif--}}
                                    <option @if($product->categories && $product->categories->contains($category->id)) selected @endif value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('categories')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="fake_price">fake price:</label>
                            <input type="text"
                                   name="options[fake_price]"
                                   id="fake_price"
                                   value="{{ $product->options['fake_price'] ?? '' }}"
                                   class="form-control"
                                   placeholder="enter fake price">
                            @error('options')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="full_price">Full Price (only for show in store list):</label>
                            <input type="text"
                                   name="options[full_price_show]"
                                   id="full_price"
                                   value="{{ $product->options['full_price_show'] ?? ''}}"
                                   class="form-control"
                                   placeholder="enter Full Price">
                            @error('options')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="expiration_duration">مدت زمان اشتراک ( به روز ):</label>
                            <input type="text"
                                   name="expiration_duration"
                                   id="expiration_duration"
                                   value="{{ $product->expiration_duration }}"
                                   class="form-control"
                                   placeholder="مدت زمان اشتراک">
                            @error('expiration_duration')<small class="text-danger">{{$message}}</small>@enderror
                        </div>
                    </div>

                    <hr class="mt-3">
                    <h5 class="card-title">وضعیت پکیج</h5>
                    <div class="col-md-4 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="is_purchasable">قابل خرید مجزا میباشد</label>
                                <input class="form-check-input" type="checkbox" role="switch" id="is_purchasable" name="is_purchasable" @if($product->is_purchasable) checked @endif>
                                @error('is_purchasable')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="has_installment"> قابلیت قسط بندی دارد</label>
                                <input class="form-check-input" type="checkbox" role="switch" id="has_installment" name="has_installment" @if($product->has_installment) checked @endif>
                                @error('has_installment')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-check form-switch">
                                <label class="form-check-label" for="show_in_list"> نمایش در لیست محصولات</label>
                                <input class="form-check-input" type="checkbox" role="switch" id="show_in_list" name="show_in_list" @if($product->show_in_list) checked @endif>
                                @error('show_in_list')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>


                    <hr class="mt-3">
                    <h5 class="card-title">مدیریت اقساط پکیج</h5>

                    <div class="col-md-4 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-group">
                                <label class="form-label" for="installment_count">تعداد قسط ها با خود پرداخت اولیه:</label>
                                <input name="installment_count" type="number" id="installment_count" class="form-control" placeholder="پیش فرض: ۴" value="{{ $product->installment_count }}">
                                @error('installment_count')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-group">
                                <label class="form-label" for="first_installment_ratio">پرداختی اولیه (بصورت درصد):</label>
                                <input name="first_installment_ratio" type="number" id="first_installment_ratio" class="form-control" placeholder="پیش فرض ۳۳" value="{{ $product->first_installment_radio }}">
                                @error('first_installment_ratio')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-group">
                                <label class="form-label" for="first_installment_amount">پرداختی اولیه (بصورت مبلغ):</label>
                                <input name="first_installment_amount" type="number" id="first_installment_amount" class="form-control" value="{{ $product->first_installment_amount }}">
                                @error('first_installment_amount')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-1">
                        <div class="form-group mt-2">
                            <div class="form-group">
                                <label class="form-label" for="final_installment_date">زمان سر رسید قسط آخر:</label>
                                <input name="final_installment_date" type="number" id="final_installment_date" class="form-control" placeholder="زمان سر رسید قسط آخر را وارد کنید." value="{{ $product->first_installment_date }}">
                                @error('final_installment_date')<small class="text-danger">{{$message}}</small>@enderror
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="mt-3">
                <h5 class="card-title">محتوای پکیج سفارشی</h5>
                @error('sections')<small class="text-danger">{{$message}}</small>@enderror
                <custom-package sections_prop='@json(\App\Models\CustomPackage::getCoursesJson($product->packages))'></custom-package>

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
@section('scripts')
    @vite(['resources/assets/js/jalalidatepicker.js'])
@endsection
