@extends('layouts.app')

@section('content')
  <h2>{{ $organization->organization_name }}</h2>

  <div class="d-grid gap-2 d-md-block">
    <a class="btn btn-gem" href="{{ route('organizations.index') }}" role="button">Back</a>
  </div>
  <br>

  <div class="card">
    <div class="card-header">
      <ul class="nav nav-tabs card-header-tabs" id="organizationTabs" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">Profile</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="departments-tab" data-bs-toggle="tab" data-bs-target="#departments" type="button" role="tab">Departments</button>
        </li>
      </ul>
    </div>
                  
    <div class="card-body">
      <div class="tab-content" id="organizationTabsContent">
        <!-- Profile Tab -->
        <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
          <h3 class="card-title">Description</h3>
          <p>{{ $organization->description }}</p><br>

          <h3 class="card-title">Industry Category</h3>
          <p>{{ $organization->industry_category }}</p><br>
          
          <h3 class="card-title">Address</h3>
          <p>{{ $organization->address }}, {{ $organization->city }}, {{ $organization->postal_code }}</p><br>

          <h3 class="card-title">State</h3>
          <p>{{ $organization->state }}</p><br>

          <h3 class="card-title">Country</h3>
          <p>{{ $organization->country }}</p><br>
                        
          <h3 class="card-title">Contact Information</h3>
          <p>
              - Email: {{ $organization->email }}<br>
              - Phone Number: {{ $organization->phone_no }}<br>
              - Fax Number: {{ $organization->fax_no }}<br>
              - Web url: {{ $organization->web_url }}
          </p>
          <br>
          
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <a href="{{ route('organizations.edit',$organization->id) }}" class="btn btn-gem">Edit Detail</a>
          </div>
        </div>
        
        <!-- Departments Tab -->
        <div class="tab-pane fade" id="departments" role="tabpanel" aria-labelledby="departments-tab">
          <div class="d-flex justify-content-between mb-3">
            <h3>Departments</h3>
            <a href="{{ route('departments.create', ['organization_id' => $organization->id]) }}" class="btn btn-gem">Add Department</a>
          </div>
          
          <div class="row">
            @forelse($departments as $department)
              <div class="col-md-4 mb-4">
                <div class="card h-100">
                  <div class="card-header bg-primary text-white">
                    <h4>{{ $department->department_name }}</h4>
                  </div>
                  <div class="card-body">
                    <p><strong>Description:</strong> {{ $department->description }}</p>
                    <p><strong>Department Head:</strong> {{ $department->department_head ?? 'Not assigned' }}</p>
                    
                    <h5 class="mt-4">Team Members</h5>
                    <ul class="list-group">
                      @php
                        $users = \App\Models\User::where('department_name', $department->department_name)->get();
                      @endphp
                      
                      @forelse($users as $user)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                          {{ $user->name }}
                          <span class="badge rounded-pill bg-primary">{{ $user->roles }}</span>
                        </li>
                      @empty
                        <li class="list-group-item">No team members assigned yet</li>
                      @endforelse
                    </ul>
                  </div>
                  <div class="card-footer d-flex justify-content-between">
                    <a class="btn btn-gem" href="{{ route('departments.edit', $department->id) }}">Edit</a>
                    <form action="{{ route('departments.destroy', $department->id) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-12">
                <div class="alert alert-info">No departments found for this organization.</div>
              </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Add Bootstrap JavaScript to handle the tabs -->
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const tabButtons = document.querySelectorAll('[data-bs-toggle="tab"]');
      
      tabButtons.forEach(button => {
        button.addEventListener('click', function(event) {
          event.preventDefault();
          
          // Remove active class from all tabs
          tabButtons.forEach(btn => {
            btn.classList.remove('active');
            document.querySelector(btn.dataset.bsTarget).classList.remove('show', 'active');
          });
          
          // Add active class to current tab
          button.classList.add('active');
          document.querySelector(button.dataset.bsTarget).classList.add('show', 'active');
        });
      });
    });
  </script>
@endsection