<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class SendReport extends Mailable
{
    use Queueable, SerializesModels;

    private string $report_file;

    /**
     * Create a new message instance.
     *
     * @param string $report_file
     */
    public function __construct(string $report_file)
    {
        $this->report_file = $report_file;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.reports.send')
            ->attach(Storage::disk('public')->path('reports/').$this->report_file, [
                'mime' => 'application/pdf',
            ]);
    }
}
