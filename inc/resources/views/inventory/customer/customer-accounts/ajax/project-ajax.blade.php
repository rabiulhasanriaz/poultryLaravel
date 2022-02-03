<select class="form-control select2" name="project" required >
    <option value="">Select</option>
    @foreach($projects as $project)
      <option value="{{ $project->id }}" {{ old('project') == $project->id ? 'selected' : '' }}>
        {{ $project->name }}
      </option>
    @endforeach
</select>
  