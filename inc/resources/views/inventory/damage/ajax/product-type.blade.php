<label>Type Name <b class="text-danger">*</b></label>
<select class="form-control select2" id="product_model" onchange="get_products(this.value)">
    <option value="">Select</option>
    @foreach($types as $type)
      <option value="{{ $type->id }}">{{ $type->name }}</option>
    @endforeach
  </select>
  
  <script>
      $('.select2').select2();
  </script>