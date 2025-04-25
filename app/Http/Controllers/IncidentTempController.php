<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreincidentTempTempRequest;
use App\Models\Incident;
use App\Models\incidentTemp;
use App\Models\incidentTempTemp;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class IncidentTempController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : Response
    {
        $incidentTemps = IncidentTemp::all();
        return response(view('incidentTemps.index', compact('incidentTemps')));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() : View
    {
        $assets = Product::all();
        $services = Service::all();

        return view('incidentTemps.create', compact('assets', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) : RedirectResponse
    {
        $request->validate([
            'incident' => 'required|min:5',
            'probability' => 'required',
            'risk_impact' => 'required',
            'incident_desc' => 'required|min:5'
        ]);

        $incidentTemp = new IncidentTemp();
        $incidentTemp->incident = $request->incident;
        $incidentTemp->probability = $request->probability;
        $incidentTemp->risk_impact = $request->risk_impact;
        $incidentTemp->priority = $request->priority;
        $incidentTemp->incident_desc = $request->incident_desc;
        $incidentTemp->service = $request->service;
        $incidentTemp->asset = $request->asset;

        $probabilityMap = ['Low' => 1, 'Medium' => 2, 'High' => 3];
        $probability = $probabilityMap[$incidentTemp->probability] ?? 0;

        $impactMap = ['Low' => 1, 'Medium' => 2, 'High' => 3];
        $impact = $impactMap[$incidentTemp->risk_impact] ?? 0;

        $priority = $probability + $impact;
        if($priority >= 0 and $priority <= 2){
            $incidentTemp->priority = "Low";
        }elseif($priority >= 3 and $priority <= 4){
            $incidentTemp->priority = "Medium";
        }elseif($priority >= 5 and $priority <= 6){
            $incidentTemp->priority = "High";
        }

        $incidentTemp->save();
        return redirect()->route('incidentTemps.index');

    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(IncidentTemp $incidentTempTemp) : RedirectResponse
    {
        $incidentTemp->delete();
        return redirect(route('incidentTemps.index'))
            ->with('success', 'Deleted successfully')
            ->withErrors('error', 'Sorry, unable to delete this!');
    }

    public function storeToIncidents(IncidentTemp $incidentTemp)
    {
        $incident = new Incident();
        $incident->incident = $incidentTemp->incident;
        $incident->probability = $incidentTemp->probability;
        $incident->risk_impact = $incidentTemp->risk_impact;
        $incident->priority = $incidentTemp->priority;
        $incident->incident_desc = $incidentTemp->incident_desc;
        $incident->service = $incidentTemp->service;
        $incident->asset = $incidentTemp->asset;

        $incident->save();

        $incidentTemp->delete();
        return redirect(route('incidentTemps.index'));
    }
}
