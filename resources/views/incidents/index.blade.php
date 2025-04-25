@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex align-items-center"
             style="border-bottom: 2px solid #ccc; padding-bottom: 0px; margin-bottom: 20px;">
            <h2 style="padding-bottom: 10px; margin-bottom: 10px;">Incident Records</h2>
        </div>
    </div>

    <div class="mb-3">
        <a href="{{ route('incidents.create') }}" class="btn" style="background-color: #7380EC; color: white; border: none; display: inline-flex; align-items: center; gap: 5px;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC'">
            <span class="material-symbols-outlined" style="font-size: 18px;">add</span>
            Add Incident
        </a>
    </div>

    <div class="mb-3">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead style="background-color: #f3f4f6;">
                    <tr>
                        <th>No</th>
                        <th>Incident</th>
                        <th>Service Impacted</th>
                        <th>Asset</th>
                        <th>Probability</th>
                        <th>Risk Impact</th>
                        <th>Priority</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php $number = 1; @endphp
                    @foreach($data as $incident)
                    <tr>
                        <td>{{ $number++ }}</td>
                        <td>{{ $incident->incident }}</td>
                        <td>{{ $incident->service }}</td>
                        <td>{{ $incident->asset }}</td>
                        <td>{{ $incident->probability }}</td>
                        <td>{{ $incident->risk_impact }}</td>
                        <td class="{{ getPriorityClass($incident->priority) }}">{{ $incident->priority }}</td>
                        <td style="display: flex; gap: 5px;">
                            <a href="{{ route('incidents.show', $incident->id) }}" 
                                class="btn" 
                                style="background-color: #7380EC; color: white; border: none; display: inline-flex; align-items: center; gap: 5px;"
                                onmouseover="this.style.backgroundColor='#8e98f5';" 
                                onmouseout="this.style.backgroundColor='#7380EC'">
                                <span class="material-symbols-outlined" style="font-size: 18px;">visibility</span>
                                Details
                            </a>
                            <a href="{{ route('incidents.edit', $incident->id) }}" 
                                class="btn" 
                                style="background-color: #7380EC; color: white; border: none; display: inline-flex; align-items: center; gap: 5px;"
                                onmouseover="this.style.backgroundColor='#8e98f5';" 
                                onmouseout="this.style.backgroundColor='#7380EC'">
                                <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                                Edit
                            </a>
                            <form action="{{ route('incidents.destroy', $incident->id)}}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit" style="display: inline-flex; align-items: center; gap: 5px;">
                                    <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection

@php
function getPriorityClass($priority) {
    switch ($priority) {
        case 'Low':
            return 'table-success'; // Green background
        case 'Medium':
            return 'table-warning'; // Yellow background
        case 'High':
            return 'table-danger'; // Red background
        default:
            return '';
    }
}
@endphp
