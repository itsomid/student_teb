@extends('dashboard.layout.master')
@section('title', 'تکالیف دانش آموزان')
@section('content')
    <div class="card ">
        <div class="card-header">
            <h3 class="col-md-12 text-center">
                فیلتر تکالیف
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('homework.index', ['page' => request()->input('page')]) }}" method="get">
                <div class="form-group col-md-6">
                    <label for="selectStudent" class="form-label mb-0">کلاس:
                    </label>
                    <class-selection-component input-name="product_id"
                                               default-value='@json(['product_id' => $productInputData['id'], 'product_name' => $productInputData['name']])'>
                    </class-selection-component>
                </div>
                <div class="form-group col-md-6">
                    <label>کاربر :</label>
                    <x-student-selection-component
                        name="user_id[]"
                        multiple="1"
                        selected="{{request()->has('user_id') ? json_encode(request()->input('user_id'),JSON_NUMERIC_CHECK) : '[]' }}">
                    </x-student-selection-component>
                </div>

                <div class="form-group col-sm-6">
                    <button class="btn btn-primary">جست و جو</button>
                </div>
                <div class="form-group col-sm-6">
                    <a class="btn btn-danger btn-block" href="{{route('homework.index')}}">لغو فیلتر</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-responsive" id="productLiveCourseClassHomeworks-table">
                <thead>
                <tr>
                    <th>شناسه ی کاربر</th>
                    <th>کلاس</th>
                    <th>فایل آپلود شده</th>
                    <th>ثبت نمره</th>
                    <th>حذف</th>
                </tr>
                </thead>
                <tbody>
                @foreach($homeworks as $homework)
                    <tr>
                        <td>{{$homework->user_id}}</td>
                        <td>
                            {{$classes->where('id',$homework->class_id)->first()->live_course->product->name}}
                            |
                            {{$classes->where('id',$homework->class_id)->first()->headlines}}
                        </td>
                        <td>
                            @foreach($homework->zip_filename as $file)
                                <a href="{{\App\Data\Store::HOMEWORK_DOWNLOAD_URL($file)}}" target="_blank">
                                    {{$file}}
                                </a>
                            @endforeach
                        </td>
                        <td>
                            <form action="{{route('homework.set_score', ['id'=> $homework->id])}}" method="post">
                                @csrf
                                @method('PATCH')
                                <select name="score" onchange="this.form.submit()">
                                    <option value="0">بدون نمره</option>
                                    @for($i=1;$i<11;$i++)
                                        <option value="{{$i}}" {{$i===$homework->score?'selected':''}}>{{$i}}</option>
                                    @endfor
                                </select>
                            </form>
                        </td>
                        <td>
                            <form action="{{route('homework.destroy', ['id' => $homework->id])}}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger btn-sm btn-block" type="submit">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="text-center">
        {{$homeworks->render()}}
    </div>
@endsection
