@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex align-items-center"
             style="border-bottom: 2px solid #ccc; padding-bottom: 0px; margin-bottom: 20px;">
            <a href="{{ route('organizations.index') }}" class="btn" style="color: black; margin-bottom: 15px; margin-right: 10px; display: flex; align-items: center;">
                <span class="material-symbols-outlined" style="margin-right: 2px;">arrow_back</span>
            </a>
            <h2 style="padding-bottom: 10px; margin-bottom: 10px;">Edit Organization</h2>
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

    <form action="{{ route('organizations.update', $organization->id) }}" method="POST">
  @csrf
  @method('PUT')
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="mb-3" style="border-bottom: 2px solid #7380EC; padding-bottom: 10px; color: #7380EC;">Profile</h4>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Organization Name:</strong></label>
                    <input type="text" class="form-control" name="organization_name" value="{{ $organization->organization_name }}">
        </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Description:</strong></label>
                    <textarea class="form-control" name="description" rows="3">{{ $organization->description }}</textarea>
      </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Industry Category:</strong></label>
                    <select class="form-select" name="industry_category">
                        <option>Select here...</option>
                        <option value="Agriculture" {{ $organization->industry_category == 'Agriculture' ? 'selected' : '' }}>Agriculture</option>
                        <option value="Consulting & Professional Services" {{ $organization->industry_category == 'Consulting & Professional Services' ? 'selected' : '' }}>Consulting & Professional Services</option>
                        <option value="Electrical Equipment" {{ $organization->industry_category == 'Electrical Equipment' ? 'selected' : '' }}>Electrical Equipment</option>
                        <option value="Food & Beverage" {{ $organization->industry_category == 'Food & Beverage' ? 'selected' : '' }}>Food & Beverage</option>
                        <option value="Health" {{ $organization->industry_category == 'Health' ? 'selected' : '' }}>Health</option>
                        <option value="Information & Communication Technology" {{ $organization->industry_category == 'Information & Communication Technology' ? 'selected' : '' }}>Information & Communication Technology</option>
                        <option value="Fashion & Textiles" {{ $organization->industry_category == 'Fashion & Textiles' ? 'selected' : '' }}>Fashion & Textiles</option>
                        <option value="Media & Entertainment" {{ $organization->industry_category == 'Media & Entertainment' ? 'selected' : '' }}>Media & Entertainment</option>
                        <option value="Manufacturing" {{ $organization->industry_category == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                        <option value="Transportation & Logistics" {{ $organization->industry_category == 'Transportation & Logistics' ? 'selected' : '' }}>Transportation & Logistics</option>
                        <option value="Other" {{ $organization->industry_category == 'Other' ? 'selected' : '' }}>Others</option>
                    </select>
        </div>
                
                <h4 class="mb-3 mt-5" style="border-bottom: 2px solid #7380EC; padding-bottom: 10px; color: #7380EC;">Location</h4>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Address:</strong></label>
                    <textarea class="form-control" name="address" rows="3">{{ $organization->address }}</textarea>
      </div>

                <div class="mb-3">
                    <label class="form-label"><strong>City:</strong></label>
                    <input type="text" class="form-control" name="city" value="{{ $organization->city }}">
    </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Postal Code:</strong></label>
                    <input type="text" class="form-control" name="postal_code" value="{{ $organization->postal_code }}">
      </div>

                <div class="mb-3">
                    <label class="form-label"><strong>State:</strong></label>
                    <input type="text" class="form-control" name="state" value="{{ $organization->state }}">
      </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Country:</strong></label>
                    <input type="text" class="form-control" name="country" value="{{ $organization->country }}">
      </div>

                <h4 class="mb-3 mt-5" style="border-bottom: 2px solid #7380EC; padding-bottom: 10px; color: #7380EC;">Contact Information</h4>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Email:</strong></label>
                    <input type="email" class="form-control" name="email" value="{{ $organization->email }}">
      </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Phone No.:</strong></label>
                    <input type="tel" class="form-control" name="phone_no" value="{{ $organization->phone_no }}">
    </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Fax No.:</strong></label>
                    <input type="tel" class="form-control" name="fax_no" value="{{ $organization->fax_no }}">
      </div>

                <div class="mb-4">
                    <label class="form-label"><strong>Web URL:</strong></label>
                    <input type="url" class="form-control" name="web_url" value="{{ $organization->web_url }}">
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
@endsection