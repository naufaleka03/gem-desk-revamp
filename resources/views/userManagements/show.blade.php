@extends('layouts.app')

@section('content')
    <h1>User Management</h1>
    <br>
    <div class="container">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" class="form-control" name="email" value="{{ $user->email }}" disabled>
        </div>

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" value="{{ $user->name }}" disabled>
        </div>

        <div class="mb-3">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" value="{{ $user->username }}" disabled>
        </div>

        <div class="form-group">
            <label for="employee_id">Employee ID</label>
            <input type="text" class="form-control" name="employee_id" value="{{ $user->employee_id }}" disabled>
        </div>

        <div class="form-group">
            <label for="department">Department Name</label>
            <input type="text" class="form-control" name="department_name" value="{{ $user->department_name }}"
                   disabled>
        </div>

        <div class="form-group">
            <label for="roles">Roles</label>
            <input type="text" class="form-control" id="roles" name="roles" value="{{ $user->roles }}" disabled>
        </div>

        <div class="form-group">
            <label for="mobile">Mobile</label>
            <input type="text" class="form-control" name="mobile" value=" {{$user->mobile }}" disabled>
        </div>

        <a class="btn btn-danger mt-2" href="{{ route('userManagements.index') }}">Back</a>
    </div>

@endsection

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
                
                // If editing, select the current department
                @if(isset($user) && $user->department_name)
                    document.querySelectorAll('#department_select option').forEach(option => {
                        if (option.value === "{{ $user->department_name }}") {
                            option.selected = true;
                        }
                    });
                @endif
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