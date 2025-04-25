@extends('layouts.app')

@section('content')
@if($organizations->isEmpty())
    <script>
        alert("No Organizations found. Redirecting...");
        window.location.href = "{{ route('organizations.index') }}";
    </script>
@endif

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex align-items-center"
             style="border-bottom: 2px solid #ccc; padding-bottom: 0px; margin-bottom: 20px;">
            <a href="{{ route('productTypes.index') }}" class="btn" style="color: black; margin-bottom: 15px; margin-right: 10px; display: flex; align-items: center;">
                <span class="material-symbols-outlined" style="margin-right: 2px;">arrow_back</span>
            </a>
            <h2 style="padding-bottom: 10px; margin-bottom: 10px;">New Product Type</h2>
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

    <form action="{{ route('productTypes.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label"><strong>Name:</strong></label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Image:</strong></label>
                    <input type="file" class="form-control" id="image" name="image">
                    <div class="form-text">Upload an image for this product type (optional)</div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Property of:</strong></label>
                    <select class="form-control" id="organization_name" name="organization_name">
                        @foreach($organizations as $org)
                            <option value="{{ $org->organization_name }}">{{ $org->organization_name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Asset Type:</strong></label>
                    <select class="form-control" id="asset_type" name="asset_type">
                        <option selected>Asset</option>
                        <option value="Consumable">Consumable</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Asset Category:</strong></label>
                    <select class="form-control" id="asset_category" name="asset_category">
                        <option selected>IT</option>
                        <option value="Non IT">Non IT</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="form-label"><strong>Description:</strong></label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>
                
                <div class="text-end">
                    <button type="submit" class="btn" style="background-color: #7380EC; border-color: #7380EC; color: white; margin-right: 10px;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC';">
                        Add
                    </button>
                    <a href="{{ route('productTypes.index') }}" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection