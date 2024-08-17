<div>
    <select name="{{ $inputName }}"
            id="selectStudent"
            class="select2 form-control"
            multiple
            data-selected="[{{$defaultValue}}]"
            src="{{route('admin.students.select.index')}}">
    </select>
</div>

