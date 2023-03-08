<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::all();
        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        return view('reports.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'profile_ids' => 'nullable|array',
            'profile_ids.*' => 'nullable|integer|exists:profiles,id'
        ]);

        $report = Report::create($validated);

        if (isset($validated['profile_ids'])) {
            $report->profile()->attach($validated['profile_ids']);
        }

        return redirect()->route('reports.index')->with('success', 'Report created successfully.');
    }

    public function show(Report $report)
    {
        $report->load('profile');
        return view('reports.show', compact('report'));
    }

    public function edit(Report $report)
    {
        return view('reports.edit', compact('report'));
    }

    public function update(Request $request, Report $report)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'profile_ids' => 'nullable|array',
            'profile_ids.*' => 'nullable|integer|exists:profiles,id'
        ]);

        $report->update($validated);

        if (isset($validated['profile_ids'])) {
            $report->profile()->sync($validated['profile_ids']);
        } else {
            $report->profile()->detach();
        }

        return redirect()->route('reports.index')->with('success', 'Report updated successfully.');
    }

    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
    }

    public function reportsWithProfiles()
    {
        $reports = Report::with('profiles')->get();
        return view('reports-with-profiles', compact('reports'));
    }
}
