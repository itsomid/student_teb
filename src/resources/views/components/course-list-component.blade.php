<div>
    <label for="selectStudent"  class="text-muted">انتخاب دوره:</label>
    <select name="{{ $name }}"
            class="select2 form-control"
        {{$multiple ? 'multiple' : ''}}
    >
        <option value="">محصول مورد نظر را انتخاب کنید</option>
        @foreach($courses as $course)
            <option value="{{ $course->id }}"  @selected(in_array($course->product_id,  $selected ?? []))>
                {{ $course->product->name }}
            </option>
        @endforeach
    </select>
</div>

