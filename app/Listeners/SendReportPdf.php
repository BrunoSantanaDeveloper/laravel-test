<?php

namespace App\Listeners;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendReportPdf implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle($event)
    {
        // Retrieves the filename generated from the event
        $filename = $event->filename;

        // Instantiate the PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configure SMTP server credentials
            $mail->isSMTP();
            $mail->Host = config('mail.smtp.host');
            $mail->SMTPAuth = true;
            $mail->Username = config('mail.smtp.username');
            $mail->Password = config('mail.smtp.password');
            $mail->SMTPSecure = config('mail.smtp.encryption');
            $mail->Port = config('mail.smtp.port');

            // Configure the sender and receiver
            $mail->setFrom(config('mail.from.address'), config('mail.from.name'));
            $mail->addAddress('destinatario@example.com', 'Destinatário');

            // Configure the subject and body of the message
            $mail->Subject = 'Novo Relatório Gerado';
            $mail->Body = 'Segue em anexo o relatório gerado.';
            $mail->AltBody = 'Segue em anexo o relatório gerado.';

            // Add the PDF as an attachment
            $mail->addAttachment(storage_path("app/reports/{$filename}"), $filename);

            // Send the email
            $mail->send();
        } catch (Exception $e) {
            // If an error occurs, log in the Laravel log
            \Log::error($e->getMessage());
        }
    }
}
