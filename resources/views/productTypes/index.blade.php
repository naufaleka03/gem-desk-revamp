@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex align-items-center"
             style="border-bottom: 2px solid #ccc; padding-bottom: 0px; margin-bottom: 20px;">
            <a href="{{ route('assetManagement.index') }}" class="btn" style="color: black; margin-bottom: 15px; margin-right: 10px; display: flex; align-items: center;">
                <span class="material-symbols-outlined" style="margin-right: 2px;">arrow_back</span>
            </a>
            <h2 style="padding-bottom: 10px; margin-bottom: 10px;">Product Types</h2>
        </div>
    </div>
    
    @if (session('success'))
        <div class="alert alert-success d-flex align-items-center" role="alert" id="alert">
            <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                <use xlink:href="#check-circle-fill"/>
            </svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('productTypes.create') }}" class="btn" style="background-color: #7380EC; color: white; border: none; display: inline-flex; align-items: center; gap: 5px;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC';">
            <span class="material-symbols-outlined" style="font-size: 18px;">add</span>
            Add Product Type
        </a>
    </div>

    @if (count($productTypes) > 0)
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Property Of</th>
                    <th>Asset Type</th>
                    <th>Asset Category</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($productTypes as $productType)
                <tr>
                    <td>{{ $productType->name }}</td>
                    <td>{{ $productType->organization_name }}</td>
                    <td>{{ $productType->asset_type }}</td>
                    <td>{{ $productType->asset_category }}</td>
                    <td>
                        <a href="{{ route('productTypes.show', $productType->id) }}" class="btn" style="background-color: #7380EC; color: white; border: none; display: inline-flex; align-items: center; gap: 5px; margin-right: 5px;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC';">
                            <span class="material-symbols-outlined" style="font-size: 18px;">visibility</span>
                            Details
                        </a>
                        <a href="{{ route('productTypes.edit', $productType->id) }}" class="btn" style="background-color: #7380EC; color: white; border: none; display: inline-flex; align-items: center; gap: 5px; margin-right: 5px;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC';">
                            <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                            Edit
                        </a>
                        <a href="{{ route('productTypes.delete', $productType->id) }}?id={{ $productType->id }}" class="btn btn-danger" style="display: inline-flex; align-items: center; gap: 5px;">
                            <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                            Delete
                        </a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @else
        <div class="alert alert-info">No product types available</div>
    @endif
</div>
@endsection