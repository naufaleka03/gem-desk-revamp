@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb d-flex align-items-center justify-content-between"
         style="border-bottom: 2px solid #ccc; padding-bottom: 0px; margin-bottom: 20px;">
        <h2 style="padding-bottom: 10px; margin-bottom: 10px;">My Tickets</h2>
        @if(auth()->user()->roles === 'user')
            <a href="{{ route('tickets.create') }}" class="btn btn-primary" style="background-color: #7380EC; color: white; border: none; display: inline-flex; align-items: center; gap: 5px;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC'">
                <span class="material-symbols-outlined" style="font-size: 18px;">add</span>
                Create New Ticket</a>
        @endif
    </div>
</div>

@if($message = Session::get('success'))
    <div class="alert alert-success" id="alert">
        {{ $message }}
    </div>
@endif

<div class="card">
    <div class="card-header" style="background-color: #7380EC; color: white;">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="mb-0">All Tickets</h5>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Title</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Last Updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>
                                <span class="badge {{ $ticket->ticket_type == 'Incident' ? 'bg-danger' : 'bg-primary' }}">
                                    {{ $ticket->ticket_type }}
                                </span>
                            </td>
                            <td>{{ $ticket->title }}</td>
                            <td>
                                <span class="badge 
                                    @if($ticket->priority == 'High') bg-danger
                                    @elseif($ticket->priority == 'Medium') bg-warning
                                    @else bg-success
                                    @endif">
                                    {{ $ticket->priority }}
                                </span>
                            </td>
                            <td>
                                <span class="badge 
                                    @if($ticket->status == 'Open') bg-success
                                    @elseif($ticket->status == 'Closed') bg-secondary
                                    @else bg-info
                                    @endif">
                                    {{ $ticket->status }}
                                </span>
                            </td>
                            <td>{{ $ticket->updated_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('tickets.show', $ticket->id) }}" class="btn btn-sm btn-primary"
                                    class="btn" 
                                    style="background-color: #7380EC; color: white; border: none; display: inline-flex; align-items: center; gap: 5px;"
                                    onmouseover="this.style.backgroundColor='#8e98f5';" 
                                    onmouseout="this.style.backgroundColor='#7380EC'">
                                    <span class="material-symbols-outlined" style="font-size: 18px;">visibility</span>
                                    Details
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No tickets found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $tickets->links() }}
    </div>
</div>
@endsection