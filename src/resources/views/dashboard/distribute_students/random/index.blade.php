@extends('dashboard.layout.master')
@section('title', 'توزیع دانشجوان به صورت رندوم')
@section('content')
    <div class="row">
        <form class="card" action="{{route('admin.random.students.distribution.distribute')}}" method="post">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="support_id">انتخاب پشتیبان فروش</label>
                            <select class="select2 form-select" id="support_id" name="support_id">
                                @foreach($supports as $support)
                                    <option
                                        value="{{$support->id}}"
                                        {{$support->id == old('support_id') ? 'selected' : null}}>
                                       #{{$support->id}} ➖ {{$support->fullname()}} ➖ {{$support->mobile}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <button class="btn btn-danger mt-5">
                            توزیع دانشجوان این پشتیبان
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js'])
    @vite(['resources/assets/vendor/js/forms-selects.js'])
@endsection
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection

