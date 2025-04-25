@extends('layouts.app')

@section('content')
    <div class="d-flex">
        <h1 class="font-weight-bold justify-content-start">Incident Request</h1>
    </div>
    <br>
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
    <div>
        <table class="table">
            <thead>
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
            @forelse($incidentTemps as $incidentTemp)
                <tr>
                    <td>{{$loop->index+1}}</td>
                    <td>{{ $incidentTemp->incident }}</td>
                    <td>{{ $incidentTemp->service }}</td>
                    <td>{{ $incidentTemp->asset }}</td>
                    <td>{{ $incidentTemp->probability }}</td>
                    <td>{{ $incidentTemp->risk_impact }}</td>
                    <td>{{ $incidentTemp->priority }}</td>
                    <td class="d-flex justify-content-center">
                        <form action="{{ route('incidentTemps.storeToIncidents', $incidentTemp)}}" method="POST">
                            @csrf
                            <button class="btn btn-primary me-1" type="submit">Accept</button>
                        </form>
                        <a class="btn btn-danger me-1" href="#" onclick="
                            event.preventDefault();
                            if(confirm('Do you want to delete this ?')){
                                document.getElementById('delete-row-{{ $incidentTemp->id }}').submit();
                            }
                        ">Delete</a>
                        <form id="delete-row-{{$incidentTemp->id}}"
                              action="{{route('incidentTemps.destroy', $incidentTemp->id)}}" method="post">
                            <input type="hidden" name="_method" value="DELETE">
                            @csrf
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">
                        <div class="d-flex justify-content-center">
                            No Record Found
                        </div>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-3" style="text-align: center;">
        </div>
    </div>
@endsection

