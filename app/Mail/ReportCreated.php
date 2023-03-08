<?php

namespace App\Mail;

use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use PDF;

class ReportCreated extends Mailable
{
    use Queueable, SerializesModels;

    protected $report;
    protected $pdf;

    public function __construct(Report $report, $pdf)
    {
        $this->report = $report;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->markdown('emails.report-created')
            ->with([
                'report' => $this->report,
            ])->attachData($this->pdf->output(), 'report.pdf');
    }
}
