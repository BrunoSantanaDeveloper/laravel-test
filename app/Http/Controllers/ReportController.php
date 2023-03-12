<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateReportJob;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\Report;
use Dompdf\Dompdf;

class ReportController extends Controller
{
    /**
     * Display a listing of reports.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports = Report::all();

        return view('reports.index', compact('reports'));
    }

    /**
     * Show the form for creating a new report.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $profiles = Profile::all();

        return view('reports.create', ['profiles' => $profiles]);
    }

    /**
     * Store a newly created report in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'profile_ids' => 'nullable|array',
            'profile_ids.*' => 'nullable|integer|exists:profiles,id'
        ]);

        $report = Report::create($validated);

        if ($request->input('profile_ids')) {
            $report->profile()->attach($request->input('profile_ids'));
        }

        GenerateReportJob::dispatch($report);

        return redirect()->route('reports.index')->with('success', 'Report created successfully.');
    }

    /**
     * Display the specified report.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        $report->load('profile');

        return view('reports.show', compact('report'));
    }

    /**
     * Show the form for editing the specified report.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        return view('reports.edit', compact('report'));
    }

    /**
     * Update the specified report in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'profile_ids' => 'nullable|array',
            'profile_ids.*' => 'nullable|integer|exists:profile,id'
        ]);

        $report->update($validated);

        if (isset($validated['profile_ids'])) {
            $report->profile()->sync($validated['profile_ids']);
        } else {
            $report->profile()->detach();
        }

        return redirect()->route('reports.index')->with('success', 'Report updated successfully.');
    }

    /**
     * Remove the specified report from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Report $report)
    {
        $report->delete();

        return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
    }

    /**
     * Display a listing of reports with their associated profiles.
     *
     * @return \Illuminate\Http\Response
     */
    public function reportsWithProfiles()
    {
        $reports = Report::with('profiles')->get();

        return view('reports-with-profiles', compact('reports'));
    }

    /**
     * Generate a PDF for the specified report.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function generatePdf($id)
    {
        // Find the report by ID
        $report = Report::find($id);

        // Create an instance of the Dompdf library
        $dompdf = new Dompdf();

        // Render the Report view as HTML
        $html = view('reports.pdf', compact('report'))->render();

        // Load the HTML into Dompdf
        $dompdf->loadHtml($html);

        // Render the PDF
        $dompdf->render();

        // Return the PDF as a "application/pdf" response
        return $dompdf->stream('report.pdf');
    }
}
