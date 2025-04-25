<?php

namespace App\Http\Controllers;

use App\Models\Organization;
use App\Models\Department;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
         $organizations = Organization::all();

//         if ($organizations) {
//             $organizations = Organization::paginate(6);
//             return view('organizations.index',compact('organizations'))
//                     ->with('i', (request()->input('page', 1) - 1) * 5);
//         } else {
//             return view('organizations.index')->with('message', '!! No Record Found !!');
//         }

        return view('organizations.index',compact('organizations'));

//        $organizations = Organization::first()->paginate(6);

//        return view('organizations.index',compact('organizations'))
//                     ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('organizations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'organization_name' => 'required',
            'description' => 'required',
            'industry_category' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'state' => 'required',
            'country' => 'required',
            'email' => 'required',
            'phone_no' => 'required',
            'fax_no' => 'required',
            'web_url' => 'required',
        ]);

        Organization::create($request->all());

        return redirect()->route('organizations.index')
                        ->with('success','Organization created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Organization $organization): View
    {
        // $organization->load('departments');
        $departments = Department::where('organization_id', $organization->id)->get();

        return view('organizations.show', compact('organization', 'departments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Organization $organization): view
    {
        return view('organizations.edit', compact('organization'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Organization $organization): RedirectResponse
    {
        $request->validate([
            'organization_name' => 'required',
            'description' => 'required',
            'industry_category' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'state' => 'required',
            'country' => 'required',
            'email' => 'required',
            'phone_no' => 'required',
            'fax_no' => 'required',
            'web_url' => 'required',
        ]);

        $organization->update($request->all());

        return redirect()->route('organizations.index')
                        ->with('success','Organization updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Organization $organization)
    {
        $organization->delete();

        return redirect()->route('organizations.index')
                        ->with('success','Organization deleted successfully!');
    }
}
