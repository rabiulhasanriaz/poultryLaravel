<label>Product Name <b class="text-danger">*</b></label>
<select class="form-control select2" id="product_name" name="product" required>
    <option value="">Select</option>
    @foreach($types as $type)
      <option value="{{ $type->id }}">{{ $type->pro_name }}</option>
    @endforeach
</select>
  

<script>
$('.select2').select2();
</script>