@extends('layouts.app')

@section('content')
  <h2>{{ $department->department_name }}</h2>

  <div class="d-grid gap-2 d-md-block">
    <a class="btn btn-primary" href="{{ route('organizations.index') }}" role="button">Back</a>
  </div>
  <br>
                  
  <div class="card-body">
    <h3 class="card-title">Description:</h3>
    <p>{{ $department->description }}</p><br>

    <h3 class="card-title">Department Head:</h3>
    <p>{{ $department->department_head }}</p><br>
      
    @csrf
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
      <a href="{{ route('departments.edit',$department->id) }}" class="btn btn-primary">Edit Detail</a>
    </div>
  </div>
@endsection