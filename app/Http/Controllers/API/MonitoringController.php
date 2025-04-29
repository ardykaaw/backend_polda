<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Monitoring;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $monitorings = Monitoring::latest()->get();
        return response()->json(['data' => $monitorings]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string',
            'priority' => 'required|string',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date',
            'location' => 'nullable|string',
            'additional_data' => 'nullable|json'
        ]);

        $monitoring = Monitoring::create($validated);
        return response()->json(['data' => $monitoring], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Monitoring $monitoring)
    {
        return response()->json(['data' => $monitoring]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Monitoring $monitoring)
    {
        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'status' => 'sometimes|string',
            'priority' => 'sometimes|string',
            'start_time' => 'nullable|date',
            'end_time' => 'nullable|date',
            'location' => 'nullable|string',
            'additional_data' => 'nullable|json'
        ]);

        $monitoring->update($validated);
        return response()->json(['data' => $monitoring]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Monitoring $monitoring)
    {
        $monitoring->delete();
        return response()->json(null, 204);
    }
}
