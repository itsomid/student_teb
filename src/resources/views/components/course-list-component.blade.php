<select name="{{ $inputName }}" class="select2 form-control" {{$multiple ? 'multiple' : ''}}>
    <option value="">محصول مورد نظر را انتخاب کنید</option>
    @foreach($products as $product)
        <option value="{{ $product->id }}"  @selected(in_array($product->id,  $selected))>
            {{ $product->name }}
        </option>
    @endforeach
</select>

