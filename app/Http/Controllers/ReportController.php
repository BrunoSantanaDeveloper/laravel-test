<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateReportJob;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\Report;
use Dompdf\Dompdf;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::all();

        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        $profiles = Profile::all();
        return view('reports.create', ['profiles' => $profiles]);
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

        if ($request->input('profile_ids')) {
            $report->profile()->attach($request->input('profile_ids'));
        }

        GenerateReportJob::dispatch($report);

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

    public function destroy(Report $report)
    {
        $report->delete();
        return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
    }

    public function reportsWithProfiles()
    {
        $reports = Report::with('profile')->get();
        return view('reports-with-profiles', compact('reports'));
    }

    public function generatePdf($id)
    {
        // Busca o Report pelo ID
        $report = Report::find($id);

        // Cria uma instância da biblioteca Dompdf
        $dompdf = new Dompdf();

        // Renderiza a view do Report em HTML
        $html = view('reports.pdf', compact('report'))->render();

        // Carrega o HTML no Dompdf
        $dompdf->loadHtml($html);

        // Renderiza o PDF
        $dompdf->render();

        // Retorna o PDF como uma resposta do tipo "application/pdf"
        return $dompdf->stream('report.pdf');
    }
}
