@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex align-items-center"
             style="border-bottom: 2px solid #ccc; padding-bottom: 0px; margin-bottom: 20px;">
            <a href="{{ route('organizations.index') }}" class="btn" style="color: black; margin-bottom: 15px; margin-right: 10px; display: flex; align-items: center;">
                <span class="material-symbols-outlined" style="margin-right: 2px;">arrow_back</span>
            </a>
            <h2 style="padding-bottom: 10px; margin-bottom: 10px;">Add New Organization</h2>
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

    <form action="{{ route('organizations.store') }}" method="POST">
        @csrf
        <div class="card mb-4">
            <div class="card-body">
                <h4 class="mb-3" style="border-bottom: 2px solid #7380EC; padding-bottom: 10px; color: #7380EC;">Profile</h4>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Organization Name:</strong></label>
                    <input type="text" class="form-control" name="organization_name">
            </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Description:</strong></label>
                    <textarea class="form-control" name="description" rows="3"></textarea>
            </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Industry Category:</strong></label>
                    <select class="form-select" name="industry_category">
                        <option selected>Select here...</option>
                        <option value="Agriculture">Agriculture</option>
                        <option value="Consulting & Professional Services">Consulting & Professional Services</option>
                        <option value="Electrical Equipment">Electrical Equipment</option>
                        <option value="Food & Beverage">Food & Beverage</option>
                        <option value="Health">Health</option>
                        <option value="Information & Communication Technology">Information & Communication Technology</option>
                        <option value="Fashion & Textiles">Fashion & Textiles</option>
                        <option value="Media & Entertainment">Media & Entertainment</option>
                        <option value="Manufacturing">Manufacturing</option>
                        <option value="Transportation & Logistics">Transportation & Logistics</option>
                        <option value="Other">Others</option>
                    </select>
                </div>
                
                <h4 class="mb-3 mt-5" style="border-bottom: 2px solid #7380EC; padding-bottom: 10px; color: #7380EC;">Location</h4>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Address:</strong></label>
                    <textarea class="form-control" name="address" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>City:</strong></label>
                    <input type="text" class="form-control" name="city">
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Postal Code:</strong></label>
                    <input type="text" class="form-control" name="postal_code">
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>State:</strong></label>
                    <input type="text" class="form-control" name="state">
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Country:</strong></label>
                    <input type="text" class="form-control" name="country">
                </div>
                
                <h4 class="mb-3 mt-5" style="border-bottom: 2px solid #7380EC; padding-bottom: 10px; color: #7380EC;">Contact Information</h4>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Email:</strong></label>
                    <input type="email" class="form-control" name="email">
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Phone No.:</strong></label>
                    <input type="tel" class="form-control" name="phone_no">
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Fax No.:</strong></label>
                    <input type="tel" class="form-control" name="fax_no">
                </div>

                <div class="mb-4">
                    <label class="form-label"><strong>Web URL:</strong></label>
                    <input type="url" class="form-control" name="web_url">
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-lg" style="background-color: #7380EC; border-color: #7380EC; color: white;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC';">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
