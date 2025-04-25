<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $departments = Department::all();
        $organization = Organization::all();

        return view('departments.index',compact('departments', 'organization'));
//                    ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $organizations = Organization::all();
        $organization_id = $request->query('organization_id', null);
        
        return view('departments.create', compact('organizations', 'organization_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required',
            'description' => 'required',
            'department_head' => 'nullable',
            'organization_id' => 'required|exists:organizations,id' ,
        ]);

        Department::create($request->all());

        return redirect()->route('organizations.show', $request->organization_id)
                        ->with('success','Department created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(department $department): View
    {
        return view('departments.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(department $department): View
    {
        return view('departments.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, department $department)
    {
        $request->validate([
            'department_name' => 'required',
            'description' => 'required',
            'department_head' => 'nullable',
        ]);

        $department->update($request->all());

        // Redirect back to the organization details
        if ($department->organization_id) {
            return redirect()->route('organizations.show', $department->organization_id)
                            ->with('success','Department updated successfully!');
        }

        return redirect()->route('departments.index')
                        ->with('success','Department updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(department $department)
    {   
        $organization_id = $department->organization_id;
        $department->delete();

        // Redirect back to the organization details
        if ($organization_id) {
            return redirect()->route('organizations.show', $organization_id)
                            ->with('success','Department deleted successfully!');
        }

        return redirect()->route('departments.index')
                        ->with('success','Department deleted successfully!');
    }
}
