<div>
    <label for="selectStudent" class="text-muted">کاربر:</label>
    <select name="{{ $name }}"
            {{$multiple ? 'multiple' : ''}}
            id="selectStudent"
            class="select2 form-control"
            data-selected="{{$selected}}"
            src="{{route('admin.students.select.index')}}">
    </select>
</div>

@section('vendor-script')
    @vite(['resources/assets/vendor/libs/select2/select2.js',
            'resources/assets/vendor/js/forms-selects.js',
            'resources/assets/js/student.js',
          ])
@endsection
@section('vendor-style')
    @vite(['resources/assets/vendor/libs/select2/select2.scss'])
@endsection


