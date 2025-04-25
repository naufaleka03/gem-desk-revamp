@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex align-items-center"
             style="border-bottom: 2px solid #ccc; padding-bottom: 0px; margin-bottom: 20px;">
            <a href="{{ route('tickets.show', $ticket->id) }}" class="btn" style="color: black; margin-bottom: 15px; margin-right: 10px; display: flex; align-items: center;">
                <span class="material-symbols-outlined" style="margin-right: 2px;">arrow_back</span>
            </a>
            <h2 style="padding-bottom: 10px; margin-bottom: 10px;">Edit Ticket #{{ $ticket->id }}</h2>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header" style="background-color: #7380EC; color: white;">
                        <h5 class="mb-0">Ticket Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title" value="{{ $ticket->title }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5" required>{{ $ticket->description }}</textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="ticket_type" class="form-label">Ticket Type</label>
                            <select class="form-select" id="ticket_type" name="ticket_type" required>
                                <option value="Incident" {{ $ticket->ticket_type == 'Incident' ? 'selected' : '' }}>Incident</option>
                                <option value="Asset" {{ $ticket->ticket_type == 'Asset' ? 'selected' : '' }}>Asset</option>
                                <option value="Service" {{ $ticket->ticket_type == 'Service' ? 'selected' : '' }}>Service</option>
                                <option value="Other" {{ $ticket->ticket_type == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                                        <option value="in progress" {{ $ticket->status == 'in progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="on hold" {{ $ticket->status == 'on hold' ? 'selected' : '' }}>On Hold</option>
                                        <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                        <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="priority" class="form-label">Priority</label>
                                    <select class="form-select" id="priority" name="priority" required>
                                        <option value="Low" {{ $ticket->priority == 'Low' ? 'selected' : '' }}>Low</option>
                                        <option value="Medium" {{ $ticket->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="High" {{ $ticket->priority == 'High' ? 'selected' : '' }}>High</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="internal_notes" class="form-label">Internal Notes (Admin Only)</label>
                            <textarea class="form-control" id="internal_notes" name="internal_notes" rows="3">{{ $ticket->internal_notes }}</textarea>
                            <small class="text-muted">These notes are visible only to administrators.</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header" style="background-color: #7380EC; color: white;">
                        <h5 class="mb-0">Assignment</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="requester" class="form-label">Requester</label>
                            <select class="form-select" id="requester" name="user_id" required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $ticket->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="assignee" class="form-label">Assign To</label>
                            <select class="form-select" id="assignee" name="assignee_id">
                                <option value="">Unassigned</option>
                                @foreach($admins as $admin)
                                    <option value="{{ $admin->id }}" {{ $ticket->assignee_id == $admin->id ? 'selected' : '' }}>
                                        {{ $admin->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="due_date" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" value="{{ $ticket->due_date }}">
                        </div>
                    </div>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-lg" style="background-color: #7380EC; color: white;">
                        Update Ticket
                    </button>
                    <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-lg btn-outline-secondary">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>
@endsection



