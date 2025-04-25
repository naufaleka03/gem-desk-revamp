<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Dompdf\Dompdf;
use Dompdf\Options;


class ServicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = $request->get('query');
        if ($request->ajax()) {
            $data = Service::query()
                ->where('name', 'LIKE', '%' . $query . '%')
                ->limit(10)
                ->get();
    
            $output = '';
            if ($data->count() > 0) {
                foreach ($data as $service) {
                    $output .= '
                        <div class="col-md-4">
                            <div class="card mb-4" style="cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;" 
                                onmouseover="this.style.transform=\'translateY(-5px)\'; this.style.boxShadow=\'0 4px 15px rgba(0,0,0,0.1)\'" 
                                onmouseout="this.style.transform=\'translateY(0)\'; this.style.boxShadow=\'none\'">
                                <div onclick="window.location=\'' . route('services.show', $service->id) . '\'" style="cursor: pointer;">
                                    <img src="' . asset('storage/' . $service->files) . '" class="card-img-top" 
                                        alt="service" style="width: 100%; height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h2 class="card-title">' . $service->name . '</h2>
                                        <p class="card-text">' . $service->description . '</p>
                                    </div>
                                </div>
                                <div class="card-body" style="display: flex; gap: 10px; justify-content: start;">
                                    <a href="' . route('services.edit', $service->id) . '" 
                                    class="btn" 
                                    style="background-color: #7380EC; color: white; border: none; display: inline-flex; align-items: center; gap: 5px;"
                                    onmouseover="this.style.backgroundColor=\'#8e98f5\';" 
                                    onmouseout="this.style.backgroundColor=\'#7380EC\'">
                                        <span class="material-symbols-outlined">stylus</span>
                                        Edit
                                    </a>
                                    <form action="' . route('services.destroy', $service->id) . '" method="POST" style="display: inline;">
                                        ' . csrf_field() . '
                                        ' . method_field('DELETE') . '
                                        <button type="submit" class="btn btn-danger" style="display: inline-flex; align-items: center; gap: 5px;">
                                            <span class="material-symbols-outlined">delete</span>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    ';
                }
            } else {
                $output .= '<div class="alert alert-warning">No Record Found</div>';
            }
    
            return $output;
        }

        $services = Service::query()->where('name', 'LIKE', '%' . $query . '%')
            ->simplePaginate(8);
        return view('services.index',compact('services'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $organizations = Organization::all();
        $products = Product::all();
        return response(view('services.create', compact('organizations','products')) );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'service_categories' => 'required|string',
            'cost' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'availability' => 'required|string',
            'hours' => 'required|string',
            'organization_id' => 'required|exists:organizations,id',
            'products' => 'required|array|min:1', // Array of products 
            'products.*' => 'required|exists:products,id',
            'file' => 'nullable|mimes:pdf,jpg,jpeg,png,doc,docx|max:2500',
        ]);

        try {
        DB::beginTransaction();

            // Create service 
            $service = new Service();
            $service->name = $validated['name'];
            $service->service_categories = $validated['service_categories'];
            $service->description = $validated['description']; 
            $service->cost = $validated['cost'];
            $service->quantity = $validated['quantity'];
            $service->availability = $validated['availability'];
            $service->hours = $validated['hours'];
            $service->organization_id = $validated['organization_id'];
            $service->product_id = $validated['products'][0]; // First product as primary
            
            // Handle file upload
            if ($request->hasFile('file')) {
                $service->files = $request->file('file')->store('files', 'public');
            }
    
            $service->save();

            // If there are multiple products, add the additional ones to the pivot table
            if (count($validated['products']) > 1) {
                // Skip the first product as it's already the primary
                $additionalProducts = array_slice($validated['products'], 1);
                $service->products()->attach($additionalProducts);
            }
            
            DB::commit();
            
            return redirect()->route('services.index')
                            ->with('success', 'Service created successfully with ' . 
                                   count($validated['products']) . ' products');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Service creation error: ' . $e->getMessage());
            
            return back()->withInput()
                        ->withErrors(['error' => 'Database error occurred: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service): View
    {
        return view('services.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service): View
    {
        $organizations = Organization::all();
        $products = Product::all();
        
        // Get all additional products linked to this service
        $linkedProductIds = $service->products()->pluck('products.id')->toArray();
        
        return view('services.edit', compact('service', 'organizations', 'products', 'linkedProductIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service): RedirectResponse
    {
        // Validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'service_categories' => 'required|string',
            'cost' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:1',
            'availability' => 'required|string',
            'hours' => 'required|string',
            'organization_id' => 'required|exists:organizations,id',
            'products' => 'required|array|min:1',
            'products.*' => 'required|exists:products,id',
            'file' => 'nullable|mimes:pdf,jpg,jpeg,png,doc,docx|max:2500',
        ]);

        try {
            DB::beginTransaction();
            
            // Update basic service info
            $service->name = $validated['name'];
            $service->service_categories = $validated['service_categories'];
            $service->description = $validated['description']; 
            $service->cost = $validated['cost'];
            $service->quantity = $validated['quantity'];
            $service->availability = $validated['availability'];
            $service->hours = $validated['hours'];
            $service->organization_id = $validated['organization_id'];
            $service->product_id = $validated['products'][0]; // First product as primary
            
            // Handle file upload if changed
            if ($request->hasFile('file')) {
                // Delete old file if exists
                if ($service->files) {
                    Storage::disk('public')->delete($service->files);
            }

                $service->files = $request->file('file')->store('files', 'public');
            }
            
            $service->save();
            
            // Sync additional products (detach all existing and attach new ones)
            $additionalProducts = count($validated['products']) > 1 
                ? array_slice($validated['products'], 1) 
                : [];
                
            $service->products()->sync($additionalProducts);
            
            DB::commit();

        return redirect()->route('services.index')
                            ->with('success', 'Service updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Service update error: ' . $e->getMessage());
            
            return back()->withInput()
                        ->withErrors(['error' => 'Database error occurred: ' . $e->getMessage()]);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service): RedirectResponse
    {
        $oldFile = $service->files;
        unlink(storage_path('app/public/') . $oldFile);
        $service->delete();

        return redirect()->route('services.index')
                        ->with('success','Service deleted successfully');
    }

}
