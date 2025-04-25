<!-- resources/views/tickets/show.blade.php -->
@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb d-flex align-items-center"
         style="border-bottom: 2px solid #ccc; padding-bottom: 0px; margin-bottom: 20px;">
        <a href="{{ route('tickets.index') }}" class="btn" style="color: black; margin-bottom: 15px; margin-right: 10px; display: flex; align-items: center;">
            <span class="material-symbols-outlined" style="margin-right: 2px;">arrow_back</span>
        </a>
        <h2 style="padding-bottom: 10px; margin-bottom: 10px;">Ticket #{{ $ticket->id }}</h2>
    </div>
</div>

@if($message = Session::get('success'))
    <div class="alert alert-success" id="alert">
        {{ $message }}
    </div>
@endif

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header" style="background-color: #7380EC; color: white;">
                <h5 class="mb-0">{{ $ticket->title }}</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-3">
                    <span class="badge bg-secondary">{{ $ticket->ticket_type }}</span>
                    @php
                        $priority = $ticket->priority ?? 'Low';
                        switch ($priority) {
                            case 'High':
                                $priorityClass = 'bg-danger text-white';
                                break;
                            case 'Medium':
                                $priorityClass = 'bg-warning text-dark';
                                break;
                            case 'Low':
                            default:
                                $priorityClass = 'bg-success text-white';
                                break;
                        }
                    @endphp
                    <span class="badge {{ $priorityClass }}">{{ $priority }}</span>
                </div>
                
                <h6 class="text-muted mb-3">
                    Submitted by: {{ $ticket->user ? $ticket->user->name : 'Unknown User' }} on {{ $ticket->created_at->format('M d, Y h:i A') }}
                </h6>
                
                <div class="mb-4">
                    <h6>Description:</h6>
                    <p>{{ $ticket->description }}</p>
                </div>
                
                @if($ticket->request_type == 'incident' && $ticket->incidentRequest)
                    <div class="mb-4">
                        <h6>Incident Details:</h6>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 30%">Service Impacted</th>
                                <td>{{ $ticket->incidentRequest->service }}</td>
                            </tr>
                            <tr>
                                <th>Assets Affected</th>
                                <td>{{ $ticket->incidentRequest->asset }}</td>
                            </tr>
                            <tr>
                                <th>Probability</th>
                                <td>{{ $ticket->incidentRequest->probability }}</td>
                            </tr>
                            <tr>
                                <th>Impact</th>
                                <td>{{ $ticket->incidentRequest->risk_impact }}</td>
                            </tr>
                            <tr>
                                <th>Incident Date</th>
                                <td>{{ \Carbon\Carbon::parse($ticket->incidentRequest->incident_date)->format('M d, Y') }}</td>
                            </tr>
                        </table>
                    </div>
                @endif
                
                @if($ticket->request_type == 'asset' && $ticket->assetRequest)
                    <div class="mb-4">
                        <h6>Asset Request Details:</h6>
                        <table class="table table-bordered">
                            <tr>
                                <th style="width: 30%">Asset Type</th>
                                <td>{{ $ticket->assetRequest->asset_type }}</td>
                            </tr>
                            <tr>
                                <th>Need By Date</th>
                                <td>{{ $ticket->assetRequest->need_by_date ? \Carbon\Carbon::parse($ticket->assetRequest->need_by_date)->format('M d, Y') : 'Not specified' }}</td>
                            </tr>
                            <tr>
                                <th>Specifications</th>
                                <td>{{ $ticket->assetRequest->specifications ?? 'Not provided' }}</td>
                            </tr>
                            <tr>
                                <th>Purpose</th>
                                <td>{{ $ticket->assetRequest->purpose }}</td>
                            </tr>
                            <tr>
                                <th>Priority</th>
                                <td><span class="badge {{ $priorityClass }}">{{ $priority }}</span></td>
                            </tr>
                        </table>
                    </div>
                @endif
                
                @php
                    $files = is_array($ticket->files) ? $ticket->files : json_decode($ticket->files, true);
                @endphp
                @if($files)
                    <div class="mb-4">
                        <h6>Attachments / Evidence:</h6>
                        @foreach($files as $file)
                            @php
                                $fileUrl = asset('storage/' . $file);
                                $isImage = in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);
                            @endphp
                            <div class="mb-2">
                                @if($isImage)
                                    <img src="{{ $fileUrl }}" alt="Attachment" style="max-width: 100%; max-height: 300px; display: block; margin-bottom: 5px;">
                                @endif
                                <a href="{{ $fileUrl }}" target="_blank">{{ basename($file) }}</a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Comments Section -->
        <div class="card mb-4">
            <div class="card-header" style="background-color: #7380EC; color: white;">
                <h5 class="mb-0">Communication</h5>
            </div>
            <div class="card-body">
                @php
                    $comments = $ticket->comments ? json_decode($ticket->comments, true) : [];
                @endphp

                @if(count($comments) > 0)
                    <div class="comments-container mb-4">
                        @foreach($comments as $comment)
                            <div class="card mb-3 {{ $comment['user_id'] == auth()->id() ? 'border-primary' : '' }}">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $comment['user_name'] }}</strong>
                                    </div>
                                    <small class="text-muted">{{ \Carbon\Carbon::parse($comment['created_at'])->format('M d, Y h:i A') }}</small>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">{{ $comment['message'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-muted">No comments yet</p>
                @endif
                
                <form action="{{ route('tickets.comment', $ticket->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="message" class="form-label">Add Comment</label>
                        <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="sendNotification" name="send_notification" checked>
                                <label class="form-check-label" for="sendNotification">
                                    Notify requester via email
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn" style="background-color: #7380EC; color: white;">
                            Post Comment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header" style="background-color: #7380EC; color: white;">
                <h5 class="mb-0">Ticket Actions</h5>
            </div>
            <div class="card-body">
                @php
                    $isAdmin = auth()->user()->roles === 'admin';
                @endphp

                @if($isAdmin)
                    <div class="mb-3">
                        <label class="form-label">Assigned To</label>
                        <input type="text" class="form-control" value="{{ $ticket->assignee ? $ticket->assignee->name : 'Unassigned' }}" readonly>
                    </div>
                    <form action="{{ route('tickets.updateStatus', $ticket->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="status" class="form-label">Update Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="in progress" {{ $ticket->status == 'in progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="on hold" {{ $ticket->status == 'on hold' ? 'selected' : '' }}>On Hold</option>
                                <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn" style="background-color: #7380EC; color: white;">
                                Update Ticket
                            </button>
                        </div>
                    </form>
                @else
                    <div class="d-grid">
                        <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-outline-primary mb-2">
                            Edit Ticket
                        </a>
                        <button type="button" class="btn btn-outline-danger" onclick="confirmDelete({{ $ticket->id }})">
                            Delete Ticket
                        </button>
                        <form id="delete-form-{{ $ticket->id }}" action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                @endif
                
                <hr>
                
                @if($ticket->request_type == 'incident' && $ticket->incidentRequest && $ticket->incidentRequest->status == 'Pending')
                    <div class="d-flex gap-2 mb-3">
                        <form action="{{ route('incidentRequests.approve', $ticket->incidentRequest->id) }}" method="POST" class="w-50">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">Approve Request</button>
                        </form>
                        <button type="button" class="btn btn-danger w-50" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            Reject Request
                        </button>
                    </div>
                @endif
                
                @if($ticket->request_type == 'asset' && $ticket->assetRequest && $ticket->assetRequest->status == 'Pending')
                    <div class="d-flex gap-2 mb-3">
                        <form action="{{ route('assetRequests.approve', $ticket->assetRequest->id) }}" method="POST" class="w-50">
                            @csrf
                            <button type="submit" class="btn btn-success w-100">Approve Request</button>
                        </form>
                        <button type="button" class="btn btn-danger w-50" data-bs-toggle="modal" data-bs-target="#rejectModal">
                            Reject Request
                        </button>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card mb-4">
            <div class="card-header" style="background-color: #7380EC; color: white;">
                <h5 class="mb-0">Ticket Information</h5>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Ticket ID:</span>
                        <strong>{{ $ticket->id }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Created:</span>
                        <strong>{{ $ticket->created_at->format('M d, Y') }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Last Updated:</span>
                        <strong>{{ $ticket->updated_at->format('M d, Y') }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Type:</span>
                        <strong>{{ $ticket->ticket_type }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Requester:</span>
                        <strong>{{ $ticket->user->name }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Assigned To:</span>
                        <strong>{{ $ticket->assignee ? $ticket->assignee->name : 'Unassigned' }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Priority:</span>
                        <span class="badge {{ $priorityClass }}">{{ $priority }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">Reject Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @if(
                ($ticket->request_type == 'incident' && $ticket->incidentRequest) ||
                ($ticket->request_type == 'asset' && $ticket->assetRequest)
            )
                <form action="{{ route(
                    $ticket->request_type == 'incident' ? 'incidentRequests.reject' : 'assetRequests.reject',
                    $ticket->request_type == 'incident' ? $ticket->incidentRequest->id : $ticket->assetRequest->id
                ) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="reject_reason" class="form-label">Reason for Rejection</label>
                            <textarea class="form-control" id="reject_reason" name="reject_reason" rows="3" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject Request</button>
                    </div>
                </form>
            @else
                <div class="modal-body">
                    <div class="alert alert-warning mb-0">
                        No related request found for this ticket.
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this ticket?')) {
            document.getElementById('delete-form-' + id).submit();
        }
    }
</script>
@endsection 