@extends('layouts.app')

@section('content')
@if($productTypes->isEmpty())
    <script>
        alert("No product types found. Redirecting...");
        window.location.href = "{{ route('productTypes.index') }}";
    </script>
@endif

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex align-items-center"
             style="border-bottom: 2px solid #ccc; padding-bottom: 0px; margin-bottom: 20px;">
            <a href="{{ route('products.index') }}" class="btn" style="color: black; margin-bottom: 15px; margin-right: 10px; display: flex; align-items: center;">
                <span class="material-symbols-outlined" style="margin-right: 2px;">arrow_back</span>
            </a>
            <h2 style="padding-bottom: 10px; margin-bottom: 10px;">New Product</h2>
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

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
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
                    <div class="form-text">Upload an image for this product (optional)</div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Property of:</strong></label>
                    <select class="form-control" id="organization_name" name="organization_name">
                        <option value="" disabled selected>Select Organization</option>
                        @foreach($organizations as $org)
                            <option value="{{ $org->organization_name }}">{{ $org->organization_name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Product Type:</strong></label>
                    <select class="form-control" id="product_type" name="product_type">
                        <!-- Options will be populated by JavaScript -->
                    </select>
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Manufacturer:</strong></label>
                    <input type="text" class="form-control" id="manufacturer" name="manufacturer">
                </div>
                
                <div class="mb-3">
                    <label class="form-label"><strong>Cost:</strong></label>
                    <input type="number" class="form-control" id="cost" name="cost">
                </div>
                
                <div class="mb-4">
                    <label class="form-label"><strong>Description:</strong></label>
                    <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label"><strong>Acquisition Date</strong></label>
                    <input type="date" class="form-control" name="acquisition_date">
                </div>
                
                <div class="text-end">
                    <button type="submit" class="btn" style="background-color: #7380EC; border-color: #7380EC; color: white; margin-right: 10px;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC';">
                        Add
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
        $('#organization_name').change(function() {
            var selectedOrganization = $(this).val();
            $.ajax({
                url: '{{ route("getProductTypesByOrganization") }}', 
                type: 'GET',
                data: { organization: selectedOrganization },
                success: function(response) {
                    $('#product_type').empty(); 
                    $.each(response, function(index, value) {
                        $('#product_type').append('<option value="' + value.name + '">' + value.name + '</option>');
                    });
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection

