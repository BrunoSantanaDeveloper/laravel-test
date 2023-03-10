<?php

namespace App\Listeners;

use Dompdf\Dompdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class GenerateReportPdf implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {
        // Retrieves the Report created from the event
        $report = $event->report;

        // Loads the view with the Report's data
        $html = view('reports.pdf', compact('report'))->render();

        // Instantiate the Dompdf
        $dompdf = new Dompdf();

        // Load HTML into Dompdf and render it
        $dompdf->loadHtml($html);
        $dompdf->render();

        // Save the PDF in storage/app/reports
        $pdf = $dompdf->output();
        $filename = "report_{$report->id}.pdf";
        $path = storage_path("app/reports/{$filename}");
        file_put_contents($path, $pdf);

        // Fires an event with the name of the generated file
        event(new \App\Events\ReportPdfGenerated($filename));
    }
}
