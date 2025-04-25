@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex align-items-center"
             style="border-bottom: 2px solid #ccc; padding-bottom: 0px; margin-bottom: 20px;">
             <a href="{{ route('incidents.index') }}" class="btn" style="color: black; margin-bottom: 15px; margin-right: 10px; display: flex; align-items: center;">
                <span class="material-symbols-outlined" style="margin-right: 2px;">arrow_back</span>
            </a>
            <h2 style="padding-bottom: 10px; margin-bottom: 10px;">Incident Details: {{ $incident->incident }}</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header" style="background-color: #7380EC; color: white;">
                    <h5 class="mb-0">Incident Information</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Incident Title</label>
                        <p class="form-control bg-light">{{ $incident->incident }}</p>
    </div>

    <div class="mb-3">
                        <label class="form-label fw-bold">Service Impacted</label>
                        <p class="form-control bg-light">{{ $incident->service }}</p>
    </div>

    <div class="mb-3">
                        <label class="form-label fw-bold">Impacted Assets</label>
                        <p class="form-control bg-light">{{ $incident->asset }}</p>
    </div>

    <div class="mb-3">
                        <label class="form-label fw-bold">Description</label>
                        <p class="form-control bg-light" style="min-height: 100px;">{{ $incident->incident_desc }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header" style="background-color: #7380EC; color: white;">
                    <h5 class="mb-0">Risk Assessment</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Probability</label>
                        <p class="form-control bg-light">{{ $incident->probability }} 
                            <small class="text-muted">
                                @if($incident->probability === 'Low')
                                    (Incident may occur once in a year)
                                @elseif($incident->probability === 'Medium')
                                    (Incident may occur once in 3 months)
                                @elseif($incident->probability === 'High')
                                    (Incident may occur once a month)
                                @endif
                            </small>
                        </p>
    </div>

    <div class="mb-3">
                        <label class="form-label fw-bold">Impact Intensity</label>
                        <p class="form-control bg-light">{{ $incident->risk_impact }}
                            <small class="text-muted">
                                @if($incident->risk_impact === 'Low')
                                    (Service is unavailable for < 6 hours)
                                @elseif($incident->risk_impact === 'Medium')
                                    (Service is unavailable for 6 - 24 hours)
                                @elseif($incident->risk_impact === 'High')
                                    (Service is unavailable for more than 24 hours)
                                @endif
                            </small>
                        </p>
    </div>

    <div class="mb-3">
                        <label class="form-label fw-bold">Priority</label>
                        <p class="form-control {{ getPriorityClass($incident->priority) }}">{{ $incident->priority }}</p>
                    </div>
                </div>
            </div>
            
            <div class="d-grid">
                <a href="{{ route('incidents.edit', $incident->id) }}" class="btn" style="background-color: #7380EC; color: white;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC'">
                    <span class="material-symbols-outlined align-middle me-1">edit</span> Edit Incident
                </a>
            </div>
        </div>
    </div>
@endsection

@php
function getPriorityClass($priority) {
    switch ($priority) {
        case 'Low':
            return 'bg-success text-white'; // Green background
        case 'Medium':
            return 'bg-warning'; // Yellow background
        case 'High':
            return 'bg-danger text-white'; // Red background
        default:
            return 'bg-light';
    }
}
@endphp
