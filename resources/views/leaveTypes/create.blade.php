  @extends('layouts.app')

@section('content')
  <div class="container mt-5">
    <h2>Add New Leave Type</h2>
    <form action="{{ route('leaveTypes.store') }}" method="POST">
      @csrf
      <div class="mb-3">
        <label for="namaLeaveType">Name Leaves Type</label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>

      <div class="mb-3">
        <label >Description</label>
          <textarea class="form-control" id="description" name="description" rows="3" required>
          </textarea>
      </div>

      <div class="mb-3">
        <label for="durationLeaveType">Maximum Duration (Days)</label>
        <input type="number" class="form-control" id="duartionLeaveType" name="max_duration" required>
      </div>

      <button type="submit" class="btn btn-primary">Add</button>
      <a href="{{route('leaveTypes.index')}}" class="btn btn-secondary">Cancel</a>
    </form>
  </div>

@endsection
