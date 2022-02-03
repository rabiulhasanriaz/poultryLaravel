<form action="{{ route('inventory.product.type.type-update',$type->id) }}" method="post">
    @csrf
    <div class="card-body">

      <div class="form-group">
        <label>Group <i class="text-danger">*</i></label>
        <select class="form-control select2" name="g_id" style="width: 100%;">
         <option value="">Select Group</option>
         @foreach ($groups as $item)
             <option value="{{ $item->id }}" {{ $type->group_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
         @endforeach
        </select>
        @error('g_id')
            <p class="text-danger">{{ $errors->first('g_id') }}</p>
        @enderror
      </div>

      <div class="form-group">
        <label for="exampleInputEmail1">Type Name <i class="text-danger">*</i></label>
        <input type="text" name="t_name" class="form-control" value="{{ $type->name }}" id="exampleInputEmail1" placeholder="Enter Type">
        @error('t_name')
          <p class="text-danger">{{ $errors->first('t_name') }}</p>
        @enderror
      </div>

    </div>
    <!-- /.card-body -->

    <div class="card-footer">
      <button type="submit" class="float-right btn btn-primary">Create</button>
    </div>
  </form>

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
       $(document).ready(function() {
    $('.select2').select2();
});
</script>