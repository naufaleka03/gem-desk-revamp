@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <div class="row">
        <div class="col-lg-12 margin-tb d-flex align-items-center"
             style="border-bottom: 2px solid #ccc; padding-bottom: 0px; margin-bottom: 20px;">
            <h2 style="padding-bottom: 10px; margin-bottom: 10px;">Asset Management</h2>
        </div>
    </div>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success" role='alert' id="alert">
            {{$message}}
        </div>
    @endif
    
    <div class="row mt-4">
        <div class="col-md-6 mb-4">
            <div class="card h-100" style="border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 8px 20px rgba(115, 128, 236, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.1)';">
                <div class="card-body text-center p-5">
                    <div style="width: 80px; height: 80px; background-color: rgba(115, 128, 236, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto;">
                        <span class="material-symbols-outlined" style="font-size: 40px; color: #7380EC;">category</span>
                    </div>
                    <h3 class="mb-3">Product Types</h3>
                    <p class="mb-4 text-muted">Manage your product types and categories</p>
                    <a href="{{ route('productTypes.index') }}" class="btn" style="background-color: #7380EC; color: white; border: none; display: inline-flex; align-items: center; gap: 5px; padding: 10px 20px; border-radius: 30px;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC';">
                        <span class="material-symbols-outlined">visibility</span>
                        View Product Types
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100" style="border-radius: 15px; border: none; box-shadow: 0 4px 15px rgba(0,0,0,0.1); transition: transform 0.3s, box-shadow 0.3s;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 8px 20px rgba(115, 128, 236, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.1)';">
                <div class="card-body text-center p-5">
                    <div style="width: 80px; height: 80px; background-color: rgba(115, 128, 236, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto;">
                        <span class="material-symbols-outlined" style="font-size: 40px; color: #7380EC;">inventory_2</span>
                    </div>
                    <h3 class="mb-3">Products</h3>
                    <p class="mb-4 text-muted">Manage all your product inventory</p>
                    <a href="{{ route('products.index') }}" class="btn" style="background-color: #7380EC; color: white; border: none; display: inline-flex; align-items: center; gap: 5px; padding: 10px 20px; border-radius: 30px;" onmouseover="this.style.backgroundColor='#8e98f5';" onmouseout="this.style.backgroundColor='#7380EC';">
                        <span class="material-symbols-outlined">visibility</span>
                        View Products
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
