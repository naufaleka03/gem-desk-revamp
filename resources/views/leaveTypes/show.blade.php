@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Leave Type</h2>
        <div class="mb-3">
            <label for="namaLeaveTypeUpdate">Name Leaves Type</label>
            <input type="text" class="form-control" id="name" name="nameLeavetype"
                   value="{{$leaveType->name}}" disabled>
        </div>
        <div class="mb-3">
            <label for="deskripsiLeaveTypeUpdate">Description</label>
            <input class="form-control" id="description" name="description" rows="3" value="{{$leaveType->description}}"
                   disabled>
        </div>
        <div class="mb-3">
            <label for="duartionLeaveTypeUpdate">Maximum Duration (Days)</label>
            <input type="number" class="form-control" id="maxDuration" name="max_duration"
                   value="{{$leaveType->max_duration}}" disabled>
        </div>
        <a href="{{route('leaveTypes.index')}}" class="btn btn-secondary">Back</a>
    </div>

@endsection