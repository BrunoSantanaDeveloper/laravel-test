<?php

namespace App\Jobs;

use Dompdf\Dompdf;
use App\Models\Report;
use App\Mail\ReportCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $report;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // gerar o PDF
        $pdf = DomPdf::loadView('reports.pdf', ['report' => $this->report]);

        // enviar o email com o PDF anexado
        Mail::to('bsantana.it@gmail.com')->send(new ReportCreated($this->report, $pdf));
    }
}
