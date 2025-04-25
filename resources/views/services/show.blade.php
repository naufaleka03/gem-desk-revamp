@extends('layouts.app')

@section('content')
 <div class="container-fluid">
   <div class="row">
       <div class="col-lg-12 margin-tb d-flex align-items-center" style="border-bottom: 2px solid #ccc; padding-bottom: 0px; margin-bottom: 20px;">
           <a href="{{ route('services.index') }}" class="btn" style="color: black; margin-bottom: 15px; margin-right: 10px; display: flex; align-items: center;">
            <span class="material-symbols-outlined" style="margin-right: 2px;">arrow_back</span>
            </a>
           <h2 style="padding-bottom: 10px; margin-bottom: 10px;">Show {{ $service->name }} Service</h2>
       </div>
   </div>

   <div class="row">
    <!-- Kolom Kiri (col-md-3) -->
    <div class="col-md-3">
        <div class="card" style="width: 100%; margin-bottom: 15px;">
            <div class="card-body">
                <div class="form-group">
                    <strong></strong>
                    <img src="{{ asset('storage/' . $service->files) }}" alt="service" width="100px">
                </div>
            </div>
        </div>
        <div class="card" style="width: 100%; background-color: #f8f9fa; border: 1px solid #e0e0e0; border-radius: 8px;">
            <div style="text-align: center; padding: 15px; border-bottom: 2px dashed #7380EC;">
                <span style="font-size: 18px; font-weight: bold;">Service Details</span>
            </div>
            <div class="card-body" style="padding: 20px;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px dotted #dee2e6;">
                    <strong>Cost</strong>
                    <span>Rp {{ number_format($service->cost, 0, ',', '.') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px dotted #dee2e6;">
                    <strong>Quantity</strong>
                    <span>{{ $service->quantity ?? 1 }}</span>
                </div>
                <div style="border-top: 2px dashed #7380EC; margin-top: 15px; padding-top: 15px;">
                    <div style="display: flex; justify-content: space-between; font-size: 18px;">
                        <strong>Total</strong>
                        <span style="font-weight: bold;">Rp {{ number_format($service->cost * ($service->quantity ?? 1), 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan (col-md-9) -->
    <div class="col-md-9">
        <!-- Nama Service -->
        <div style="width: 100%; margin-bottom: 15px;">
                <div class="form-group">
                    <span style="font-size: 25px; font-weight: bold;">{{ $service->name }} Service</span>
                </div>
        </div>

        <!-- Owned By -->
        <div class="card" style="width: 100%; background-color: rgba(115, 128, 236, 0.5); color: black; margin-bottom: 15px;">
            <div class="card-body">
                <div class="form-group">
                    <strong>Owned By</strong><br>
                    {{ $service->organization->name }}
                </div>
            </div>
        </div>

        <!-- Info Cards -->
        <div class="row" style="margin-bottom: 15px;">
            <div class="col-md-4">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-group">
                            <strong>Product</strong><br>
                            {{ $service->product->name ?? 'No Product Found' }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-group">
                            <strong>Availability</strong><br>
                            {{ $service->availability }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card" style="width: 100%;">
                    <div class="card-body">
                        <div class="form-group">
                            <strong>Service Support Hours</strong><br>
                            {{ $service->hours }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        <div class="card" style="width: 100%;">
            <div class="card-body">
                <div class="form-group">
                    <strong>Description</strong>
                    <div>
                    {{ $service->description }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 </div>
 <style>
   .card {
       transition: 0.3s;
       margin: 20px auto;
   }

   .card:hover {
       box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
   }
 </style>
@endsection
