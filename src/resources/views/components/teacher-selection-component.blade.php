<div>
    <select name="{{ $inputName }}" id="" class="select2 form-control">
        <option value="">استاد را انتخاب کنید</option>
        @foreach($teachers as $teacher)
            <option @if($defaultValue == $teacher->id) selected @endif value="{{ $teacher->id }}">{{ $teacher->fullname() }}</option>
        @endforeach
    </select>
</div>
