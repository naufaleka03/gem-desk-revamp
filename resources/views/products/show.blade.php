@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex align-items-center"
             style="border-bottom: 2px solid #ccc; padding-bottom: 0px; margin-bottom: 20px;">
            <a href="{{ route('products.index') }}" class="btn" style="color: black; margin-bottom: 15px; margin-right: 10px; display: flex; align-items: center;">
                <span class="material-symbols-outlined" style="margin-right: 2px;">arrow_back</span>
            </a>
            <h2 style="padding-bottom: 10px; margin-bottom: 10px;">Product Details</h2>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-body">
            @if(isset($products->image) && !empty($products->image))
                <div class="text-center mb-4">
                    <img src="{{ asset('storage/' . $products->image) }}" alt="{{ $products->name }}" style="max-width: 300px; max-height: 300px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                </div>
            @endif
            
            <div class="mb-3">
                <label class="form-label"><strong>Name:</strong></label>
                <input type="text" class="form-control" value="{{ $products->name }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Property Of:</strong></label>
                <input type="text" class="form-control" value="{{ $products->organization_name }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Product Type:</strong></label>
                <input type="text" class="form-control" value="{{ $products->product_type }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Manufacturer:</strong></label>
                <input type="text" class="form-control" value="{{ $products->manufacturer }}" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label"><strong>Cost:</strong></label>
                <input type="text" class="form-control" value="{{ $products->cost }}" disabled>
            </div>

            <div class="mb-4">
                <label class="form-label"><strong>Description:</strong></label>
                <textarea class="form-control" rows="3" disabled>{{ $products->description }}</textarea>
            </div>
            
            <div class="text-end">
                <a href="{{ route('products.edit', $products->id) }}" class="btn" style="background-color: #7380EC; border-color: #7380EC; color: white; margin-right: 5px;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC';">
                    Edit
                </a>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>
    </div>
    </div>
@endsection
