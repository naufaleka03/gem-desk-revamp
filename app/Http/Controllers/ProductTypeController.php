<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductType;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductTypeController extends Controller
{

    public function index()
    {
        $productTypes = ProductType::all();
        return view('productTypes.index', compact('productTypes'));
    }

    public function create()
    {
        $organizations = Organization::all();
        return view('productTypes.create', compact('organizations'));
    }

    public function show($id)
    {
        $productTypes = ProductType::findOrFail($id);
        return view('productTypes.show', compact('productTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'organization_name' => 'required',
            'asset_type' => 'required',
            'asset_category' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_types', 'public');
            $data['image'] = $imagePath;
        }

        ProductType::create($data);

        return redirect()->route('productTypes.index')
                        ->with('success', 'Product Type created successfully!');
    }

    public function edit($id)
    {
        $productTypes = ProductType::findOrFail($id);
        $organizations = Organization::all();
        return view('productTypes.edit', compact('productTypes','organizations'));
    }

    public function update(Request $request, $id)
    {
        $productType = ProductType::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required',
            'organization_name' => 'required',
            'asset_type' => 'required',
            'asset_category' => 'required',
            'description' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $data = $request->except('image');
        
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($productType->image) {
                Storage::disk('public')->delete($productType->image);
            }
            
            $imagePath = $request->file('image')->store('product_types', 'public');
            $data['image'] = $imagePath;
        }
        
        $productType->update($data);

        return redirect()->route('productTypes.index')
                        ->with('success', 'Product Type updated successfully!');
    }


    public function delete(Request $request)
    {
        $id = $request->id;
        $productTypes = ProductType::findOrFail($id);
        $name = $productTypes->name;
        $products = Product::where('product_type', $name)->exists();
        
        if ($products) {
            return redirect()->route('productTypes.index')
                            ->with('success', 'You cannot delete this product type because there are still products using this type.');
        }

        $productTypes->delete();
        return redirect()->route('productTypes.index')
                        ->with('success', 'Product Type deleted successfully.');
    }}