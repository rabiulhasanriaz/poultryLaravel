<select class="form-control select2" id="product_model" name="type" required>
    <option value="">Select</option>
    @foreach($types as $type)
      <option value="{{ $type->id }}" {{ old('type') == $type->id ? 'selected' : '' }}>
        {{ $type->name }}
      </option>
    @endforeach
</select>
  