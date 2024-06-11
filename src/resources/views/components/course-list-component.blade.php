<div>
    <select name="{{ $inputName }}" class="select2 form-control">
        <option value="">محصول مورد نظر را انتخاب کنید</option>
        @foreach($courses as $course)
            <option value="{{ $course->product_id }}">{{ $course->product->name }}</option>
        @endforeach
    </select>
</div>
