@extends('layouts.app')

@section('content')
<div>
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex align-items-center"
             style="border-bottom: 2px solid #ccc; padding-bottom: 0px; margin-bottom: 20px;">
            <a href="{{ route('userManagements.index') }}" class="btn" style="color: black; margin-bottom: 15px; margin-right: 10px; display: flex; align-items: center;">
                <span class="material-symbols-outlined" style="margin-right: 2px;">arrow_back</span>
            </a>
            <h2 style="padding-bottom: 10px; margin-bottom: 10px;">Edit User</h2>
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

        <form action="{{ route('userManagements.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')

        <div class="card mb-4">
            <div class="card-body">
                <!-- User Account Section -->
                <h4 class="mb-3" style="border-bottom: 2px solid #7380EC; padding-bottom: 10px; color: #7380EC;">User Account</h4>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Name:</strong></label>
                    <input type="text" name="name" class="form-control" placeholder="Name" value="{{ $user->name }}">
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Username:</strong></label>
                    <input type="text" name="username" class="form-control" placeholder="Username" value="{{ $user->username }}">
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Password:</strong></label>
                    <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current password">
            </div>

            <div class="mb-3">
                    <label class="form-label"><strong>Confirm Password:</strong></label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password">
                </div>
                
                <!-- Employee Data Section -->
                <h4 class="mb-3 mt-5" style="border-bottom: 2px solid #7380EC; padding-bottom: 10px; color: #7380EC;">Employee Data</h4>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Employee ID:</strong></label>
                    <input type="text" name="employee_id" class="form-control" placeholder="Employee ID" value="{{ $user->employee_id }}">
            </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Organization:</strong></label>
                <select name="organization_id" id="organization_select" class="form-control">
                    <option value="">Select Organization</option>
                    @foreach ($organizations as $organization)
                            <option value="{{ $organization->id }}" @if($user->organization_id == $organization->id) selected @endif>
                            {{ $organization->organization_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
                <div class="mb-3">
                    <label class="form-label"><strong>Department:</strong></label>
                <select name="department_name" id="department_select" class="form-control">
                    <option value="">Select Department</option>
                </select>
            </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Role:</strong></label>
                    <select name="roles" class="form-control">
                        <option value="admin" @if($user->roles == 'admin') selected @endif>Admin</option>
                        <option value="user" @if($user->roles == 'user') selected @endif>User</option>
                </select>
            </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Mobile:</strong></label>
                    <input type="text" name="mobile" class="form-control" placeholder="Mobile Number" value="{{ $user->mobile }}">
            </div>

            <div class="mb-3">
                    <label class="form-label"><strong>Email:</strong></label>
                    <input type="email" name="email" class="form-control" placeholder="Email" value="{{ $user->email }}">
                </div>
                
                <div class="mb-4">
                    <label class="form-label"><strong>Profile Picture:</strong></label>
                    <input type="file" name="profile_picture" class="form-control">
                    @if($user->profile_picture)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $user->profile_picture) }}" alt="Current profile picture" style="max-width: 100px; max-height: 100px;">
                            <p class="text-muted">Current profile picture</p>
                        </div>
                    @endif
                </div>
                
                <div class="text-end">
                    <button type="submit" class="btn btn-lg" style="background-color: #7380EC; border-color: #7380EC; color: white;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC';">
                        Update
                    </button>
                </div>
            </div>
        </div>
        </form>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const organizationSelect = document.getElementById('organization_select');
        const departmentSelect = document.getElementById('department_select');
        
        // Function to load departments
        function loadDepartments(organizationId) {
            if (!organizationId) {
                departmentSelect.innerHTML = '<option value="">Select Department</option>';
                return;
            }
            
            // AJAX call to get departments
            fetch(`/getdepartments/${organizationId}`)
                .then(response => response.json())
                .then(data => {
                    departmentSelect.innerHTML = '<option value="">Select Department</option>';
                    data.forEach(department => {
                        const option = document.createElement('option');
                        option.value = department.department_name;
                        option.textContent = department.department_name;
                        departmentSelect.appendChild(option);
                    });
                    
                // Select the current department
                if ("{{ $user->department_name }}") {
                        document.querySelectorAll('#department_select option').forEach(option => {
                            if (option.value === "{{ $user->department_name }}") {
                                option.selected = true;
                            }
                        });
                }
                });
        }
        
        // Load departments when organization changes
        organizationSelect.addEventListener('change', function() {
            loadDepartments(this.value);
        });
        
        // Load departments on page load if organization is selected
        if (organizationSelect.value) {
            loadDepartments(organizationSelect.value);
        }
    });
</script>
@endsection