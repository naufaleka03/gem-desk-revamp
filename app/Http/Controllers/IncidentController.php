<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $data = Incident::all();
        return view("incidents.index", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $assets = Product::all();
        $services = Service::all();
        return view("incidents.create", compact('assets', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'incident' => 'required',
            'service' => 'required',
            'assets' => 'required|array',
            'assets.*' => 'required|string',
           'probability' => 'required',
           'risk_impact' => 'required',
            'incident_desc' => 'required',
        ]);

        $priority = $this->calculatePriority($request->probability, $request->risk_impact);

        $assets = implode(', ', $request->assets);

        $incident = new Incident();
        $incident->incident = $request->incident;
        $incident->service = $request->service;
        $incident->asset = $assets;
        $incident->probability = $request->probability;
        $incident->risk_impact = $request->risk_impact;
        $incident->priority = $priority;
        $incident->incident_desc = $request->incident_desc;
        $incident->save();

        return redirect()->route('incidents.index')
                        ->with('success', 'Incident created successfuly.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $incident = Incident::findOrFail($id);
        return view("incidents.show", ['incident' => $incident]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $incident = Incident::findOrFail($id);
        $services = Service::all();
        $assets = Product::all();
        return view("incidents.edit", compact('incident', 'services', 'assets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Incident $incident): RedirectResponse
    {
        $request->validate([
            'incident' => 'required',
            'service' => 'required',
            'assets' => 'required|array',
            'assets.*' => 'required|string',
            'probability' => 'required',
            'risk_impact' => 'required',
            'incident_desc' => 'required',
        ]);

        $priority = $this->calculatePriority($request->probability, $request->risk_impact);

        $assets = implode(', ', $request->assets);

        $incident->incident = $request->incident;
        $incident->service = $request->service;
        $incident->asset = $assets;
        $incident->probability = $request->probability;
        $incident->risk_impact = $request->risk_impact;
        $incident->priority = $priority;
        $incident->incident_desc = $request->incident_desc;
        $incident->save();

        return redirect()->route('incidents.index')
                    ->with('success', 'Incident updated successfuly.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $incident = Incident::findOrFail($id);
        $incident->delete();

        return redirect()->route('incidents.index')
                        ->with('success', 'Incident deleted successfuly.');
    }

    private function calculatePriority($probability, $impact)
    {
        if (($probability === 'High' && $impact === 'High') ||
            ($probability === 'High' && $impact === 'Medium') ||
            ($probability === 'Medium' && $impact === 'High')) {
            return 'High';
        } elseif (($probability === 'Medium' && $impact === 'Medium') ||
                  ($probability === 'High' && $impact === 'Low') ||
                  ($probability === 'Low' && $impact === 'High')) {
            return 'Medium';
        } else {
            return 'Low';
        }
    }
}
