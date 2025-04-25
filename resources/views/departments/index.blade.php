@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Departments</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('departments.create') }}">Create New Department</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <div class="row mt-4">
        @forelse($departments as $department)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h4>{{ $department->department_name }}</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>Description:</strong> {{ $department->description }}</p>
                        <p><strong>Department Head:</strong> {{ $department->department_head ?? 'Not assigned' }}</p>
                        
                        <h5 class="mt-4">Team Members</h5>
                        <ul class="list-group">
                            @php
                                $users = \App\Models\User::where('department_name', $department->department_name)->get();
                            @endphp
                            
                            @forelse($users as $user)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $user->name }}
                                    <span class="badge rounded-pill bg-primary">{{ $user->roles }}</span>
                                </li>
                            @empty
                                <li class="list-group-item">No team members assigned yet</li>
                            @endforelse
                        </ul>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <a class="btn btn-primary" href="{{ route('departments.edit', $department->id) }}">Edit</a>
                        <form action="{{ route('departments.destroy', $department->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">No departments found</div>
            </div>
        @endforelse
    </div>
@endsection
