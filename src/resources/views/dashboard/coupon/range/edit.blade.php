@extends('dashboard.layout.master')
@section('title', 'ایجاد بازه تخفیف جدید')
@section('content')
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">ایجاد بازه تخفیف جدید</h5>
            <form action="{{route('admin.coupons.range.update')}}" method="post">
                @csrf
                @method('PATCH')
                <div class="row">
                    <h5 class="card-title">بازه تخففیف کنونی: {{$range->start_discount}} - {{$range->end_discount}} درصد</h5>
                    <div class="col-md-6 my-2">
                        <div class="form-group">
                            <label for="start_discount" class="mb-3">از بازه :</label>
                            <input name="start_discount"
                                   id="start_discount"
                                   value="{{$range->start_discount}}"
                                   class="form-control"
                                   type="number"
                                   required>
                            @error('start_discount')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 my-2">
                        <div class="form-group">
                            <label class="mb-3" for="end_discount">تا بازه :</label>
                            <input name="end_discount"
                                   type="number"
                                   id="end_discount"
                                   class="form-control"
                                   value="{{$range->end_discount}}"
                                   required>
                            @error('end_discount')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12 my-2">
                        <div class="row">
                            @foreach($courses as $course)
                                <div class="col-md-6">
                                    <div class="form-check form-check-primary mt-3">
                                        <input class="form-check-input"
                                               name="product_ids[]"
                                               type="checkbox"
                                               value="{{$course->product->id}}"
                                               id="{{$course->product->id}}"
                                                {{in_array($course->product_id, $range->ids) ? 'checked' : null}}
                                        />
                                        <label class="form-check-label" for="{{$course->product->id}}">{{$course->product->name}}</label>
                                    </div>
                                </div>
                            @endforeach
                            @error('product_ids')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
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
