<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductType;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $organizations = Organization::all();
        $productTypes = ProductType::all();
        return view('products.create', compact('productTypes','organizations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'organization_name' => 'required',
            'product_type' => 'required',
            'manufacturer' => 'required',
            'cost' => 'required|numeric',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'acquisition_date' => 'required'
        ]);
        
        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }
        
        Product::create($data);
        
        return redirect()->route('products.index')
                        ->with('success', 'Product created successfully!');
    }

    public function getProductTypesByOrganization(Request $request)
    {
        $organizations = $request->input('organization');
        $productTypes = ProductType::where('organization_name', $organizations)->get();
        return response()->json($productTypes);
    }


    public function show($id)
    {
        $products = Product::findOrFail($id);
        return view('products.show', compact('products'));
    }

    public function edit($id)
    {
        $products = Product::findOrFail($id);
        $organizations = Organization::all();
        
        return view('products.edit', compact('products', 'organizations'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required',
            'organization_name' => 'required',
            'product_type' => 'required',
            'manufacturer' => 'required',
            'cost' => 'required|numeric',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'acquisition_date' => 'required|date'
        ]);
        
        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }
        
        $product->update($data);
        
        return redirect()->route('products.index')
                        ->with('success', 'Product updated successfully!');
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $products = Product::findOrFail($id);
        $products->delete();

        return redirect()->route('products.index')
                         ->with('success', 'Product deleted successfully.');
    }
}