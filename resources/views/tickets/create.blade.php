@extends('layouts.app')

@section('content')
    <h1>Add Ticket</h1>
    <br>
    <link href="{{asset('css/file_upload.css')}}" rel="stylesheet" />
    <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data" name="formName">
        @csrf
        @if($errors->any())
            <div class="alert alert-danger" >
                <div class="alert-heading">
                    <h4>Snapped!!</h4>
                </div>
                There are something wrong with your input.
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if($message = Session::get('success'))
            <div class="alert alert-success" id="alert">
                {{ $message }}
            </div>
        @endif
        @if($message = Session::get('error'))
            <div class="alert alert-error" id="alert">
                {{ $message }}
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-header" style="background-color: #7380EC; color: white;">
                <h5 class="mb-0">Create Ticket</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label" for="title"><h2>Title</h2></label>
                    <input type="text" name="title" id="title" class="form-control" placeholder="write title here...." required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="description"><h2>Description</h2></label>
                    <textarea class="form-control" name="description" id="description" rows="3" placeholder="write description here...." required></textarea>
                </div>
                <div class="mb-3">
                    <label for="ticketType" class="form-label"><h2>Ticket Type</h2></label>
                    <div class="input-group">
                        <select id="ticketType" name="ticket_type" class="form-select">
                            @forelse($incidents as $incident)
                                <option value="{{ $incident->incident }}">{{ $incident->incident }}</option>
                            @empty
                                <option>There's no incident</option>
                            @endforelse
                        </select>
                        <a class="btn btn-outline-warning rounded" href="{{route('incidentTemps.create')}}" role="button">No Types</a>
                        <div id="ticketTypeHelp" class="input-group form-text">
                            If there's no type, you can request a new type so admin can added it.
                        </div>
                    </div>
                </div>
                @if(isset($isAdmin) && $isAdmin)
                <div class="mb-3">
                    <label class="form-label">Assign To</label>
                    <select class="form-select" name="assignee_id">
                        <option value="">Unassigned</option>
                        @foreach($admins as $admin)
                            <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div class="form-group mb-3">
                    <div class="upload-container">
                        <div class="border-container">
                            <div class="icons fa-4x">
                                <i class="fas fa-file-image" data-fa-transform="shrink-3 down-2 left-6 rotate--45"></i>
                                <i class="fas fa-file-alt" data-fa-transform="shrink-2 up-4"></i>
                                <i class="fas fa-file-pdf" data-fa-transform="shrink-3 down-2 right-6 rotate-45"></i>
                            </div>
                            <input type="file" class="form-control" name="file" id="file_upload" placeholder=""
                                   aria-describedby="fileHelpId">
                            <p>Drag and drop files here, or browse from computer</p>
                        </div>
                    </div>
                </div>
                <div class="form-group d-flex flex-row-reverse">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
@endsection




