@extends('layouts.app')

@section('content')

<div>
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex align-items-center" style="border-bottom: 2px solid #ccc; padding-bottom: 0px; margin-bottom: 20px;">
            <a href="{{ route('services.index') }}" class="btn" style="color: black; margin-bottom: 15px; margin-right: 10px; display: flex; align-items: center;">
                <span class="material-symbols-outlined" style="margin-right: 2px;">arrow_back</span>
            </a>
            <h2 style="padding-bottom: 10px; margin-bottom: 10px;">Edit {{ $service->name }} Service</h2>
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

  <form action="{{ route('services.update',$service->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row">

        <div class="col-md-6">

            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-bottom: 15px;">
                <div class="form-group">
                    <strong>Icon Upload:</strong>
                    <input type="file" name="files" value="{{ $service->files }}" class="form-control" placeholder="Icon">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-bottom: 15px;">
                <div class="form-group">
                    <strong>Category:</strong>
                    <select name="service_categories" value="{{ $service->service_categories }}" class="form-control">
                        <option value="Business Category">Business Category</option>
                        <option value="IT Category">IT Category</option>
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-bottom: 15px;">
                <div class="form-group">
                    <strong>Name:</strong>
                    <input type="text" name="name" value="{{ $service->name }}" class="form-control" placeholder="Name">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Description:</strong>
                    <textarea class="form-control" style="height:150px" name="description" placeholder="Description">{{ $service->description }}</textarea>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-bottom: 15px;">
                <div class="form-group">
                    <strong>Owned By:</strong>
                    <select class="form-select" id="ownedBy" name="organization_id" required>
                        @foreach($organizations as $org)
                            <option value="{{ $org->id }}" {{ $org->id == $service->organization_id ? 'selected' : '' }}>
                                {{ $org->organization_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-bottom: 15px;">
                <div class="form-group">
                    <strong>Service Support Hours:</strong>
                    <input type="text" name="hours" value="{{ $service->hours }}" class="form-control" placeholder="Service Support Hours">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-bottom: 15px;">
                <strong for="availabilityTarget" class="form-label">Availability Target (%):</strong>
                <input type="number" value="{{ $service->availability}}" class="form-control" id="availabilityTarget" name="availability" placeholder="Availability Target">
            </div>

            <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                <div class="form-group" style="flex: 1;">
                    <strong>Cost:</strong>
                    <input type="text" name="cost" id="cost" value="{{ $service->cost }}" class="form-control" placeholder="cost" oninput="calculateTotal()">
                </div>
                <div class="form-group" style="flex: 1;">
                    <strong>Quantity:</strong>
                    <input type="number" name="quantity" id="quantity" value="{{ $service->quantity }}" class="form-control" placeholder="quantity" oninput="calculateTotal()">
                </div>
            </div>
            <div style="font-size: 1.1em; font-weight: bold; padding: 10px; background-color: rgba(115, 128, 236, 0.5); border-radius: 4px; margin-top: 10px; margin-bottom: 10px;">
                Total: <span id="total">Rp {{ number_format($service->cost * $service->quantity, 0, ',', '.') }}</span>
            </div>
            
            <script>
                function calculateTotal() {
                    const cost = document.getElementById('cost').value.replace(/\D/g, '') || 0;
                    const quantity = document.getElementById('quantity').value || 0;
                    const total = parseFloat(cost) * parseFloat(quantity);
                    
                    const formattedTotal = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR'
                    }).format(total);
                    
                    document.getElementById('total').textContent = formattedTotal;
                }
                calculateTotal();
            </script>
            

        </div>

    </div>

    <div class="col-xs-12 col-sm-12 col-md-12" style="margin-bottom: 15px;">
        <div id="products-container">
            <!-- Primary product -->
            <div class="form-group product-selection mb-2">
                <strong>Product:</strong>
                <div class="d-flex align-items-center gap-2">
                    <select name="products[]" class="form-control" required>
                        <option value="">-- Select a Product --</option> 
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ $product->id == $service->product_id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-danger remove-product" style="display: none;">
                        <span class="material-symbols-outlined">delete</span>
                    </button>
                </div>
            </div>
            
            <!-- Additional products from the pivot table -->
            @foreach($linkedProductIds as $productId)
                @if($productId != $service->product_id) {{-- Skip primary product --}}
                    <div class="form-group product-selection mb-2">
                        <strong>Product:</strong>
                        <div class="d-flex align-items-center gap-2">
                            <select name="products[]" class="form-control">
                                <option value="">-- Select a Product --</option> 
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ $product->id == $productId ? 'selected' : '' }}>
                                        {{ $product->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-danger remove-product">
                                <span class="material-symbols-outlined">delete</span>
                            </button>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 mb-3">
        <button type="button" class="btn" id="add-product-btn" style="color: #7380EC; border: 3px solid #7380EC; background: transparent; padding: 4px 16px;" onmouseover="this.style.backgroundColor='#7380EC'; this.style.color='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#7380EC';">
            <i class="fas fa-plus-circle"></i> Add Additional Product
        </button>
    </div>

    <div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-end">
            <button type="submit" class="btn btn-lg" style="background-color: #7380EC; border-color: #7380EC; color: white;">Submit</button>
        </div>
    </div>


</form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addProductBtn = document.getElementById('add-product-btn');
        const productsContainer = document.getElementById('products-container');
        
        // Add product button click handler
        addProductBtn.addEventListener('click', function() {
            // Create a new product selection element
            const newProductDiv = document.createElement('div');
            newProductDiv.className = 'form-group product-selection mb-2';
            
            // Get the original select element
            const originalSelect = document.querySelector('select[name="products[]"]');
            
            // Create HTML with proper options (without duplicating the placeholder)
            let optionsHtml = '<option value="">-- Select a Product --</option>';
            
            // Add all product options (skipping the placeholder)
            Array.from(originalSelect.options).forEach((option, index) => {
                if (index > 0) { // Skip the first placeholder option
                    optionsHtml += `<option value="${option.value}">${option.text}</option>`;
                }
            });
            
            newProductDiv.innerHTML = `
                <strong>Product:</strong>
                <div class="d-flex align-items-center gap-2">
                    <select name="products[]" class="form-control">
                        ${optionsHtml}
                    </select>
                    <button type="button" class="btn btn-danger remove-product">
                        <span class="material-symbols-outlined">delete</span>
                    </button>
                </div>
            `;
            
            // Add to container
            productsContainer.appendChild(newProductDiv);
            
            // Update remove buttons visibility
            updateRemoveButtons();
        });
        
        // Event delegation for remove buttons
        productsContainer.addEventListener('click', function(e) {
            if (e.target.closest('.remove-product')) {
                const button = e.target.closest('.remove-product');
                const selection = button.closest('.product-selection');
                
                // Only remove if there are more than one product selection
                const productSelections = document.querySelectorAll('.product-selection');
                if (productSelections.length > 1) {
                    selection.remove();
                    updateRemoveButtons();
                }
            }
        });
        
        // Update remove buttons visibility
        function updateRemoveButtons() {
            const productSelections = document.querySelectorAll('.product-selection');
            
            // Show remove buttons only if there's more than one selection
            const showRemove = productSelections.length > 1;
            
            productSelections.forEach((selection, index) => {
                const removeBtn = selection.querySelector('.remove-product');
                if (index === 0 && !showRemove) {
                    removeBtn.style.display = 'none';
                } else {
                    removeBtn.style.display = 'block';
                }
            });
        }
        
        // Initialize remove buttons
        updateRemoveButtons();
    });
</script>

@endsection
