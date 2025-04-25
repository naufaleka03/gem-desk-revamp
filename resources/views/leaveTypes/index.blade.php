@extends('layouts.app')

@section('content')
    <h1>Leave Type</h1>
    <a href="{{route('leaveTypes.create')}}" type="submit" class="btn btn-primary" style="margin-bottom:1%">Add</a>
    @if ($message = Session::get('success'))
        <div class="alert alert-success" role="alert" id="alert" style="margin-top: 1%">
            {{$message}}
        </div>
    @endif
    <table class="table">
        <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Leave Name</th>
            <th scope="col">Maximum Duration (Days)</th>
            <th scope="col">Status</th>
            <th scope="col" class="d-flex justify-content-center">Action</th>
        </tr>
        </thead>

        <tbody>
        @php
            $number = 1;
        @endphp
        @forelse ($leaveTypes as $index => $leaveType)
            <tr>
                <th scope="row">{{ $number ++ }}</th>
                <td>{{ $leaveType->name}}</td>
                <td>{{ $leaveType->max_duration}}</td>
                <td> {{ $leaveType->status}} </td>
                <td class="d-flex justify-content-center">
                    @role('admin')
                        @if($leaveType->status != 'approved')
                            <form action="{{route('leaveTypes.approve', $leaveType)}}" method="post">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success me-1"  href="{{ route('leaveTypes.index') }}">
                                    Approve
                                </button>
                            </form>
                        @endif
                    @endrole

                    <a href="{{ route('leaveTypes.show', $leaveType->id) }}" class="btn btn-info me-1"
                        style="margin-right: 2%">Show</a>
                    <a class="btn btn-danger me-1" href="#" onclick="
                            event.preventDefault();
                            if(confirm('Do you want to delete this ?')){
                                document.getElementById('delete-row-{{ $leaveType->id }}').submit();}">Delete</a>
                        <form id="delete-row-{{$leaveType->id}}" action="{{route('leaveTypes.destroy', $leaveType->id)}}"
                            method="post">
                        <input type="hidden" name="_method" value="DELETE">
                        @csrf
                        </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">
                    <div class="d-flex justify-content-center">
                        No Record Found
                    </div>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="mt-3" style="text-align: center;">
        {{  $leaveTypes->withQueryString()->links() }}
    </div>
@endsection
@push('script')
@endpush
