@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <h1>User Management/Users Table</h1>

    @if ($message = Session::get('success'))
        <div class="alert alert-success" role='alert' id="alert" style="margin-top: 1%">
            {{$message}}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        @role('admin')
        <a href="{{route('userManagements.create')}}" class="btn" style="background-color: #7380EC; color: white; border: none; display: inline-flex; align-items: center; gap: 5px;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC';">
            <span class="material-symbols-outlined" style="font-size: 18px;">add</span>
            Add User
        </a>
        @endrole
        
        <form action="{{ route('userManagements.index') }}" method="GET">
            <div class="input-group" style="width: 300px;">
                <input type="text" class="form-control" placeholder="Search..." name="q" id="search" autocomplete="off">
            </div>
        </form>
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Name</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Employee ID</th>
            <th scope="col">Organization</th>
            <th scope="col">Department Name</th>
            <th scope="col">Roles</th>
            <th scope="col">Mobile</th>
            <th scope="col" class="text-center">Action</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($users as $index => $user)
            <tr>
                <th scope="row">{{$index + $users->firstItem()}}</th>
                <td>{{$user->name}}</td>
                <td>{{$user->username}}</td>
                <td>{{$user->email}}</td>
                <td>{{$user->employee_id}}</td>
                <td>{{$user->organization ? $user->organization->organization_name : "Not assigned"}}</td>
                <td>{{$user->department_name ?? "Not assigned"}}</td>
                <td>{{$user->roles}}</td>
                <td>{{$user->mobile}}</td>
                <td class="text-center">
                    @role('admin')
                    <a href="{{ route('userManagements.edit', $user->id) }}" class="btn" style="background-color: #7380EC; color: white; border: none; display: inline-flex; align-items: center; gap: 5px; margin-right: 5px;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC';">
                        <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                        Edit
                    </a>
                    <form action="{{ route('userManagements.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" style="display: inline-flex; align-items: center; gap: 5px;">
                            <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                            Delete
                        </button>
                    </form>
                    @endrole
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="mt-3" style="text-align: center;">
        {{  $users->withQueryString()->links() }}
    </div>
</div>
@endsection
@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $('#search').on('keyup', function () {
            var query = $(this).val();
            if (query !== '') {
                $.ajax({
                    url: "{{ route('userManagements.index') }}",
                    type: "GET",
                    data: {'query': query},
                    success: function (data) {
                        $('tbody').empty().html(data);
                    }
                })
            } else {
                $('tbody').empty();
                @foreach($users as $index => $user)
                $('tbody').append(`
          <tr>
              <td>{{ $loop->index + 1 }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->username }}</td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->employee_id }}</td>
              <td>{{ $user->organization ? $user->organization->organization_name : "Not assigned" }}</td>
              <td>{{ $user->department_name ?? "Not assigned" }}</td>
              <td>{{ $user->roles }}</td>
              <td>{{ $user->mobile }}</td>
              <td class="d-flex justify-content-center">
                  @role('admin')
                  <a href="{{ route('userManagements.edit', $user->id) }}" class="btn" style="background-color: #7380EC; color: white; border: none; display: inline-flex; align-items: center; gap: 5px; margin-right: 5px;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC';">
                      <span class="material-symbols-outlined">edit</span>
                      Edit
                  </a>
                  <form action="{{ route('userManagements.destroy', $user->id) }}" method="post">
                  @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" style="display: inline-flex; align-items: center; gap: 5px;">
                        <span class="material-symbols-outlined">delete</span>
                        Delete
                    </button>
                  </form>
                  @endrole
                </td>
            </tr>`
                );
                @endforeach
            }
        });
    </script>
@endpush