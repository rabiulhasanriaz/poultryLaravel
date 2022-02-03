<form action="{{ route('inventory.product.group.group-update',$group->id) }}" method="post">
    @csrf
    <div class="card-body">
      <div class="form-group">
        <label for="exampleInputEmail1">Product Group Name <i class="text-danger">*</i></label>
        <input type="text" name="g_name" class="form-control" value="{{ $group->name }}" id="exampleInputEmail1" placeholder="Enter Product Group Name">
      </div>
      @error('g_name')
            <p class="text-danger">{{ $errors->first('g_name') }}</p>
      @enderror
    </div>
    <!-- /.card-body -->

    <div class="card-footer">
      <button type="submit" class="float-right btn btn-primary">Submit</button>
    </div>
  </form>