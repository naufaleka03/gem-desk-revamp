@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex align-items-center"
             style="border-bottom: 2px solid #ccc; padding-bottom: 0px; margin-bottom: 20px;">
            <a href="{{ route('products.index') }}" class="btn" style="color: black; margin-bottom: 15px; margin-right: 10px; display: flex; align-items: center;">
                <span class="material-symbols-outlined" style="margin-right: 2px;">arrow_back</span>
            </a>
            <h2 style="padding-bottom: 10px; margin-bottom: 10px;">Edit Product</h2>
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

    <form action="{{ route('products.update', $products->id) }}" method="POST" id="editProductForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card mb-4">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label"><strong>Name:</strong></label>
                    <input type="text" class="form-control" name="name" value="{{ $products->name }}" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Image:</strong></label>
                    <input type="file" class="form-control" name="image">
                    <div class="form-text">Upload a new image for this product (optional)</div>
                    
                    @if(isset($products->image) && !empty($products->image))
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $products->image) }}" alt="Current product image" style="max-width: 100px; max-height: 100px;">
                            <p class="text-muted">Current image</p>
                        </div>
                    @endif
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Property of:</strong></label>
                    <select class="form-control" id="organization_name" name="organization_name" required>
                        <option value="">Select Organization</option>
                        @foreach($organizations as $org)
                            <option value="{{ $org->organization_name }}" {{ $products->organization_name == $org->organization_name ? 'selected' : '' }}>
                                {{ $org->organization_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Product Type:</strong></label>
                    <select class="form-control" id="product_type" name="product_type" required>
                        <!-- Options will be populated by JavaScript -->
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Manufacturer:</strong></label>
                    <input type="text" class="form-control" name="manufacturer" value="{{ $products->manufacturer }}" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Cost:</strong></label>
                    <input type="text" class="form-control" name="cost" value="{{ $products->cost }}" required>
                </div>
                
                <div class="mb-4">
                    <label class="form-label"><strong>Description:</strong></label>
                    <textarea class="form-control" name="description" required>{{ $products->description }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Acquisition Date</strong></label>
                    <input type="date" class="form-control" name="acquisition_date" value="{{ $products->acquisition_date }}" required>
                </div>
                
                <div class="text-end">
                    <button type="submit" class="btn" style="background-color: #7380EC; border-color: #7380EC; color: white; margin-right: 10px;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC';">
                        Update
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-danger">Cancel</a>
                </div>
            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Function to load product types based on selected organization
        function loadProductTypes(organization) {
            if (!organization) return;
            
            $.ajax({
                url: '{{ route("getProductTypesByOrganization") }}',
                type: 'GET',
                data: { organization: organization },
                success: function(response) {
                    $('#product_type').empty();
                    $.each(response, function(index, value) {
                        $('#product_type').append('<option value="' + value.name + '">' + value.name + '</option>');
                    });
                    
                    // Select the current product type after populating options
                    $('#product_type option').each(function() {
                        if ($(this).val() === '{{ $products->product_type }}') {
                            $(this).prop('selected', true);
                        }
                    });
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        }
        
        // Load product types when the page loads
        loadProductTypes($('#organization_name').val());
        
        // Handle organization change
        $('#organization_name').change(function() {
            loadProductTypes($(this).val());
        });
    });
</script>
@endsection

