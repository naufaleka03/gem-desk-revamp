@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex align-items-center"
             style="border-bottom: 2px solid #ccc; padding-bottom: 0px; margin-bottom: 20px;">
            <a href="{{ route('productTypes.index') }}" class="btn" style="color: black; margin-bottom: 15px; margin-right: 10px; display: flex; align-items: center;">
                <span class="material-symbols-outlined" style="margin-right: 2px;">arrow_back</span>
            </a>
            <h2 style="padding-bottom: 10px; margin-bottom: 10px;">Edit Product Type</h2>
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

    <form action="{{ route('productTypes.update', $productTypes->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
        <div class="card mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label"><strong>Name:</strong></label>
                <input type="text" class="form-control" name="name" value="{{ $productTypes->name }}" required>
            </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Image:</strong></label>
                    <input type="file" class="form-control" name="image">
                    <div class="form-text">Upload a new image for this product type (optional)</div>
                    
                    @if(isset($productTypes->image) && !empty($productTypes->image))
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $productTypes->image) }}" alt="Current product type image" style="max-width: 100px; max-height: 100px;">
                            <p class="text-muted">Current image</p>
                        </div>
                    @endif
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Property of:</strong></label>
                    <select class="form-control" id="organization_name" name="organization_name" required>
                    @foreach($organizations as $org)
                    <option value="{{ $org->organization_name }}" {{ $org->organization_name == $productTypes->organization_name ? 'selected' : '' }}>{{ $org->organization_name }}</option>
                    @endforeach
                </select>
            </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Asset Type:</strong></label>
                    <select class="form-control" id="asset_type" name="asset_type" required>
                        <option value="Asset" {{ $productTypes->asset_type == 'Asset' ? 'selected' : '' }}>Asset</option>
                        <option value="Consumable" {{ $productTypes->asset_type == 'Consumable' ? 'selected' : '' }}>Consumable</option>
                </select>
            </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Asset Category:</strong></label>
                    <select class="form-control" id="asset_category" name="asset_category" required>
                        <option value="IT" {{ $productTypes->asset_category == 'IT' ? 'selected' : '' }}>IT</option>
                        <option value="Non IT" {{ $productTypes->asset_category == 'Non IT' ? 'selected' : '' }}>Non IT</option>
                </select>
            </div>
            
                <div class="mb-4">
                    <label class="form-label"><strong>Description:</strong></label>
                <textarea class="form-control" name="description" required>{{ $productTypes->description }}</textarea>
            </div>

                <div class="text-end">
                    <button type="submit" class="btn" style="background-color: #7380EC; border-color: #7380EC; color: white; margin-right: 10px;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC';">
                        Update
                    </button>
            <a href="{{ route('productTypes.index') }}" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </div>
        </form>
    </div>
@endsection
