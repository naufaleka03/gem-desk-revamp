@extends('layouts.app')

@section('content')
    <div>
        <h1>Organization List</h1>
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="{{ route('organizations.create') }}" class="btn" style="background-color: #7380EC; color: white; border: none; display: inline-flex; align-items: center; gap: 5px;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC';">
                Add New Organization
            </a>
        </div>
    </div>
    <br>

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
        </symbol>
        <symbol id="info-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
        </symbol>
        <symbol id="exclamation-triangle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
        </symbol>
    </svg>

    @if ($message = Session::get('success'))
        <div class="alert alert-success d-flex align-items-center" role="alert" id="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                <use xlink:href="#check-circle-fill"/>
            </svg>
            <div>{{ $message }}</div>
        </div><br>
    @endif

    @if($message = Session::get('error'))
        <div class="alert alert-danger d-flex align-items-center" role="alert" id="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:">
                <use xlink:href="#exclamation-triangle-fill"/>
            </svg>
            <div>{{ $message }}</div>
        </div><br>
    @endif

    <div>
        <table class="table table-striped table-hover">
            <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Organization Name</th>
                <th scope="col">Industry Category</th>
                <th scope="col">State</th>
                <th scope="col">Country</th>
                <th scope="col">Action</th>
            </tr>
            </thead>

            @foreach ($organizations as $organization)
                @php
                    $number = 1;
                @endphp
                <tr>
                    <th scope="row">{{ $number++ }}</th>
                    <td>{{ $organization->organization_name }}</td>
                    <td>{{ $organization->industry_category }}</td>
                    <td>{{ $organization->city }}</td>
                    <td>{{ $organization->country }}</td>
                    <td>
                        <form action="{{ route('organizations.destroy',$organization->id) }}" method="POST">
                            <a href="{{ route ('organizations.show',$organization->id) }}" class="btn" style="background-color: #7380EC; color: white; border: none; display: inline-flex; align-items: center; gap: 5px;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC';">
                                <span class="material-symbols-outlined" style="font-size: 18px;">visibility</span>
                                Details
                            </a>
                            <a href="{{ route ('organizations.edit',$organization->id) }}" class="btn" style="background-color: #7380EC; color: white; border: none; display: inline-flex; align-items: center; gap: 5px;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC';">
                                <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                                Edit
                            </a>
                            @csrf
                            @method ('DELETE')
                            <button type="submit" class="btn btn-danger" style="display: inline-flex; align-items: center; gap: 5px;">
                                <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
    {{--  --}}
    {{--  <div clas="d-flex justify-content-start">--}}
    {{--    {{ $organizations->links() }}--}}
    {{--  </div>--}}

@endsection
