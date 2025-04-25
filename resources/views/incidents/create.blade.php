@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex align-items-center"
             style="border-bottom: 2px solid #ccc; padding-bottom: 0px; margin-bottom: 20px;">
             <a href="{{ route('incidents.index') }}" class="btn" style="color: black; margin-bottom: 15px; margin-right: 10px; display: flex; align-items: center;">
                <span class="material-symbols-outlined" style="margin-right: 2px;">arrow_back</span>
            </a>
            <h2 style="padding-bottom: 10px; margin-bottom: 10px;">Create Incident</h2>
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

    <form action="{{ route('incidents.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header" style="background-color: #7380EC; color: white;">
                        <h5 class="mb-0">Incident Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="IncidentInput" class="form-label">Incident Title</label>
                            <input type="text" class="form-control" value="{{ old('incident') }}" name="incident" id="IncidentInput" placeholder="Incident Title" required>
                        </div>

                        <div class="mb-3">
                            <label for="ServiceSelect" class="form-label">Impacted Service</label>
                            <select class="form-select" name="service" id="ServiceSelect" aria-label="Impacted Service" required>
                                <option value="">-- Select a Service --</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->name }}" {{ old('service') == $service->name ? 'selected' : '' }}>
                                        {{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Impacted Assets</label>
                            <div id="assets-container">
                                <div class="form-group asset-selection mb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <select name="assets[]" class="form-control" required>
                                            <option value="">-- Select an Asset --</option>
                                            @foreach($assets as $product)
                                                <option value="{{ $product->name }}" {{ (collect(old('assets'))->contains($product->name)) ? 'selected' : '' }}>
                                                    {{ $product->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-danger remove-asset" style="display: none;">
                                            <span class="material-symbols-outlined">delete</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" class="btn mt-2" id="add-asset-btn" style="color: #7380EC; border: 3px solid #7380EC; background: transparent; padding: 4px 16px;" onmouseover="this.style.backgroundColor='#7380EC'; this.style.color='white';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#7380EC';">
                                <i class="fas fa-plus-circle"></i> Add Another Asset
                            </button>
                        </div>

                        <div class="mb-3">
                            <label for="DescriptionInput" class="form-label">Incident Description</label>
                            <textarea class="form-control" name="incident_desc" id="DescriptionInput" rows="4" required>{{ old('incident_desc') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-header" style="background-color: #7380EC; color: white;">
                        <h5 class="mb-0">Risk Assessment</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="ProbabilitySelect" class="form-label">Incident Probability</label>
                            <select class="form-select" name="probability" id="ProbabilitySelect" aria-label="Incident Probability" required>
                                <option value="Low" {{ old('probability') == 'Low' ? 'selected' : '' }}>Low (Incident may occur once in a year)</option>
                                <option value="Medium" {{ old('probability') == 'Medium' ? 'selected' : '' }}>Medium (Incident may occur once in 3 months)</option>
                                <option value="High" {{ old('probability') == 'High' ? 'selected' : '' }}>High (Incident may occur once a month)</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="ImpactSelect" class="form-label">Impact Intensity</label>
                            <select class="form-select" name="risk_impact" id="ImpactSelect" aria-label="Impacted Intensity" required>
                                <option value="Low" {{ old('risk_impact') == 'Low' ? 'selected' : '' }}>Low (Service is unavailable for &lt; 6 hours)</option>
                                <option value="Medium" {{ old('risk_impact') == 'Medium' ? 'selected' : '' }}>Medium (Service is unavailable for 6 - 24 hours)</option>
                                <option value="High" {{ old('risk_impact') == 'High' ? 'selected' : '' }}>High (Service is unavailable for more than 24 hours)</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Current Priority Level</label>
                            <div class="p-3 rounded {{ getPriorityClass(old('priority', 'Low')) }}" id="priorityDisplay">
                                {{ old('priority', 'Low') }} Priority
                            </div>
                            <small class="text-muted">Priority will update when you change probability or impact intensity.</small>
                        </div>
                    </div>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-lg" style="background-color: #7380EC; color: white;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC';">
                        Create Incident
                    </button>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Asset selection management
            const addAssetBtn = document.getElementById('add-asset-btn');
            const assetsContainer = document.getElementById('assets-container');
            
            // Add asset button click handler
            addAssetBtn.addEventListener('click', function() {
                // Create a new asset selection element
                const newAssetDiv = document.createElement('div');
                newAssetDiv.className = 'form-group asset-selection mb-2';
                
                // Get the original select element
                const originalSelect = document.querySelector('select[name="assets[]"]');
                
                // Create HTML with proper options (without duplicating the placeholder)
                let optionsHtml = '<option value="">-- Select an Asset --</option>';
                
                // Add all asset options (skipping the placeholder)
                Array.from(originalSelect.options).forEach((option, index) => {
                    if (index > 0) { // Skip the first placeholder option
                        optionsHtml += `<option value="${option.value}">${option.text}</option>`;
                    }
                });
                
                newAssetDiv.innerHTML = `
                    <div class="d-flex align-items-center gap-2">
                        <select name="assets[]" class="form-control">
                            ${optionsHtml}
                        </select>
                        <button type="button" class="btn btn-danger remove-asset">
                            <span class="material-symbols-outlined">delete</span>
                        </button>
                    </div>
                `;
                
                // Add to container
                assetsContainer.appendChild(newAssetDiv);
                
                // Update remove buttons visibility
                updateRemoveButtons();
            });
            
            // Event delegation for remove buttons
            assetsContainer.addEventListener('click', function(e) {
                if (e.target.closest('.remove-asset')) {
                    const button = e.target.closest('.remove-asset');
                    const selection = button.closest('.asset-selection');
                    
                    // Only remove if there are more than one asset selection
                    const assetSelections = document.querySelectorAll('.asset-selection');
                    if (assetSelections.length > 1) {
                        selection.remove();
                        updateRemoveButtons();
                    }
                }
            });
            
            // Update remove buttons visibility
            function updateRemoveButtons() {
                const assetSelections = document.querySelectorAll('.asset-selection');
                
                // Show remove buttons only if there's more than one selection
                const showRemove = assetSelections.length > 1;
                
                assetSelections.forEach((selection, index) => {
                    const removeBtn = selection.querySelector('.remove-asset');
                    if (index === 0 && !showRemove) {
                        removeBtn.style.display = 'none';
                    } else {
                        removeBtn.style.display = 'block';
                    }
                });
            }
            
            // Initialize remove buttons
            updateRemoveButtons();

            const probabilitySelect = document.getElementById('ProbabilitySelect');
            const impactSelect = document.getElementById('ImpactSelect');
            const priorityDisplay = document.getElementById('priorityDisplay');

            function getPriority(probability, impact) {
                if (probability === 'High' || impact === 'High') {
                    return 'High';
                } else if (probability === 'Medium' || impact === 'Medium') {
                    return 'Medium';
                } else {
                    return 'Low';
                }
            }

            function getPriorityClass(priority) {
                switch (priority) {
                    case 'High':
                        return 'bg-danger text-white';
                    case 'Medium':
                        return 'bg-warning';
                    case 'Low':
                    default:
                        return 'bg-success text-white';
                }
            }

            function updatePriorityDisplay() {
                const probability = probabilitySelect.value;
                const impact = impactSelect.value;
                const priority = getPriority(probability, impact);
                const priorityClass = getPriorityClass(priority);

                priorityDisplay.className = 'p-3 rounded ' + priorityClass;
                priorityDisplay.textContent = priority + ' Priority';
            }

            probabilitySelect.addEventListener('change', updatePriorityDisplay);
            impactSelect.addEventListener('change', updatePriorityDisplay);

            // Initialize on page load
            updatePriorityDisplay();
        });
    </script>
@endsection

@php
function getPriorityClass($priority) {
    switch ($priority) {
        case 'Low':
            return 'bg-success text-white'; // Green background
        case 'Medium':
            return 'bg-warning'; // Yellow background
        case 'High':
            return 'bg-danger text-white'; // Red background
        default:
            return 'bg-light';
    }
}
@endphp

